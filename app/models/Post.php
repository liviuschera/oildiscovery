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

    public function getLastInsertId()
    {
        return $this->db->retrieveLastInsertId();
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

            $_SESSION['last_id'] = $this->db->executeStmt();

            $last_post_id = $this->db->executeStmt();

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
}
?>
