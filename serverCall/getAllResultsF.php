<?php

putenv("TZ=America/Buenos_Aires");
include('var.php');
$db="u157368432_acn";

  if (!($conn = db_connection()))
    die("Error: No se pudo conectar".mysql_error());
	
	
    $sentencia = "SELECT ev.EVENT_ID, op.URL, cat.CATEGORY_ID, cat.DESCRIPTION as 'DESC', scat.DESCRIPTION, scat.SUB_CATEGORY_ID, ev.EVENT, ev.OFF_DTTM, 
    			  ev.EVENT_TYPE, ope.SCORE, op.OPPONENT_NAME, op2.OPPONENT_NAME as 'WNAME', ope.SCORE
    			  FROM $db.CM_EVENT ev  
				  INNER JOIN $db.CM_OPPONENT_EVENT ope ON ev.EVENT_ID = ope.EVENT_ID 
			   	  INNER JOIN $db.CM_OPPONENT op ON ope.OPPONENT_ID = op.OPPONENT_ID
			   	  INNER JOIN $db.CM_OPPONENT op2 ON ev.RESULT = op2.OPPONENT_ID 
				  INNER JOIN $db.CM_CATEGORY cat ON ev.CATEGORY_ID = cat.CATEGORY_ID  
				  INNER JOIN $db.CM_SUB_CATEGORY scat ON ev.SUB_CATEGORY_ID = scat.SUB_CATEGORY_ID 
				  WHERE ev.OFF_DTTM BETWEEN DATE_SUB(SYSDATE(), INTERVAL 14 DAY) AND SYSDATE()
				  AND ev.EVENT_STATUS_FLG = 'E'
				  AND ope.OPPONENT_ID <> 0
				  ORDER BY cat.CATEGORY_ID, scat.SUB_CATEGORY_ID, ev.OFF_DTTM";
				  
				  //TODO Pasar valor 14 a la tabla de configuración
				  //echo $sentencia;
	
	$resultado = mysql_query($sentencia, $conn);
	
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
     				
     				$array[$i-1]['subcategories'][$j-1]['events'][]= array('event_id' => $event,
																		'event_type' => $event_type,
																		'event_d'=>$fila['EVENT'],
																		'off_date'=>$fila['OFF_DTTM'],
																		'wname'=>$fila['WNAME']
																		);
     			}else{
     				//grabo la url
     				$url1=$fila['URL'];
					$name1=$fila['OPPONENT_NAME'];
					$score1=$fila['SCORE'];
     			}
				$aux_event=$event;
			//Verifico si el evento es viejo	
			}else if($event==$aux_event && $subcat==$aux_sub_cat && $cat == $aux_cat){
				//Si es de un tipo distinto de N, grabo el encabezado del evento
				if($event_type!='N'){
     				
     				$array[$i-1]['subcategories'][$j-1]['events'][]= array('event_id' => $event,
																		'event_type' => $event_type,
																		'url1' => $url1,
																		'url2'=>$fila['URL'],
																		'event_d'=>$fila['EVENT'],
																		'off_date'=>$fila['OFF_DTTM'],
																		'name1' => $name1,
																		'name2' => $fila['OPPONENT_NAME'],
																		'score1' => $score1,
																		'score2' => $fila['SCORE']
																	 );
     			}
			}	
				
		 		     	
     }

     $data = array('status'=> 'ok',
					'allResults'=> $array                  
					);
	 	 
	 echo json_encode($data);
	 mysql_free_result($resultado);
	 mysql_close($conn); 
 
?>
