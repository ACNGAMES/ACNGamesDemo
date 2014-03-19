<?php
  if(!($iden = mysql_connect("localhost:3306", "u970955255_acn", "sys123")))
        die("Error: No se pudo conectar".mysql_error()); 
     
  $sentencia = "SELECT * FROM u970955255_acn.CM_CATEGORY"; 
  // Ejecuta la sentencia SQL 
  $resultado = mysql_query($sentencia, $iden); 
  if(!$resultado) 
    die("Error: no se pudo realizar la consulta");
  $array = array();
while($fila = mysql_fetch_assoc($resultado)){
	$array[] = array('id'=> $fila['CATEGORY_ID'],
	    			'desc'=>$fila['DESCRIPTION'],
	    			'img' => $fila['URL']          
                 );
}
  $data = array('status'=> 'ok',
					'categories'=> $array                  
           );
  mysql_free_result($resultado);
  //Envio la respuesta por json
  echo json_encode($data);
  // Cierra la conexión con la base de datos 
  mysql_close($iden);	
		

?>