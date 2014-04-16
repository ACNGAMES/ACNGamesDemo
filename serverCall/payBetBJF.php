<?php

putenv("TZ=America/Buenos_Aires");
$id=$_GET["id"];
$auth_token=$_GET["auth_token"];
$amount=$_GET["amount"];
$bj_id=$_GET["bj_id"];
$descr=$_GET["descr"];

include 'valF.php';
if(validate($id, $auth_token)){
		
	//include('var.php');
  	if (!($iden = db_connection()))
        die("Error: No se pudo conectar".mysql_error()); 
  $db="u157368432_acn";  
  $sentencia = "SELECT * FROM $db.CM_BJ WHERE user_id='$id' and bj_id='$bj_id'"; 
  // Ejecuta la sentencia SQL 
  $resultado=mysql_query($sentencia, $iden);
  if(mysql_num_rows($resultado)!= 0){
  	
	  mysql_free_result($resultado);
	  
	  
	  //Actualizo la cantidad de monedas
	  $sentencia = "UPDATE $db.CM_COIN SET SILVER_COINS=SILVER_COINS+$amount where user_id='$id'"; 
	  // Ejecuta la sentencia SQL 
	  mysql_query($sentencia, $iden); 
	  $sentencia = "SELECT * FROM $db.CM_COIN WHERE user_id='$id'"; 
  	// Ejecuta la sentencia SQL 
  		$resultado=mysql_query($sentencia, $iden);
		$fila = mysql_fetch_assoc($resultado);
		$tot_gold=$fila['GOLDEN_COINS'];
		$tot_silver=$fila['SILVER_COINS'];
		mysql_free_result($resultado);
	  //agrego un regitro en la tabla de movimientos
	  $sentencia = "INSERT INTO $db.CM_CR_MOVES(USER_ID, MOVE_DTTM, MOVE_CD, DESCR ,SILVER, TOT_GOLD, TOT_SILVER) VALUES ('$id','".NOW()."','G','$descr',$amount,$tot_gold,$tot_silver)"; 
	  // Ejecuta la sentencia SQL 
	  mysql_query($sentencia, $iden);
	  //Borro el regitro de la tabla de pagos
	  $sentencia = "DELETE FROM $db.CM_BJ WHERE user_id='$id' and bj_id='$bj_id'"; 
	  // Ejecuta la sentencia SQL 
	  mysql_query($sentencia, $iden); 
	  
	  $data = array('status'=> 'ok');
  }else{
  	mysql_free_result($resultado);
  	$data = array('status'=> 'error');	
  }
  
  //Envio la respuesta por json
   echo json_encode($data);
  
  // Cierra la conexión con la base de datos 
  mysql_close($iden);	
		
	
}else{
	$data = array('status'=> 'exp');
    echo json_encode($data);
}



?>