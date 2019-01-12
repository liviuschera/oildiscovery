<?php
/* PDO Database Class
      - connect to database
      - create prepared statements
      - bind values
      - return rows and results
 */

class Database
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $PDOhandler; // DB handler
    private $stmt;
    private $error;

    public function __construct()
    {
        // Set  the PDO_MYSQL Data Source Name (DSN)
        $dsn = "mysql:host={$this->host};dbname={$this->dbname}";
        /* 
        Persistent Database Connections
        http://www.php.net/manual/en/features.persistent-connections.php 
         */
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ];

        // Create a PDO instance
        try {
            $this->PDOhandler = new PDO(
                $dsn,
                $this->user,
                $this->pass,
                $options
            );
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo "Ups! {$this->error}";
        }
    }

    // Prepare statement with query
    public function queryDB($sql)
    {
        $this->stmt = $this->PDOhandler->prepare($sql);
    }

    // Bind values
    public function bindVal($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        /* Binds a value to a corresponding named or question mark
         placeholder in the SQL statement that was used to prepare the statement.  */
        // $this->stmt->bindParam($param, $value, $type);
        $this->stmt->bindValue($param, $value, $type);
    }

    // Start transaction
    public function startTransaction()
    {
        $this->PDOhandler->beginTransaction();
    }

    // Commit transaction
    public function commitTransaction()
    {
        $this->PDOhandler->commit();
    }

    // Roll Back transaction
    public function rollBackTransaction()
    {
        $this->PDOhandler->rollBack();
    }

    // Execute the prepared statement
    public function executeStmt()
    {
        $this->stmt->execute();
    }

    // Get result set as array of objects
    public function getResultSet()
    {
        $this->executeStmt();
        return $this->stmt->fetchAll();
    }

    // Get a single record as object
    public function getSingleResult()
    {
        $this->executeStmt();
        return $this->stmt->fetch();
    }

    // Get row count
    public function getRowCount()
    {
        return $this->stmt->rowCount();
    }
}
?>
