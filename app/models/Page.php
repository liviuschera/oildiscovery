<?php

class Page
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getNavbar()
    {
        // Query database
        $this->db->queryDB('SELECT * FROM navbar ORDER BY navbar_order ASC;');

        //   Fetch the navbar
        $results = $this->db->getResultSet();
        return $results;
    }

    public function addPage($data)
    {
        try {
            $this->db->startTransaction();
            // Query posts database
            $this->db->queryDB(
                "INSERT INTO posts (userID, title, active, priv, isBlogpost) VALUES (:loggedUserId, :title, :active, :priv, :isBlogpost);"
         );

            // Bind values
            $this->db->bindVal(':loggedUserId', $data['loggedUserId']);
            $this->db->bindVal(':title', $data['title']);
            $this->db->bindVal(':active', $data['active']);
            $this->db->bindVal(':priv', $data['priv']);
            $this->db->bindVal(':isBlogpost', $data['isBlogpost']);

            $this->db->executeStmt();
            $last_post_id = $this->db->retrieveLastInsertId();

            // Query post_body table
            $this->db->queryDB(
                'INSERT INTO post_body (postID, content) VALUES (:postID, :content);'
         );
            $this->db->bindVal(':postID', $last_post_id);
            $this->db->bindVal(':content', $data['content']);

            $this->db->executeStmt();

            // Query post_images table
            $this->db->queryDB(
                "INSERT INTO post_images (post_id, img_name) VALUES (:post_id, :img_name);"
         );
            $this->db->bindVal(':post_id', $last_post_id);
            $this->db->bindVal(':img_name', $data['imgName']);

            $this->db->executeStmt();

            // Query navbar table
            $this->db->queryDB(
                "INSERT INTO navbar (page_id, navbar_title, navbar_order, link) VALUES (:page_id, :navbar_title, :navbar_order, :link);"
         );
            $this->db->bindVal(':page_id', $last_post_id);
            $this->db->bindVal(':navbar_title', $data['menutitle']);
            $this->db->bindVal(':navbar_order', $data['order']);
            $this->db->bindVal(':link', $data['link']);

            $this->db->executeStmt();

            $this->db->commitTransaction();
        } catch (Exception $e) {
            $this->db->rollBackTransaction();
            // echo "Failed to execute ADD post transaction: " . $e->getMessage();
            die("Failed to execute ADD post transaction: {$e->getMessage()}");
        }
    }
}