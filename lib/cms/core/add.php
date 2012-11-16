<?php 
/**
 * Add class
 * Handles the addition of new records to the database
 *
 * @package CMS
 * @subpackage Core
 *
 */

class Add extends Safanoria
{
	/**
	 * 
	 */
	function __construct()
	{
		parent::__construct();
		/*if ( ! $this->post_has_token()) 
		{
			throw new Exception("This form has not been tokenized");
		}
		$this->post = $_POST;
		$this->_unset_useless();
		$this->_check_magic_quotes();
		*/
	}

	/**
	 *
	 */
	function initialize($args)
	{
		/*if ( ! $this->post_has_token()) 
		{
			throw new Exception("This form has not been tokenized");
		}*/
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
	private function _to_validate($model)
	{
		$model = ucfirst($model);
		$this->_to_validate = new $model($this->post);
		$this->_set_errors();
	}

	/**
	 *
	 */
	private function _set_errors()
	{
		foreach ($this->post as $key => $value) 
		{
			if ($this->_to_validate->is_invalid($key)) 
			{ 
				$this->errors[$key] = $this->_to_validate->errors->on($key);
			}
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
	public function admin_user($args) 
	{
		$this->initialize($args);

		// We don't need this for model validation
		$password_confirm = $this->post['password_confirm'];
		unset($this->post['password_confirm']);

		$this->_to_validate('admin_user');

		// Check password confirmation by comparing inputs. STRCMP will return 0 if they're the same
		if (0 !== strcmp($this->post['password'], $password_confirm) ) 
		{
			$this->errors['password_confirm'] = 'pass_not_match';
		}

		if (0 < count($this->errors)) 
		{
			throw new InvalidModelException('A new user could not be created due to errors validating the model');
		}

		if ( 0 === count($this->errors)) 
		{
			$valid = $this->post;
			// Encrypt password
			$valid['salt'] 		= sha1(microtime() . $valid['password']);
			$valid['password'] 	= sha1($valid['salt'] . $valid['password']);
			$valid['last_login'] = date('c');
			return Admin_user::create($valid);
			
		}
		throw new AddException("Error Processing Request");
	}
}