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
	public $user_nav_lang;
	public $parent_section = 1;
	public $news_section = 3;
	public $projects_section = 4; 
	
	/**
	 * 
	 */
	function __construct($method, $query=null) 
	{
		parent::__construct();
		
		$this->user_nav_lang = $_SESSION['lang'];
		$this->menus = Section::all(array('lang'=>$this->user_nav_lang));
		
		return $this->$method();
	}
	
	/**
	 * 
	 */
	public function index() 
	{
		require $this->view('_header');
		require $this->view('index');
		require $this->view('_footer');
	}
	
	/**
	 * 
	 */
	public function biografia() 
	{
		require $this->view('_header');
		require $this->view('bio');
		require $this->view('_footer');
	}
	
	/**
	 * 
	 */
	public function terapia() 
	{
		require $this->view('_header');
		require $this->view('terapia');
		require $this->view('_footer');
	}
	
	/**
	 * 
	 */
	public function grupos() 
	{
		require $this->view('_header');
		require $this->view('grupos');
		require $this->view('_footer');
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