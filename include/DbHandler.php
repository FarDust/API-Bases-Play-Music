<?php
/**
 *
 */
class DbLogic
{

  function __construct(conn)
  {
    private $db = conn.connect();
  }

  function find(type,labels,conditions){
    $query = $this->db->prepare("");
    for($i = 0; $i < sizeof($conditions);$i++){
      $quey -> bindParam($i+1,$conditions[$i]);
    }
    $query->execute();
  }
}

 ?>
