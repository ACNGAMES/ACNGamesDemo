<?php

$id=$_GET["id"];
$auth_token=$_GET["auth_token"];
include 'valF.php';
if(validate($id, $auth_token)){
	$db="u157368432_acn";	
	
  	if (!($iden = db_connection()))
        die("Error: No se pudo conectar".mysql_error());
	
	$sentencia = "SELECT ENTERPRISE_ID, NAME FROM $db.CM_USER WHERE USER_ID='$id'";
	$resultado = mysql_query($sentencia, $iden);
	
   	$fila = mysql_fetch_assoc($resultado);
	$enterprise = $fila['ENTERPRISE_ID'];
	$name = $fila['NAME'];
	
	mysql_free_result($resultado);

	$sentencia = "SELECT ACTIVATE_TOKEN FROM $db.CM_ACTIVATE_ACCT WHERE USER_ID='$id'";
	$resultado = mysql_query($sentencia, $iden);
	
	if(mysql_num_rows($resultado)==0) {
    	$var = false;
	}else{
    	$var=true;
	}
	
		if ($var==true) {	
	 		$fila = mysql_fetch_assoc($resultado);
			$activeToken = $fila['ACTIVATE_TOKEN'];
			
			mysql_free_result($resultado);
		
			if(sendMail($id, $name, $enterprise, $activeToken)) {
			    $sendMail = "Y";
			 }
			 else {
				$sendMail = "N";
		     }
			   
		 $sentencia = "UPDATE $db.CM_ACTIVATE_ACCT SET SEND_MAIL_FLG='$sendMail' where user_id='$id'"; 
	     mysql_query($sentencia, $iden);
	   
	     $data = array('status'=> 'ok');
	     echo json_encode($data);
	     mysql_close($iden);	
	   }		
 
 }else{
	$data = array('status'=> 'exp');
    echo json_encode($data);
 }
 
 

function sendMail($userId, $name, $enterprise, $activeToken){

$para = "$enterprise@accenture.com";
$titulo = 'Activacion de cuenta';
$mensaje = "<fieldset><lengend>";
$mensaje .= "Hola <var>$name</var>, te damos la bienvenida a <strong size='10''>ACN Games</strong>.<br/><br/>";
$mensaje .= "Para activar tu cuenta por favor hacer click en el siguiente link:";
$mensaje .= "<a href='http://acngames.com.ar/act.php?1=$userId&2=$activeToken'>http://acngames.com.ar/act.php?1=$userId&2=$activeToken<a>";
$mensaje .= "<br/><br/>";
$mensaje .= "Si tienes problemas para acceder oprimiendo en el link, copia y pegalo en el buscador de tu navegador web.";
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