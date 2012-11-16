<?php 
/**
 * Session class
 *
 * @package Safanoria
 * @subpackage Admin
 */

class Admin_session
{						
	/**
	 * Returns the admin's ID if $email and $password are correct
	 */ 
	public static function credentials_valid($email=null, $password=null) 
	{
		if ( ! $valid_email = is_email($email)) 
		{
			throw new Exception("This is not a valid email address");
		}

		$user = Admin_user::find_by_email($valid_email);
		
		if ($user) 
		{ 
			// Check if password sent by form is equal to salt + password in the database
			$password_requested = sha1($user->salt . $password);
			if ($password_requested === $user->password) 
			{
				return $user;
			}
		}
		throw new Exception("No user was found matching this email ({$email}) and password");
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
}