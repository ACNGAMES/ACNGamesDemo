<?php
$name=$_GET["name"];
$surname=$_GET["surname"];
$enterprise=$_GET["enterprise"];
$password=$_GET["ps"];



insertAccount();
//sendMail();

//$vr = include("serverCall/var.php");

 
function insertAccount(){
		
	include('var.php');	
	global $name;
	global $surname;
	global $enterprise;
	global $password;
	$sendMail;
	$db="u157368432_acn";
	$hash = db_hash($enterprise,$password); 
	
		if (!($iden = db_connection()))
 		echo(die("Error: No se pudo conectar metodo insert() " .mysql_error()));
		$checkAccount = "SELECT * FROM $db.CM_USER WHERE enterprise_id= '$enterprise'";
		
		$resultado = mysql_query($checkAccount, $iden); 
		
		if (!$resultado) 
		   die("Error: no se pudo realizar la consulta");
		  
		if (mysql_num_rows($resultado)==0) {
		   $var=true;
		}else{
		   $var=false;
		}
		
		if ($var==true) {
	 	   $sentencia = "INSERT INTO $db.CM_USER (USER_ID, ENTERPRISE_ID, NAME, SURNAME, PASSWORD, CRE_DTTM, AUTH_TOKEN) VALUES (FLOOR( 1 + ( RAND( ) * 9999999999)), '$enterprise', '$name', '$surname', '$hash',NOW(), ' ');";
		      	
		   $resultado = mysql_query($sentencia, $iden);
		   if (!$resultado) 
		     die("Error: no se pudo realizar la consulta");
		  
		   	 $sentencia = "SELECT USER_ID FROM $db.CM_USER where enterprise_id='$enterprise'";
			 $resultado = mysql_query($sentencia, $iden);
			 $fila = mysql_fetch_assoc($resultado);
			 $userId = $fila['USER_ID'];
			 $activeToken = sha1(date("Y-m-d H:i:s"));
			 
		     if(sendMail($userId, $name, $enterprise, $activeToken)) {
		     	$sendMail = "Y";
		     }
			 else {
			 	$sendMail = "N";
			 }
		     	
			 $sentencia = "INSERT INTO $db.CM_ACTIVATE_ACCT (USER_ID, ACTIVATE_TOKEN, SEND_MAIL_FLG, REMINDER_FLG) VALUES ($userId, '$activeToken', '$sendMail', 'N')";
			 $resultado = mysql_query($sentencia, $iden);
		    
		   	  $data = array('status'=> 'ok');
              echo json_encode($data);
              mysql_close($iden);
		
		}else{
         	 
           $data = array('status'=> 'error');
           mysql_free_result($resultado);
           echo json_encode($data);
		   mysql_close($iden); 
    	}
		
};

function sendMail($userId, $name, $enterprise, $activeToken){

$para = "$enterprise@accenture.com";
$titulo = 'Activación de cuenta';
$mensaje = "<fieldset><lengend>";
$mensaje .= "Hola <var>$name</var>, te damos la bienvenida a <strong size='10''>ACN Games</strong>.<br/><br/>";
$mensaje .= "Para activar tu cuenta por favor hacer click en el siguiente link: <br/>";
$mensaje .= "<a href='http://acngames.com.ar/act.php?1=$userId&2=$activeToken'>http://acngames.com.ar/act.php?1=$userId&2=$activeToken<a>";
$mensaje .= "<br/><br/>";
$mensaje .= "Si tienes problemas para acceder oprimiendo en el link, copia y pegalo en el buscador de tu navegador web.";
$mensaje .= "Record&aacute; que ten&eacute;s 48Hs para activar tu cuenta, pasado ese tiempo tu cuenta ser&aacute; eliminada.";
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
