<?php

putenv("TZ=America/Buenos_Aires");
$id=$_GET["id"];
$auth_token=$_GET["auth_token"];
include 'valF.php';
if(validate($id, $auth_token)){
		
	//include('var.php');
  	if (!($iden = db_connection()))
        die("Error: No se pudo conectar".mysql_error()); 
  $db="u157368432_acn";  
  $sentencia = "SELECT * FROM $db.CM_ALERT where user_id='$id' and check_sw='N' order by ALERT_DTTM desc"; 
  // Ejecuta la sentencia SQL 
  $resultado = mysql_query($sentencia, $iden); 
  if(!$resultado) 
    die("Error: no se pudo realizar la consulta");
  $array=array();
  while($fila = mysql_fetch_assoc($resultado)){
		
	$array[] = array('id'=> $fila['ALERT_ID'],
	    			'alert_cd'=>$fila['ALERT_CD'],
	    			'nav_key' => $fila['NAV_KEY'],
	    			'descr' =>  $fila['DESCR'],
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