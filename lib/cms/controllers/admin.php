<?php
/**
 *
 * @package Safanoria
 * @subpackage Admin
 */

class Admin extends Controller
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
		$this->cms = $this->load_class('cms', 'lib/cms/core');
		$this->query = $query;
		/* Empty queries are set to 'index' for convenience, 
			so invalid URLs like method/an-invalid-action can return an error page as a default case
		*/
		$this->query[0] = isset($this->query[0]) && !empty($this->query[0]) ? $this->query[0] : 'index';
		
		$this->current['page'] = 'index';
		$this->current['menu'] = TRUE;
		
		if ( ! Admin_user::is_logged()) 
		{
			return $this->login();
		}
		// Sections must be crated first
		if ( count(Section::all()) === 0
			 && '/admin/'.$method.'/'.$query[0] != $this->cms->url['add-section']) 
		{
			return $this->index();	
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
		$list = Section::all(array('parent'=>0,'lang'=>$this->cms->administrator->clean['lang']));
		$this->current['new_item'] = $this->cms->url['add-section'];
		
		if( count($list) === 0 )
		{
			require $this->load->layout('header', 'lib/cms');
			require $this->load->view('index', null, 'lib/cms');
			require $this->load->layout('footer', 'lib/cms');
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
		if (0 == Section::all(array('lang'=>$this->cms->administrator->clean['lang']))) 
		{
			$this->current['page_title'] = "Publica";
			require $this->load->view('header', null,  'lib/cms');
			require $this->load->view('index', null, 'lib/cms');
			require $this->load->view('footer', 'layouts',  'lib/cms');
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
		if (0 == Section::all(array('lang'=>$this->cms->administrator->clean['lang']))) 
		{
			$this->current['page_title'] = "Publica";
			require $this->load->view('header', null,  'lib/cms');
			require $this->load->view('index', null, 'lib/cms');
			require $this->load->view('footer', 'layouts',  'lib/cms');
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
					$list = Post::all(array('status'=>'trash', 'lang'=>$this->cms->administrator->clean['lang']));
					$this->current['new_item'] = $this->cms->url['add-post'];
					$this->current['page'] = 'trash';
					require $this->load->layout('header', 'lib/cms');
					require $this->load->view('trash', null, 'lib/cms');
					require $this->load->layout('footer', 'lib/cms');
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
				require $this->load->view('login', null, 'lib/cms');
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