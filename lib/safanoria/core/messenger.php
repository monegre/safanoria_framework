<?php
/**
 * Global messages API
 */

class Messenger
{
	private $message;
	private $gender;
	private $lang;
	public $default_lang = 'ca';
	public $message_class = 'success';
	
	/**
	 * 
	 */
	function __construct($message=null, $args=array()) 
	{
		$this->message 	= $message;
		$this->gender 	= isset($args['gender']) ? $args['gender'] : 'male';
		$this->lang 	= isset($_SESSION['lang']) ? $_SESSION['lang'] : $this->default_lang;
		// Attempt to get the lang variables
		$this->_get_lang_files();
	}

	/**
	 * 
	 */
	private function _get_lang_files()
	{
		$lang_dirs = array(
				1 => ROOT.LIB.SYS.LANG,
				2 => ROOT.APP.LANG
			);

		foreach ($lang_dirs as $dir) 
		{
			if (file_exists($dir.$this->lang)) 
			{
				@include ($dir.$this->lang.'/general.php');
			}
			else
			{
				if (file_exists($dir.$this->default_lang)) 
				{
					@include ($dir.$this->default_lang.'/general.php');
				}
			}
		}
				
		$this->safanoria = $safanoria;

		if ( ! $this->safanoria) 
		{
			throw new Exception('Files containing language variables could not be found. They should be place either at system/langs/[your language] or app/langs/[your language]');
			
		}
	}

	
	/** 
	 * Checks whether a global_message is stored in a session or not 
	 * 
	 * @return boolean
	 */
	public function got_global_message()
	{
		if (isset($_SESSION['global_message']))
		{	
			// Set the message class before we destroy the SESSION variable
			$this->_set_message_class();
			return TRUE;
		} 
		else
		{
			return FALSE;
		}
	}
	
	/** 
	 * Checks if we have any global message stored in a $_SESSION
	 * This function is only meant for screen messages. Please notice that it requires a $_SESSION message to be set 
	 *
	 * @requires $safanoria array
	 * @return $message A male or female version of the global message after evaluating the Customer
	 */
	public function global_message($args=array()) 
	{				
		if (isset($_SESSION['global_message'])) 
		{	
			$gender = isset($args['gender']) ? $args['gender'] : 'male';
			
			if ($gender = "female" && isset($this->safanoria["female"][$_SESSION['global_message']]))
			{
				$message = $this->safanoria["female"][$_SESSION['global_message']];
			}
			else
			{
				if (isset($this->safanoria[$_SESSION['global_message']])) 
				{
					$message = $this->safanoria[$_SESSION['global_message']];
				}
				else 
				{
					$message = $_SESSION['global_message'];
				}
			}
			
			unset($_SESSION['global_message']);	
			return $message;
		}
		return FALSE;
	}
	
	/**
	 * 
	 */
	private function _set_message_class() 
	{
		$class = explode('_', $_SESSION['global_message']);		
		if (isset($class[0]) && $class[0] == 'error') 
		{
			$this->message_class = 'error';
		}
		else 
		{
			$this->message_class = 'success';	
		}
	}
	
	/**
	 * 
	 */
	public function message_class() 
	{	
		return $this->message_class;
	}
	
	/**
	 * 
	 */
	function __toString() 
	{
		return $this->built_message();
	}
	
	/**
	 * 
	 */
	private function built_message($message=null) 
	{
		return $this->safanoria[$this->message];
	}
}