<?php
class Post
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getPosts()
    {
        $this->db->queryDB('SELECT *
        FROM users
        JOIN posts ON users.id=posts.userID
        JOIN post_body ON posts.id = post_body.postID ORDER BY posts.createdAt DESC');
        $restuls = $this->db->getResultSet();
        return $restuls;
    }

    public function addPost($data)
    {
        try {
            $this->db->startTransaction();
            // Query database
            $this->db->queryDB(
                "INSERT INTO posts (userID, title, active, priv) VALUES (:loggedUserId, :title, :active, :priv)"
            );

            // Bind values
            $this->db->bindVal(':loggedUserId', $data['loggedUserId']);
            $this->db->bindVal(':title', $data['title']);
            $this->db->bindVal(':active', $data['active']);
            $this->db->bindVal(':priv', $data['priv']);

            $this->db->executeStmt();
            $last_post_id = $this->db->retrieveLastInsertId();

            $this->db->queryDB(
                "INSERT INTO post_body (postID, content) VALUES (:postID, :content)"
            );
            $this->db->bindVal(':postID', $last_post_id);
            // $this->db->bindVal(':postID', $_SESSION['last_id']);
            $this->db->bindVal(':content', $data['content']);
            $this->db->executeStmt();
            // Execute the prepared statement
            $this->db->commitTransaction();
            return true;
        } catch (Exception $e) {
            $this->db->rollBackTransaction();
            echo "Failed to execute transaction: " . $e->getMessage();
            return false;
        }

        // if ($this->db->executeStmt()) {
        //     return true;
        // } else {
        //     return false;
        // }
    }

    public function getPostById($id)
    {
        $this->db->queryDB('SELECT 
        users.id AS userID,
        users.firstName AS fName,
        users.lastName AS lName,
        users.createdAt AS userCreatedAt, 
        users.modified AS userModified, 
        users.priv AS userPriv, 
        users.active AS userActive, 
        posts.id AS postID,
        posts.title AS title,
        posts.createdAt AS postCreatedAt,
        posts.modified AS postModified, 
        posts.priv AS postPriv, 
        posts.active AS postActive,
        post_body.content AS content
        FROM users
        JOIN posts ON users.id = posts.userID
        JOIN post_body ON posts.id = post_body.postID WHERE posts.id =:id');

        $this->db->bindVal(':id', $id);

        $row = $this->db->getSingleResult();
        return $row;
    }
}
?>
