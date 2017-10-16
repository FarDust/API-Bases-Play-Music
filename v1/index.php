<?php

#define('ENVIRONMENT','dev');


header('Content-Type: application/json');

include("../include/DbConnect.php");
include_once("../include/DbHandler.php");

if (isset($_POST['rule']) && $_POST['rule'] == 'find') {
  $response;
  $db9 = new Connection(9);
  $logic9 = new DbLogic($db9);
  $db28 = new Conection(28);
  $logic28 = new DbLogic($db28)
  unset($_POST['rule']);
  if (isset($_POST['option']) && $_POST['option'] == 'banda'){
    $sql =
      'SELECT Artista.nombre, Email.email
      FROM Banda, Miembro, Artista, HasEmail, Email
      WHERE Banda.nombre = ?
      AND Miembro.idb = Banda.id
      AND Miembro.ida = Artista.id
      AND Artista.id = HasEmail.id
      AND HasEmail.email = Email.email';
    unset($_POST['option']);
    $response = $logic9->bind($sql,$_POST);
    header(http_response_code(200));
  }elseif (isset($_POST['option']) && $_POST['option'] == 'artista') {
    $sql =
    'SELECT *
      FROM Artista, HasEmail, Email
      WHERE Artista.nombre = ?
      AND Artista.id = HasEmail.id
      AND HasEmail.email = Email.email';
    unset($_POST['option']);
    $response = $logic9->bind($sql,$_POST);
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
