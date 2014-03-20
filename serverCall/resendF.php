<?php

$id=$_GET["id"];
$auth_token=$_GET["auth_token"];
include 'valF.php';
if(validate($id, $auth_token)){
	$db="u157368432_acn";	
	include('var.php');
  	if (!($iden = db_connection()))
        die("Error: No se pudo conectar".mysql_error()); 
     
  $sentencia = "UPDATE $db.CM_ACTIVATE_ACCT SET SEND_MAIL_FLG='N' where user_id='$id'"; 
   
  mysql_query($sentencia, $iden); 
  
  $data = array('status'=> 'ok');
  echo json_encode($data);
  mysql_close($iden);	
		
	
}else{
	$data = array('status'=> 'exp');
    echo json_encode($data);
}


?>