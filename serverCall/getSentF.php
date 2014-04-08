<?php

putenv("TZ=America/Buenos_Aires");
$id=$_GET["id"];
$auth_token=$_GET["auth_token"];
$msg_id=$_GET["msg_id"];
include 'valF.php';
if(validate($id, $auth_token)){
		
	//include('var.php');
  	if (!($iden = db_connection()))
        die("Error: No se pudo conectar".mysql_error()); 
  $db="u157368432_acn";  
  $sentencia = "SELECT * FROM $db.CM_MSG_SENT LEFT JOIN $db.CM_USER ON to_id=user_id where msg_id='$msg_id' and from_id='$id'"; 
  // Ejecuta la sentencia SQL 
  $resultado = mysql_query($sentencia, $iden); 
  if(!$resultado) 
    die("Error: no se pudo realizar la consulta");
  $array=array();
  if($fila = mysql_fetch_assoc($resultado)){
		if($fila['TO_ID']==0){
			$to='Equipo de ACN Games';			
		}else{
			$to=$fila['TO_ID'];
		}
		
		if($fila['SUBJECT']!= null){
			$subject=$fila['SUBJECT'];
		}else{
			$subject="";
		}
	$data = array('status'=> 'ok',
				  'id'=> $fila['MSG_ID'],
	    			'to'=>$to,
	    			'subject' => $subject,
	    			'body' =>  $fila['BODY'],
	    			'date' =>  $fila['MSG_DTTM']
                 );
	}
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