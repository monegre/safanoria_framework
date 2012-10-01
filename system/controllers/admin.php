<?php
/**
 *
 * @package Safanoria
 * @subpackage Admin
 */

class Admin extends SF_Controller
{
	/**
	 * 
	 */
	public $current = array(
		   'edit' => FALSE,
		   'page_title' => 'A healthy way to manage content',
		   );
		
	/**
	 * 
	 */
	function __construct($method, $query=array()) 
	{
		parent::__construct();
		
		$this->query = $query;
		/* Empty queries are set to 'index' for convenience, 
			so invalid URLs like method/an-invalid-action can return an error page as a default case
		*/
		$this->query[0] = isset($this->query[0]) && !empty($this->query[0]) ? $this->query[0] : 'index';
		
		if ( ! Admin_user::is_logged()) 
		{
			return $this->login();
		}
		
		if (method_exists($this, $method)) 
		{
			return $this->$method($this->query);	
		}
		$controller = ucfirst($method);
		return new $controller($this->query);
	}
	
	/**
	 * 
	 */
	private function index($query=null) 
	{		
		// We want users to create sections first
		if (0 == Section::all(array('lang'=>$this->administrator->clean['lang']))) 
		{
			require $this->view('_header', 'cms');
			require $this->view('index', 'cms');
			require $this->view('_footer', 'cms');
		}
		else 
		{
			return new Sections($query);
		}
	}
	
	/**
	 * 
	 */
	private function publish($query=null) 
	{		
		// We want users to create sections first
		if (0 == Section::all(array('lang'=>$this->administrator->clean['lang']))) 
		{
			$this->current['page_title'] = "Publica";
			require $this->view('_header', 'cms');
			require $this->view('index', 'cms');
			require $this->view('_footer', 'cms');
		}
		else 
		{
			return new Sections($query);
		}
	}
	
	/**
	 * 
	 */
	private function edit($query=null) 
	{		
		// We want users to create sections first
		if (0 == Section::all(array('lang'=>$this->administrator->clean['lang']))) 
		{
			$this->current['page_title'] = "Publica";
			require $this->view('_header', 'cms');
			require $this->view('index', 'cms');
			require $this->view('_footer', 'cms');
		}
		else 
		{
			return new Sections($query);
		}
	}
		
	/**
	 * 
	 */
	private function trash($query) 
	{
		$this->current['page_title'] = $this->message('trash');
		if (isset($query)) 
		{
			switch ($query[0]) 
			{ 
				case 'index':
					$list = Post::all(array('status'=>'trash', 'lang'=>$this->administrator->clean['lang']));
					$this->current['new_item'] = $this->cms->url['add-post'];
					$this->current['page'] = 'trash';
					require $this->view('_header', 'cms');
					require $this->view('trash', 'cms');
					require $this->view('_footer', 'cms');
					break;
			}
		}
	}
	
	/**
	 * 
	 */
	private function login($query=null)
	{	
		if (isset($_POST['email'],$_POST['password'])) 
		{
			$user_data = Admin_user::credentials_valid($_POST['email'], $_POST['password']);
			// User is valid
			if ($user_data) 
			{
				Admin_user::log_in($user_data['admin_id']);
				header("Location: ".$this->cms->url['index']);
				exit;
			}
			// Customer or password ain't valid
			else 
			{	
				header("Location: " . $this->cms->url['login-error']);
				$this->redirect_with_message(array('url'=>$this->cms->url['login-error'],'message'=>'invalid_login'));
				exit("Either the username or the password is not correct. We could not redirect you to the login page, so please, click <a href=\"/admin/login\">here</a> to try again");
			}	
		}
		else 
		{
			if (Admin_user::is_logged()) 
			{
				$this->redirect_with_message(array('url'=>$this->cms->url['index'],'message'=>'already_logged_in'));
			}
			else 
			{
				require $this->view('login', 'cms');
			}	
		}
	}
	
	/**
	 * 
	 */
	private function logout()
	{
		if (Admin_user::is_logged()) 
		{
			Admin_user::log_out();
			header("Location: /");
		}
		else 
		{
			header("Location: /");
		}
	}
}