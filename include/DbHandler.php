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
    if (isset($conditions["rule"]) && $conditions["rule"] == "find"){
      $stament = "'".$conditions['nombre']."'";
      /*$query->bindParam(1,$stament,PDO::PARAM_STR);*/
      $query->execute();
      return $query-> fetchAll();
    }

  }
}

 ?>
