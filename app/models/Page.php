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
                "INSERT INTO navbar (page_id, navbar_title, navbar_order, navbar_active, link) VALUES (:page_id, :navbar_title, :navbar_order, :navbar_active, :link);"
            );
            $this->db->bindVal(':page_id', $last_post_id);
            $this->db->bindVal(':navbar_title', $data['menutitle']);
            $this->db->bindVal(':navbar_order', $data['order']);
            $this->db->bindVal(':navbar_active', $data['active']);
            $this->db->bindVal(':link', $data['link']);

            $this->db->executeStmt();

            $this->db->commitTransaction();
        } catch (Exception $e) {
            $this->db->rollBackTransaction();
            // echo "Failed to execute ADD post transaction: " . $e->getMessage();
            die("Failed to execute ADD post transaction: {$e->getMessage()}");
        }
    }

    public function updatePage($data)
    {
        try {
            $this->db->startTransaction();
            // Query posts database
            $this->db->queryDB(
                "UPDATE posts SET title = :title, active = :active, priv = :priv, isBlogpost = :isBlogpost), modified = now() WHERE id = :postID;"
            );

            // Bind values
            $this->db->bindVal(':postID', $data['postID']);
            $this->db->bindVal(':title', $data['title']);
            $this->db->bindVal(':active', $data['active']);
            $this->db->bindVal(':priv', $data['priv']);
            $this->db->bindVal(':isBlogpost', $data['isBlogpost']);

            $this->db->executeStmt();

            // Query post_body table
            $this->db->queryDB(
                'UPDATE post_body SET content = :content) WHERE postID = postID;'
            );
            $this->db->bindVal(':postID', $date['postID']);
            $this->db->bindVal(':content', $data['content']);

            $this->db->executeStmt();

            // Query post_images table
            if (!empty($data['imgName'])) {
                $this->db->queryDB(
                    "UPDATE post_images SET img_name = :img_name WHERE post_id = :post_id;"
                );
                $this->db->bindVal(':post_id', $data['postID']);
                $this->db->bindVal(':img_name', $data['imgName']);
                $this->db->executeStmt();
            }

            // Query navbar table
            $this->db->queryDB(
                "UPDATE navbar SET page_id, navbar_title = :navbar_title, navbar_order = :navbar_order, navbar_active = :navbar_active, link = :link WHERE page_id = :page_id;"
            );
            $this->db->bindVal(':page_id', $data['postID']);
            $this->db->bindVal(':navbar_title', $data['menutitle']);
            $this->db->bindVal(':navbar_order', $data['order']);
            $this->db->bindVal(':navbar_active', $data['active']);
            $this->db->bindVal(':link', $data['link']);

            $this->db->executeStmt();

            $this->db->commitTransaction();
        } catch (Exception $e) {
            $this->db->rollBackTransaction();
            // echo "Failed to execute ADD post transaction: " . $e->getMessage();
            die("Failed to execute ADD post transaction: {$e->getMessage()}");
        }
    }

    public function getPageById($id)
    {
        $this->db->queryDB('SELECT
        navbar.page_id AS pageID,
        navbar.navbar_title AS pageTitle,
        navbar.navbar_order AS pageOrder,
        navbar.navbar_active AS pageActive,
        navbar.link AS pageLink,
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
        posts.isBlogpost AS isblogpost,
        post_body.content AS content,
        post_images.img_name AS imgName,
        FROM users
        JOIN posts ON users.id = posts.userID
        JOIN navbar ON users.id = navbar.page_id
        JOIN post_body ON posts.id = post_body.postID
        JOIN post_images ON posts.id = post_images.post_id
        WHERE posts.id =:id;');

        $this->db->bindVal(':id', $id);

        $row = $this->db->getSingleResult();
        return $row;
    }
}
