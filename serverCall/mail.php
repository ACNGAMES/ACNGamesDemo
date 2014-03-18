<?php 
	echo 'hola';
$para      = 'jonatanbahut@gmail.com';
$titulo = 'El título';
$mensaje = 'Hola, activatu cuenta mierda carajo!!';
$cabeceras = 'From: accounts@acngames.com.ar' . "\r\n" .
    'Reply-To: accounts@acngames.com.ar' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($para, $titulo, $mensaje, $cabeceras);
	
/**
* //TODO: pude eviar el mail ocn la funcion de abajo

function mail1(){

// El mensaje
$mensaje = "Línea 1\r\nLínea 2\r\nLínea 3";

// Si cualquier línea es más larga de 70 caracteres, se debería usar wordwrap()
$mensaje = wordwrap($mensaje, 70, "\r\n");

// Send
mail('moroco.ortiz@gmail.com', 'Mi título', $mensaje);
};	
	

**/
?>