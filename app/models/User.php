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
        // Query database
        $this->db->queryDB(
            'INSERT INTO users (first_name, last_name, email, phone, passw) VALUES (:first_name, :last_name, :email, :phone, :passw)'
        );
        // Bind values
        $this->db->bindVal(':first_name', $data['first_name']);
        $this->db->bindVal(':last_name', $data['last_name']);
        $this->db->bindVal(':email', $data['email']);
        $this->db->bindVal(':phone', $data['phone']);
        $this->db->bindVal(':passw', $data['passw']);

        // Execute the prepared statement
        if ($this->db->executeStmt()) {
            return true;
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
