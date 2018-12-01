<?php
// Is a good convetion to hame models singular
// and controllers plural both the filename and folders
class Post
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }
}
?>
