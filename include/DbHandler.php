<?php
/**
 *
 */
class DbLogic
{
  private $db;
  function __construct($conn)
  {
    $this->db = $conn->connect();
  }

  function bind($sql,$conditions){
    $query = $this->db->prepare($sql);
    if (isset[$conditions["rule"]] && $conditions["rule"] == "find"){
      $query->bindParam(1,$conditions['nombre']);
    }
    
    return $query->execute();
  }
}

 ?>
