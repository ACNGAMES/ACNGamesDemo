<?php
$ps=$_GET["ps"];
$email=$_GET["email"];

//die(" The esmail address");
   

   foo2();

function foo2()
{
    $var;
    global $email;
   global $ps;
     //if(!($iden = mysql_connect("127.0.0.1:3306", "cisuser", "cisuser"))) 
     if(!($iden = mysql_connect("localhost:3306", "u970955255_acn", "sys123")))
        die("Error: No se pudo conectar".mysql_error()); 
    
    // Sentencia SQL: muestra todo el contenido de la tabla "user" 
  $sentencia = "SELECT * FROM u970955255_acn.CM_USER where enterprise_id='$email' and password='$ps'";// where email='$email' and ps='$ps'"; 
  // Ejecuta la sentencia SQL 
  $resultado = mysql_query($sentencia, $iden); 
  if(!$resultado) 
    die("Error: no se pudo realizar la consulta");
  
  if(mysql_num_rows($resultado)== 0){
        $var = false;
  }else{
        $var=true;
  }

  /*
  echo '<table>'; 
  while($fila = mysql_fetch_assoc($resultado)) 
  { 
    echo '<tr>'; 
    echo '<td>' . $fila['email'] . '</td><td>' . $fila['ps'] . '</td>'; 
    echo '</tr>'; 
  } 
  echo '</table>';*/
  
  
   
  
   if ($var==true)
    {
    
    //TODO aca tengo que genrar el token de authenticacion y subirlo al base
    $auth_token = '1224'; 
    $fila = mysql_fetch_assoc($resultado);
    $data = array('status'=> 'ok',
                  'user_id'=>$fila['USER_ID'],
                  'name'=>$fila['NAME'],
                  'surname'=>$fila['SURNAME'],
                  'auth_token'=>$auth_token 
                 );           
    
    }else{
         $data = array('status'=> 'error');
    }
    
    // JSON encode and send back to the server
    echo json_encode($data);
    // Libera la memoria del resultado
    mysql_free_result($resultado);
  
    // Cierra la conexión con la base de datos 
    mysql_close($iden); 
   
   
   }


?>

