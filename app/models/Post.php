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
}
?>
