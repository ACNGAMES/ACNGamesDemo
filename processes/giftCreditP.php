<?php

putenv("TZ=America/Buenos_Aires");
giftCredit();

function giftCredit() {
	
 include('var.php');
 $db="u157368432_acn";
 if(!($conn = db_connection()))
 echo(die("Error: No se pudo conectar a la base de datos " .mysql_error()));
 
 
 $sentencia = "SELECT VALUE FROM $db.CM_CONFIG WHERE CONFIG_CD = 'SILL_CREDIT'";
			   
 $sillCredit = mysql_query($sentencia, $conn);
 if(!$sillCredit) 
    die("Error: no se pudo realizar la consulta de SILL_CREDIT");
 
 $sentencia_2 = "SELECT VALUE FROM $db.CM_CONFIG WHERE CONFIG_CD = 'GIFT_CREDIT'";
			   
 $giftCredit = mysql_query($sentencia_2, $conn);
 if(!$giftCredit) 
    die("Error: no se pudo realizar la consulta de GIFT_CREDIT");
 
 $sentencia_3 = "SELECT USER_ID FROM $db.CM_COIN WHERE SILVER_COINS+GOLDEN_COINS <= $sillCredit";
			   
 $userIds = mysql_query($sentencia_3, $conn);
 if(!$userIds) 
    die("Error: no se pudo realizar la consulta USER_ID");
 
 while ($fila = mysql_fetch_assoc($userIds)) {

    $userId = $fila["USER_ID"];
    
	$sentencia_4 = "UPDATE $db.CM_COIN SET GOLDEN_COINS = (GOLDEN_COINS + $giftCredit) WHERE USER_ID = $userId";
	mysql_query($sentencia_4, $conn);
	
	$sentencia_5 = "INSERT INTO $db.CM_ALERT (USER_ID, ALERT_CD,DESCR, ALERT_DTTM) VALUES ($userId, 'CD', 'ACN Games te envio $giftCredit cr. de regalo', '".NOW()."')";
	mysql_query($sentencia_5, $conn);
	
 }			   

 mysql_free_result($sillCredit);
 mysql_free_result($giftCredit);
 mysql_free_result($userIds);
 mysql_close($conn);
 
}

?>
