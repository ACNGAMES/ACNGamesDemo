<?php

putenv("TZ=America/Buenos_Aires");
include('var.php');	
$db="u157368432_acn";
global $conn;

returnCredit();

function returnCredit () {
	
	if (!($conn = db_connection()))
		echo(die("Error: No se pudo conectar metodo insert() " .mysql_error()));
	
	$returnChallenges = "SELECT cha.USER_ID, cha.EVENT_ID, cha.AMOUNT FROM CM_CHALLENGE cha 
				         INNER JOIN CM_EVENT ev ON cha.EVENT_ID = ev.EVENT_ID 
				         WHERE ev.EVENT_STATUS_FLG IN ('C','E','R')";

	$resultChallenge = mysql_query($returnChallenges, $conn); 
 
    while ($fila = mysql_fetch_assoc($resultChallenge)) {
    	
		$userId = $fila['USER_ID'];
		$amount = $fila['AMOUNT'];
		$eventId = $fila['EVENT_ID'];
		
		$returnCoins = "UPDATE $db.CM_COIN SET GOLDEN_COINS = (GOLDEN_COINS + $amount) WHERE USER_ID = $userId'";
		mysql_query($returnCoins, $conn);
		
		$deleteChallenge = "DELETE FROM $db.CM_CHALLENGE WHERE USER_ID = $userId AND EVENT_ID = $eventId";
		mysql_query($deleteChallenge, $conn);
		
		//Se recupera el valor de configuración del tipo de apuesta DR
		$alarmValue = getAlarmDesc('DR');
		
		//Se inserta la alarma de desafio perdido
		insertAlarm ($userId, 'DR', $amount, $alarmValue);
 
     }	

   mysql_free_result($returnChallenges);
   mysql_close($conn); 
}

function getAlarmDesc ($alarmCd) {
		
	$getAlarm = "SELECT VALUE FROM $db.CM_ALARM_TYPE WHERE ALARM_CD = '$alarmCd'";
	$value = mysql_query($getAlarm, $conn);
	mysql_free_result($value);
	return $value;
}

function insertAlarm ($userId, $type, $amount, $alarmValue) {
	
	$insertAlarm = "INSERT INTO $db.CM_ALERT (USER_ID, ALERT_CD,DESCR, ALERT_DTTM) VALUES ($userId, 'DR', '$amount $alarmValue', '".NOW()."')";    
	mysql_query($insertAlarm, $conn);
}


?>
