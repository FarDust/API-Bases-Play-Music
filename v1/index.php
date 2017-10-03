<?php

define('ENVIRONMENT','dev');


header('Content-Type: application/json');

include("../include/DbConnect.php");
include_once("../include/DbHandler.php");

if (isset($_POST['rule']) && $_POST['rule'] == 'find') {
  $response;
  $db = new Connection();
  $logic = new DbLogic($db);
  unset($_POST['rule']);
  if (isset($_POST['option']) && $_POST['option'] == 'banda'){
    $sql = 'SELECT * FROM Banda WHERE Banda.nombre = ?';
    unset($_POST['option']);
    $response = $logic->bind($sql,$_POST);
    header(http_response_code(200));
  }elseif (isset($_POST['option']) && $_POST['option'] == 'artista') {
    $sql = 'SELECT * FROM Artista WHERE Artista.nombre = ?';
    unset($_POST['option']);
    $response = $logic->bind($sql,$_POST);
    header(http_response_code(200));
  } else {
    header(http_response_code(400));
    $response = "{'error' : 400}";
  }
  if (defined('ENVIRONMENT') && ENVIRONMENT == 'dev' && isset($sql)){
    var_dump($sql);
  }
  echo json_encode($response);
}else{
  header(http_response_code(405));
  $response = "{'error' : 400}";
  echo json_encode($response);
}
 ?>
