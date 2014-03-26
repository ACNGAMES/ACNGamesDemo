<?php

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
