<?php
$ps=$_GET["ps"];
$email=$_GET["email"];

//die(" The esmail address");
   

   foo2();

function foo2()
{
	include('var.php');	
    $var;
    global $email;
    global $ps;
   	$db="u157368432_acn";
    $hash = db_hash($email,$ps); 
  	 
    if (!($iden = db_connection()))
        die("Error: No se pudo conectar".mysql_error()); 
    
    // Sentencia SQL: muestra todo el contenido de la tabla "user" 
  $sentencia = "SELECT * FROM $db.CM_USER where enterprise_id='$email' and password='$hash'";// where email='$email' and ps='$ps'"; 
  // Ejecuta la sentencia SQL 
  $resultado = mysql_query($sentencia, $iden); 
  if(!$resultado) 
    die("Error: no se pudo realizar la consulta");
  
  if(mysql_num_rows($resultado)== 0){
        $var = false;
  }else{
        $var=true;
  }

  if ($var==true)
    {
    $fila = mysql_fetch_assoc($resultado);
    //TODO aca tengo que genrar el token de authenticacion y subirlo al base
    $userid = $fila['USER_ID']; 
    $auth_token = $hash = db_hash(date("Y-m-d H:i:s").$userid,date("Y-m-d H:i:s").$hash);
    $data = array('status'=> 'ok',
                  'user_id'=>$userid,
                  'name'=>$fila['NAME'],
                  'surname'=>$fila['SURNAME'],
                  'auth_token'=>$auth_token
                 );
    mysql_free_result($resultado);
      
    $sentencia = "SELECT * FROM $db.CM_ACTIVATE_ACCT where user_id='$userid'"; 
    // Ejecuta la sentencia SQL 
    $resultado = mysql_query($sentencia, $iden); 
    if(!$resultado) 
        die("Error: no se pudo realizar la consulta");
    if(mysql_num_rows($resultado)!= 0){
        $data = array('status'=> 'activate',
					'user_id'=>$userid,
					'auth_token'=>$auth_token
		);
    }  
    mysql_free_result($resultado);
    //Envio la respuesta por json
    $sentencia = "UPDATE $db.CM_USER SET AUTH_TOKEN='$auth_token' where user_id='$userid'"; 
  		// Ejecuta la sentencia SQL 
  		mysql_query($sentencia, $iden);
    
    echo json_encode($data);
    
    }else{
         $data = array('status'=> 'error');
         mysql_free_result($resultado);
         //Envio la respuesta por json
         echo json_encode($data);
    }
    
    
    // Cierra la conexi�n con la base de datos 
    mysql_close($iden); 
   
   
   }


?>
