<?php
    	
	//db_connection();
	
	function db_connection(){
		
		$host="localhost:3306";
		$db="u970955255_acn";
		$password="sys123";
		echo "Hola";
		return mysql_connect($host, $db, $password);
	};

?>