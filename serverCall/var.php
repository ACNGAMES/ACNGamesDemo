<?php
    	
	//db_connection();
	
	function db_connection(){
		
		$host="localhost:3306";
		$db="u970955255_acn";
		$password="sys123";
		return mysql_connect($host, $db, $password);
	};
	
	function db_hash($value1,$value2){
		return sha1($value1.$value2.$value1);
	}

?>