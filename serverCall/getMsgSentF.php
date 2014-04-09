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
  $sentencia = "SELECT * FROM $db.CM_MSG_SENT LEFT JOIN $db.CM_USER ON to_id=user_id where from_id='$id'"; 
  // Ejecuta la sentencia SQL 
  $resultado = mysql_query($sentencia, $iden); 
  if(!$resultado) 
    die("Error: no se pudo realizar la consulta");
  $array=array();
  while($fila = mysql_fetch_assoc($resultado)){
		if($fila['TO_ID']==0){
			$to='Equipo de ACN Games';			
		}else{
			$to=$fila['NAME'];
		}
		
		if($fila['SUBJECT']!= null){
			$subject=$fila['SUBJECT'];
		}else{
			$subject="";
		}
	$array[] = array('id'=> $fila['MSG_ID'],
	    			'to'=>$to,
	    			'subject' => $subject,
	    			'date' =>  $fila['MSG_DTTM']
	    			
                 );
	}
  $data = array('status'=> 'ok',
					'msgs'=> $array                  
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