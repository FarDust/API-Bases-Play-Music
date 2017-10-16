<?php

#define('ENVIRONMENT','dev');

header('Content-Type: application/json');

include_once("../include/DbConnect.php");
include_once("../include/DbHandler.php");

if (isset($_POST['rule']) && $_POST['rule'] == 'find') {
  $response;
  $fullresponse = [];
  $db9 = new Connection(9);
  $logic9 = new DbLogic($db9);
  $db28 = new Conection(28);
  $logic28 = new DbLogic($db28);
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
    unset($_POST['option']);
    $sql =
      'SELECT Artista.nombre, Email.email
      FROM Banda, Miembro, Artista, HasEmail, Email
      WHERE Artista.nombre = ?
      AND Miembro.idb = Banda.id
      AND Miembro.ida = Artista.id
      AND Artista.id = HasEmail.id
      AND HasEmail.email = Email.email
      AND Miembro.fecha_abandono = null';
    $response = $logic9->bind($sql,$_POST);
    $fullresponse['a_members'] = $response;
    $sql =
      'SELECT Artista.nombre
      FROM Banda,Disco, BandaAutorOf, Miembro, Artista
      WHERE Banda.id = BandaAutorOf.idd
      AND Disco.id = BandaAutorOf.idd
      AND Banda.id = Miembro.idb
      AND Artista.id = Miembro.ida
      AND Artista.nombre = ?
      UNION SELECT Artista.nombre
      FROM Artista, Disco, ArtistaAutorOf
      WHERE Artista.id = ArtistaAutorOf.idd
      AND Disco.id = ArtistaAutorOf.idd
      AND Artista.nombre = ?';
    $response = $logic9->bind($sql,$_POST);
    $fullresponse['discs'] = $response;
    header(http_response_code(200));
  } else {
    header(http_response_code(400));
    $response = "{'error' : 400}";
  }
  if (defined('ENVIRONMENT') && ENVIRONMENT == 'dev' && isset($sql)){
    var_dump($sql);
  }

  echo json_encode($fullresponse);
}else{
  header(http_response_code(405));
  $response = "{'error' : 405}";
  echo json_encode($response);
}
 ?>
