<?php
/**
 *
 */

class Users extends Controller
{
	/**
	 * 
	 */
	public $current = array(
				'edit' => FALSE,
		   		'page_title' => __CLASS__,
			);

	/**
	 * 
	 */
	function __construct($query=array()) 
	{
		parent::__construct();
		$this->cms = $this->load_class('cms', 'lib/cms/core');
		$this->query = $query;
		/* Empty queries are set to 'index' for convenience, 
			so invalid URLs like method/an-invalid-action can return an error page as a default case
		*/
		$this->query[0] = isset($this->query[0]) && !empty($this->query[0]) ? $this->query[0] : 'index';
		$method	= array_shift($this->query);
		
		$this->current['page'] = 'users';
		
		if ( ! Admin_session::is_logged()) 
		{
			return $this->login();
		}
		
		if (method_exists($this, $method)) 
		{
			return $this->$method($this->query);
		}
		require $this->load->view('404');
	}

	/**
	 * 
	 */
	private function index($query=null) 
	{
		$list = Admin_user::all();
		$this->current['new_item'] = $this->cms->url['add_user'];
		require $this->load->layout('header', 'lib/cms');
		require $this->load->view('index', 'users', 'lib/cms');
		require $this->load->layout('footer', 'lib/cms');
	}

	/**
	 * 
	 */
	private function add($query=null) 
	{
		if ($this->post_has_token()) 
		{
			try 
			{	
				$this->cms->add->admin_user($_POST);
				$this->redirect_with_message(array('url'=>$this->cms->url['users'], 'message'=>'post_created'));
				exit('This item was entered to the database. Click <a href="/admin">here to go back to the dashoard</a>');
			}
			catch (InvalidModelException $e)
			{
				$_SESSION['global_message'] = $e->getMessage();
				$this->errors = $this->cms->add->get_errors();
			}
			// Could not register customer
			//$this->redirect_with_message(array('url'=>$this->cms->url['add_user'], 'message'=>$e->getMessage()));
			//exit('An error occurred and the new user could not be created. Click <a href="/admin">here to go back to the dashoard</a>');
		}
		// Define current states
		$this->current['token'] = $this->tokenize();
		$this->current['page_title'] = $this->cms->message('add_section');
		$this->current['action'] = 'add';
		$this->current['next_action'] = $this->cms->url['add_user'];

		$levels = Admin_users_level::all(
					array(
						'conditions' => "level >= {$this->cms->admin->level}",
						'order' => 'level desc'
						)
				  );

		require $this->load->layout('header', 'lib/cms');
		require $this->load->view('add', 'users', 'lib/cms');
		require $this->load->layout('footer', 'lib/cms');
	}

	public function edit($query=null) 
	{
		// Data
		$item = Admin_user::find($query[0]);
		$levels = Admin_users_level::all(
					array(
						'conditions' => "level >= {$this->cms->admin->level}",
						'order' => 'level desc'
						)
				  );

		if ($this->post_has_token()) 
		{
			try 
			{	
				$this->cms->edit->admin_user($query[0],$_POST);
				$this->redirect_with_message(array('url'=>$this->cms->url['users'], 'message'=>'post_created'));
				exit('This item was entered to the database. Click <a href="/admin">here to go back to the dashoard</a>');
			}
			catch (InvalidModelException $e)
			{
				$_SESSION['global_message'] = $e->getMessage();
				$this->errors = $this->cms->add->get_errors();
			}
			// Could not register customer
			//$this->redirect_with_message(array('url'=>$this->cms->url['add_user'], 'message'=>$e->getMessage()));
			//exit('An error occurred and the new user could not be created. Click <a href="/admin">here to go back to the dashoard</a>');
		}
		// Define current states
		$this->current['token'] = $this->tokenize();
		$this->current['page_title'] = $this->cms->message('add_section');
		$this->current['action'] = 'add';
		$this->current['next_action'] = $this->cms->url['add_user'];

		require $this->load->layout('header', 'lib/cms');
		require $this->load->view('edit', 'users', 'lib/cms');
		require $this->load->layout('footer', 'lib/cms');	
	}
	
	/** 
	 * Removes all customer's data from the database 
	 */
	public function remove($query=null) 
	{
		$item = Admin_user::find($query[0]);
		if ($item->delete()) 
		{
			$this->redirect_with_message(array('url'=>$this->cms->url['users'], 'message'=>'post_removed'));
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
}