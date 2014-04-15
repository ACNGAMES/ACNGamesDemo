<?php

putenv("TZ=America/Buenos_Aires");
include('var.php');	
$db="u157368432_acn";
global $conn;

payBets();

function payBets () {
	
	if (!($conn = db_connection()))
		echo(die("Error: No se pudo conectar metodo insert() " .mysql_error()));
	
	$returnEvents = "SELECT EVENT_ID, EVENT, RESULT, ODDS FROM $db.CM_EVENT eva
				 	INNER JOIN $db.CM_OPPONENT_EVENT oe ON ev.RESULT = oe.OPPONENT_ID
				 	WHERE EVENT_STATUS_FLG = 'C'";

	$resultEvents = mysql_query($returnEvents, $conn); 
 
    while ($fila = mysql_fetch_assoc($resultEvents)) {
    	
		$eventId = $fila['EVENT_ID'];
		$event = $fila['EVENT'];
		$result = $fila['RESULT'];
		$odds = $fila['ODDS'];
		
		$returnBets = "SELECT USER_ID, OPP_USER_ID, SELECTION, AMOUNT FROM $db.CM_BET
					   WHERE EVENT_ID = $eventId
					   AND BET_STATUS_FLG = 'O'";
					   
       	$resultBets = mysql_query($returnBets, $conn); 
 
    	while ($fila = mysql_fetch_assoc($resultBets)) {				   
 	
			$userId = $fila['USER_ID'];
			$oppUserId = $fila['OPP_USER_ID'];
			$selection = $fila['SELECTION'];
			$amount = $fila['AMOUNT'];
			
			if ($result==$selection) {
				
				if ($oppUserId>0) {
					
					//Se efectua el pago de la apuesta
					payBetGolden($amount, 2, $userId);
					
					//Se cierra la apuesta ganada
					closeBetWon($userId, 'W');
					
					//Se recupera el valor de configuración del tipo de apuesta DG
					$alarmValue = getAlarmDesc('DG');
					
					//Se recupera el nombre del oponente del desafio
					$getUserName = getUserName($oppUserId);
					
					//Se inserta la alarma de desafio ganado
					insertAlarm($userId, 'DG', $alarmValue, $getUserName);
						
				} else {
					
					//Se efectua el pago de la apuesta
					payBetSilver($amount, $odds, $userId);
					
					//Se cierra la apuesta ganada
					closeBetWon($userId, 'W');
					
					//Se recupera el valor de configuración del tipo de apuesta AP
					$alarmValue = getAlarmDesc('AP');
					
					$credits = $amount * $odds;
					//Se inserta la alarma de la apuesta ganado
					insertAlarm ($userId, 'AP', $credits, $alarmValue);					
				}
				
				
			} else {
				
				if ($oppUserId>0) {
					
					//Se cierra la apuesta perdida
					closeBet($userId, 'L');
					
					//Se recupera el valor de configuración del tipo de apuesta DP
					$alarmValue = getAlarmDesc('DP');
					
					//Se recupera el nombre del oponente del desafio
					$getUserName = getUserName($oppUserId);
					
					//Se inserta la alarma de desafio perdido
					insertAlarm ($userId, 'DP', $alarmValue, $getUserName);
									
				} else {
					//Se cierra la apuesta perdida
					closeBet($userId, 'L');
				}
			}
		}

		mysql_free_result($returnBets);
		
		//Finalizado los pagos de apuestas, se cierra el evento
		endEvent($eventId);
		
    }

   mysql_free_result($resultBets);
   mysql_close($conn); 
}


function payBetGolden ($amount, $odds, $userId) {
	
	$payBet = "UPDATE $db.CM_COIN SET GOLDEN_COINS = (GOLDEN_COINS + ($amount * $odds)) WHERE USER_ID='$userId'";
	mysql_query($payBet, $conn);
}

function payBetSilver ($amount, $odds, $userId) {
	
	$payBet = "UPDATE $db.CM_COIN SET SILVER_COINS = (SILVER_COINS + ($amount * $odds)) WHERE USER_ID='$userId'";
	mysql_query($payBet, $conn);
}


function getAlarmDesc ($alarmCd) {
		
	$getAlarm = "SELECT VALUE FROM $db.CM_ALARM_TYPE WHERE ALARM_CD = '$alarmCd'";
	$value = mysql_query($getAlarm, $conn);
	mysql_free_result($value);
	return $value;
}

function getUserName () {
	
	$userName = "SELECT NAME FROM $db.CM_USER WHERE USER_ID = $oppUserId";
	$name = mysql_query($userName, $conn);
	mysql_free_result($name);
	return $name;
					
}

function closeBet ($userId, $winFlag) {
	
	$closeBet = "UPDATE $db.CM_BET SET BET_STATUS_FLG = 'C', WIN_FLG = '$winFlag' WHERE USER_ID = $userId";
	mysql_query($closeBet, $conn);
	
}

function insertAlarm ($userId, $type, $alarmValue, $getUserName) {
	
	$insertAlarm = "INSERT INTO $db.CM_ALERT (USER_ID, ALERT_CD,DESCR, ALERT_DTTM) VALUES ($userId, 'DP', '$alarmValue $getUserName', NOW())";    
	mysql_query($insertAlarm, $conn);
}

function endEvent ($eventId) {
		
	$endEvent = "UPDATE $db.CM_EVENT SET EVENT_STATUS_FLG = 'E' WHERE EVENT_ID = $eventId";
	mysql_query($endEvent, $conn);
}


?>
