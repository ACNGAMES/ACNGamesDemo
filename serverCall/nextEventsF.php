<?php

$userId=$_GET["id"];
$authToken=$_GET["auth_token"];
include('valF.php');
$db="u157368432_acn";

if(validate($userId, $authToken)){
  if (!($conn = db_connection()))
    die("Error: No se pudo conectar".mysql_error());
	
	
    $sentencia = "SELECT ev.EVENT_ID, op.URL, cat.CATEGORY_ID, cat.DESCRIPTION as 'DESC', scat.DESCRIPTION, scat.SUB_CATEGORY_ID, ev.EVENT, ev.OFF_DTTM, ev.EVENT_TYPE, bet.USER_ID FROM $db.CM_EVENT ev  
				  INNER JOIN $db.CM_OPPONENT_EVENT ope ON ev.EVENT_ID = ope.EVENT_ID 
			   	  INNER JOIN $db.CM_OPPONENT op ON ope.OPPONENT_ID = op.OPPONENT_ID 
				  INNER JOIN $db.CM_CATEGORY cat ON ev.CATEGORY_ID = cat.CATEGORY_ID  
				  INNER JOIN $db.CM_SUB_CATEGORY scat ON ev.SUB_CATEGORY_ID = scat.SUB_CATEGORY_ID 
				  LEFT  JOIN $db.CM_BET bet ON ev.EVENT_ID = bet.EVENT_ID AND bet.USER_ID = $userId
				  WHERE ev.OFF_DTTM BETWEEN SYSDATE() AND DATE_ADD(SYSDATE(), INTERVAL 1 DAY)
				  AND ev.EVENT_STATUS_FLG = 'O'
				  AND ope.OPPONENT_ID <> 0
				  ORDER BY ev.OFF_DTTM, cat.CATEGORY_ID, scat.SUB_CATEGORY_ID";
				  
	$resultado = mysql_query($sentencia, $conn);
	
	$count = mysql_num_rows($resultado);
	
	if($count<20){
		
	$sentencia = "SELECT ev.EVENT_ID, op.URL, cat.CATEGORY_ID, cat.DESCRIPTION as 'DESC', scat.DESCRIPTION, scat.SUB_CATEGORY_ID, ev.EVENT, ev.OFF_DTTM, ev.EVENT_TYPE, bet.USER_ID FROM $db.CM_EVENT ev  
				  INNER JOIN $db.CM_OPPONENT_EVENT ope ON ev.EVENT_ID = ope.EVENT_ID 
			   	  INNER JOIN $db.CM_OPPONENT op ON ope.OPPONENT_ID = op.OPPONENT_ID 
				  INNER JOIN $db.CM_CATEGORY cat ON ev.CATEGORY_ID = cat.CATEGORY_ID  
				  INNER JOIN $db.CM_SUB_CATEGORY scat ON ev.SUB_CATEGORY_ID = scat.SUB_CATEGORY_ID 
				  LEFT  JOIN $db.CM_BET bet ON ev.EVENT_ID = bet.EVENT_ID AND bet.USER_ID = $userId
				  WHERE ev.OFF_DTTM > SYSDATE()
				  AND ev.EVENT_STATUS_FLG = 'O'
				  ORDER BY ev.OFF_DTTM, cat.CATEGORY_ID, scat.SUB_CATEGORY_ID
				  LIMIT 30";
				  
				  //TODO Pasar valor 30 a la tabla de configuración
	$resultado = mysql_query($sentencia, $conn);
		
	} 
	 
	 //Inicializo las varialbes
	 $array = array();
	 $array_sub = array();
	 $array_evt = array();
	 $aux_cat = 0;
	 $aux_sub_cat = 0;
	 $aux_event = 0;
	 $url1 = '';
	 $url2 = '';
	 $i = 0;
	 $j = 0;
     while ($fila = mysql_fetch_assoc($resultado)) {
     			
     		$cat=$fila['CATEGORY_ID'];
     		$subcat=$fila['SUB_CATEGORY_ID'];
     		$event=$fila['EVENT_ID'];
			$event_type=$fila['EVENT_TYPE'];     							
     		
     		//Grabo el header de la categoria
     		if($cat != $aux_cat){
     			//Si entra aca es una categoria nueva
     			
     			$array_sub = array();
     			$array[]= array('cat_id' => $cat,
						'cat_descr' => $fila['DESC'],
						'subcategories' => $array_sub
				);
     			//Dejo la marca de subcategoria nueva
     			$aux_sub_cat = 0;
     			$aux_cat = $cat;
     			$j=0;
     			$i++;
     		}
			//grabo el header de la subcategoria
     		if($subcat!=$aux_sub_cat && $cat == $aux_cat){
     			//Si entra aca es una subcategoria nueva.
     			$array_evt = array();
     			
     			$array[$i-1]['subcategories'][]= array('subcat_id' => $subcat,
														'subcat_descr' => $fila['DESCRIPTION'],
														'events' => $array_evt				
														);
     			//Dejo la marca del evento nuevo
     			$aux_event = 0;
				$aux_sub_cat=$subcat;
				$j++;			
     		}
     		
			//Verifico si el evento es nuevo
			//echo "$cat:$aux_cat->$subcat:$aux_sub_cat->$event:$aux_event <br/>"; 
     		if($event!=$aux_event && $subcat==$aux_sub_cat && $cat == $aux_cat){
     			//Si es del tipo N grabo el encabezao	
     			if($event_type=='N'){
     				$bet=$fila['USER_ID'];	
     				if($bet==null){
     					$bet=0;
     				}
     				$array[$i-1]['subcategories'][$j-1]['events'][]= array('event_id' => $event,
																		'event_type' => $event_type,
																		'event_d'=>$fila['EVENT'],
																		'off_dttm'=>$fila['OFF_DTTM'],
																		'bet' => $bet													
																		);
     			}else{
     				//grabo la url
     				$url1=$fila['URL'];	
     			}
				$aux_event=$event;
			//Verifico si el evento es viejo	
			}else if($event==$aux_event && $subcat==$aux_sub_cat && $cat == $aux_cat){
				//Si es de un tipo distinto de N, grabo el encabezado del evento
				if($event_type!='N'){
     				$bet=$fila['USER_ID'];	
     				if($bet==null){
     					$bet=0;
     				}	
     				$array[$i-1]['subcategories'][$j-1]['events'][]= array('event_id' => $event,
																		'event_type' => $event_type,
																		'url1' => $url1,
																		'url2'=>$fila['URL'],
																		'event_d'=>$fila['EVENT'],
																		'off_dttm'=>$fila['OFF_DTTM'],
																		'bet' => $bet				
																		);
     			}
			}	
				
		 		     	
     }

     $data = array('status'=> 'ok',
					'next_events'=> $array                  
					);
	 	 
	 mysql_free_result($resultado);
	 echo json_encode($data);
	 mysql_close($conn); 
	 
}else{
	$data = array('status'=> 'exp');
    echo json_encode($data);
}

?>
