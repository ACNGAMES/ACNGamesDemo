<?php

putenv("TZ=America/Buenos_Aires");
$db="u157368432_acn";

function validate($id, $auth_token){
	include('var.php');
	global $db;
  	if (!($iden = db_connection()))
    	die("Error: No se pudo conectar".mysql_error()); 
    
  	$sentencia = "SELECT * FROM $db.CM_USER where user_id='$id' and auth_token='$auth_token'";// where email='$email' and ps='$ps'"; 
  	$resultado = mysql_query($sentencia, $iden); 
  	if(!$resultado) 
    	die("Error: no se pudo realizar la consulta");
  
  	if(mysql_num_rows($resultado)== 0){
        mysql_free_result($resultado);
        mysql_close($iden);
        return false;
  	}else{
        mysql_free_result($resultado);
        mysql_close($iden);
		return true;
		
  	}

};

function validateAct($id, $auth_token){
	include('var.php');
  	if (!($iden = db_connection()))
    	die("Error: No se pudo conectar".mysql_error()); 
	global $db;
  	$sentencia = "SELECT * FROM $db.CM_ACTIVATE_ACCT where user_id='$id' and activate_token='$auth_token'";// where email='$email' and ps='$ps'"; 
  	$resultado = mysql_query($sentencia, $iden); 
  	if(!$resultado) 
    	die("Error: no se pudo realizar la consulta");
  
  	if(mysql_num_rows($resultado)== 0){
        mysql_free_result($resultado);
        mysql_close($iden);
        return false;
  	}else{
        mysql_free_result($resultado);
        mysql_close($iden);
		return true;
		
  	}

};
?>

