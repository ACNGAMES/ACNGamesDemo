<?php

putenv("TZ=America/Buenos_Aires");
$id=$_GET["id"];
$auth_token=$_GET["auth_token"];
include 'valF.php';
if(validate($id, $auth_token)){
		
	//include('var.php');
  	if (!($iden = db_connection()))
        die("Error: No se pudo conectar".mysql_error()); 
  $db="u157368432_acn";  
  $sentencia = "SELECT * FROM $db.CM_CR_MOVES where user_id='$id' order by MOVE_DTTM desc"; 
  // Ejecuta la sentencia SQL 
  $resultado = mysql_query($sentencia, $iden); 
  if(!$resultado) 
    die("Error: no se pudo realizar la consulta");
  $array=array();
  while($fila = mysql_fetch_assoc($resultado)){
		$tot_gold = $fila['TOT_GOLD'];
	  	$tot_silver = $fila['TOT_SILVER'];
		if($tot_gold==null){
			$tot_gold=0;
		}
		if($tot_silver==null){
			$tot_silver=0;
		}
	$array[] = array('move_cd'=>$fila['MOVE_CD'],
	    			'date' =>  $fila['MOVE_DTTM'],
	    			'descr' => $fila['DESCR'],
	    			'gold' =>  $fila['GOLD'],
	    			'silver' =>  $fila['SILVER'],
	    			'tot_gold' =>  $tot_gold,
	    			'tot_silver' =>  $tot_silver
                 );
	}
  $data = array('status'=> 'ok',
					'moves'=> $array                  
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