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

$array[] = array('oponent1img'=>'http://www.ole.com.ar/bbtfile/5012_20130919pfptsb.jpg',
				'oponent2img'=>'http://www.ole.com.ar/bbtfile/5012_20130919S82Aj9.jpg',
				'oponent1Score'=>'1',
				'oponent2Score'=>'0',
				'category'=>'1era División Torneo Final 2014',
				'subcategory'=>'Fecha 4',
				'event'=>'All Boys - Olimpo',
				'date'=>'22-02-2014',
				'type'=>'E' //E significa que son dos rivales y acepta Empates          
                 );

$array[] = array('oponent1img'=>'http://www.ole.com.ar/bbtfile/5012_20130919o2QZN4.jpg',
				'oponent2img'=>'http://www.ole.com.ar/bbtfile/5012_20131223Pn0vfS.jpg',
				'oponent1Score'=>'3',
				'oponent2Score'=>'1',
				'category'=>'1era División Torneo Final 2014',
				'subcategory'=>'Fecha 4',
				'event'=>'Arsenal - Racing',
				'date'=>'22-02-2014',
				'type'=>'E' //E significa que son dos rivales y acepta Empates          
                 );
           	   			
$array[] = array('oponent1img'=>'http://www.ole.com.ar/bbtfile/5012_20130919kqazK9.jpg',
				'oponent2img'=>'http://www.ole.com.ar/bbtfile/5012_20130919yjZkbh.jpg',
				'oponent1Score'=>'4',
				'oponent2Score'=>'1',
				'category'=>'1era División Torneo Final 2014',
				'subcategory'=>'Fecha 4',
				'event'=>'Newell´s - Atletico Rafaela',
				'date'=>'23-02-2014',
				'type'=>'E' //E significa que son dos rivales y acepta Empates          
                 );

$array[] = array('oponent1img'=>'http://www.ole.com.ar/bbtfile/5012_20131030wV2rSa.jpg',
				'oponent2img'=>'http://www.ole.com.ar/bbtfile/5012_20130919V9l1uI.jpg',
				'oponent1Score'=>'1',
				'oponent2Score'=>'0',
				'category'=>'1era División Torneo Final 2014',
				'subcategory'=>'Fecha 4',
				'event'=>'San Lorenzo - Quilmes',
				'date'=>'23-02-2014',
				'type'=>'E' //E significa que son dos rivales y acepta Empates          
                 );
           	   			
$array[] = array('oponent1img'=>'http://www.ole.com.ar/bbtfile/5012_20130919x7cYEQ.jpg',
				'oponent2img'=>'http://www.ole.com.ar/bbtfile/5012_20130919LjyQq9.jpg',
				'oponent1Score'=>'1',
				'oponent2Score'=>'0',
				'category'=>'1era División Torneo Final 2014',
				'subcategory'=>'Fecha 4',
				'event'=>'Boca Juniors - Estudiantes',
				'date'=>'23-02-2014',
				'type'=>'E' //E significa que son dos rivales y acepta Empates          
                 );
           	   			
$array[] = array('oponent1img'=>'http://www.ole.com.ar/bbtfile/5012_20130919Dpc4Gi.jpg',
				'oponent2img'=>'http://www.ole.com.ar/bbtfile/5012_20130919vBcRjT.jpg',
				'oponent1Score'=>'3',
				'oponent2Score'=>'1',
				'category'=>'1era División Torneo Final 2014',
				'subcategory'=>'Fecha 4',
				'event'=>'Colon - River Plate',
				'date'=>'23-02-2014',
				'type'=>'E' //E significa que son dos rivales y acepta Empates          
                 );
				 
$array[] = array('oponent1img'=>'http://www.ole.com.ar/bbtfile/5012_20130919RwThSo.jpg',
				'oponent2img'=>'http://www.ole.com.ar/bbtfile/5012_20130919iwwqOj.jpg',
				'oponent1Score'=>'3',
				'oponent2Score'=>'0',
				'category'=>'1era División Torneo Final 2014',
				'subcategory'=>'Fecha 4',
				'event'=>'Godoy Cruz - Rosario Central',
				'date'=>'24-02-2014',
				'type'=>'E' //E significa que son dos rivales y acepta Empates          
                 );
           	   			
$array[] = array('oponent1img'=>'http://www.ole.com.ar/bbtfile/5012_20130919QSkMJc.jpg',
				'oponent2img'=>'http://www.ole.com.ar/bbtfile/5012_20130919txaGHT.jpg',
				'oponent1Score'=>'0',
				'oponent2Score'=>'0',
				'category'=>'1era División Torneo Final 2014',
				'subcategory'=>'Fecha 4',
				'event'=>'Tigre - Argentinos Juniors',
				'date'=>'24-02-2014',
				'type'=>'E' //E significa que son dos rivales y acepta Empates          
                 );

$array[] = array('oponent1img'=>'http://www.ole.com.ar/bbtfile/5012_20130919BuYLJy.jpg',
				'oponent2img'=>'http://www.ole.com.ar/bbtfile/5012_20130919AprvTS.jpg',
				'oponent1Score'=>'2',
				'oponent2Score'=>'2',
				'category'=>'1era División Torneo Final 2014',
				'subcategory'=>'Fecha 4',
				'event'=>'Gimnasia - Belgrano',
				'date'=>'24-02-2014',
				'type'=>'E' //E significa que son dos rivales y acepta Empates          
                 );
           	   			
$data = array('status'=> 'ok',
					'results'=> $array                  
           );
  
  //Envio la respuesta por json
  echo json_encode($data);
  
?>
