<?php 
/**
 * Admin User class
 *
 * @package Safanoria
 * @subpackage Admin
 */

class Admin_user extends Safanoria
{
	/**
	 *
	 */
	function __construct($id=null) 
	{
//		parent::__construct();
		
		$this->table = "admin_users"; 
		
		if (isset($_SESSION['admin_id'])) 
		{
			$this->clean['admin_id'] 	= (int) $_SESSION['admin_id'];
			$this->clean['first_name'] 	= is_name(self::info('first_name'));
			$this->clean['last_name'] 	= is_name(self::info('last_name'));
			$this->clean['email'] 		= is_email(self::info('email'));
			$this->clean['username'] 	= is_name(self::info('username'));
			
			/*
			
			! AIXÒ NO ESTÀ FILTRAT, MADAFACA!
			
			*/
			$this->clean['gender'] 		= self::info('gender');
			$this->clean['lang'] 		= self::info('lang');
			$this->clean['level'] 		= self::info('level');
			$this->clean['last_login'] 	= self::info('last_login');
			
			// Create some usefull vars
			$this->clean['full_name'] 	= $this->clean['first_name'] . ' ' . $this->clean['last_name'];
			$this->clean['author'] 		= $this->clean['username'];

			// Set vars for HTML display
			$this->html($this->clean);
			/*
				If you prefer another syntax, for clarity, that's how it'd be done:
				foreach ($this->clean as $key => $value) {
					$this->html[$key] = h($this->clean[$key]);
				}
			*/
		}
	}
						
	/**
	 * Returns the admin's ID if $email and $password are correct
	 */ 
	public static function credentials_valid($email=null, $password=null) 
	{
		$email = is_email($email);
		$email = escape($email);
		
		$query = "SELECT * 
				  FROM admin_users
				  WHERE email = '$email'";
		
		$conn = new PDO(DB_DSN, DB_USER, DB_PASS);
		
		if ($result = $conn->query($query)) 
		{ 
			$customer = $result->fetch(PDO::FETCH_ASSOC);	
			// Check if password sent by form is equal to salt + password in the database
			$password_requested = sha1($customer['salt'] . $password);
			if ($password_requested === $customer['password']) 
			{
				return $customer;
			}
		}
		return FALSE;
	}

	/**
	 * Logs into the admin 
	 */
	public static function log_in($id) 
	{	
		$_SESSION['admin_id'] = $id;		
	}
	
	/**
	 * Logs out the admin 
	 */
	public static function log_out() 
	{		
		unset($_SESSION['admin_id']);
		session_destroy();
	}
	
	/** 
	 * Returns true if admin is logged, and false otherwise 
	 */
	public static function is_logged() 
	{
		if (isset($_SESSION['admin_id'])) 
		{
			return TRUE;
		}
		else 
		{
			return FALSE;	
		}	
	}
	
	/** 
	 * Returns an array with the information of the current customer (if any) 
	 */
	public function info($row) 
	{		
		if (isset($this->clean['admin_id'])) 
		{	
			$this->sql['admin_id'] = escape($this->clean['admin_id']);
			
			$query = "SELECT {$row}
					  FROM {$this->table} 
					  WHERE admin_id = '{$this->sql['admin_id']}'";
			
			$this->DB = $this->load_class('database', 'lib/safanoria/core');
			$this->DB = $this->DB->connect();
			$result = $this->DB->query($query);
			
			if ($result->num_rows) 
			{
				$data = $result->fetch_assoc();
				$this->clean['info'] = stripslashes_deep($data);
				return $this->clean['info'][$row];
			}
		}
	}
	
	/** Evaluates if the currents customer is a male, and returns true if he is */
	public function is_male() {
		if ($this->clean['gender'] == "M") {
			return true;
		}
		return false;
	}
	
	/** Evaluates if the currents customer is a female, and returns true if she is */
	public function is_female() {
		if ($this->clean['gender'] == "F") {
			return true;
		}
		return false;
	}

	/** 
	 * Returns gender as "female" or "male" for standarized usage in scripts 
	 */
	public function male_or_female($gender=null) 
	{
		switch ($gender) {
			case 'M':
			case 'male':
				$gender = "male";
				break;
			case 'F':
			case 'female':
				$gender = "female";
				break;
			default:
				exit('No valid gender value was passed to male_or_female()');
		}
		return $gender;
	}
	
	public function add() 
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') 
		{			
			self::filter();
			
			// Check password has at least 6 characters
			if (!is_password($_POST['password'])) {
				$this->errors['password'] = $this->safanoria['pass_not_valid'];
			} else {
				$this->clean['password'] = $_POST['password'];
			}
			// Check password confirmation by comparing inputs. STRCMP will return 0 if they're the same
			if (0 !== strcmp($_POST['password'], $_POST['password_confirmation']) ) {
				$this->errors['password_confirmation'] = $this->safanoria['pass_not_match'];
			}
							
			// No errors
			if(0 === count($this->errors)) 
			{
				if (isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token']) 
				{
					// Sanitize, sanitize, sanitize
					$this->sql['first_name'] 	= escape($this->clean['first_name']);
					$this->sql['last_name']		= escape($this->clean['last_name']);
					$this->sql['username']		= escape($this->clean['username']);
					$this->sql['email'] 		= escape($this->clean['email']);
					// Encrypt password
					$this->sql['salt'] 			= sha1(microtime() . $this->clean['password']);
					$this->sql['password'] 		= sha1($this->sql['salt'] . $this->clean['password']);
					//
					$this->sql['gender'] 		= escape($this->clean['gender']);
					$this->sql['lang'] 			= escape($this->clean['lang']);
					$this->sql['level'] 		= escape($this->clean['level']);
					$this->sql['last_login'] 	= escape(date('c'));
					
					$query = "INSERT INTO {$this->table['admin']} 
							  		( 
							  		  first_name, 
							  		  last_name,
							  		  username, 
							  		  email, 
							  		  salt, 
							  		  password, 
							  		  gender, 
							  		  lang, 
							  		  level,
							  		  last_login
							  		) 
							  VALUES('{$this->sql['first_name']}', 
							  		 '{$this->sql['last_name']}',
							  		 '{$this->sql['username']}', 
							  		 '{$this->sql['email']}', 
							  		 '{$this->sql['salt']}',
							  		 '{$this->sql['password']}',
							  		 '{$this->sql['gender']}',
							  		 '{$this->sql['lang']}',
							  		 '{$this->sql['level']}',
							  		 '{$this->sql['last_login']}'
							  )";
					$this->DB->query($query);
					
					// Registration successful
					if ($this->DB->errno === 0) 
					{
						$this->clean['admin_id'] = intval($this->DB->insert_id);
						$this->log_in($this->clean['admin_id']);
						
//						$s_email = new Email (
//											$this->clean['email'], 
//											"welcome", 
//											"welcome_customer", 
//											"", 
//											$customerinfo = array (
//															"first_name" =>$this->clean['first_name'], 
//															"gender"	 =>$this->clean['gender'],  
//															"lang"		 =>$this->clean['lang']
//														)
//										);
//						$s_email->email_send();
																	
						$this->redirect_with_message(array('url'=>url('admin'), 'message'=>'welcome_admin'));
						exit('A new admin user has been created');
					}
					// Email is duplicated.
					elseif (preg_match("/^Duplicate.*email.*/i", $this->DB->error)) 
					{
						$this->errors['email'] = $this->safanoria['duplicated_email'];
					}
					// Username is duplicated.
					elseif (preg_match("/^Duplicate.*username.*/i", $this->DB->error)) 
					{
						$this->errors['username'] = $this->safanoria['duplicated_username'];
					}
					// Could not register customer
					else 
					{
						redirect_with_message(array('url'=>url('error'), 'message'=>'register_error'));
						exit('There was an error submiting your form');
					}		
				}	
			}
		}
	}
	
	public function edit() 
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') 
		{
			self::filter();

			if(0 === count($this->errors)) 
			{
				if (isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token']) 
				{
					self::escape();

					$query = "UPDATE {$this->table['admin']}
							  SET 
							   	first_name 	= '{$this->sql['first_name']}',
							  	last_name 	= '{$this->sql['last_name']}',
							  	username 	= '{$this->sql['username']}',
							  	email 		= '{$this->sql['email']}',
							  	gender 		= '{$this->sql['gender']}',
							  	lang 		= '{$this->sql['lang']}',
							  	level 		= '{$this->sql['level']}'
							  WHERE admin_id = '{$this->sql['admin_id']}'";
					$this->DB->query($query);
					
					// Admin edit successful
					if ($this->DB->errno === 0) 
					{
						$this->redirect_with_message(array('url'=>url('profile'), 'message'=>'profile_updated'));
						exit;
					}
					// Email is duplicated.
					elseif (preg_match("/^Duplicate.*email.*/i", $this->DB->error)) 
					{
						$this->errors['email'] = $this->safanoria['duplicated_email'];
					}
					// Could not edit admin
					else 
					{
						$this->redirect_with_message(array('url'=>url('error'), 'message'=>'register_error'));
						exit('There was an error submiting your form');
					}	
				}
			}
		}	
	}
	
	/** 
	 * Removes all customer's data from the database 
	 */
	public function remove() 
	{
		$clean['id'] = intval(self::info('admin_id'));
		
		if ($clean['id']) 
		{
			$kaboom = $this->DB->query("DELETE FROM {$this->table['admin']} WHERE admin_id='{$clean['id']}'");
			$kaboom = $this->DB->query("DELETE FROM {$this->table['address_book']} WHERE admin_id='{$clean['id']}'");
			$kaboom = $this->DB->query("DELETE FROM {$this->table['newsletter_subscriptors']} WHERE admin_id='{$clean['id']}'");
			
			if (intval(self::info('seller_id')) != null) 
			{
				$kaboom = $this->DB->query("DELETE FROM {$this->table['sellers']} WHERE admin_id='{$clean['id']}'");
			}
			
//			Safanoria::redirect_with_message(array('url'=>'/ciao', 'message'=>'ciao'));
//			exit();
			
			/*
			
			AIXÒ ÉS MASSA CACA, PERQUÈ TAN SOLS EVALUA L'ÚLTIM $kaboom
			
			*/
			if (!$kaboom) 
			{
				redirect_with_message(array('url'=>'/', 'message'=>'error_deleting_profile'));
				exit("There was a problem removing your profile");
			}
		}
	}
	
	public function new_password()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') 
		{			
			// Validate old pass
			if (!is_password($_POST['old_password'])) {
				$this->errors['old_password'] = $this->safanoria['incorrect_old_password'];
			} else {
				$this->clean['old_password'] = $_POST['old_password'];
			}
			// Validate new pass
			if (!is_password($_POST['password'])) {
				$this->errors['password'] = $this->safanoria['pass_not_valid'];
			} else {
				$this->clean['password'] = $_POST['password'];
			}
			// Confirm password
			if (0 !== strcmp($_POST['password'], $_POST['password_confirmation']) ) {
				$this->errors['password_confirmation'] = $this->safanoria['pass_not_match'];
			}
			
			if(0 === count($this->errors)) 
			{
				$old_password = sha1($this->info('salt') . $this->clean['old_password']);
				if ($old_password === $this->info('password')) 
				{ 
					if (isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token']) 
					{
						// Salt & Password
						$salt = sha1(microtime() . $this->clean['password']);
						$password = sha1($salt . $this->clean['password']);
								
						$query = "UPDATE {$this->table['admin']}
								  SET 
								   salt = '$salt',
								   password = '$password'
								  WHERE admin_id = '{$this->clean['admin_id']}'";
						$this->DB->query($query);
						
						if ($this->DB->errno === 0) 
						{
							$this->redirect_with_message(array('url'=>url('profile'), 'message'=>'password_changed'));
							exit("Your password was successfully changed, but we could not redirect you to your profile page");
						}
					}
				}
				else 
				{
					$this->errors['old_password'] = $this->safanoria['incorrect_old_password'];
				}
			}
		}
	}
	
	/**
	 * 
	 */
	private function filter() 
	{
		// First name
		if (!is_name($_POST['first_name'])) {
			$this->errors['first_name'] = $this->safanoria['need_first_name'];
		} else {
			$this->clean['first_name'] = $_POST['first_name'];
		}
		// Last name
		if (!is_name($_POST['last_name'])) {
			$this->errors['last_name'] = $this->safanoria['need_last_name'];
		} else {
			$this->clean['last_name'] = $_POST['last_name'];
		}
		// Email
		if (!is_email($_POST['email'])) {
			$this->errors['email'] = $this->safanoria['email_not_valid'];
		} else {
			$this->clean['email'] = $_POST['email'];
		}
		
		// Gender
		if (set_index($_POST,'gender') == null) {
			$this->errors['gender'] = $this->safanoria['need_gender'];
		} else {
			$this->clean['gender'] = $_POST['gender'];
		}
		// Lang
		if (set_index($_POST,'lang')) {
			switch ($_POST['lang']) {
				case 'ca':
				case 'es':
				case 'en':
					$this->clean['lang'] = $_POST['lang'];
					break;
				default:
					$this->errors['lang'] = $this->safanoria['need_lang'];
			}	
		}
		// Newsletter
		if (set_index($_POST,'newsletter')) {
			switch ($_POST['newsletter']) {
				case 'Y':
				case 'N':
					$this->clean['newsletter'] = $_POST['newsletter'];
					break;
				default:
					$this->clean['newsletter'] = null;
			}
		}
	}
	
	/**
	 * 
	 */
	private function escape() 
	{
		$this->sql['admin_id'] 	= escape($this->clean['admin_id']);
		$this->sql['first_name']	= escape($this->clean['first_name']);
		$this->sql['last_name'] 	= escape($this->clean['last_name']);
		$this->sql['email'] 		= escape($this->clean['email']);
		$this->sql['gender'] 		= escape($this->clean['gender']);
		$this->sql['lang']			= escape($this->clean['lang']);
	}
	
		
	/** Init arrays for sanitizing purposes */
	public $clean = array();
	public $sql = array();
	public $errors = array();
}