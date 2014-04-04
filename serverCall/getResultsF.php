<?php

$userId=$_GET["id"];
$authToken=$_GET["auth_token"];
include('valF.php');
$db="u157368432_acn";

if(validate($userId, $authToken)){
  if (!($conn = db_connection()))
    die("Error: No se pudo conectar".mysql_error());
	
	
    $sentencia = "SELECT ev.EVENT_ID, op.URL, cat.CATEGORY_ID, cat.DESCRIPTION as 'DESC', scat.DESCRIPTION, scat.SUB_CATEGORY_ID, ev.EVENT, ev.OFF_DTTM, ev.EVENT_TYPE FROM $db.CM_EVENT ev  
				  INNER JOIN $db.CM_OPPONENT_EVENT ope ON ev.EVENT_ID = ope.EVENT_ID 
			   	  INNER JOIN $db.CM_OPPONENT op ON ope.OPPONENT_ID = op.OPPONENT_ID 
				  INNER JOIN $db.CM_CATEGORY cat ON ev.CATEGORY_ID = cat.CATEGORY_ID  
				  INNER JOIN $db.CM_SUB_CATEGORY scat ON ev.SUB_CATEGORY_ID = scat.SUB_CATEGORY_ID 
				  WHERE ev.OFF_DTTM BETWEEN DATE_SUB(SYSDATE(), INTERVAL 14 DAY) AND SYSDATE()
				  AND ev.EVENT_STATUS_FLG = 'E'
				  ORDER BY cat.CATEGORY_ID, scat.SUB_CATEGORY_ID, ev.OFF_DTTM";
				  
				  //TODO Pasar valor 14 a la tabla de configuración
				  
	$resultado = mysql_query($sentencia, $conn);
	
	$count = mysql_num_rows($resultado);
	
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
	 $threeEvents=0;
	 
     while (($fila = mysql_fetch_assoc($resultado)) && $$threeEvents<16 ) {
     			
     		$cat=$fila['CATEGORY_ID'];
     		$subcat=$fila['SUB_CATEGORY_ID'];
     		$event=$fila['EVENT_ID'];
			$event_type=$fila['EVENT_TYPE'];     							
     		
     		//Grabo el header de la categoria
     		if($cat != $aux_cat){
     			//Si entra aca es una categoria nueva
     			
     			$array_sub = array();
     			$array[]= array('cat_id' => $cat,
						'category' => $fila['DESC'],
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
														'subcategory' => $fila['DESCRIPTION'],
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
																		'type' => $event_type,
																		'event'=>$fila['EVENT'],
																		'date'=>$fila['OFF_DTTM']																															
																		);
				  $threeEvents++;
				  
     			}else{
     				//grabo la url
     				$url1=$fila['URL'];	
     			}
				$aux_event=$event;
			//Verifico si el evento es viejo	
			}else if($event==$aux_event && $subcat==$aux_sub_cat && $cat == $aux_cat){
				//Si es de un tipo distinto de N, grabo el encabezado del evento
				if($event_type!='N'){
     			 $array[$i-1]['subcategories'][$j-1]['events'][]= array('event_id' => $event,
																		'type' => $event_type,
																		'oponent1img' => $url1,
																		'oponent2img'=>$fila['URL'],
																		'event'=>$fila['EVENT'],
																		'date'=>$fila['OFF_DTTM']																		
																		);
     			 $threeEvents++;
				
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

$array[] = array('category'=>'Premios Oscars 2014',
				'subcategory'=>'Entrega Premios 2014',
				'event'=>'Mejor Pelicula',
				'img'=>'',
				'result' => '12 años de esclavitud',
				'date'=>'28-02-2014 22:00',
				'type'=>'N' //N significa que son varios rivales          
                 );


$array[] = array('oponent1img'=>'http://www.ole.com.ar/bbtfile/5012_201309199atd2A.jpg',
				'oponent2img'=>'http://www.ole.com.ar/bbtfile/5012_20130919xYIoMs.jpg',
				'oponent1Score'=>'3',
				'oponent2Score'=>'2',
				'category'=>'1era División Torneo Final 2014',
				'subcategory'=>'Fecha 4',
				'event'=>'Lanus - Velez Sarfield',
				'date'=>'22-02-2014',
				'type'=>'E' //E significa que son dos rivales y acepta Empates          
                 );

           	   			
$data = array('status'=> 'ok',
					'results'=> $array                  
           );
  
  //Envio la respuesta por json
  echo json_encode($data);
  
?>
