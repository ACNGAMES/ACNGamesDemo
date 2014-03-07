<?php 

// primero hay que incluir la clase phpmailer para poder instanciar
//un objeto de la misma
require "includes/class.phpmailer.php";

//instanciamos un objeto de la clase phpmailer al que llamamos 
//por ejemplo mail
$mail = new phpmailer();

//Definimos las propiedades y llamamos a los métodos 
//correspondientes del objeto mail

//Con PluginDir le indicamos a la clase phpmailer donde se 
//encuentra la clase smtp que como he comentado al principio de 
//este ejemplo va a estar en el subdirectorio includes
$mail->PluginDir = "includes/";
$mail->IsSMTP();
//Con la propiedad Mailer le indicamos que vamos a usar un 
//servidor smtp
$mail->Mailer = "smtp";

//Asignamos a Host el nombre de nuestro servidor smtp
$mail->Host = "mx1.hostinger.es";
$mail->Port = 2525;
//Le indicamos que el servidor smtp requiere autenticación
$mail->SMTPAuth = true;

//Le decimos cual es nuestro nombre de usuario y password
$mail->Username = "accounts@acngames.com.ar"; 
$mail->Password = "Edenor2014";
$mail->SMTPSecure = 'ssl'; 
//Indicamos cual es nuestra dirección de correo y el nombre que 
//queremos que vea el usuario que lee nuestro correo
$mail->From = "accounts@acngames.com.ar"; 
$mail->FromName = "Mi Nombre";

//el valor por defecto 10 de Timeout es un poco escaso dado que voy a usar 
//una cuenta gratuita, por tanto lo pongo a 30 
$mail->Timeout=120;

//Indicamos cual es la dirección de destino del correo
$mail->AddAddress("eortiz@edenor.com");

//Asignamos asunto y cuerpo del mensaje
//El cuerpo del mensaje lo ponemos en formato html, haciendo 
//que se vea en negrita
$mail->Subject = "Prueba de phpmailer";
$mail->Body = "Mensaje de prueba mandado con phpmailer en formato html";

//Definimos AltBody por si el destinatario del correo no admite email con formato html 
$mail->AltBody = "Mensaje de prueba mandado con phpmailer en formato solo texto";

//se envia el mensaje, si no ha habido problemas 
//la variable $exito tendra el valor true
$exito = $mail->Send();



if(!$exito)
{
echo "Problemas enviando correo electrónico a ";
echo "".$mail->ErrorInfo;	
}
else
{
echo "Mensaje enviado correctamente";
} 
?>