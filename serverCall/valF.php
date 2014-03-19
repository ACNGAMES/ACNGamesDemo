<?php

function validate($id, $auth_token){
	include('var.php');
  	if (!($iden = db_connection()))
    	die("Error: No se pudo conectar".mysql_error()); 
    
  	$sentencia = "SELECT * FROM u970955255_acn.CM_USER where user_id='$id' and auth_token='$auth_token'";// where email='$email' and ps='$ps'"; 
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
    
  	$sentencia = "SELECT * FROM u970955255_acn.CM_ACTIVATE_ACCT where user_id='$id' and activate_token='$auth_token'";// where email='$email' and ps='$ps'"; 
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

