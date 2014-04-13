<?php

putenv("TZ=America/Buenos_Aires");
receiveSuggestions();

function receiveSuggestions() {
	
 include('var.php');
 $db="u157368432_acn";
 if(!($conn = db_connection()))
 echo(die("Error: No se pudo conectar a la base de datos " .mysql_error()));
 
 
 $sentencia = "SELECT user.NAME, user.SURNAME, user.ENTERPRISE_ID, msg.MSG_ID, msg.SUBJECT, msg.BODY, msg.MSG_DTTM FROM $db.CM_MSG msg
			   INNER JOIN $db.CM_USER user ON msg.FROM_ID = user.USER_ID
               WHERE CHECK_SW = 'N'";
			   
 $resultado = mysql_query($sentencia, $conn);
 if(!$resultado) 
    die("Error: no se pudo realizar la consulta");
  
 while ($fila = mysql_fetch_assoc($resultado)) {
    $name = $fila["NAME"];
    $surname = $fila["SURNAME"];
    $enterprise = $fila["ENTERPRISE_ID"];
	$msgId = $fila["MSG_ID"];
	$subject = $fila["SUBJECT"];
	$body = $fila["BODY"];
	$msgDttm = $fila["MSG_DTTM"];
	
	sendMail($name, $surname, $enterprise, $subject, $body, $msgDttm);
	
	$sentencia_2 = "UPDATE $db.CM_MSG SET CHECK_SW = 'Y' WHERE MSG_ID = $msgId";
	
	mysql_query($sentencia_2, $conn);
 }			   

 mysql_free_result($resultado);
 mysql_close($conn);
 
}
 
function sendMail($name, $surname, $enterprise, $subject, $body, $msgDttm){

$para = "acngames2014@accenture.com";
$titulo = "$subject";
$mensaje = "<fieldset><lengend>";
$mensaje .= "Sugerencia de <var>$name $surname ($enterprise):</var><br/>";
$mensaje .= "$body <br/>";
$mensaje .= "Fecha de sugerencia : $msgDttm";

$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$cabeceras .= 'From: accounts@acngames.com.ar' . "\r\n" .
    'Reply-To: accounts@acngames.com.ar' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

$resp=mail($para, $titulo, $mensaje, $cabeceras);
return $resp; 
  
};

?>
