<?php

putenv("TZ=America/Buenos_Aires");
deleteWhiteningPass();

function deleteWhiteningPass() {
	
 include('var.php');
 $db="u157368432_acn";
 if(!($conn = db_connection()))
 echo(die("Error: No se pudo conectar a la base de datos " .mysql_error()));
 
 
 $sentencia = "SELECT VALUE FROM $db.CM_CONFIG WHERE CONFIG_CD = 'DELETE_WHITENING'";
			   
 $resultado = mysql_query($sentencia, $conn);
 if(!$resultado) 
    die("Error: no se pudo realizar la consulta"); 
 
 while ($fila = mysql_fetch_assoc($resultado)) {

    $dias = $fila["VALUE"];
    
	$sentencia_2 = "DELETE FROM $db.CM_WHITENING_PASS WHERE WHITENING_DTTM <= DATE_SUB(SYSDATE(), INTERVAL $dias DAY)";
	mysql_query($sentencia_2, $conn);
	
 }			   

 mysql_free_result($resultado);
 mysql_close($conn);
 
}

?>
