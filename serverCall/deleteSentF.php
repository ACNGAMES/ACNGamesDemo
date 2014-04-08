<?php

putenv("TZ=America/Buenos_Aires");
$id=$_GET["id"];
$auth_token=$_GET["auth_token"];
$msg_id=$_GET["msg_id"];
include 'valF.php';
if(validate($id, $auth_token)){
		
	//include('var.php');
  	if (!($iden = db_connection()))
        die("Error: No se pudo conectar".mysql_error()); 
  $db="u157368432_acn";  
  $sentencia = "DELETE FROM $db.CM_MSG_SENT where msg_id='$msg_id' and from_id='$id'"; 
  // Ejecuta la sentencia SQL 
  mysql_query($sentencia, $iden); 
  $data = array('status'=> 'ok');

 	//Envio la respuesta por json
 	echo json_encode($data);
  	
  // Cierra la conexión con la base de datos 
  mysql_close($iden);	
		
	
}else{
	$data = array('status'=> 'exp');
    echo json_encode($data);
}


?>