<?php

$array[] = array('oponent1img'=>'http://www.ole.com.ar/static/OLEOle/images/escudos/escudos_g/png/20.png',
				'oponent2img'=>'http://www.ole.com.ar/static/OLEOle/images/escudos/escudos_g/png/5.png',
				'category'=>'1era División Torneo Final 2014',
				'subcategory'=>'Fecha 5',
				'event'=>'Velez Sarfield  vs  Boca Juniors',
				'date'=>'01-03-2014 18:00',
				'type'=>'E' //E significa que son dos rivales y acepta Empates          
                 );
	
$array[] = array('oponent1img'=>'http://www.ole.com.ar/static/OLEOle/images/escudos/escudos_g/png/7.png',
				'oponent2img'=>'http://www.ole.com.ar/static/OLEOle/images/escudos/escudos_g/png/13.png',
				'category'=>'Copa Libertadores 2014',
				'subcategory'=>'Grupos IDA',
				'event'=>'Estudiantes  vs  Newell´s',
				'date'=>'02-03-2014 21:30',
				'type'=>'D' //D significa que son dos rivales          
                 );

$array[] = array('category'=>'Premios Oscars 2014',
				'subcategory'=>'Entrega Premios 2014',
				'event'=>'Mejor Pelicula',
				'date'=>'28-02-2014 22:00',
				'type'=>'N' //N significa que son varios rivales          
                 );


  $data = array('status'=> 'ok',
					'events'=> $array                  
           );
  
  //Envio la respuesta por json
  echo json_encode($data);
  
?>