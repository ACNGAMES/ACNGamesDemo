<?php

$id=$_GET["id"];
$auth_token=$_GET["auth_token"];
include 'valF.php';
if(validate($id, $auth_token)){
		
	if(!($iden = mysql_connect("localhost:3306", "u970955255_acn", "sys123")))
        die("Error: No se pudo conectar".mysql_error()); 
     
  $sentencia = "UPDATE u970955255_acn.CM_ACTIVATE_ACCT SET SEND_MAIL_FLG='N' where user_id='$id'"; 
   
  mysql_query($sentencia, $iden); 
  
  $data = array('status'=> 'ok');
  echo json_encode($data);
  mysql_close($iden);	
		
	
}else{
	$data = array('status'=> 'exp');
    echo json_encode($data);
}


?>