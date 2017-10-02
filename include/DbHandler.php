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

  function bind(sql,conditions){
    $query = $this->db->prepare($sql);
    for($i = 0; $i < sizeof($conditions);$i++){
      $quey -> bindParam($i+1,$conditions[$i]);
    }
    return $query->execute();
  }
}

 ?>
