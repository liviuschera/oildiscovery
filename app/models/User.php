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
}
?>
