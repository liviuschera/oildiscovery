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
        JOIN posts ON users.id=posts.userId
        JOIN body ON posts.id = body.postId ORDER BY posts.createdAt DESC');
        $restuls = $this->db->getResultSet();
        return $restuls;
    }

    public function addPost($data)
    {
        try {
            $this->db->startTransaction();
            // Query database
            $this->db->queryDB(
                'INSERT INTO posts (userId, title, active, priv) VALUES (:userId, :title, :active, :priv)'
            );
            // Bind values
            $this->db->bindVal(':userId', $data['userId']);
            $this->db->bindVal(':title', $data['title']);
            $this->db->bindVal(':active', $data['active']);
            $this->db->bindVal(':priv', $data['priv']);

            // Execute the prepared statement
            $this->db->executeStmt();
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
