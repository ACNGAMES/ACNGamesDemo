<?php
	$new_ps=$_GET["new_ps"];
	$auth_token=$_GET["auth_token"];
	$id=$_GET["id"];
	include('var.php');
	 
  	if (!($iden = db_connection()))
        die("Error: No se pudo conectar".mysql_error());

	$email= getEnterprise();
	if($email==null){
		$data = array('status'=> 'error');
        //Envio la respuesta por json
        echo json_encode($data);
	}else{
		$new_hash = db_hash($email,$new_ps);
		if(valRestoreToken()){
			$sentencia = "UPDATE u970955255_acn.CM_USER SET PASSWORD='$new_hash' where user_id='$id'"; 
  			// Ejecuta la sentencia SQL 
  			mysql_query($sentencia, $iden);				
			
			$sentencia = "DELETE FROM u970955255_acn.CM_WHITENING_PASS where user_id='$id'";
            mysql_query($sentencia, $iden);
			
			$data = array('status'=> 'ok');
        	//Envio la respuesta por json
        	echo json_encode($data);	
		}else{
			$data = array('status'=> 'error');
        	//Envio la respuesta por json
        	echo json_encode($data);
		}
	}
	mysql_close($iden);
	
function valRestoreToken(){
	global $iden;
	global $auth_token;
	global $id;
	
	$sentencia = "SELECT * FROM u970955255_acn.CM_WHITENING_PASS where user_id='$id' and ACTIVATE_TOKEN='$auth_token'"; 
    // Ejecuta la sentencia SQL 
    $resultado = mysql_query($sentencia, $iden); 
    if(!$resultado) 
       die("Error: no se pudo realizar la consulta");
  
    if(mysql_num_rows($resultado)!= 0){
    	mysql_free_result($resultado);
		return true;
	}else{
		mysql_free_result($resultado);
		return false;
	}
};
	
function getEnterprise(){
	global $iden;
	global $id;
	$sentencia = "SELECT * FROM u970955255_acn.CM_USER where user_id='$id'"; 
  // Ejecuta la sentencia SQL 
  $resultado = mysql_query($sentencia, $iden); 
  if(!$resultado) 
    die("Error: no se pudo realizar la consulta");
  
  if(mysql_num_rows($resultado)== 0){
    mysql_free_result($resultado);
    return null;
  }else{
    $fila = mysql_fetch_assoc($resultado);
    $enterprise = $fila['ENTERPRISE_ID']; 
    mysql_free_result($resultado);
	return $enterprise;  
  }
	
	
};
?>