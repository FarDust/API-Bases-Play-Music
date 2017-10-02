<?php

class Connection {

  private $link;

  function __construct(){

  }

  function connect(){
    include_once dirname(__FILE__).'./Config.php';

    try {
      $this->link = new PDO('psql:host='.DB_HOST.
                            ';port='.DB_PORT.
                            ';dbname='.DB_NAME.
                            ';user='.DB_USERNAME.
                            ';password='.DB_PASSWORD);
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
