<?php 
/** 
 * Router class
 */

class Router
{
	public $controller = FALSE;
	public $method 	= FALSE;
	public $query = FALSE;
	private $routes; // The config routes
	public $url_parts = array(); // The requested URL
	public $segments = array(); // The remaped URL
	private $replace = array('/-/','_');

	/** 
	 * 
	 */
	function __construct($url)
	{
		$this->lang = new Lang;

		if ( ! session_id()) 
		{
			session_start();
		}

		$this->url_parts = explode("/", clean_path($url));
		$this->initialize();
		return $this->calling();
	}

	/** 
	 * 
	 */
	private function initialize()
	{
		if(file_exists(ROOT.CONFIG.'/routes.php'))
		{
			require (ROOT.CONFIG.'/routes.php');
		}
		$this->routes = ( ! isset($route) OR ! is_array($route)) ? array() : $route;
		unset($route);

		// First deal with lang
		$_SESSION['lang'] = $this->set_lang();
		
		// Is this a valid URL?		
		$this->segments = $this->validate_url();
		
		// Now we can set those
		$this->controller = $this->set_controller();
		$this->method = $this->set_method();
		$this->query = $this->set_query();
	}

	/** 
	 * 
	 */
	private function set_lang()
	{
		if ($this->first_segment_is_lang()) 
		{
			return array_shift($this->url_parts);
		}
		
		if($this->lang->get_user_agent_langs())
		{
			foreach ($this->lang->get_user_agent_langs() as $array) 
			{
				if ($this->lang->is_active($array[1])) 
				{
					return $array[1];
				}
			}
		}
		
		if ( ! isset($_SESSION['lang'])) 
		{
			$a = Lang::first();
			return $a->code;
		}		
	}

	/** 
	 * 
	 */
	private function set_controller()
	{
		return isset($this->segments[0]) 
					? $this->underscore(array_shift($this->segments)) 
					: $this->routes['default_controller'];
	}

	/** 
	 * 
	 */
	private function set_method()
	{
		return isset($this->segments[0]) 
					? $this->underscore(array_shift($this->segments)) 
					: $this->routes['default_method'];
	}

	/** 
	 * 
	 */
	private function set_query()
	{
		$count = count($this->segments);
		for ($i = 0; $i < $count; $i++) 
		{
			$this->query[] = $this->segments[$i];
		}
		return $this->query;
	}

	/** 
	 * 
	 */
	public function first_segment_is_lang()
	{
		if (preg_match('/^([a-z]{2})$/', $this->url_parts[0]))
		{
			if ($this->lang->is_active($this->url_parts[0])) 
			{
				return TRUE;
			}
		}
		return FALSE;
	}

	/** 
	 * 
	 */
	private function underscore($string)
	{
		global $config;
		if ($config['underscore_routes'] === TRUE) 
		{
			return preg_replace($this->replace[0], $this->replace[1], $string);
		}
		return $string;
	}
	
	/**
	 *  Check Routes
	 *
	 * This function matches any routes that may exist in
	 * the config/routes.php file against the URI to
	 * determine if the class/method need to be remapped.
	 *
	 * This function is almost a copy/paste of CodeIgniter's _parse_routes
	 *
	 * @access	private
	 * @return	array
	 */
	private function check_routes()
	{
		// Turn the segment array into a URI string
		$uri = implode('/', $this->url_parts);

		// Is there a literal match?  If so we're done
		if (isset($this->routes[$uri]))
		{
			return explode('/', clean_path($this->routes[$uri]));
		}

		// Loop through the route array looking for wild-cards
		foreach ($this->routes as $key => $val)
		{
			// Convert wild-cards to RegEx
			$key = str_replace(':any', '.+', str_replace(':num', '[0-9]+', $key));

			// Does the RegEx match?
			if (preg_match('#^'.$key.'$#', $uri))
			{
				// Do we have a back-reference?
				if (strpos($val, '$') !== FALSE AND strpos($key, '(') !== FALSE)
				{
					$val = preg_replace('#^'.$key.'$#', $val, $uri);
				}

				return explode('/', clean_path($val));
			}
		}
		return $this->url_parts;
	}
	
	/** 
	 * URL segments can either be a class, a class method, or a database object.
	 *
	 * /class/method/query
	 * /class/class/method/query
	 * /method/query
	 * /query
	 *
	 */
	private function validate_url() 
	{
		$this->url_parts = $this->check_routes();
		
		$to_validate = $this->url_parts;
		$validated = array();
		$errors = array();
		
		// Validate controllers
		for ($i = 0; $i < count($to_validate); $i++) 
		{
			if ( file_exists(ROOT.SYS.CONTROLS.$to_validate[$i].'.php')
				 OR file_exists(ROOT.APP.CONTROLS.$to_validate[$i].'.php'))
			{
				$validated['class'][] = $to_validate[$i];
				continue;
			}
			break;
		}
		$classes = isset($validated['class']) ? count($validated['class']) : 0;
		
		// No controllers? 
		if ( ! $classes > 0) 
		{
			$error = new SF_Controller;
			return $error->show_404();
			//throw new Exception('URL segment is not an existing controller');
		}
		
		// Is next segment a method of the last class?
		if ( isset($to_validate[$classes])
			 && ! method_exists($to_validate[$classes-1], $to_validate[$classes]) )
		{
			$error = new SF_Controller;
			return $error->show_404();
			//throw new Exception('URL segment is not a method of the controller');
		}
		//$methods = isset($validated['method']) ? count($validated['method']) : 0;
		
		// No method?
//		if ( ! $methods > 0) 
//		{
//			echo '404';
//		}
			
		// Collect everything else as the query
//		for ($i = $classes + $methods; $i < count($to_validate); $i++) 
//		{
//			$validated['query'][] = $to_validate[$i];
//		}	
		
		// At this point is ok to return the original array
		return $this->url_parts;
	}

	/** 
	 * 
	 */
	private function calling()
	{
		return new $this->controller($this->method, $this->query);
	}
}