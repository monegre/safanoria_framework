<?php 
/**
 * Admin User class
 *
 * @package Safanoria
 * @subpackage Admin
 */

class Admin_user extends ActiveRecord\Model
{							
	
	public $password_confirm = false;
	public $old_password = false;
	public $new_password = false;
	public $user_confirm_id = false;
	/*
	static $before_validation = array('is_new_password');
	*/
	
	static $validates_presence_of = array(
		array('first_name', 'message' => 'We need your name'),
		array('last_name', 'message' => 'We need your last name'),
		array('email', 'message' => 'We need your email'),
		//array('password', 'message' => 'Please, type a password')
	);

	static $validates_size_of = array(
		//array('password', 'minimum' => 8)
	);

	static $validates_format_of = array(
		array(
			'email', 
			'with' => '/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/',
			'message' => 'This is not a valid email address'
		)
	);

	static $validates_uniqueness_of = array(
		array('email', 'message' => 'Sorry. We already have a user with this email address')
	);

	
	/**
	 * @access public   
	 */
	public function is_new_password()
	{
		if ( ! isset($_POST['old_password'], 
					 $_POST['new_password'], 
					 $_POST['password_confirm'],
					 $_POST['user_confirm_id'])) 
		{
			return FALSE;
		}
		
		$user = self::find($_POST['user_confirm_id']);

		if ($user->password === sha1($user->salt . $_POST['old_password'])) 
		{
			echo 'yes';
			//$this->password = sha1($user->salt . $_POST['password']);
		}
		return FALSE;
	}

	/** Evaluates if the currents customer is a male, and returns TRUE if he is */
	public function is_male() 
	{
		if ($this->gender == "M") 
		{
			return TRUE;
		}
		return FALSE;
	}
	
	/** Evaluates if the currents customer is a female, and returns TRUE if she is */
	public function is_female() 
	{
		if ($this->gender == "F") 
		{
			return TRUE;
		}
		return FALSE;
	}

	/**
	 *
	 */
	public static function levels()
	{
		return Admin_user_level::all();
	}
}