<?php

class Page
{
   private $db;

   function __construct()
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
}