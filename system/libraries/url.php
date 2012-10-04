<?php
/**
 * URL class
 * Gets off you the stupid job of writing URLs 
 * 
 * @package Safanoria
 * @subpackage Libraries
 * @author Carles Jove i Buxeda
 *
 * 		 
 */

class Url extends Safanoria
{
	/**
	 *
	 */
	public function full_path_to()
	{
		return $_SESSION['lang'];
	}
}