<?php
$ps=$_POST["ps"];
$email=$_POST["email"];
foo2();
//die(" The esmail address");

function foo2()
{
    $var;
    global $email;
    global $ps;
     //if(!($iden = mysql_connect("127.0.0.1:3306", "cisuser", "cisuser"))) 
     if(!($iden = mysql_connect("localhost:3306", "u970955255_acn", "sys123")))
        die("Error: No se pudo conectar".mysql_error()); 
    
    // Sentencia SQL: muestra todo el contenido de la tabla "user" 
  $sentencia = "SELECT * FROM u970955255_acn.CM_EVENT";// where email='$email' and ps='$ps'"; 
  // Ejecuta la sentencia SQL 
  $resultado = mysql_query($sentencia, $iden); 
  if(!$resultado) 
    die("Error: no se pudo realizar la consulta");
  
  if(mysql_num_rows($resultado)== 0){
       echo("Usuario invalido\n");
       $username = $_COOKIE["TestCookie"];
        echo ("Mi nombre es $username");
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
  
  // Libera la memoria del resultado
  mysql_free_result($resultado);
  
  // Cierra la conexión con la base de datos 
  mysql_close($iden); 
    
   if ($var==true)
    {
    header("Location: template.php");
    exit;
    }
   
}


?>

