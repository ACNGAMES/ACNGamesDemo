<?php

$userId=$_GET["id"];
include('var.php');
$db="u157368432_acn";

function getNext3Events() {

if (!($conn = db_connection()))
    die("Error: No se pudo conectar".mysql_error());
	
	$array = array(array(array()));
    $sentencia = "SELECT ev.EVENT_ID, op.URL, cat.DESCRIPTION, scat.DESCRIPTION, 
				  ev.EVENT, ev.OFF_DTTM, ev.EVENT_TYPE, bet.USER_ID FROM CM_EVENT ev  
				  LEFT JOIN CM_OPPONENT_EVENT ope ON ev.EVENT_ID = ope.EVENT_ID 
				  INNER JOIN CM_OPPONENT op ON ope.OPPONENT_ID = op.OPPONENT_ID 
				  INNER JOIN CM_CATEGORY cat ON ev.CATEGORY_ID = cat.CATEGORY_ID  
				  INNER JOIN CM_SUB_CATEGORY scat ON ev.SUB_CATEGORY_ID = scat.SUB_CATEGORY_ID 
				  LEFT  JOIN CM_BET bet ON ev.EVENT_ID = bet.EVENT_ID 
				  WHERE ev.OFF_DTTM > SYSDATE() 
				  ORDER BY cat.CATEGORY_ID, scat.SUB_CATEGORY_ID, ev.OFF_DTTM";

     $resultado = mysql_query($sentencia, $conn); 
 
     while ($fila = mysql_fetch_assoc($resultado)) {
     	$category = $fila["cat.DESCRIPTION"];
     	for ($i=0; $i < mysql_num_rows($resultado); $i++) { 
			 if(searchInMultiArray($category, $array)){
			 	$j=0;	
			 	$subCategory = $fila["scat.DESCRIPTION"];
			 	if(searchInMultiArray($subCategory, $array)){
			 		
					$array = array($category => array($subCategory => array('event' => "Valor1", 'event2' => "Valor2")));
			 	} 
			 	
			 	else {
			 		
			 	}
			 
		 	}
		 	
			else {
				
			}
     	
     	}
     }
}

function searchInMultiArray($element, $array)
    {
        $top = sizeof($array) - 1;
        $bottom = 0;
        while($bottom <= $top)
        {
            if($array[$bottom] == $elem)
                return true;
            else 
                if(is_array($array[$bottom]))
                    if(in_multiarray($elem, ($array[$bottom])))
                        return true;
                    
            $bottom++;
        }        
        return false;
    }

?>