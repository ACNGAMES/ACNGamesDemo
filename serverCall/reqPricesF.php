<?php

putenv("TZ=America/Buenos_Aires");
$id=$_GET["id"];
$prod_id=$_GET["prod_id"];
$auth_token=$_GET["auth_token"];
include 'valF.php';
if(validate($id, $auth_token)){
		
	//include('var.php');
  	if (!($iden = db_connection()))
        die("Error: No se pudo conectar".mysql_error()); 
  $db="u157368432_acn";  
  $sentencia = "SELECT * FROM $db.CM_STORE inner join $db.CM_COIN on CR<=SILVER_COINS where PRODUCT_ID='$prod_id' AND CM_COIN.USER_ID='$id' and QTY>0"; 
  // Ejecuta la sentencia SQL 
  $resultado = mysql_query($sentencia, $iden); 
  if(!$resultado) 
    die("Error: no se pudo realizar la consulta");
  $array=array();
  if($fila = mysql_fetch_assoc($resultado)){
		
	$price = $fila['CR'];
	$descr = $fila['DESCR'];
	$descr="Se canjeo: $descr";
	$silver_coins = $fila['SILVER_COINS'];
	$golden_coins = $fila['GOLDEN_COINS'];
	$silver_coins=$silver_coins-$price;
	$sentencia = "UPDATE $db.CM_COIN SET SILVER_COINS=SILVER_COINS-$price where user_id='$id'"; 
	  // Ejecuta la sentencia SQL 
	mysql_query($sentencia, $iden); 
	//agrego un regitro en la tabla de movimientos
	$sentencia = "INSERT INTO $db.CM_CR_MOVES(USER_ID, MOVE_DTTM, MOVE_CD, DESCR, SILVER, TOT_GOLD, TOT_SILVER) VALUES ('$id',NOW(),'P','$descr',$price,$golden_coins,$silver_coins)";
	// Ejecuta la sentencia SQL 
	mysql_query($sentencia, $iden);
	$sentencia = "INSERT INTO $db.CM_STORE_USER VALUES ('$prod_id','$id',NOW(),'N')";
	// Ejecuta la sentencia SQL 
	mysql_query($sentencia, $iden);
	
	$sentencia = "UPDATE $db.CM_STORE SET QTY=QTY-1 where PRODUCT_ID='$prod_id'"; 
	  // Ejecuta la sentencia SQL 
	mysql_query($sentencia, $iden);			 
		$data = array('status'=> 'ok');
		mysql_free_result($resultado);
	}else{
		$data = array('status'=> 'disp');
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