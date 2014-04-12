<?php

putenv("TZ=America/Buenos_Aires");
include('var.php');	
$db="u157368432_acn";
	
	if (!($conn = db_connection()))
	echo(die("Error: No se pudo conectar metodo insert() " .mysql_error()));
	
	$returnEvents = "SELECT EVENT_ID, EVENT, RESULT FROM $db.CM_EVENT WHERE EVENT_STATUS_FLG = 'C'";
	
	$resultEvents = mysql_query($returnEvents, $conn); 
 
    while ($fila = mysql_fetch_assoc($resultEvents)) {
    	
		$eventId = $fila['EVENT_ID'];
		$event = $fila['EVENT'];
		$result = $fila['RESULT'];
		
		$returnBets = "SELECT USER_ID, OPP_USER_ID, SELECTION, AMOUNT FROM $db.CM_BET 
					   WHERE EVENT_ID = $eventId
					   AND BET_STATUS_FLG = 'A'";
					   
       	$resultBets = mysql_query($returnBets, $conn); 
 
    	while ($fila = mysql_fetch_assoc($resultBets)) {				   
 	
			$userId = $fila['USER_ID'];
			$oppUserId = $fila['OPP_USER_ID'];
			$selection = $fila['SELECTION'];
			$amount = $fila['AMOUNT'];
			
			if ($result==$selection) {
				
				
			} else {
				
				if ($oppUserId>0) {
					
					$closeBet = "UPDATE $db.CM_BET SET ";
				
				} else {
					
					
				}
				
			}
			
		}
    }

?>
