<?php
class Post
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getPosts($offset = 0)
    {
        $rows = 'SELECT *
        FROM users
        JOIN posts ON users.id=posts.userID
        JOIN post_body ON posts.id = post_body.postID
        JOIN post_images ON posts.id = post_images.post_id 
        ORDER BY posts.createdAt DESC';

        // First get the row count
        $this->db->queryDB($rows);
        $this->db->executeStmt();
        $_SESSION['row_count_posts'] = $this->db->getRowCount();

        // Now add the LIMIT clause
        $limit = " LIMIT " . $offset . "," . ROWS_PER_PAGE_POSTS;
        $this->db->queryDB($rows . $limit);
        $results = $this->db->getResultSet();
        return $results;
    }

    public function addPost($data)
    {
        try {
            $this->db->startTransaction();
            // Query posts database
            $this->db->queryDB(
                "INSERT INTO posts (userID, title, active, priv) VALUES (:loggedUserId, :title, :active, :priv);"
            );

            // Bind values
            $this->db->bindVal(':loggedUserId', $data['loggedUserId']);
            $this->db->bindVal(':title', $data['title']);
            $this->db->bindVal(':active', $data['active']);
            $this->db->bindVal(':priv', $data['priv']);

            $this->db->executeStmt();
            $last_post_id = $this->db->retrieveLastInsertId();

            // Query post_body database
            $this->db->queryDB(
                'INSERT INTO post_body (postID, content) VALUES (:postID, :content);'
            );
            $this->db->bindVal(':postID', $last_post_id);
            $this->db->bindVal(':content', $data['content']);

            $this->db->executeStmt();

            // Query post_images database
            $this->db->queryDB(
                "INSERT INTO post_images (post_id, img_name) VALUES (:post_id, :img_name);"
            );
            $this->db->bindVal(':post_id', $last_post_id);
            $this->db->bindVal(':img_name', $data['imgName']);

            $this->db->executeStmt();

            $this->db->commitTransaction();
        } catch (Exception $e) {
            $this->db->rollBackTransaction();
            // echo "Failed to execute ADD post transaction: " . $e->getMessage();
            die("Failed to execute ADD post transaction: {$e->getMessage()}");
        }
    }

    public function updatePost($data)
    {
        try {
            $this->db->startTransaction();
            // Query database
            $this->db->queryDB(
                "UPDATE posts SET title = :title, active = :active, priv = :priv, modified = now() WHERE id = :postID;"
            );
            // Bind values
            $this->db->bindVal(':postID', $data['postID']);
            $this->db->bindVal(':title', $data['title']);
            $this->db->bindVal(':active', $data['active']);
            $this->db->bindVal(':priv', $data['priv']);

            $this->db->executeStmt();

            $this->db->queryDB(
                "UPDATE post_body SET content = :content WHERE postID = :postID;"
            );
            $this->db->bindVal(':postID', $data['postID']);
            $this->db->bindVal(':content', $data['content']);
            $this->db->executeStmt();

            $this->db->queryDB(
                "UPDATE post_images SET img_name = :img_name WHERE post_id = :post_id;"
            );
            $this->db->bindVal(':post_id', $data['postID']);
            $this->db->bindVal(':img_name', $data['imgName']);
            $this->db->executeStmt();

            $this->db->commitTransaction();
        } catch (Exception $e) {
            $this->db->rollBackTransaction();
            // throw new Exception($e->getMessage());
            die(
                "Failed to execute UPDATE post transaction: {$e->getMessage()}"
            );
        }
    }

    public function deletePost($id)
    {
        try {
            //Query database
            $this->db->queryDB(" DELETE FROM posts WHERE id = :postID;
            ");
            // Bind values
            $this->db->bindVal(':postID', $id);
            if ($this->db->executeStmt()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo " Failed to execute DELETE post : " . $e->getMessage();
        }
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
        post_body.content AS content,
        post_images.img_name AS imgName
        FROM users
        JOIN posts ON users.id = posts.userID
        JOIN post_body ON posts.id = post_body.postID 
        JOIN post_images ON posts.id = post_images.post_id 
        WHERE posts.id =:id;');

        $this->db->bindVal(':id', $id);

        $row = $this->db->getSingleResult();
        return $row;
    }

    public function addComment($data)
    {
        try {
            $this->db->queryDB(
                "INSERT INTO comments (commenter_id, commenter_fname, commenter_lname, post_id, comment) VALUES (:commenter_id, :commenter_fname, :commenter_lname, :post_id, :comment);"
            );

            $this->db->bindVal(':commenter_id', $_SESSION['login_user_id']);
            $this->db->bindVal(
                ':commenter_fname',
                $_SESSION['login_user_fname']
            );
            $this->db->bindVal(
                ':commenter_lname',
                $_SESSION['login_user_lname']
            );
            $this->db->bindVal(':post_id', $data['post']->postID);
            $this->db->bindVal(':comment', $data['post']->comment);

            $this->db->executeStmt();
        } catch (Throwable $e) {
            die("Failed to execute addComment: {$e->getMessage()}");
        }
    }

    public function getCommentsByPostId($id)
    {
        $this->db->queryDB("SELECT * FROM comments WHERE post_id = :post_id;");

        $this->db->bindVal(':post_id', $id);

        $comments = $this->db->getResultSet();

        return $comments;
    }
}
