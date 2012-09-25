<?php
/**
 *
 */

class Performance
{
	/**  
	 * Destroys a variable or a set of variables 
	 */
	public function free($string) 
	{
		if (is_array($string)) 
		{
			return array_map(array($this,'free'), $string);
		}
		$string = null;
		unset($string);
	}
}