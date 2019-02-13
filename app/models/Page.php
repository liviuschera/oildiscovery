<?php
class Page
{
    private $db;

    function __construct()
    {
        $this->db = new Database();
    }

    public function getPages()
    {
        // Query database
        $this->db->queryDB('SELECT * FROM pages ORDER BY navbar_order ASC;');

        //   Fetch the pages
        $results = $this->db->getResultSet();
        return $results;
    }
}
?>
