<?php

putenv("TZ=America/Buenos_Aires");
searchAccounts();

function searchAccounts() {
	
 include('var.php');
 $db="u157368432_acn";
 if(!($conn = db_connection()))
 echo(die("Error: No se pudo conectar a la base de datos " .mysql_error()));
 
 
 $sentencia = "SELECT usr.USER_ID, usr.NAME, usr.ENTERPRISE_ID, act.ACTIVATE_TOKEN FROM $db.CM_USER usr
 			   INNER JOIN $db.CM_ACTIVATE_ACCT act ON usr.USER_ID=act.USER_ID
 			   WHERE act.REMINDER_FLG = 'N'
 			   AND usr.CRE_DTTM <= SYSDATE() - 1";
			   
 $resultado = mysql_query($sentencia, $conn); 
 
 while ($fila = mysql_fetch_assoc($resultado)) {
    $userId = $fila["USER_ID"];
    $name = $fila["NAME"];
    $enterprise = $fila["ENTERPRISE_ID"];
	$activeToken = $fila["ACTIVATE_TOKEN"];
	
	sendMail($userId, $name, $enterprise, $activeToken);
	
	$sentencia_2 = "UPDATE $db.CM_ACTIVATE_ACCT SET REMINDER_FLG = 'Y' WHERE USER_ID = $userId";
	
	mysql_query($sentencia_2, $conn);
 }			   

 mysql_free_result($resultado);
 mysql_close($conn);
 
}
 
function sendMail($userId, $name, $enterprise, $activeToken){

$para = "$enterprise@accenture.com";
$titulo = 'Activaci&oacute;n de cuenta';
$mensaje = "<fieldset><lengend>";
$mensaje .= "Hola <var>$name</var>, te damos la bienvenida a <strong size='10''>ACN Games</strong>.<br/><br/>";
$mensaje .= "Para activar tu cuenta por favor hacer click en el siguiente link: <br/>";
$mensaje .= "<a href='http://acngames.com.ar/act.php?1=$userId&2=$activeToken'>http://acngames.com.ar/act.php?1=$userId&2=$activeToken<a>";
$mensaje .= "<br/><br/>";
$mensaje .= "Si tienes problemas para acceder oprimiendo en el link, copia y pegalo en el buscador de tu navegador web.<br/>";
$mensaje .= "Record&aacute; que ten&eacute;s 24Hs para activar tu cuenta, pasado ese tiempo tu cuenta ser&aacute; eliminada.";
$mensaje .= "<br/>";
$mensaje .= "Si tu no has solicitado la creaci&oacute;n de una cuenta, desestim&aacute; este mail!<br/>";
$mensaje .= "<br/>";
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
