<?php
    	
	//db_connection();
	$db ="u157368432_acn";
	
	function db_connection(){
		
		$host="localhost:3306";
		//$db="u970955255_acn";
		global $db;
		$password="sys123";
		return mysql_connect($host, $db, $password);
	};
	
	function db_hash($value1,$value2){
		return sha1($value1.$value2.$value1);
	}

?>