<?php
  include('var.php');
  $db="u157368432_acn";
  if (!($iden = db_connection()))
        die("Error: No se pudo conectar".mysql_error()); 
     
  $sentencia = "SELECT * FROM $db.CM_CATEGORY"; 
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