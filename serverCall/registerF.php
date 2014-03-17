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
	
	
		if(!($iden = db_connection()))
 		echo(die("Error: No se pudo conectar metodo insert() " .mysql_error())); 
		
 		$sentencia = "INSERT INTO u970955255_acn.cm_user (USER_ID, ENTERPRISE_ID, NAME, SURNAME, PASSWORD, CRE_DTTM, AUTH_TOKEN) VALUES (FLOOR( 1 + ( RAND( ) * 9999999999)), '$enterprise', '$name', '$surname', '$password', CURTIME(), '123456');";
 	
		//$enterprise, $name, $surname, $password	
		$resultado = mysql_query($sentencia, $iden); 
		  /*if(mysql_num_rows($resultado)== 0){
		        $var = false;
			  echo "Error";
		  }else{
		        $var=true;
				echo "OK";
		  }*/
		
		//mysql_free_result(true);
    	//Envio la respuesta por json
    	echo json_encode($resultado);
	//sendMail();
 }

/*function sendMail(){

     //Recuperar los datos que serviran para enviar el correo
     $seEnvio;      //Para determinar si se envio o no el correo
     //$destinatario = 'jonatanbahut@gmail.com';        //A quien se envia
     $elmensaje = str_replace("\n.", "\n..", $_POST['elmsg']);     //por si el mensaje empieza con un punto ponerle 2
     $elmensaje = wordwrap($elmensaje, 70);                       //dividir el mensaje en trozos de 70 cols
     //Recupear el asunto
     $asunto = $_POST['asunt'];
     //Formatear un poco el texto que escribio el usuario (asunto) en la caja
     //de comentario con ayuda de HTML
     $mensaje ='
		<html>
		<head>
		  <title>Recordatorio de cumpleaños para Agosto</title>
		</head>
		<body>
		  <p>¡Estos son los cumpleaños para Agosto!</p>
		  <table>
		    <tr>
		      <th>Quien</th><th>Día</th><th>Mes</th><th>Año</th>
		    </tr>
		    <tr>
		      <td>Joe</td><td>3</td><td>Agosto</td><td>1970</td>
		    </tr>
		    <tr>
		      <td>Sally</td><td>17</td><td>Agosto</td><td>1973</td>
		    </tr>
		  </table>
		</body>
		</html>
		';

// Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Cabeceras adicionales
$cabeceras .= 'To: Jonatan <jonatanbahut@gmail.com>, Fieldy <fieldy_prodark@hotmail.com>' . "\r\n";
$cabeceras .= 'From: ACN Games <accounts@acngames.com.ar>' . "\r\n";
//$cabeceras .= 'Cc: birthdayarchive@example.com' . "\r\n";
//$cabeceras .= 'Bcc: birthdaycheck@example.com' . "\r\n";
    if(mail($cabeceras,$asunto,$mensaje)){
        $seEnvio = true;
    }else{
        $seEnvio = false;
	}
//Enviar el estado del envio (por metodo GET ) y redirigir navegador al archivo index.php
    if($seEnvio == true){
        header('Enviadoooo');
    }else{
        header('Location: index.php?estado=no_enviado');
    }
  
};*/


/*function sendMail(){

include('mail.php');
 
 $from = "Sandra Sender <jonatanbahut@gmail.com>";
 $to = "Ramona Recipient <jbahut@edenor.com>";
 $subject = "Hi!";
 $body = "Hi,\n\nHow are you?";
 
 $host = "smtp.gmail.com";
 $username = "jonatanbahut@gmail.com";
 $password = "kornkorn1";
 $port = "2525";
 
 $headers = array ('From' => $from,
   'To' => $to,
   'Subject' => $subject);
 $smtp = Mail::factory('smtp',
   array ('host' => $host,
     'port' => $port,
     'auth' => true,
     'username' => $username,
     'password' => $password));
 
 $mail = $smtp->send($to, $headers, $body);
 
 if (PEAR::isError($mail)) {
   echo("<p>" . $mail->getMessage() . "</p>");
  } else {
   echo("<p>Message successfully sent!</p>");
   echo "Salió mail";
  }
  
	
};*/

/*function sendMail(){
		
require('class.phpmailer.php');	
require('class.smtp.php');
require_once('mail.php');



$mail = new PHPMailer(); // create a new object
$mail->IsSMTP(); // enable SMTP
$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; // authentication enabled
$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
$mail->Host = "ns1.cdmon.net";
$mail->Port = 2525; // or 587
$mail->IsHTML(true);
$mail->Username = "accounts@acngames.com.ar";
$mail->Password = "Edenor2014";
$mail->SetFrom("accounts@acngames.com.ar");
$mail->Subject = "Test";
$mail->Body = "hello";
$mail->AddAddress("jonatanbahut@gmail.com");
 if(!$mail->Send())
    {
    echo "Mailer Error: " . $mail->ErrorInfo;
    }
    else
    {
    echo "Message has been sent";
	//insert();
    }
	
}*/

?>
