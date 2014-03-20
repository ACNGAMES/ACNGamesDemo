<?php

$id=$_GET["id"];
$auth_token=$_GET["auth_token"];
include 'valF.php';
if(validate($id, $auth_token)){
		
	//include('var.php');
  	if (!($iden = db_connection()))
        die("Error: No se pudo conectar".mysql_error()); 
  $db="u157368432_acn";  
  $sentencia = "SELECT * FROM $db.CM_COIN where user_id='$id'"; 
  // Ejecuta la sentencia SQL 
  $resultado = mysql_query($sentencia, $iden); 
  if(!$resultado) 
    die("Error: no se pudo realizar la consulta");
  
  if(mysql_num_rows($resultado)== 0){
        $data = array('status'=> 'error');
        mysql_free_result($resultado);
        //Envio la respuesta por json
        echo json_encode($data);
  }else{
        $fila = mysql_fetch_assoc($resultado);
		$data = array('status'=> 'ok',
					'silver'=> $fila['SILVER_COINS'],
                  	'gold'=>$fila['GOLDEN_COINS']                  
                 );
         mysql_free_result($resultado);
         //Envio la respuesta por json
         echo json_encode($data);
  }
  // Cierra la conexión con la base de datos 
  mysql_close($iden);	
		
	
}else{
	$data = array('status'=> 'exp');
    echo json_encode($data);
}


?>