<?php 
/**
 * Safanoria uses PHP ActiveRecord
 * This is here just meanwhile we make a new user model
 */

class Database 
{
	// Array of table names
	public $sf_table = array(
		"admin" 					=> "sf_admin_users",
		"product_images" 			=> "product_images",
		"products" 					=> "products",
	);
		
	public function connect($host=DB_HOST, $user=DB_USER, $pass=DB_PASS, $db_name=DB_NAME) 
	{	
		$mysqli = new mysqli($host, $user, $pass, $db_name);
		
		// Change character set to utf8
		if (!$mysqli->set_charset("utf8")) {
		    printf("Error loading character set utf8: %s\n", $mysqli->error);
		} 
		
		// Connect to database
		if ($mysqli->connect_errno) {
		    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
		}
		return $mysqli;
	}
}