<?php

class Trash extends Cms
{
	function __construct() 
	{
		parent::__construct();
	}
	
	/**
	 * 
	 */
// 	public function get_list($type, $trash=FALSE) 
// 	{
// 		$this->class = ucfirst($type);
		
// 		$query = "SELECT * 
// 				  FROM 	 sf_{$type}s
// 				  WHERE lang = '{$this->lang->admin['code']}'
// 				  AND status = 'trash'";		  

// 		$list = array();
		
// 		$conn = new PDO( DB_DSN, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
// 		$st = $conn->prepare($query);
// 		$st->execute();
		
// 		if ($st->rowCount()) 
// 		{ 
// 		    while ($fetch = $st->fetch()) 
// 		    {
// 		        $conn = null;
// 		        $fetch = new $this->class($fetch, $this->type);
// 		        $list[] = $fetch;
// 		    }
// 		    return $list;
// 		}
// 	}
// }