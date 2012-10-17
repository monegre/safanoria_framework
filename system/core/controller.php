<?php
/**
 * Global Controller
 */
 
class SF_Controller extends Safanoria
{
	function __construct() 
	{
		parent::__construct();
	}
	
	/**
	 * 
	 */
	public function error() 
	{
		require $this->view('error');
	}
}
