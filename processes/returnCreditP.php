<?php

putenv("TZ=America/Buenos_Aires");
include('var.php');	
global $conn;

returnCredit();

function returnCredit () {
	
	$db="u157368432_acn";
	if (!($conn = db_connection()))
		echo(die("Error: No se pudo conectar metodo insert() " .mysql_error()));
	
	$returnChallenges = "SELECT cha.USER_ID, cha.EVENT_ID, cha.AMOUNT FROM $db.CM_CHALLENGE cha 
				         INNER JOIN $db.CM_EVENT ev ON cha.EVENT_ID = ev.EVENT_ID 
				         WHERE ev.EVENT_STATUS_FLG IN ('C','E','R')";

	$resultChallenge = mysql_query($returnChallenges, $conn); 
 
    while ($fila = mysql_fetch_assoc($resultChallenge)) {
    	
		$userId = $fila['USER_ID'];
		$amount = $fila['AMOUNT'];
		$eventId = $fila['EVENT_ID'];
		
		$returnCoins = "UPDATE $db.CM_COIN SET GOLDEN_COINS = (GOLDEN_COINS + $amount) WHERE USER_ID = $userId";
		mysql_query($returnCoins, $conn);
		
		$deleteChallenge = "DELETE FROM $db.CM_CHALLENGE WHERE USER_ID = $userId AND EVENT_ID = $eventId";
		mysql_query($deleteChallenge, $conn);
		
		//Se recupera el valor de configuración del tipo de apuesta DR
		$alarmValue = getAlarmDesc($conn,'DR');
		
		$eventDesc = getEventDesc($conn, $eventId);
		
		//Se inserta la alarma de desafio perdido
		insertAlarm ($conn, $userId, 'DR', $amount, $alarmValue, $eventDesc);
 
     }	

   mysql_free_result($returnChallenges);
   mysql_close($conn); 
}

function getAlarmDesc ($conn, $alarmCd) {
	$db="u157368432_acn";
	$getAlarm = "SELECT VALUE FROM $db.CM_ALERT_TYPE WHERE ALERT_CD = '$alarmCd'";
	$value = mysql_query($getAlarm, $conn);
	$alarm = mysql_fetch_assoc($value);
	$alarmVal = $alarm['VALUE'];
	return $alarmVal;
}

function getEventDesc ($conn, $eventId) {
		
	$db="u157368432_acn";
	$getAlarm = "SELECT EVENT FROM $db.CM_EVENT WHERE EVENT_ID = $eventId";
	$value = mysql_query($getAlarm, $conn);
	$EventVal = mysql_fetch_assoc($value);
	$EventValue = $EventVal['EVENT'];
	return $EventValue;
}

function insertAlarm ($conn, $userId, $type, $amount, $alarmValue, $eventDesc) {
	$db="u157368432_acn";
	$insertAlarm = "INSERT INTO $db.CM_ALERT (USER_ID, ALERT_CD,DESCR, ALERT_DTTM) VALUES ($userId, '$type', '$amount $alarmValue | $eventDesc', '".NOW()."')";
	//echo $insertAlarm;
	mysql_query($insertAlarm, $conn);
}


?>
