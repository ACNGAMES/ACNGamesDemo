<?php

$id=$_GET["id"];
$auth_token=$_GET["auth_token"];
include 'valF.php';
if(validate($id, $auth_token)){
		
	//include('var.php');
  	if (!($iden = db_connection()))
        die("Error: No se pudo conectar".mysql_error()); 
  $db="u157368432_acn";  
  $sentencia = "SELECT ev.EVENT_ID, op.URL, ope.ODDS, ope.SELECTION, cat.CATEGORY_ID, bet.BET_DTTM, bet.AMOUNT ,cat.DESCRIPTION as 'DESC', scat.DESCRIPTION, scat.SUB_CATEGORY_ID, ev.EVENT, ev.OFF_DTTM, ev.EVENT_TYPE, bet.USER_ID FROM $db.CM_EVENT ev  
				  INNER JOIN $db.CM_OPPONENT_EVENT ope ON ev.EVENT_ID = ope.EVENT_ID 
			   	  INNER JOIN $db.CM_OPPONENT op ON ope.OPPONENT_ID = op.OPPONENT_ID 
				  INNER JOIN $db.CM_CATEGORY cat ON ev.CATEGORY_ID = cat.CATEGORY_ID  
				  INNER JOIN $db.CM_SUB_CATEGORY scat ON ev.SUB_CATEGORY_ID = scat.SUB_CATEGORY_ID 
				  INNER JOIN $db.CM_BET bet ON ev.EVENT_ID = bet.EVENT_ID AND bet.USER_ID = $id
				  WHERE ev.EVENT_STATUS_FLG = 'O'
				  ORDER BY cat.CATEGORY_ID, scat.SUB_CATEGORY_ID, ev.OFF_DTTM"; 
  // Ejecuta la sentencia SQL 
  $resultado = mysql_query($sentencia, $iden); 
  echo $sentencia;
  if(!$resultado) 
    die("Error: no se pudo realizar la consulta");
  $array=array();
  while($fila = mysql_fetch_assoc($resultado)){
		
	$array[] = array('id'=> $fila['ALERT_ID'],
	    			'alert_cd'=>$fila['ALERT_CD'],
	    			'nav_key' => $fila['NAV_KEY'],
	    			'descr' =>  $fila['DESCR'],
	    			'check_sw' => $fila['CHECK_SW'],
	    			'date' =>  $fila['ALERT_DTTM']
                 );
	}
  $data = array('status'=> 'ok',
					'alerts'=> $array                  
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