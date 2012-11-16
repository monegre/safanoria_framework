<?php 
/**
 * Edit class
 * Handles the update of records to the database
 *
 * @package CMS
 * @subpackage Core
 *
 */

class Edit
{
	public $errors = array();
	public $model;
	private $post; // $_POST tainted data
	private $clean; // $_POST validated (aka clean) data

	/**
	 * 
	 */
	function __construct()
	{
	}

	/**
	 *
	 */
	function initialize($args)
	{
		$this->post = $args;
		$this->_unset_useless();
		$this->_check_magic_quotes();
	}

	/**
	 *
	 */
	private function _unset_useless()
	{
		// We no longer need 'em
		if (isset($this->post['token'], $this->post['submit'], $_SESSION['token'])) 
		{
			unset($this->post['token'], $this->post['submit'], $_SESSION['token']);
		}
	}

	/**
	 *
	 */
	private function _check_magic_quotes()
	{
		if (in_array(strtolower(ini_get('magic_quotes_gpc' )), array( '1', 'on')))
		{
		    $this->post = array_map('stripslashes_deep', $this->post);
		}
	}

	/**
	 *
	 */
	private function _validate($model, $identifier)
	{
		$model = ucfirst($model);
		$this->model = $model::find($identifier);
		
		foreach ($this->post as $key => $value) 
		{
			if ($this->model->is_invalid($key)) 
			{ 
				$this->errors[$key] = $this->model->errors->on($key);
			}
		}

		if (0 < count($this->errors)) 
		{
			throw new InvalidModelException('A new user could not be created due to errors validating the model');
		}

		// Model is valid
		$this->clean = $this->post;
	}

	/**
	 *
	 */
	private function _assign_new_values()
	{
		foreach ($this->clean as $key => $value) 
		{
			$this->model->$key = $value;
		}
	}

	/**
	 *
	 */
	private function _change_password()
	{
		if ( ! isset($this->post['old_password'], 
				  	 $this->post['new_password'], 
				  	 $this->post['password_confirm'])) 
		{
			throw new PasswordChangeException('To change the password you must fill all related fields');
		}

		if ( ! $this->model->password === sha1($this->model->salt . $this->post['old_password'])) 
		{
			throw new PasswordChangeException('Your current password is not correct');
		}

		if (0 === strcmp($this->post['new_password'], $this->post['password_confirm'])) 
		{
			$this->model->password = sha1($this->model->salt . $this->post['new_password']);
		}
		else
		{
			$this->errors['new_password'] = 'Your new password does not match';
		}
	}

	/**
	 *
	 */
	public function get_errors()
	{
		return $this->errors;
	}

	/**
	 * 
	 */
	public function admin_user($id, $args) 
	{
		$this->initialize($args);
		$this->_validate('admin_user',$id);

		if (isset($this->post['old_password']))
		{
			try
			{
				$this->_change_password();
			}
			catch (PasswordChangeException $e)
			{
				echo $e->getMessage();
			}
		}		

		if ( 0 === count($this->errors)) 
		{			
			
			$this->_assign_new_values();
			// Encrypt password
			//$valid['salt'] 		= sha1(microtime() . $valid['password']);
			//$valid['password'] 	= sha1($valid['salt'] . $valid['password']);
			//$valid['last_login'] = date('c');
			return $this->model->save();
		}
		throw new Exception('A new user could not be created due to errors validating the model');
	}
}