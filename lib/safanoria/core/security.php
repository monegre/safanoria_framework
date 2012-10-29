<?php
/**
 *
 */

class Security 
{
	/**
	 *
	 */
	public function __construct() 
	{
			
	}
	
	/**
	 *
	 */
	public function sql($data) 
	{
		return sql($data);
	}
	
	/**
	 *
	 */
	public function input($variable) 
	{
		if ( ! empty($variable) OR $variable == '0') 
		{
			return $variable;
		}
		return FALSE;
	}
}