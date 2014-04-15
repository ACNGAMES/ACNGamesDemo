<?php

putenv("TZ=America/Buenos_Aires");
$userId=$_GET["userId"];
//$auth_token=$_GET["auth_token"];
$catId=$_GET["category_id"];
include 'var.php';
//if(validate($id, $auth_token)){
		
	//include('var.php');
  	if (!($iden = db_connection()))
        die("Error: No se pudo conectar".mysql_error()); 
  $db="u157368432_acn";
  $sentencia = "SELECT evt.EVENT_ID, cat.CATEGORY_ID, cat.DESCRIPTION as 'DESC', scat.DESCRIPTION, scat.SUB_CATEGORY_ID, 
				evt.EVENT, evt.OFF_DTTM, evt.EVENT_TYPE, op.URL, bet.USER_ID, bet.OPP_USER_ID FROM $db.CM_EVENT  evt
				INNER JOIN $db.CM_OPPONENT_EVENT ope ON evt.EVENT_ID = ope.EVENT_ID 
				INNER JOIN $db.CM_OPPONENT op ON ope.OPPONENT_ID = op.OPPONENT_ID 
				INNER JOIN $db.CM_CATEGORY cat ON evt.CATEGORY_ID = cat.CATEGORY_ID
				INNER JOIN $db.CM_SUB_CATEGORY scat ON evt.SUB_CATEGORY_ID = scat.SUB_CATEGORY_ID
				LEFT JOIN  $db.CM_BET bet ON evt.EVENT_ID = bet.EVENT_ID AND USER_ID = $userId
				WHERE cat.CATEGORY_ID = $catId
				AND evt.EVENT_STATUS_FLG = 'O'
				and ope.OPPONENT_ID != 0
				AND evt.OFF_DTTM BETWEEN SYSDATE() AND DATE_ADD(SYSDATE(), INTERVAL 7 DAY)
				ORDER BY scat.SUB_CATEGORY_ID, evt.OFF_DTTM, ev.EVENT_ID, ope.LOCAL"; 
  // Ejecuta la sentencia SQL
  //echo $sentencia; 
  
  $resultado = mysql_query($sentencia, $iden); 
  
  if(!$resultado) 
    die("Error: no se pudo realizar la consulta");
  $array=array();
  //Inicializo las varialbes

	 $array_sub = array();
	 $array_evt = array();
	 $aux_cat = 0;
	 $aux_sub_cat = 0;
	 $aux_event = 0;
	 $url1 = '';
	 $url2 = '';
	 $i = -1;
	 
	 while ($fila = mysql_fetch_assoc($resultado)) {
     			
     		$cat=$fila['CATEGORY_ID'];
     		$subcat=$fila['SUB_CATEGORY_ID'];
     		$event=$fila['EVENT_ID'];
			$event_type=$fila['EVENT_TYPE'];     							
     		
     		//Grabo el header de la categoria
     		if($cat != $aux_cat){
     			//Si entra aca es una categoria nueva
     			
     			$array_sub = array();
     			$array= array('cat_id' => $cat,
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
     			
     			$array['subcategories'][]= array('subcat_id' => $subcat,
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
     				$array['subcategories'][$j-1]['events'][]= array('event_id' => $event,
																		'event_type' => $event_type,
																		'event_d'=>$fila['EVENT'],
																		'off_date'=>$fila['OFF_DTTM'],
																		'bet' => $bet,
																		'opp_user' => $fila['OPP_USER_ID']													
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
     				$array['subcategories'][$j-1]['events'][]= array('event_id' => $event,
																		'event_type' => $event_type,
																		'url1' => $url1,
																		'url2'=>$fila['URL'],
																		'event_d'=>$fila['EVENT'],
																		'off_date'=>$fila['OFF_DTTM'],
																		'bet' => $bet,
																		'opp_user' => $fila['OPP_USER_ID']				
																		);
     			}
			}	
				
		 		     	
     }

  $data = array('status'=> 'ok',
  					'category'=> $array                  
    );
  mysql_free_result($resultado);
 	//Envio la respuesta por json
 	echo json_encode($data);
  
  // Cierra la conexión con la base de datos 
  mysql_close($iden);	
		
	
//}else{
//	$data = array('status'=> 'exp');
//    echo json_encode($data);
//}


?>