<?php
/**
 *
 * @package Safanoria
 * @subpackage Admin
 */

class Categories extends Controller
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
		$method	= $this->query[0];
		
		if ( ! Admin_user::is_logged()) 
		{
			return $this->login();
		}
		
		$this->current['page'] = 'categories';
		
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
		$list = Category::all(array('lang'=>$this->cms->administrator->clean['lang']));
		$this->current['new_item'] = $this->cms->url['add-category'];
		
		require $this->load->layout('header', 'lib/cms');
		require $this->load->layout('list', 'lib/cms');
		require $this->load->layout('footer', 'lib/cms');
	}
	
	/**
	 * 
	 */
	private function add($query=null) 
	{
		if ($this->post_has_token()) 
		{
			if ($this->cms->add(array('category','categories'), $_POST)) 
			{
				$this->redirect_with_message(array('url'=>$this->cms->url['categories'], 'message'=>'post_created'));
				exit('This item was entered to the database. Click <a href="/admin">here to go back to the dashoard</a>');
			}
		}
		// Pass some vars
		$this->current['token'] = $this->tokenize();
		$this->current['page_title'] = $this->cms->message('add_category');
		$this->current['next_action'] = $this->cms->url['add-category'];
		// Data
		$langs = $this->cms->lang->get_active();
		require $this->load->layout('header', 'lib/cms');
		require $this->load->view('add', 'taxonomy', 'lib/cms');
		require $this->load->layout('footer', 'lib/cms');
	}
	
	/**
	 * 
	 */
	private function edit($query=null) 
	{
		if ($this->post_has_token()) 
		{
			if ($this->cms->edit('category', $query[1], $_POST)) 
			{
				$this->redirect_with_message(array('url'=>$this->cms->url['categories'], 'message'=>'item_updated'));
				exit('This item was entered to the database. Click <a href="/admin">here to go back to the dashoard</a>');
			}
		}
		$list = Category::all(array('identifier'=>$query[1]));

		// Define current states
		$this->current['token'] = $this->tokenize();
		$this->current['page_title'] = $this->cms->message('edit_category');
		$this->current['next_action'] = $this->cms->url['edit-category'].'/'.$query[1];
		
		require $this->load->layout('header', 'lib/cms');
		require $this->load->view('edit', 'taxonomy', 'lib/cms');
		require $this->load->layout('footer', 'lib/cms');
	}
	
	/**
	 * 
	 */
	private function remove($query=null) 
	{
		if ($this->cms->remove('category', $query[1])) 
		{
			$this->redirect_with_message(array('url'=>$this->cms->url['categories'], 'message'=>'item_removed'));
		}
	}
}