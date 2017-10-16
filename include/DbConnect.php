<?php

class Connection {

  private $link;
  private $db;

  function __construct($db){
    $this->db = $db;
  }

  function connect(){
    include_once dirname(__FILE__).'/Config.php';

    try {
      if ($this->db == 9){
        $this->link = new PDO('pgsql:host='.DB_HOST.
                              ';port='.DB_PORT.
                              ';dbname='.DB_NAME.
                              ';user='.DB_USERNAME.
                              ';password='.DB_PASSWORD);
      }else{
        $this->link = new PDO('pgsql:host='.DB_HOST.
                              ';port='.DB_PORT.
                              ';dbname='.DB_NAME1.
                              ';user='.DB_USERNAME1.
                              ';password='.DB_PASSWORD1);
      }

      $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->link->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

      return $this->link;

    } catch (PDOException $e) {
        if (defined('ENVIRONMENT') && ENVIRONMENT == 'dev'){
          echo $e->getMessage();
        }
      exit;
    }

  }
}

?>
