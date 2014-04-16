<?php
	
	putenv("TZ=America/Buenos_Aires");
	function db_connection(){
		
		$host="localhost:3306";
		$db="u157368432_acn";
		$password="sys123";
		return mysql_connect($host, $db, $password);
	};
	
	function db_hash($value1,$value2){
		return sha1($value1.$value2.$value1);
	}
	
	function NOW() {
           $date = date('Y-m-d H:i:s');
           return $date;
    }

?>