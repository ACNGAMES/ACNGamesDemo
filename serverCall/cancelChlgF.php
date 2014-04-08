<?php

putenv("TZ=America/Buenos_Aires");
$id=$_GET["id"];
$auth_token=$_GET["auth_token"];
$event_id=$_GET["event_id"];

include 'valF.php';
if(validate($id, $auth_token)){
		
	//include('var.php');
  	if (!($iden = db_connection()))
        die("Error: No se pudo conectar".mysql_error()); 
  $db="u157368432_acn";  
  
  
  $sentencia = "SELECT * FROM $db.CM_CHALLENGE 
  				INNER JOIN $db.CM_USER ON CM_USER.USER_ID=CM_CHALLENGE.USER_ID 
  				INNER JOIN $db.CM_EVENT ON CM_EVENT.EVENT_ID=CM_CHALLENGE.EVENT_ID
  				WHERE CM_CHALLENGE.USER_ID=$id and CM_CHALLENGE.EVENT_ID=$event_id"; 
  // Ejecuta la sentencia SQL 
  $resultado=mysql_query($sentencia, $iden);
  $fila = mysql_fetch_assoc($resultado);
  $user_opp_id=$fila['USER_OPP_ID'];
  $name=$fila['NAME'];
  $event_d=$fila['EVENT'];
  $amount=$fila['AMOUNT'];
  mysql_free_result($resultado);
  
  $sentencia = "DELETE FROM $db.CM_CHALLENGE WHERE USER_ID=$id and EVENT_ID=$event_id"; 
  // Ejecuta la sentencia SQL 
  mysql_query($sentencia, $iden);
  
  
  
  $sentencia = "INSERT INTO $db.CM_ALERT(USER_ID, ALERT_CD,DESCR, ALERT_DTTM) VALUES ('$user_opp_id','DE','$name cancelo el desafio $event_d.',NOW())"; 
  mysql_query($sentencia, $iden); 
  
  
  $sentencia = "SELECT * FROM $db.CM_COIN WHERE user_id='$id'"; 
  	// Ejecuta la sentencia SQL 
	$resultado=mysql_query($sentencia, $iden);
	$fila = mysql_fetch_assoc($resultado);
	$tot_gold=$fila['GOLDEN_COINS'];
	$new_silver=$fila['SILVER_COINS'];
	mysql_free_result($resultado);
  
  	$new_gold=$tot_gold+$amount;
	  //Actualizo la cantidad de monedas
	$sentencia = "UPDATE $db.CM_COIN SET GOLDEN_COINS=$new_gold where user_id='$id'"; 
	  // Ejecuta la sentencia SQL 
	  mysql_query($sentencia, $iden); 
	  //agrego un regitro en la tabla de movimientos
	  $sentencia = "INSERT INTO $db.CM_CR_MOVES(USER_ID, MOVE_DTTM, MOVE_CD, DESCR, GOLD, TOT_GOLD, TOT_SILVER) VALUES ('$id',NOW(),'R','Se Retiro el Desafio $event_d',$amount,$new_gold,$new_silver)";
	  // Ejecuta la sentencia SQL 
	  mysql_query($sentencia, $iden);
	  //Borro el regitro de la tabla de pagos
	  
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