<?php

$id=$_GET["id"];
$auth_token=$_GET["auth_token"];
$opp_user=$_GET["opp_user"];
$event_id=$_GET["event_id"];
include 'valF.php';
if(validate($id, $auth_token)){
		
	//include('var.php');
  	if (!($iden = db_connection()))
        die("Error: No se pudo conectar".mysql_error()); 
  $db="u157368432_acn";  
  $sentencia = "SELECT EVENT, OPPONENT_NAME, AMOUNT, ope.OPPONENT_ID 'OPP_ID'   
  				  FROM $db.CM_EVENT ev  
				  INNER JOIN $db.CM_OPPONENT_EVENT ope ON ev.EVENT_ID = ope.EVENT_ID
				  INNER JOIN $db.CM_OPPONENT op ON ope.OPPONENT_ID = op.OPPONENT_ID 
				  INNER JOIN $db.CM_CHALLENGE bet ON ev.EVENT_ID = bet.EVENT_ID 
				  WHERE ev.EVENT_STATUS_FLG = 'O' 
				  and bet.USER_ID = $id 
				  and bet.USER_OPP_ID = $opp_user 
				  and bet.EVENT_ID=$event_id
				  and bet.OPPONENT_ID!=ope.OPPONENT_ID"; 
  // Ejecuta la sentencia SQL 
  $resultado = mysql_query($sentencia, $iden); 
  
  if(!$resultado) 
    die("Error: no se pudo realizar la consulta");
  $array=array();
  //Inicializo las varialbes
	 $array = array();
	 
	 while ($fila = mysql_fetch_assoc($resultado)) {
     		//grabo la info de cada oponente	
     		$array[]= array('opp_name' => $fila['OPPONENT_NAME'],
    						'opp_id' => $fila['OPP_ID'],
    						'amount'=>$fila['AMOUNT'],
    						'event_id'=>$event_id,
                            'opp_user' => $opp_user													
    						);
             		     	
     }
  $data = array('status'=> 'ok',
  				'event_d' => $fila['EVENT'],
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