<?php

putenv("TZ=America/Buenos_Aires");
$id=$_GET["id"];
$auth_token=$_GET["auth_token"];
$event_id=$_GET["event_id"];
$opp_user=$_GET["opp_user"];

include 'valF.php';

if(validate($id, $auth_token)){
		
	//include('var.php');
  	if (!($iden = db_connection()))
        die("Error: No se pudo conectar".mysql_error()); 
  $db="u157368432_acn";  
  
  
  //Chequear que exista el opp_user
	$sentencia = "SELECT * FROM $db.CM_USER WHERE enterprise_id='$opp_user'"; 
  	// Ejecuta la sentencia SQL 
		
	$resultado=mysql_query($sentencia, $iden);
  	if(mysql_num_rows($resultado)!= 0){
  		$fila = mysql_fetch_assoc($resultado);
		$opp_user_id=$fila['USER_ID'];
		$opp_name=$fila['NAME'];
		mysql_free_result($resultado);
		
	 	
	  	//BUSCO EL NOMBRE DE MI USUARIO
		$sentencia = "SELECT * FROM $db.CM_USER WHERE user_id='$id'"; 
  		// Ejecuta la sentencia SQL 
		$resultado=mysql_query($sentencia, $iden);
	  	$fila = mysql_fetch_assoc($resultado);	
	  	$name=$fila['NAME'];
		mysql_free_result($resultado);
			
		$sentencia = "SELECT * FROM  $db.CM_EVENT WHERE event_id=$event_id"; 
  		// Ejecuta la sentencia SQL 
		$resultado=mysql_query($sentencia, $iden);
		$fila = mysql_fetch_assoc($resultado);
		$descr=$fila['EVENT'];
		mysql_free_result($resultado);
		
	  	  //GENERO LA 
	  	  $body = "Hola $opp_name: <br/>$name te recomienda el evento $descr <br> haga <a href=\"#\" onclick=\"openEvent($event_id)\">click aqui</a> para verlo completo <br/>Saludos.<br/>ACN Games";
		  $sentencia = "INSERT INTO $db.CM_MSG(TO_ID, FROM_ID, SUBJECT, BODY, MSG_DTTM) VALUES('$opp_user_id','$id','$name Te envia un evento','$body', NOW())"; 
	  	  mysql_query($sentencia, $iden);
			
		  $data = array('status'=> 'ok');
		  
		  //Envio la respuesta por json
		   echo json_encode($data);
		  
		  // Cierra la conexión con la base de datos 
		  mysql_close($iden);
			
  }else{
  		mysql_free_result($resultado);
		$data = array('status'=> 'user');
    	echo json_encode($data);
		mysql_close($iden);
  }
	
}else{
	$data = array('status'=> 'exp');
    echo json_encode($data);
}




?>