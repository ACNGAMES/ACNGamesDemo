<?php

putenv("TZ=America/Buenos_Aires");
	
payBets();

function payBets () {
	include('var.php');	
	$db="u157368432_acn";
	if (!($conn = db_connection()))
		echo(die("Error: No se pudo conectar metodo insert() " .mysql_error()));
	
	$returnEvents = "SELECT ev.EVENT_ID, EVENT, RESULT, ODDS FROM $db.CM_EVENT ev
				 	INNER JOIN $db.CM_OPPONENT_EVENT oe ON ev.EVENT_ID = oe.EVENT_ID AND ev.RESULT = oe.OPPONENT_ID
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
					   AND BET_STATUS_FLG = 'O'";
					   
       	$resultBets = mysql_query($returnBets, $conn); 
 
    	while ($fila2 = mysql_fetch_assoc($resultBets)) {				   
 	
			$userId = $fila2['USER_ID'];
			$oppUserId = $fila2['OPP_USER_ID'];
			$selection = $fila2['SELECTION'];
			$amount = $fila2['AMOUNT'];

			if ($result==$selection) {
				
				if ($oppUserId>0) {
					
					//Se efectua el pago de la apuesta
					payBetGolden($conn, $db, $amount, 2, $userId);
					
					//Se cierra la apuesta ganada
					closeBet($conn, $db, $eventId, $userId, 'W');
					
					//Se recupera el valor de configuración del tipo de apuesta DG
					$resultDg = getAlarmDesc($conn, $db, 'DG');
					
					//Se recupera el nombre del oponente del desafio
					$getUserName = getUserName($conn, $db, $oppUserId);
					
					//Se inserta la alarma de desafio ganado
					$insertAlarm = "INSERT INTO $db.CM_ALERT (USER_ID, ALERT_CD,DESCR, ALERT_DTTM) VALUES ($userId, 'DG', '$alarmValue $event a $getUserName', '".NOW()."')";    
					mysql_query($insertAlarm, $conn);
					
					$coins = "SELECT * FROM $db.CM_COIN WHERE user_id = '$userId'"; 
				  	// Ejecuta la sentencia SQL 
					$resultadoCoins = mysql_query($coins, $conn);
					$fila3 = mysql_fetch_assoc($resultadoCoins);
					$tot_gold=$fila3['GOLDEN_COINS'];
					$tot_silver=$fila3['SILVER_COINS'];
				    mysql_free_result($resultadoCoins);
					
					$coinsWon = $amount * 2;
					
					$sentencia = "INSERT INTO $db.CM_CR_MOVES(USER_ID, MOVE_DTTM, MOVE_CD, DESCR, SILVER, GOLD, TOT_GOLD, TOT_SILVER) VALUES ('$userId','".NOW()."','G','Se acert&oacute; el desaf&iacute;o $event','0.00', $coinsWon, $tot_gold, $tot_silver)";
					mysql_query($sentencia, $conn);
											
				} else {
					
					//Se efectua el pago de la apuesta
					payBetSilver($conn, $db, $amount, $odds, $userId);
					
					//Se cierra la apuesta ganada
					closeBet($conn, $db, $eventId, $userId, 'W');
					
					//Se recupera el valor de configuración del tipo de apuesta AP
					$resultAp = getAlarmDesc($conn, $db, 'AP');
					
					$credits = $amount * $odds;
					//Se inserta la alarma de la apuesta ganado
					$insertAlarm = "INSERT INTO $db.CM_ALERT (USER_ID, ALERT_CD,DESCR, ALERT_DTTM) VALUES ($userId, 'AP', '$credits $resultAp $event', '".NOW()."')";    
					mysql_query($insertAlarm, $conn);
					
					$coins = "SELECT * FROM $db.CM_COIN WHERE user_id = '$userId'"; 
				  	// Ejecuta la sentencia SQL 
					$resultadoCoins = mysql_query($coins, $conn);
					$fila4 = mysql_fetch_assoc($resultadoCoins);
					$tot_gold=$fila4['GOLDEN_COINS'];
					$tot_silver=$fila4['SILVER_COINS'];
				    mysql_free_result($resultadoCoins);
					
					$sentencia = "INSERT INTO $db.CM_CR_MOVES(USER_ID, MOVE_DTTM, MOVE_CD, DESCR, SILVER, GOLD, TOT_GOLD, TOT_SILVER) VALUES ('$userId','".NOW()."','G','Se acert&oacute; la predicci&oacute;n $event', $credits,'0.00' , $tot_gold, $tot_silver)";
					mysql_query($sentencia, $conn);				
				}
				
				
			} else {
				
				if ($oppUserId>0) {
					
					//Se cierra la apuesta perdida
					closeBet($conn, $db, $eventId, $userId, 'L');
					
					//Se recupera el valor de configuración del tipo de apuesta DP
					$resultDp = getAlarmDesc($conn, $db, 'DP');
					
					//Se recupera el nombre del oponente del desafio
					$getUserName = getUserName($conn, $db, $oppUserId);
					
					//Se inserta la alarma de desafio perdido
					$insertAlarm = "INSERT INTO $db.CM_ALERT (USER_ID, ALERT_CD, DESCR, ALERT_DTTM) VALUES ($userId, 'DP', '$resultDp $event contra $getUserName', '".NOW()."')";    
					mysql_query($insertAlarm, $conn);
														
				} else {
					//Se cierra la apuesta perdida
					closeBet($conn, $db, $eventId, $userId, 'L');
					
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

function closeBet ($conn, $db, $eventId, $userId, $winFlag) {
	
	$closeBet = "UPDATE $db.CM_BET SET BET_STATUS_FLG = 'C', WIN_FLG = '$winFlag' WHERE USER_ID = $userId AND EVENT_ID = $eventId";
	mysql_query($closeBet, $conn);
	
}

function endEvent ($conn, $db, $eventId) {
		
	$endEvent = "UPDATE $db.CM_EVENT SET EVENT_STATUS_FLG = 'E' WHERE EVENT_ID = $eventId";
	mysql_query($endEvent, $conn);
}


?>
