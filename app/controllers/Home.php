<?php
/**
 *
 */
 
class Home extends SF_Controller
{
	/**
	 * 
	 */
	function __construct($method, $query=null) 
	{
		parent::__construct();
		return $this->$method();
	}
	
	/**
	 * 
	 */
	public function index() 
	{
		require $this->view('benvinguda');
	}
		
	/**
	 * 
	 */
	function error() 
	{
		require $this->view('error');
	}	
}