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
  $sentencia = "SELECT * FROM $db.CM_MSG LEFT JOIN $db.CM_USER ON from_id=user_id where to_id='$id' and check_sw='N'"; 
  // Ejecuta la sentencia SQL 
  $resultado = mysql_query($sentencia, $iden); 
  if(!$resultado) 
    die("Error: no se pudo realizar la consulta");
  $array=array();
  while($fila = mysql_fetch_assoc($resultado)){
		if($fila['FROM_ID']==0){
			$from='Equipo de ACN Games';			
		}else{
			$from=$fila['NAME'];
		}
		
		if($fila['SUBJECT']!= null){
			$subject=$fila['SUBJECT'];
		}else{
			$subject="";
		}
	$array[] = array('id'=> $fila['MSG_ID'],
	    			'from'=>$from,
	    			'subject' => $subject,
	    			'body' =>  $fila['BODY'],
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