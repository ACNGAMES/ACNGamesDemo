<?php 
    $enterprise= $_GET['enterprise'];
    include('var.php'); 
    global $db;
  	if (!($iden = db_connection()))
        die("Error: No se pudo conectar".mysql_error()); 
    
    // Sentencia SQL: muestra todo el contenido de la tabla "user" 
  $sentencia = "SELECT * FROM $db.CM_USER where enterprise_id='$enterprise'";// where email='$email' and ps='$ps'"; 
  // Ejecuta la sentencia SQL 
  $resultado = mysql_query($sentencia, $iden); 
  if(!$resultado) 
    die("Error: no se pudo realizar la consulta");
  
  if(mysql_num_rows($resultado)!= 0){
        $fila = mysql_fetch_assoc($resultado);
        $userid = $fila['USER_ID'];
        $username = $fila['NAME'];
        $res_token = db_hash($userid,date("Y-m-d H:i:s"));
        mysql_free_result($resultado);
        
        $sentencia = "SELECT * FROM $db.CM_WHITENING_PASS where user_id='$userid'"; 
        // Ejecuta la sentencia SQL 
        $resultado = mysql_query($sentencia, $iden); 
        if(!$resultado) 
        die("Error: no se pudo realizar la consulta");
  
        if(mysql_num_rows($resultado)!= 0){
            mysql_free_result($resultado);    
            $sentencia = "DELETE FROM $db.CM_WHITENING_PASS where user_id='$userid'";
            mysql_query($sentencia, $iden); 
        }
        $FECHA = date("Y-m-d H:i:s");
        
        //Envio del mail
        $para      = "$enterprise@accenture.com";
        $titulo = 'ACN Games - Blanqueo de Contraseña';
        $mensaje = "Hola $username, <br/>
        Para poder finalizar el proceso de blanqueo de contraseña Por favor haz click en el siguiente link.<br/><br/>
        <a href='http://acngames.com.ar/clr.php?1=$userid&2=$res_token'>http://acngames.com.ar/clr.php?1=$userid&2=$res_token<a> <br/><br/>
        Si tu no haz solicitado el blanqueo de contraseña por favor elimina este mail!<br/>
        Muchas Gracias<br/>
        Equipo de ACN Games";
        // To send HTML mail, the Content-type header must be set
        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $cabeceras .= 'From: accounts@acngames.com.ar' . "\r\n" .
                    'Reply-To: accounts@acngames.com.ar' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
        if(mail($para, $titulo, $mensaje, $cabeceras)){
        	$sentencia = "INSERT INTO $db.CM_WHITENING_PASS VALUES('$userid','$res_token','Y','$FECHA')";  
        	mysql_query($sentencia, $iden);	
        }else{
        	$sentencia = "INSERT INTO $db.CM_WHITENING_PASS VALUES('$userid','$res_token','N','$FECHA')";  
        	mysql_query($sentencia, $iden);
        }

        $data = array('status'=> 'ok');
        
     //Envio la respuesta por json
     echo json_encode($data);
                 
  }else{
     $data = array('status'=> 'error');
     mysql_free_result($resultado);
     //Envio la respuesta por json
     echo json_encode($data);
    }
    
    // Cierra la conexi&#65533;n con la base de datos 
    mysql_close($iden); 
    
?>      