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
		
		// Is there a defined class/method map for this URL?		
		$this->segments = $this->check_routes();

		// Now we can set those
		$this->controller = $this->set_controller();
		$this->method = $this->set_method();
		$this->query = $this->set_query();
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
	}

	/** 
	 * 
	 */
	private function set_lang()
	{
		if ($this->first_segment_is_lang()) 
		{
			return array_shift($this->segments);
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
	 * 
	 */
	private function calling()
	{
		return new $this->controller($this->method, $this->query);
	}
}