<?php 
/** 
 * Router class
 */

class Router
{
	public $controller = FALSE;
	public $method 	= FALSE;
	public $query = FALSE;
	public $url_parts = array();

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
		// First deal with lang
		$_SESSION['lang'] = $this->set_lang();

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
		return isset($this->url_parts[0]) 
					? $this->underscore(array_shift($this->url_parts)) 
					: 'home';
	}

	/** 
	 * 
	 */
	private function set_method()
	{
		return isset($this->url_parts[0]) 
					? $this->underscore(array_shift($this->url_parts)) 
					: 'index';
	}

	/** 
	 * 
	 */
	private function set_query()
	{
		$count = count($this->url_parts);
		for ($i = 0; $i < $count; $i++) 
		{
			$this->query[] = $this->url_parts[$i];
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