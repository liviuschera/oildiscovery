<?php

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Register user
    public function registerUser($data)
    {
        try {
            $this->db->startTransaction();
            // Query database
            $this->db->queryDB(
                "INSERT INTO users (firstName, lastName, email, phone, passw) VALUES (:firstName, :lastName, :email, :phone, :passw);"
         );
            // Bind values
            $this->db->bindVal(':firstName', $data['firstName']);
            $this->db->bindVal(':lastName', $data['lastName']);
            $this->db->bindVal(':email', $data['email']);
            $this->db->bindVal(':phone', $data['phone']);
            $this->db->bindVal(':passw', $data['passw']);

            // Execute the prepared statement
            $this->db->executeStmt();
            $last_user_id = $this->db->retrieveLastInsertId();

            // Query user_images table
            $this->db->queryDB(
                "INSERT INTO user_images (user_id, img_name) VALUES (:user_id, :img_name);"
         );
            $this->db->bindVal(':user_id', $last_user_id);
            $this->db->bindVal(':img_name', $data['imgName']);

            $this->db->executeStmt();

            $this->db->commitTransaction();
        } catch (Exception $e) {
            $this->db->rollBackTransaction();
            die(
         "Failed to execute REGISTER user transaction: {$e->getMessage()}"
         );
        }
    }

    // Edit user
    public function editUser($data)
    {
        try {
            $this->db->startTransaction();
            // Query database
            $updated_email = '';
            if ($data['email']) {
                $updated_email = 'email = :email,';
            }

            $this->db->queryDB(
                "UPDATE users SET firstName = :firstName, lastName = :lastName, phone = :phone, {$updated_email} passw = :passw, priv = :priv, active = :active, modified = now() WHERE id = :id"
            );

            // Bind values
            if ($data['email']) {
                $this->db->bindVal(':email', $data['email']);
            }
            $this->db->bindVal(':id', $data['id']);
            $this->db->bindVal(':firstName', $data['firstName']);
            $this->db->bindVal(':lastName', $data['lastName']);
            $this->db->bindVal(':phone', $data['phone']);
            $this->db->bindVal(':passw', $data['passw']);
            $this->db->bindVal(':priv', $data['priv']);
            $this->db->bindVal(':active', $data['active']);

            // Execute the prepared statement
            $this->db->executeStmt();
            if (!empty($data['imgName'])) {
                // Update user photo
                $this->db->queryDB(
                    "UPDATE user_images SET img_name=:img_name, uploaded_on=now() WHERE user_id=:user_id;"
            );
                $this->db->bindVal(':img_name', $data['imgName']);
                $this->db->bindVal(':user_id', $data['id']);

                $this->db->executeStmt();
            }

            $this->db->commitTransaction();
        } catch (Exception $e) {
            $this->db->rollBackTransaction();
            die(
         "Failed to execute UPDATE user transaction: {$e->getMessage()}"
         );
        }
    }

    // Login user
    public function login($email, $passw)
    {
        $this->db->queryDB('SELECT * FROM users WHERE email = :email');
        $this->db->bindVal(':email', $email);

        $row = $this->db->getSingleResult();
        $hashed_password = $row->passw;
        if (password_verify($passw, $hashed_password)) {
            return $row;
        } else {
            return false;
        }
    }

    // Find user by email
    public function findUserByEmail($email)
    {
        // Query database
        $this->db->queryDB('SELECT * FROM users WHERE email = :email');
        // Bind value
        $this->db->bindVal(':email', $email);
        // Retrieve row from database
        $row = $this->db->getSingleResult();
        return $row;
    }

    // Find if there is another user image with same name
    public function findUserImageByImageName($img_name)
    {
        // Query database
        $this->db->queryDB(
            'SELECT * FROM user_images WHERE img_name = :img_name'
      );
        // Bind value
        $this->db->bindVal(':img_name', $img_name);
        // Retrieve row from database
        $row = $this->db->getSingleResult();
        return $row;
    }

    // Retrieve user by id
    public function getUserById($id)
    {
        // Query Database
        $this->db->queryDB(
            'SELECT * FROM users
            JOIN user_images ON users.id = user_images.user_id
            WHERE users.id = :id;'
      );
        // Bind value
        $this->db->bindVal(':id', $id);
        // Retrieve from database
        $row = $this->db->getSingleResult();

        return $row;
    }

    public function searchUsers($data)
    {
        // Query Database
        if (!empty($data)) {
            $search = "%{$data['keyword']}%";
            $priv = $_SESSION['login_user_priv'];

            // Query without LIMIT clause
            $rows = "SELECT
            users.id AS id,
            users.firstName AS firstName,
            users.lastName AS lastName,
            users.email AS email,
            users.phone AS phone,
            users.createdAt AS createdAt,
            users.modified AS modified,
            users.priv AS priv,
            users.active AS active,
            user_images.user_id as imgUserId,
            user_images.img_name as imgName,
            user_images.uploaded_on as imgDate,
            user_images.status as imgStatus
             FROM users
             JOIN user_images ON users.id = user_images.user_id
             WHERE
                (lower(firstName) LIKE :search
                OR lower(lastName) LIKE :search
                OR lower(email) LIKE :search)
                AND priv <= :priv ORDER BY lastName
                ";

            $this->db->queryDB($rows);

            // Bind value
            $this->db->bindVal(':search', $search);
            $this->db->bindVal(':priv', $priv);
            $this->db->executeStmt();
            $_SESSION['row_count_users'] = $this->db->getRowCount();

            // Now add LIMIT clause to the main query after retrieving row_count
            $limit = " LIMIT " . $data['offset'] . "," . ROWS_PER_PAGE_USERS;
            $this->db->queryDB($rows . $limit);

            $this->db->bindVal(':search', $search);
            $this->db->bindVal(':priv', $priv);

            // Retrieve results
            $results = $this->db->getResultSet();
            return $results;
        }
    }

    public function deleteUser($id)
    {
        try {
            //Query database
            $this->db->queryDB("DELETE FROM users WHERE id = :id;");
            // Bind values
            $this->db->bindVal(':id', $id);
            if ($this->db->executeStmt()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo "Failed to execute DELETE user: " . $e->getMessage();
        }
    }
}
