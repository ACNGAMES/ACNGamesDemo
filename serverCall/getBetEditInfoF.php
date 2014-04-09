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
  $sentencia = "SELECT EVENT, OPPONENT_NAME, ODDS, ope.OPPONENT_ID 'OPP_ID', AMOUNT, SELECTION   
  				  FROM $db.CM_EVENT ev  
				  INNER JOIN $db.CM_OPPONENT_EVENT ope ON ev.EVENT_ID = ope.EVENT_ID
				  INNER JOIN $db.CM_OPPONENT op ON ope.OPPONENT_ID = op.OPPONENT_ID 
				  INNER JOIN $db.CM_BET be ON  ev.EVENT_ID = be.EVENT_ID
				  WHERE ev.EVENT_STATUS_FLG = 'O' 
				  and ev.EVENT_ID = $event_id
				  and be.USER_ID = $id"; 
  // Ejecuta la sentencia SQL 
  
  $resultado = mysql_query($sentencia, $iden); 
  
  if(!$resultado) 
    die("Error: no se pudo realizar la consulta");
  $array=array();
   
	 while ($fila = mysql_fetch_assoc($resultado)) {
     		//grabo la info de cada oponente	
     		
     		$array[]= array('opp_name' => $fila['OPPONENT_NAME'],
    						'opp_id' => $fila['OPP_ID'],
    						'odds' => $fila['ODDS']
    						);
             		     	$event_d=$fila['EVENT'];
							$amount=$fila['AMOUNT'];
							$selection=$fila['SELECTION'];
             		     	
     }
  $data = array('status'=> 'ok',
  				'event_id'=>$event_id,
                'event_d' => $event_d,
                'amount' => $amount,
                'selection' => $selection,
  				'opponents'=> $array                  
    );
  mysql_free_result($resultado);
 	//Envio la respuesta por json
 echo json_encode($data);
 
  // Cierra la conexión con la base de datos 
  mysql_close($iden);	
		
	
}else{
	$data = array('status'=> 'exp');
    echo json_encode($data);
}


?>