<?php
$id=$_GET["id"];
$auth_token=$_GET["auth_token"];


     //if(!($iden = mysql_connect("127.0.0.1:3306", "cisuser", "cisuser"))) 
     if(!($iden = mysql_connect("localhost:3306", "u970955255_acn", "sys123")))
        die("Error: No se pudo conectar".mysql_error()); 
    
    // Sentencia SQL: muestra todo el contenido de la tabla "user" 
  $sentencia = "SELECT * FROM u970955255_acn.CM_USER where user_id='$id' and auth_token='$auth_token'";// where email='$email' and ps='$ps'"; 
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
        $data = array('status'=> 'ok');
         mysql_free_result($resultado);
         //Envio la respuesta por json
         echo json_encode($data);
  }
  // Cierra la conexión con la base de datos 
  mysql_close($iden); 

?>

