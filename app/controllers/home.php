<?php
/**
 * Home controller
 *
 * This is the default controller that comes with Safanòria installation.
 * As such, it is the default_controller in config/routes
 * It comes with customizable show_404() and error() methods.
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
	 * Here you can custom your 404 error page.
	 * You can also create an app_errors controller
	 * or map error through the config/routes
	 */
	public function show_404() 
	{
		require $this->view('404');
		exit;
	}

	/**
	 * Here you can custom your generic error page
	 * You can also create an app_errors controller
	 * or map error through the config/routes
	 */
	public function error() 
	{
		require $this->view('error');
		exit;
	}	
}