<?php 
	echo 'hola';
$para      = 'jonatanbahut@gmail.com';
$titulo = 'El t�tulo';
$mensaje = 'Hola, activatu cuenta mierda carajo!!';
$cabeceras = 'From: accounts@acngames.com.ar' . "\r\n" .
    'Reply-To: accounts@acngames.com.ar' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($para, $titulo, $mensaje, $cabeceras);
	
/**
* //TODO: pude eviar el mail ocn la funcion de abajo

function mail1(){

// El mensaje
$mensaje = "L�nea 1\r\nL�nea 2\r\nL�nea 3";

// Si cualquier l�nea es m�s larga de 70 caracteres, se deber�a usar wordwrap()
$mensaje = wordwrap($mensaje, 70, "\r\n");

// Send
mail('moroco.ortiz@gmail.com', 'Mi t�tulo', $mensaje);
};	
	

**/
?>