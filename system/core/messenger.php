<?php
/**
 * Global messages API
 */

class Messenger
{
	private $message;
	private $gender;
	private $lang;
	public $message_class = 'success';
	
	/**
	 * 
	 */
	function __construct($message=null, $args=array()) 
	{
		$this->message 	= $message;
		$this->gender 	= isset($args['gender']) ? $args['gender'] : 'male';
		$this->lang 	= isset($_SESSION['lang']) ? $_SESSION['lang'] : 'ca';
				
		$sf_general = ROOT. SYS . LANG . $this->lang . '/general.php';
		$app_general = ROOT. APP . LANG . $this->lang . '/general.php';
		
		if (file_exists($sf_general)) 
		{
			include ($sf_general);
		}
		if (file_exists($app_general)) 
		{
			include ($app_general);
		}
		
		$this->safanoria = $safanoria;
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