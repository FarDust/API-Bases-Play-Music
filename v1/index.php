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
  $db28 = new Connection(28);
  $logic28 = new DbLogic($db28);
  $statement = $_POST['nombre'];
  if (isset($_POST['option']) && $_POST['option'] == 'banda'){
    $sql =
      "SELECT Artista.nombre, Email.email
      FROM Banda, Miembro, Artista, HasEmail, Email
      WHERE Banda.nombre = \'$statement\'
      AND Miembro.idb = Banda.id
      AND Miembro.ida = Artista.id
      AND Artista.id = HasEmail.id
      AND HasEmail.email = Email.email
      AND (Miembro.fecha_abandono > NOW()
      OR Miembro.fecha_abandono = null)
      AND Miembro.fecha_ingreso < NOW()";
      $fullresponse['a_members'] = $logic9->bind($sql,$_POST);
      $sql =
        "SELECT Artista.nombre, Email.email
        FROM Banda, Miembro, Artista, HasEmail, Email
        WHERE Banda.nombre = \'$statement\'
        AND Miembro.idb = Banda.id
        AND Miembro.ida = Artista.id
        AND Artista.id = HasEmail.id
        AND HasEmail.email = Email.email
        AND (Miembro.fecha_abandono < NOW() OR Miembro.fecha_abandono != null";
        $fullresponse['r_members'] = $logic9->bind($sql,$_POST);
        $sql =
          "SELECT Disco.nombre
          FROM Banda, Disco, BandaAutorOf, Miembro, Artista
          WHERE Banda.id = BandaAutorOf.idd
          AND Disco.id = BandaAutorOf.idd
          AND Banda.id = Miembro.idb
          AND Artista.id = Miembro.ida
          AND Artista.nombre = \'$statement\'
          UNION SELECT Artista.nombre
          FROM Artista, Disco, ArtistaAutorOf
          WHERE Artista.id = ArtistaAutorOf.idd
          AND Disco.id = ArtistaAutorOf.idd
          AND Artista.nombre = \'$statement\'";
        $fullresponse['discs'] = $logic9->bind($sql,$_POST);
    header(http_response_code(200));
  }elseif (isset($_POST['option']) && $_POST['option'] == 'artista') {
    $sql =
      "SELECT Artista.nombre, Email.email
      FROM Banda, Miembro, Artista, HasEmail, Email,
      (SELECT banda.id
        FROM Artista, Miembro, Banda
        WHERE Artista.nombre = \'$statement\'
        AND Artista.id = Miembro.ida
        AND Miembro.idb = Banda.id) AS A
      WHERE A.id = Banda.id
      AND Miembro.idb = Banda.id
      AND Miembro.ida = Artista.id
      AND Artista.id = HasEmail.id
      AND HasEmail.email = Email.email
      AND (Miembro.fecha_abandono > NOW()
      OR Miembro.fecha_abandono = null)
      AND Miembro.fecha_ingreso < NOW()";
    $fullresponse['a_members'] = $logic9->bind($sql,$_POST);
    $sql =
    "SELECT Artista.nombre, Email.email
    FROM Banda, Miembro, Artista, HasEmail, Email,
    (SELECT banda.id
      FROM Artista, Miembro, Banda
      WHERE Artista.nombre = \'$statement\'
      AND Artista.id = Miembro.ida
      AND Miembro.idb = Banda.id) AS A
    WHERE A.id = Banda.id
    AND Miembro.idb = Banda.id
    AND Miembro.ida = Artista.id
    AND Artista.id = HasEmail.id
    AND HasEmail.email = Email.email
    AND Miembro.fecha_abandono < NOW()";
    $fullresponse['r_members'] = $logic9->bind($sql,$_POST);
    $sql =
      "SELECT Disco.nombre
      FROM Banda, Disco, BandaAutorOf, Miembro, Artista
      WHERE Banda.id = BandaAutorOf.idd
      AND Disco.id = BandaAutorOf.idd
      AND Banda.id = Miembro.idb
      AND Artista.id = Miembro.ida
      AND Artista.nombre = \'$statement\'
      UNION SELECT Artista.nombre
      FROM Artista, Disco, ArtistaAutorOf
      WHERE Artista.id = ArtistaAutorOf.idd
      AND Disco.id = ArtistaAutorOf.idd
      AND Artista.nombre = \'$statement\'";
    $fullresponse['discs'] = $logic9->bind($sql,$_POST);
    header(http_response_code(200));
  } else {
    header(http_response_code(400));
    $fullresponse = "{'error' : 400}";
  }
  if (defined('ENVIRONMENT') && ENVIRONMENT == 'dev' && isset($sql)){
    var_dump($sql);
  }

  echo json_encode($fullresponse);
}else{
  header(http_response_code(405));
  $fullresponse = "{'error' : 405}";
  echo json_encode($fullresponse);
}
 ?>
