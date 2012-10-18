<?php
/**
 * Global Controller
 *
 * Provides default 404 and generic error methods
 * that can be overrided by the app's controllers.
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
	public function show_404() 
	{
		if(file_exists(ROOT.CONFIG.'/routes.php'))
		{
			require (ROOT.CONFIG.'/routes.php');
			// Do we have a custom app_errors controller?
			if (file_exists(ROOT.APP.CONTROLS.'app_errors.php')) 
			{
				return new App_errors('show_404');
			}
			// Do we have a default errors controller?
			if (isset($route['error_controller']) && file_exists(ROOT.APP.CONTROLS.$route['error_controller'].'.php')) 
			{
				$controller = ucfirst($route['error_controller']);
				return new $controller('show_404');
			}
			// Does the default controller have an error method?
			if (isset($route['default_controller']) && file_exists(ROOT.APP.CONTROLS.$route['default_controller'].'.php')) 
			{
				$controller = ucfirst($route['default_controller']);
				return new $controller('show_404');
			}
		}
		// No options left. Return the default 404 error.
		require $this->view('404');
		exit;
	}
	
	/**
	 * 
	 */
	public function error() 
	{
		if(file_exists(ROOT.CONFIG.'/routes.php'))
		{
			require (ROOT.CONFIG.'/routes.php');
			// Do we have a custom app_errors controller?
			if (file_exists(ROOT.APP.CONTROLS.'app_errors.php')) 
			{
				return new App_errors('error');
			}
			// Do we have a default errors controller?
			if (isset($route['error_controller']) && file_exists(ROOT.APP.CONTROLS.$route['error_controller'].'.php')) 
			{
				$controller = ucfirst($route['error_controller']);
				return new $controller('error');
			}
			// Does the default controller have an error method?
			if (isset($route['default_controller']) && file_exists(ROOT.APP.CONTROLS.$route['default_controller'].'.php')) 
			{
				$controller = ucfirst($route['default_controller']);
				return new $controller('error');
			}
		}
		// No options left. Return the default 404 error.
		require $this->view('error');
		exit;
	}
}
