<?php

putenv("TZ=America/Buenos_Aires");
$id=$_GET["id"];
$auth_token=$_GET["auth_token"];
$event_id=$_GET["event_id"];
$selection=$_GET["selection"];
$amount=$_GET["amount"];

include 'valF.php';
if($amount >= 0.5 && ($amount*100)%50==0){
if(validate($id, $auth_token)){

	//include('var.php');
  	if (!($iden = db_connection()))
        die("Error: No se pudo conectar".mysql_error()); 
  $db="u157368432_acn";  
  
  //TODO chequear que no exista otra apuesta para ese evento
	$sentencia = "SELECT * FROM $db.CM_BET WHERE user_id='$id' and event_id=$event_id"; 
  	// Ejecuta la sentencia SQL 

	$resultado=mysql_query($sentencia, $iden);
  
  	if(mysql_num_rows($resultado)== 0){
  		mysql_free_result($resultado);
  		//Busco el monto de la apuesta en la tabla de cm_challenge
  		$sentencia = "SELECT * FROM  $db.CM_EVENT WHERE event_id=$event_id and OFF_DTTM > NOW()"; 
  		// Ejecuta la sentencia SQL 
		$resultado=mysql_query($sentencia, $iden);
		//Significa que el evento ya arranco
		if(mysql_num_rows($resultado) > 0){
			$fila = mysql_fetch_assoc($resultado);
			$descr=$fila['EVENT'];
			mysql_free_result($resultado);


			$sentencia = "SELECT * FROM $db.CM_COIN WHERE user_id='$id'"; 
		  	// Ejecuta la sentencia SQL 
			$resultado=mysql_query($sentencia, $iden);
			$fila = mysql_fetch_assoc($resultado);
			$tot_gold=$fila['GOLDEN_COINS'];
			$tot_silver=$fila['SILVER_COINS'];
		    mysql_free_result($resultado);

		  	if($tot_gold+$tot_silver>=$amount){


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
			  	$sentencia = "INSERT INTO $db.CM_CR_MOVES(USER_ID, MOVE_DTTM, MOVE_CD, DESCR, GOLD, TOT_GOLD, TOT_SILVER) VALUES ('$id',NOW(),'B','Se realizo la predicci&oacute;n $descr',$amount,$new_gold,$new_silver)";

			  }else{
			  	$sentencia = "INSERT INTO $db.CM_CR_MOVES(USER_ID, MOVE_DTTM, MOVE_CD, DESCR, GOLD, SILVER, TOT_GOLD, TOT_SILVER) VALUES ('$id',NOW(),'B','Se realizo la predicci&oacute;n  $descr',$tot_gold,$res_silver,$new_gold,$new_silver)";

			  }
			  // Ejecuta la sentencia SQL 
			  mysql_query($sentencia, $iden);


	  	  //GENERO LAS APUESTA
		  $sentencia = "INSERT INTO $db.CM_BET(EVENT_ID, USER_ID, BET_DTTM, OPP_USER_ID, SELECTION, AMOUNT) VALUES ('$event_id','$id',NOW(),'0','$selection','$amount')"; 
	  	  mysql_query($sentencia, $iden);


			$data = array('status'=> 'ok');
		  }else{
		  	$data = array('status'=> 'credit');	
		  }


		  //Envio la respuesta por json
		   echo json_encode($data);

		  // Cierra la conexión con la base de datos 
		  mysql_close($iden);

		}else{
  		mysql_free_result($resultado);
		$data = array('status'=> 'date');
    	echo json_encode($data);
		mysql_close($iden);
  	}

  	}else{
  		mysql_free_result($resultado);
		$data = array('status'=> 'bet');
    	echo json_encode($data);
		mysql_close($iden);
  	}
  

}else{
	$data = array('status'=> 'exp');
    echo json_encode($data);
}
}else{
	$data = array('status'=> 'error');
    echo json_encode($data);
}



?>