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
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        // Create a PDO instance
        try {
            $this->PDOhandler = new PDO(
                $dsn,
                $this->user,
                $this->pass,
                $options
            );
            $this->PDOhandler->setAttribute(
                PDO::ATTR_DEFAULT_FETCH_MODE,
                PDO::FETCH_OBJ
            );
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
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
            switch ($type) {
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
        $this->stmt->bindValue($param, $value, $type);
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
