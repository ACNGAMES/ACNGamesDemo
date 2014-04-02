<?php

$id=$_GET["id"];
$auth_token=$_GET["auth_token"];
include 'valF.php';
if(validate($id, $auth_token)){
		
	//include('var.php');
  	if (!($iden = db_connection()))
        die("Error: No se pudo conectar".mysql_error()); 
  $db="u157368432_acn";  
  $sentencia = "SELECT ev.EVENT_ID, op.URL, op.OPPONENT_ID, ope.ODDS, bet.OPP_USER_ID, bet.SELECTION, cat.CATEGORY_ID, bet.BET_DTTM, bet.AMOUNT ,cat.DESCRIPTION as 'DESC', scat.DESCRIPTION, scat.SUB_CATEGORY_ID, ev.EVENT, ev.OFF_DTTM, ev.EVENT_TYPE FROM $db.CM_EVENT ev  
				  INNER JOIN $db.CM_OPPONENT_EVENT ope ON ev.EVENT_ID = ope.EVENT_ID
				  INNER JOIN $db.CM_OPPONENT op ON ope.OPPONENT_ID = op.OPPONENT_ID 
				  INNER JOIN $db.CM_CATEGORY cat ON ev.CATEGORY_ID = cat.CATEGORY_ID  
				  INNER JOIN $db.CM_SUB_CATEGORY scat ON ev.SUB_CATEGORY_ID = scat.SUB_CATEGORY_ID 
				  INNER JOIN $db.CM_BET bet ON ev.EVENT_ID = bet.EVENT_ID AND bet.USER_ID = $id 
				  WHERE ev.EVENT_STATUS_FLG = 'O'
				  ORDER BY cat.CATEGORY_ID, scat.SUB_CATEGORY_ID, ev.OFF_DTTM"; 
  // Ejecuta la sentencia SQL 
  $resultado = mysql_query($sentencia, $iden); 
  echo $sentencia;
  if(!$resultado) 
    die("Error: no se pudo realizar la consulta");
  $array=array();
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
     				$array[$i-1]['subcategories'][$j-1]['events']= array('event_id' => $event,
																		'event_type' => $event_type,
																		'event'=>$fila['EVENT'],
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
     				$array[$i-1]['subcategories'][$j-1]['events']= array('event_id' => $event,
																		'event_type' => $event_type,
																		'url1' => $url1,
																		'url2'=>$fila['URL'],
																		'event'=>$fila['EVENT'],
																		'off_dttm'=>$fila['OFF_DTTM'],
																		'bet' => $bet				
																		);
     			}
			}	
				
		 		     	
     }
  $data = array('status'=> 'ok',
					'alerts'=> $array                  
    );
  mysql_free_result($resultado);
 	//Envio la respuesta por json
 	echo json_encode($data);
  
  // Cierra la conexión con la base de datos 
  mysql_close($iden);	
		
	
}else{
	$data = array('status'=> 'exp');
    echo json_encode($data);
}


?>