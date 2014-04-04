<?php

$id=$_GET["id"];
$auth_token=$_GET["auth_token"];
include 'valF.php';
if(validate($id, $auth_token)){
		
	//include('var.php');
  	if (!($iden = db_connection()))
        die("Error: No se pudo conectar".mysql_error()); 
  $db="u157368432_acn";  
  $sentencia = "SELECT COUNT(EVENT_ID) 'COUNT' FROM  $db.CM_CHALLENGE WHERE USER_ID = $id"; 
  // Ejecuta la sentencia SQL 
  $resultado = mysql_query($sentencia, $iden); 
  
  if(!$resultado) 
    die("Error: no se pudo realizar la consulta");
  	
  	//Inicializo las varialbes
	$fila = mysql_fetch_assoc($resultado);
    $pend=$fila['COUNT'];
  	mysql_free_result($resultado);
	
	$sentencia = "SELECT COUNT(EVENT_ID) 'COUNT' FROM  $db.CM_CHALLENGE WHERE USER_OPP_ID = $id"; 
  // Ejecuta la sentencia SQL 
  $resultado = mysql_query($sentencia, $iden); 
  
  if(!$resultado) 
    die("Error: no se pudo realizar la consulta");
  	
  	//Inicializo las varialbes
	 $fila = mysql_fetch_assoc($resultado);
     $req=$fila['COUNT'];
  	mysql_free_result($resultado);   				 		     	
     
  $data = array('status'=> 'ok',
					'pending'=> $pend,
					'request'=>$req                  
    );
  	//Envio la respuesta por json
 	echo json_encode($data);
  
  // Cierra la conexión con la base de datos 
  mysql_close($iden);	
		
	
}else{
	$data = array('status'=> 'exp');
    echo json_encode($data);
}


?>