<?php

include("../../include/DbConnect.php")
include_once("../../include/DbHandler.php");

if (isset($_POST['rule']) && $_POST['rule'] == 'find') {
  
}else{
  header(var_dump(http_response_code(405)));
}
 ?>
