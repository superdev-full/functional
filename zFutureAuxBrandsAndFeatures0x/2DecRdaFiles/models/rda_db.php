<?php

class RdaDB{

	var $debug = false;

	function __construct($debug = false){
		$this->debug = $debug;
	}

	/**
	 * A method to get records from the db
	 * @param $sql, sql
	 * 
	 * @return $items, An array with the data
	 */	
	public function db_query_select( $sql ){
		// mysqli_report(MYSQLI_REPORT_ERROR);
		// Connect to the MySQL database using MySQLi
		$con = mysqli_connect(db_host, db_user, db_pass, db_name);
		// If there is an error with the MySQL connection, stop the script and output the error
		if (mysqli_connect_errno()) {
			exit('Failed to connect to MySQL: ' . mysqli_connect_error());
		}
		// Update the charset
		mysqli_set_charset($con, db_charset);	

		// Prepare query; prevents SQL injection
		$result = $con->query($sql);
	
		return $result;
	}
	
	/**
	 * A method to get a record 
	 * @param $sql, sql
	 * 
	 * @return $items, An array with the data
	 */	
	public function db_query_select_row( $sql  ){
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		// Connect to the MySQL database using MySQLi
		$con = mysqli_connect(db_host, db_user, db_pass, db_name);
		// If there is an error with the MySQL connection, stop the script and output the error
		if (mysqli_connect_errno()) {
			exit('Failed to connect to MySQL: ' . mysqli_connect_error());
		}
		// Update the charset
		mysqli_set_charset($con, db_charset);	

		// Prepare query; prevents SQL injection
		$result = $con->query($sql);

		$record = $result->fetch_assoc();
	
		return $record;
	}	
	
	/**
	 * A method to update records 
	 * @param $sql, sql
	 * 
	 * @return $items, An array with the data
	 */	
	public function db_query_update( $sql  ){
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		// Connect to the MySQL database using MySQLi
		$con = mysqli_connect(db_host, db_user, db_pass, db_name);
		// If there is an error with the MySQL connection, stop the script and output the error
		if (mysqli_connect_errno()) {
			exit('Failed to connect to MySQL: ' . mysqli_connect_error());
		}
		// Update the charset
		mysqli_set_charset($con, db_charset);	

		// Prepare query; prevents SQL injection
		$result = $con->query($sql);
	
		return $result;
	}		

}