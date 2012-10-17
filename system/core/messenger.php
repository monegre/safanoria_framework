<?php
/**
 * Global messages API
 */

class Messenger
{
	private $message;
	private $gender;
	private $lang;
	
	/**
	 * 
	 */
	function __construct($message=null, $gender=null, $lang=null) 
	{
		$this->message 	= $message;
		$this->gender 	= $gender;
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
	public static function got_global_message()
	{
		if (isset($_SESSION['global_message']))
		{		
			return TRUE;
		} else
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
	public function global_message($message=null, $gender=null, $lang=null) 
	{				
		if (isset($_SESSION['global_message'])) 
		{	
			$gender = isset($gender) ? $gender : 'male';
			
			if ($gender = "female" && isset($this->safanoria["female"][$_SESSION['global_message']]))
			{
				$message = $this->safanoria["female"][$_SESSION['global_message']];
			}
			else
			{
				$message = $this->safanoria[$_SESSION['global_message']];
			}
			unset($_SESSION['global_message']);	
			return $message;
		}
		return FALSE;
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
	private function built_message($message=null, $gender=null, $lang=null) 
	{
		return $this->safanoria[$this->message];
	}
}