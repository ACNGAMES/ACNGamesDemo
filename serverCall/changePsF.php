<?php

$id=$_GET["id"];
$auth_token=$_GET["auth_token"];
$ps = $_GET["ps"];
//TODO tengo que aplicar key a las contraseñas
$new_ps = $_GET["new_ps"];

 
include 'valF.php';
if(validate($id, $auth_token)){
		
	   if(!($iden = mysql_connect("localhost:3306", "u970955255_acn", "sys123")))
        die("Error: No se pudo conectar".mysql_error()); 
     
  $sentencia = "SELECT * FROM u970955255_acn.CM_USER where user_id='$id' and password='$ps'"; 
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
		mysql_free_result($resultado);        	
        $sentencia = "UPDATE u970955255_acn.CM_USER SET PASSWORD='$new_ps' where user_id='$id' and password='$ps'"; 
  		// Ejecuta la sentencia SQL 
  		mysql_query($sentencia, $iden); 
  		//Envio la respuesta por json
  		$data = array('status'=> 'ok');
        echo json_encode($data);
  }
  // Cierra la conexión con la base de datos 
  mysql_close($iden);	
		
	
}else{
	$data = array('status'=> 'exp');
    echo json_encode($data);
}
?>