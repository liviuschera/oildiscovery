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
            // Query database
            $this->db->queryDB(
                'INSERT INTO users (firstName, lastName, email, phone, passw) VALUES (:firstName, :lastName, :email, :phone, :passw)'
            );
            // Bind values
            $this->db->bindVal(':firstName', $data['firstName']);
            $this->db->bindVal(':lastName', $data['lastName']);
            $this->db->bindVal(':email', $data['email']);
            $this->db->bindVal(':phone', $data['phone']);
            $this->db->bindVal(':passw', $data['passw']);

            // Execute the prepared statement
            $this->db->executeStmt();
            return true;
        } catch (Exception $e) {
            echo "Failed to execute statement: " . $e->getMessage();
            return false;
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

        //   Check if DB has any record with the $email
        if ($this->db->getRowCount() > 0) {
            return true;
        } else {
            return false;
        }
        //   $this->db->getRowCount() > 0 ? true : false;
    }

    // Get user by id
    public function getUserById($id)
    {
        // Query Database
        $this->db->queryDB('SELECT * FROM users WHERE id = :id');
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
            users.active AS active 
             FROM users WHERE 
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
}
?>
