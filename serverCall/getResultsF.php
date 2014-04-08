<?php

putenv("TZ=America/Buenos_Aires");
include('var.php');
$db="u157368432_acn";

  if (!($conn = db_connection()))
    die("Error: No se pudo conectar".mysql_error());
	
	
    $sentencia = "SELECT ev.EVENT_ID, op.URL, cat.CATEGORY_ID, cat.DESCRIPTION as 'DESC', scat.DESCRIPTION, scat.SUB_CATEGORY_ID, ev.EVENT, ev.OFF_DTTM, ev.EVENT_TYPE, ope.SCORE, op.OPPONENT_NAME, op2.OPPONENT_NAME FROM $db.CM_EVENT ev  
				  INNER JOIN $db.CM_OPPONENT_EVENT ope ON ev.EVENT_ID = ope.EVENT_ID 
			   	  INNER JOIN $db.CM_OPPONENT op ON ope.OPPONENT_ID = op.OPPONENT_ID
			   	  INNER JOIN $db.CM_OPPONENT op2 ON ev.RESULT = op2.OPPONENT_ID 
				  INNER JOIN $db.CM_CATEGORY cat ON ev.CATEGORY_ID = cat.CATEGORY_ID  
				  INNER JOIN $db.CM_SUB_CATEGORY scat ON ev.SUB_CATEGORY_ID = scat.SUB_CATEGORY_ID 
				  WHERE ev.OFF_DTTM BETWEEN DATE_SUB(SYSDATE(), INTERVAL 14 DAY) AND SYSDATE()
				  AND ev.EVENT_STATUS_FLG = 'E'
				  AND ope.OPPONENT_ID <> 0
				  ORDER BY ev.OFF_DTTM, cat.CATEGORY_ID, scat.SUB_CATEGORY_ID";
				  
				  //TODO Pasar valor 14 a la tabla de configuración
	
	$resultado = mysql_query($sentencia, $conn);
	
	 //Inicializo las varialbes
	 $array = array();
	 $aux_cat = 0;
	 $aux_sub_cat = 0;
	 $aux_event = 0;
	 $score1 = 0;
	 $score2 = 0;
	 $i = -1;
	 $threeEvents = 0;
	 
     while (($fila = mysql_fetch_assoc($resultado)) && $threeEvents < 16 ) {
     			
     		$cat=$fila['CATEGORY_ID'];
     		$subcat=$fila['SUB_CATEGORY_ID'];
     		$event=$fila['EVENT_ID'];	
			$event_type=$fila['EVENT_TYPE'];     							
     		
     		//Grabo el header de la categoria
     		if($cat != $aux_cat){
     			//Si entra aca es una categoria nueva
     			
     			//Dejo la marca de subcategoria nueva
     			$aux_sub_cat = 0;
     			$aux_cat = $cat;
     			
     			
     		}
			//grabo el header de la subcategoria
     		if($subcat!=$aux_sub_cat && $cat == $aux_cat){
     			//Si entra aca es una subcategoria nueva.
     			
     			//Dejo la marca del evento nuevo
     			$aux_event = 0;
				$aux_sub_cat=$subcat;
				
     		}
     		
			
			//Verifico si el evento es nuevo
			//echo "$cat:$aux_cat->$subcat:$aux_sub_cat->$event:$aux_event <br/>"; 
     		if($event!=$aux_event && $subcat==$aux_sub_cat && $cat == $aux_cat){
     			//Si es del tipo N grabo el encabezao	
     			
     			$threeEvents++;
				if ($threeEvents<=15) {
					
				    $array[]= array('cat_id' => $cat,
    						'category' => $fila['DESC'],
    						'subcat_id' => $subcat,
    						'subcategory' => $fila['DESCRIPTION'],
    						'type' => $event_type,
    						'event'=>$fila['EVENT'],
    						'date'=>$fila['OFF_DTTM'],
    						'oponent1img'=>$fila['URL'],
    						'id' => $event,
    						'score1' => $fila['SCORE'],
    						'result' => $fila['OPPONENT_NAME']    						
							);
                    $i++;
                    $aux_event=$event;
					/*echo "<br/> cat: $cat <br/>";
					echo " category:". $fila['DESC'] ."<br/>";
					echo "subcat: $subcat <br/>";
					echo "subcategory:". $fila['DESCRIPTION'] ."<br/>";
					echo "event_type: $event_type <br/>";
					echo "event:". $fila['EVENT'] ."<br/>";
					echo "date:". $fila['OFF_DTTM'] ."<br/>";
					echo "img1:". $fila['URL'] ."<br/>";
					echo "id:". $event ."<br/>";
					echo "score1:". $fila['SCORE'] ."<br/>";*/
				}
				
			//Verifico si el evento es viejo	
			}else if($event==$aux_event && $subcat==$aux_sub_cat && $cat == $aux_cat){
				//Si es de un tipo distinto de N, grabo el encabezado del evento
				$array[$i]['oponent2img'] = ($fila['URL']);
				$array[$i]['score2'] = ($fila['SCORE']);
				
				//echo "img2:". $fila['URL'] ."<br/>";
				//echo "score2:". $fila['SCORE'] ."<br/>";
		    }	

     }

     $data = array('status'=> 'ok',
					'results'=> $array                  
					);
	 	 
	 echo json_encode($data);
	 mysql_free_result($resultado);
	 mysql_close($conn); 
 
?>
