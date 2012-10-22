<?php
/**
 * Safanòria's main class
 * Contains lots of useful functions and stuff to be used around the app
 */

class Safanoria 
{	
	public $version = "0.5.3";
	public $active_record = "1.0";
	
	/**
	 * Holds the Database connection
	 *
	 * @var string
	 */
	public $DB;
	
	/**
	 * Holds the name of Database tables
	 *
	 * @var string
	 */
	public $table;
	
	
	/**
	 * Holds the error messages that ara generated throughout Safanòria
	 *
	 * @var array
	 */
	public $errors = array();
	
	private static $instance;
		
	public function __construct() 
	{
		if ( ! session_id()) 
		{
			session_start();
		}
		
		self::$instance =& $this;
		
		// Manually load classes
		$this->lang = $this->load_class('lang', 'system/models');
		$this->messenger = $this->load_class('messenger', 'system/core');
		$this->security = $this->load_class('security', 'system/core');
		$this->performance = $this->load_class('performance', 'system/core');
		$this->upload = $this->load_class('upload', 'system/libraries');		
		$this->administrator = $this->load_class('admin_user', 'system/models');
		$this->url = $this->load_class('url', 'system/libraries');
		$this->cms = $this->load_class('cms', 'system/libraries');
		$this->error = $this->load_class('error', 'system/core');
	}
	
	public static function &get_instance() {
		return self::$instance;
	}
	
	/**
	 *
	 */
	function load_class($class, $directory = 'models') 
	{
		static $_classes = array();
		
		if (isset($_classes[$class])) 
		{
			return $_classes[$class];
		}
		
		$name = FALSE;
		
		$path = ROOT . $directory.'/';
		
		if (file_exists($path.$class.'.php')) 
		{
			$name = ucfirst($class);
			if (class_exists($name) === FALSE) 
			{
				require_once($path.$class.'.php');
			}
		}
		
		if ($name === FALSE) 
		{
			exit("Unable to locate the class $class at the directory $directory");
		}
		
		$_classes[$class] = new $class();
		return $_classes[$class];
	}

	/** 
	 * Returns input field content according to this rule:
	 * 1. If $_POST content was submitted, it'd be returned in the first place
	 * 2. If $global is passed, its content will be returned
	 * 3. If $alternate is passed and no $_POST is passed, its content will be returned even if $global is passed
	 *
	 * Please notice: $alternate is meant for forms that need to handle up to three different kinds of data: 
	 * 		I.e: a new address form that shows $global['name'] by default, but that after submission needs to print $_POST['name'], and when retrieving from database for edition purposes needs to print $alternate['name']
	 */
	public function input_for($field, $global=null, $alternate=null) {
	
//		$clean = array();

		// Post submitted => we want it
		if ( isset($_POST[$field]) ) {
			return h($_POST[$field]);
		}
		
		// $_POST not submited => try other options
		else {
			
			/*
				AIXÍ ELS INPUTS HAN D'ESTAR PASSATS PER VALOR.
				SEMBLA UNA MANERA MOLT MÉS PRÀCTICA I MÉS AGNÒSTICA
				QUE NO PAS LA QUE ESTÀ COMENTADA A BAIX
			
			*/
			
			if ($alternate!=null) 
			{
				return h($alternate);
			} 
			elseif ( $global!=null ) 
			{
				
				return h($global);
			}
			else 
			{
				$a = set_index($_POST, $field);
				return h($a);
			}
		}
	}

	/**
	 * Checks wheteher a token has been set or not
	 */
	public static function token_is_set() 
	{
		if (isset($_SESSION['token'])) {
			return TRUE;
		}
		return FALSE;	
	}
	
	/**
	 * Checks wheteher a token has been set or not
	 */
	public static function post_has_token() 
	{
		if ( isset($_SESSION['token']) 
			 && isset($_POST['token'])
			 && $_POST['token'] == $_SESSION['token']) 
		{
			return TRUE;
		}
		return FALSE;	
	}
	
	/**
	 * Random token to prevent CSRF
	 * IMPORTANT! This must be called after all form processing so the token it's not recreated on post submission
	 */
	public static function tokenize() 
	{
		if (isset($_SESSION['token'])) {
			unset($_SESSION['token']);
		}
		$token = sha1(uniqid(rand(), true)); 
		$_SESSION['token'] = $token;
		return $token;	
	}
	
	/**
	 * Returns a string ready for HTML performance
	 */
	public function html($array) 
	{
		$this->html = array();
		return $this->html = h($array);		
	}
	
	/**
	 * Checks wheteher a file exists and returns it, or an error page
	 */
	public static function view($file, $folder=null) 
	{		
		$views = ROOT . APP . VIEWS;
		$falls = ROOT . SYS . VIEWS;
		$ext = ".php";

		$n_file = isset($folder) ? clean_path($folder) . '/' : false;
		$n_file .= $file.$ext;
				
		if (file_exists($views.$n_file)) 
		{
			return $views.$n_file;
		} 
		else 
		{	
			if (file_exists($falls.$n_file)) 
			{ 
				return ($falls.$n_file);
			}
			else 
			{
				return ($falls . '404.php');
			}
		}	
	}
	
	/**
	 * 
	 */
	public function message($message) 
	{
		return new Messenger($message);
	}
	
	/** 
	 * Adds error class at forms submission 
	 * 
	 * @param $name 
	 * @returns the error class
	 */
	public function error_class($name=null) 
	{
		return isset($this->errors[$name]) ? "form_error_row" : "";
	}
	
	/**  
	 * Prints an error message and error markup at form submission 
	 */
	public function error_for($name=null) 
	{
		if (isset($this->errors[$name])) 
		{
			return $this->errors[$name];
		}
	}
	
	
	
	/** 
	 * Stores a global_message in a session and redirects to a specified URL
	 * If no particular URL is passed, will redirect to the home page
	 * The message will then be processed by global_message()
	 *
	 * @param $args array
	 */ 
	public function redirect_with_message($args)
	{		
		if (isset($args['message'])) 
		{
			$_SESSION['global_message'] = $args['message'];
			if (isset($args['url'])) 
			{
				header("Location: ".$args['url']."");
				exit();
			}
			else 
			{
				header("Location: /");
				exit();
			}
		}
	}
	
	/**
	 * Checks if a variables is set and not empty
	 * @param string
	 * @return bool
	 */
	public function have($string) 
	{
		if (isset($string) && ! empty($string)) 
		{
			return TRUE;
		}
		return FALSE;	
	}
	
	/**
	 * Checks whether a current state is
	 * @param string
	 * @param array
	 * @return void | FALSE
	 */
	public function is_current($string, $args) 
	{
		if ( isset($this->current['page'])
			 && $this->current['page'] == $string ) 
		{
			foreach ($args as $key => $value) {
				return $key . '=' . '"'.$value.'"';
			}
		}
		return FALSE;	
	}
	
	/**
	 * Returns this library version, 
	 * as defined at the top of this document
	 */
	public function version() 
	{
		return $this->version;	
	}		
}