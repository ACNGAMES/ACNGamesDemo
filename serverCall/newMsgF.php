<?php

$id=$_GET["id"];
$to=$_GET["to"];
$auth_token=$_GET["auth_token"];
$subject=$_GET["subject"];
$body=$_GET["body"];
include 'valF.php';
if(validate($id, $auth_token)){
		
	//include('var.php');
  	if (!($iden = db_connection()))
        die("Error: No se pudo conectar".mysql_error()); 
  $db="u157368432_acn";  
  $sentencia = "INSERT INTO $db.CM_MSG(TO_ID, FROM_ID, SUBJECT, BODY, MSG_DTTM) VALUES('$to','$id','$subject','$body', NOW())"; 
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