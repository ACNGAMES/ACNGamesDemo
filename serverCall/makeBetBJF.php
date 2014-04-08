<?php

putenv("TZ=America/Buenos_Aires");
$id=$_GET["id"];
$auth_token=$_GET["auth_token"];
$amount=$_GET["amount"];
$descr=$_GET["descr"];

include 'valF.php';
if(validate($id, $auth_token)){
		
	//include('var.php');
  	if (!($iden = db_connection()))
        die("Error: No se pudo conectar".mysql_error()); 
  $db="u157368432_acn";  
  
  $newID= mt_rand();
  $sentencia = "INSERT INTO $db.CM_BJ VALUES ('$id','$newID',NOW())"; 
  // Ejecuta la sentencia SQL 
  mysql_query($sentencia, $iden);
  
  $sentencia = "SELECT * FROM $db.CM_COIN WHERE user_id='$id'"; 
  	// Ejecuta la sentencia SQL 
	$resultado=mysql_query($sentencia, $iden);
	$fila = mysql_fetch_assoc($resultado);
	$tot_gold=$fila['GOLDEN_COINS'];
	$tot_silver=$fila['SILVER_COINS'];
    mysql_free_result($resultado);
  
  	if($tot_gold+$tot_silver>$amount){
  
  		
  		if($tot_gold>=$amount){
  			$res_silver=0;
  			$new_gold=$tot_gold-$amount;
			$new_silver=$tot_silver;
  		}else{
  			$res_silver=$amount-$tot_gold;
  			$new_gold=0;
			$new_silver=$tot_silver+$tot_gold-$amount;
  		}
	  
	  //Actualizo la cantidad de monedas
	  $sentencia = "UPDATE $db.CM_COIN SET SILVER_COINS=$new_silver, GOLDEN_COINS=$new_gold where user_id='$id'"; 
	  // Ejecuta la sentencia SQL 
	  mysql_query($sentencia, $iden); 
	  //agrego un regitro en la tabla de movimientos
	  if($res_silver==0){
	  	$sentencia = "INSERT INTO $db.CM_CR_MOVES(USER_ID, MOVE_DTTM, MOVE_CD, DESCR, GOLD, TOT_GOLD, TOT_SILVER) VALUES ('$id',NOW(),'B','$descr',$amount,$new_gold,$new_silver)";
			
	  }else{
	  	$sentencia = "INSERT INTO $db.CM_CR_MOVES(USER_ID, MOVE_DTTM, MOVE_CD, DESCR, GOLD, SILVER, TOT_GOLD, TOT_SILVER) VALUES ('$id',NOW(),'B','$descr',$tot_gold,$res_silver,$new_gold,$new_silver)";
		
	  }
	  // Ejecuta la sentencia SQL 
	  mysql_query($sentencia, $iden);
	  //Borro el regitro de la tabla de pagos
	  
	  $data = array('status'=> 'ok',
	  				'id'=> $newID);
  }else{
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