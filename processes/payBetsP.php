<?php

putenv("TZ=America/Buenos_Aires");
	
payBets();

function payBets () {
	include('var.php');	
	global $conn;
	$db="u157368432_acn";
	if (!($conn = db_connection()))
		echo(die("Error: No se pudo conectar metodo insert() " .mysql_error()));
	
	$returnEvents = "SELECT ev.EVENT_ID, EVENT, RESULT, ODDS FROM $db.CM_EVENT ev
				 	INNER JOIN $db.CM_OPPONENT_EVENT oe ON ev.RESULT = oe.OPPONENT_ID
				 	WHERE EVENT_STATUS_FLG = 'C'
				 	GROUP BY ev.EVENT_ID";				

	$resultEvents = mysql_query($returnEvents, $conn); 
 
    while ($fila = mysql_fetch_assoc($resultEvents)) {
    	
		$eventId = $fila['EVENT_ID'];
		$event = $fila['EVENT'];
		$result = $fila['RESULT'];
		$odds = $fila['ODDS'];
		
		$returnBets = "SELECT USER_ID, OPP_USER_ID, SELECTION, AMOUNT FROM $db.CM_BET
					   WHERE EVENT_ID = $eventId
					   AND BET_STATUS_FLG = 'P'";
					   
       	$resultBets = mysql_query($returnBets, $conn); 
 
    	while ($fila = mysql_fetch_assoc($resultBets)) {				   
 	
			$userId = $fila['USER_ID'];
			$oppUserId = $fila['OPP_USER_ID'];
			$selection = $fila['SELECTION'];
			$amount = $fila['AMOUNT'];
			
			if ($result==$selection) {
				
				if ($oppUserId>0) {
					
					//Se efectua el pago de la apuesta
					payBetGolden($conn, $db, $amount, 2, $userId);
					
					//Se cierra la apuesta ganada
					closeBet($conn, $db, $userId, 'W');
					
					//Se recupera el valor de configuración del tipo de apuesta DG
					$resultDg = getAlarmDesc($conn, $db, 'DG');
					
					//Se recupera el nombre del oponente del desafio
					$getUserName = getUserName($conn, $db, $oppUserId);
					
					//Se inserta la alarma de desafio ganado
					$insertAlarm = "INSERT INTO $db.CM_ALERT (USER_ID, ALERT_CD,DESCR, ALERT_DTTM) VALUES ($userId, 'DG', '$alarmValue $event a $getUserName', '".NOW()."')";    
					mysql_query($insertAlarm, $conn);
											
				} else {
					
					//Se efectua el pago de la apuesta
					payBetSilver($conn, $db, $amount, $odds, $userId);
					
					//Se cierra la apuesta ganada
					closeBet($conn, $db, $userId, 'W');
					
					//Se recupera el valor de configuración del tipo de apuesta AP
					$resultAp = getAlarmDesc($conn, $db, 'AP');
					
					$credits = $amount * $odds;
					//Se inserta la alarma de la apuesta ganado
					$insertAlarm = "INSERT INTO $db.CM_ALERT (USER_ID, ALERT_CD,DESCR, ALERT_DTTM) VALUES ($userId, 'AP', '$credits $alarmValue $event', '".NOW()."')";    
					mysql_query($insertAlarm, $conn);				
				}
				
				
			} else {
				
				if ($oppUserId>0) {
					
					//Se cierra la apuesta perdida
					closeBet($conn, $db, $userId, 'L');
					
					//Se recupera el valor de configuración del tipo de apuesta DP
					$resultDp = getAlarmDesc($conn, $db, 'DP');
					
					//Se recupera el nombre del oponente del desafio
					$getUserName = getUserName($conn, $db, $oppUserId);
					
					//Se inserta la alarma de desafio perdido
					$insertAlarm = "INSERT INTO $db.CM_ALERT (USER_ID, ALERT_CD, DESCR, ALERT_DTTM) VALUES ($userId, 'DP', '$resultDp $event contra $getUserName', '".NOW()."')";    
					mysql_query($insertAlarm, $conn);
														
				} else {
					//Se cierra la apuesta perdida
					closeBet($conn, $db, $userId, 'L');
					
					$resultDp = getAlarmDesc($conn, $db, 'PP');
					
					//Se inserta la alarma de desafio perdido
					$insertAlarm = "INSERT INTO $db.CM_ALERT (USER_ID, ALERT_CD, DESCR, ALERT_DTTM) VALUES ($userId, 'DP', '$resultDp $event', '".NOW()."')";    
					mysql_query($insertAlarm, $conn);
				}
			}
		}

		mysql_free_result($resultBets);
		
		//Finalizado los pagos de apuestas, se cierra el evento
		endEvent($conn, $db, $eventId);
		
    }

   mysql_free_result($resultEvents);
   mysql_close($conn); 
}


function payBetGolden ($conn, $db, $amount, $odds, $userId) {
	
	$payBet = "UPDATE $db.CM_COIN SET GOLDEN_COINS = (GOLDEN_COINS + ($amount * $odds)) WHERE USER_ID='$userId'";
	mysql_query($payBet, $conn);
}

function payBetSilver ($conn, $db, $amount, $odds, $userId) {
	
	$payBet = "UPDATE $db.CM_COIN SET SILVER_COINS = (SILVER_COINS + ($amount * $odds)) WHERE USER_ID='$userId'";
	mysql_query($payBet, $conn);
}


function getAlarmDesc ($conn, $db, $alarmCd) {
		
	$getAlarm = "SELECT VALUE FROM $db.CM_ALERT_TYPE WHERE ALERT_CD = '$alarmCd'";
	$value = mysql_query($getAlarm, $conn);
	$alarm = mysql_fetch_assoc($value);
	$alarmValue = $alarm['VALUE'];
	return $alarmValue;
}

function getUserName ($conn, $db, $oppUserId) {
	
	$userName = "SELECT NAME FROM $db.CM_USER WHERE USER_ID = $oppUserId";
	$returnName = mysql_query($userName, $conn);
	$nameValue = mysql_fetch_assoc($returnName);
	$value = $nameValue['NAME'];
	return $value;
					
}

function closeBet ($conn, $db, $userId, $winFlag) {
	
	$closeBet = "UPDATE $db.CM_BET SET BET_STATUS_FLG = 'C', WIN_FLG = '$winFlag' WHERE USER_ID = $userId";
	mysql_query($closeBet, $conn);
	
}

function endEvent ($conn, $db, $eventId) {
		
	$endEvent = "UPDATE $db.CM_EVENT SET EVENT_STATUS_FLG = 'E' WHERE EVENT_ID = $eventId";
	mysql_query($endEvent, $conn);
}


?>
