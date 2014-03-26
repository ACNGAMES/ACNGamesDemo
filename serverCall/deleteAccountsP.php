<?php

searchAccounts();

function searchAccounts() {
	
 include('var.php');
 $db="u157368432_acn";
 if(!($conn = db_connection()))
 echo(die("Error: No se pudo conectar a la base de datos " .mysql_error()));
 
 
 $sentencia = "SELECT usr.USER_ID, usr.NAME, usr.ENTERPRISE_ID FROM $db.CM_USER usr
 			   INNER JOIN $db.CM_ACTIVATE_ACCT act ON usr.USER_ID=act.USER_ID
 			   WHERE usr.CRE_DTTM <= SYSDATE() - 2";
			   
 $resultado = mysql_query($sentencia, $conn); 
 
 while ($fila = mysql_fetch_assoc($resultado)) {
    $userId = $fila["USER_ID"];
    $name = $fila["NAME"];
    $enterprise = $fila["ENTERPRISE_ID"];
		
	sendMail($name, $enterprise);
	
	$sentencia_2 = "DELETE FROM $db.CM_ACTIVATE_ACCT WHERE USER_ID = $userId";
	mysql_query($sentencia_2, $conn);
	
	$sentencia_2 = "DELETE FROM $db.CM_USER WHERE USER_ID = $userId";
	mysql_query($sentencia_2, $conn);
 }			   

 mysql_free_result($resultado);
 mysql_close($conn);
 
}
 
function sendMail($name, $enterprise){

$para = "$enterprise@accenture.com";
$titulo = 'Eliminaci&oacute;n de cuenta';
$mensaje = "<fieldset><lengend>";
$mensaje .= "Hola <var>$name</var>,<br/><br/>";
$mensaje .= "Te notificamos que la cuenta creada con el Enterprise <var>$enterprise</var> ha sido eliminada <br/>";
$mensaje .= "dado que la misma no ha sido activada pasadas las 48Hs desde su creaci&oacute;n";
$mensaje .= "<br/><br/>";
$mensaje .= "Muchas Gracias!<br/>";
$mensaje .= "<br/>";
$mensaje .= "<strong size='14'>Equipo de ACN Games</strong>";
$mensaje .= "</lengend></fieldset>";

$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$cabeceras .= 'From: accounts@acngames.com.ar' . "\r\n" .
    'Reply-To: accounts@acngames.com.ar' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

$resp=mail($para, $titulo, $mensaje, $cabeceras);
return $resp; 
  
};

?>
