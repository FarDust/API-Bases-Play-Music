<?php
header('Content-Type: application/json');

include("../include/DbConnect.php");
include_once("../include/DbHandler.php");

if (isset($_POST['rule']) && $_POST['rule'] == 'find') {
  $responce;
  $db = new Connection();
  $logic = new DbLogic($db);
  unset($_POST['rule']);
  if (isset($_POST['option']) && $_POST['option'] == 'banda'){
    $sql = 'SELECT * FROM Banda WHERE Banda.nombre = ?';
    unset($_POST['option']);
    $responce = $logic->bind($sql,$_POST);
    header(http_response_code(200));
  }elseif (isset($_POST['option']) && $_POST['option'] == 'artista') {
    $sql = 'SELECT * FROM Artista WHERE Banda.nombre = ?';
    unset($_POST['option']);
    $responce = $logic->bind($sql,$_POST);
    header(http_response_code(200));
  } else {
    header(http_response_code(400));
    $responce = "{'error' : 400}";
  }
  echo json_encode($responce);
}else{
  header(http_response_code(405));
  $responce = "{'error' : 400}";
  echo json_encode($responce);
}
 ?>
