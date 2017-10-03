<?php
/**
 *
 */
class DbLogic
{
  private $db;
  function __construct($conn)
  {
    $this->$db = $conn;
  }

  function bind($sql,$conditions){
    $query = $this->$db->prepare($sql);
    for($i = 0; $i < sizeof($conditions);$i++){
      $quey -> bindParam($i+1,$conditions[$i]);
    }
    return $query->execute();
  }
}

 ?>
