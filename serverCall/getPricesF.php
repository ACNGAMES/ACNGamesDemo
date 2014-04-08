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
  $sentencia = "SELECT * FROM $db.CM_STORE where QTY>0"; 
  // Ejecuta la sentencia SQL 
  $resultado = mysql_query($sentencia, $iden); 
  if(!$resultado) 
    die("Error: no se pudo realizar la consulta");
  $array=array();
  while($fila = mysql_fetch_assoc($resultado)){
		
	$array[] = array('id'=> $fila['PRODUCT_ID'],
	    			'url'=> $fila['URL'],
	    			'descr' =>  $fila['DESCR'],
	    			'qty' => $fila['QTY'],
	    			'cr' =>  $fila['CR']
                 );
	}
  $data = array('status'=> 'ok',
			'products'=> $array                  
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