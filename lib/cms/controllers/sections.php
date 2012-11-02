<?php
/**
 *
 * @package Safanoria
 * @subpackage Admin
 */

class Sections extends Controller
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
		
		$this->current['page'] = 'sections';
		
		if ( ! Admin_user::is_logged()) 
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
		$list = Section::all(array('parent'=>0,'lang'=>$this->cms->administrator->clean['lang']));
		$this->current['new_item'] = $this->cms->url['add-section'];
		require $this->load->layout('header', 'lib/cms');
		require $this->load->layout('list', 'lib/cms');
		require $this->load->layout('footer', 'lib/cms');
		$this->performance->free($list,$this->current);
	}
	
	/**
	 * 
	 */
	private function add($query=null) 
	{
		if ($this->post_has_token()) 
		{
			if ($this->cms->add('section', $_POST)) 
			{
				$this->redirect_with_message(array('url'=>$this->cms->url['sections'], 'message'=>'post_created'));
				exit('This item was entered to the database. Click <a href="/admin">here to go back to the dashoard</a>');
			}
		}
		// Define current states
		$this->current['token'] = $this->tokenize();
		$this->current['page_title'] = $this->cms->message('add_section');
		$this->current['action'] = 'add';
		$this->current['next_action'] = $this->cms->url['add-section'];
		// Data
		$langs = $this->cms->lang->get_active();
		$sections = Section::all(array('parent'=>0,'lang'=>$this->cms->administrator->clean['lang']));
		require $this->load->layout('header', 'lib/cms');
		require $this->load->view('add', 'taxonomy', 'lib/cms');
		require $this->load->layout('footer', 'lib/cms');
		$this->performance->free($this->current);
	}
	
	/**
	 * 
	 */
	private function edit($query=null) 
	{
		if ($this->post_has_token()) 
		{
			if ($this->cms->edit('section', $query[1], $_POST)) 
			{
				$this->redirect_with_message(array('url'=>$this->cms->url['sections'], 'message'=>'post_created'));
				exit('This item was entered to the database. Click <a href="/admin">here to go back to the dashoard</a>');
			}
		}
		$list = Section::all(array('identifier'=>$query[1]));
		$sections = Section::all(array('parent'=>0,'lang'=>$this->cms->administrator->clean['lang']));

		// Define current states
		$this->current['token'] = $this->tokenize();
		$this->current['page_title'] = $this->cms->message('edit_section');
		$this->current['next_action'] = $this->cms->url['edit-section'].'/'.$query[1];
		
		require $this->load->layout('header', 'lib/cms');
		require $this->load->view('edit', 'taxonomy', 'lib/cms');
		require $this->load->layout('footer', 'lib/cms');
		$this->performance->free($list,$this->current);
	}
	
	/**
	 * 
	 */
	private function remove($query=null) 
	{
		if ($this->cms->remove('section', $query[1])) 
		{
			$this->redirect_with_message(array('url'=>$this->cms->url['sections'], 'message'=>'item_removed'));
		}
	}
}