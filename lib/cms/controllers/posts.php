<?php
/**
 *
 * @package Safanoria
 * @subpackage Admin
 */

class Posts extends Controller
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
		
		if ( ! Admin_session::is_logged()) 
		{
			return $this->login();
		}
		
		$this->current['page'] = 'posts';
		
		if (method_exists($this, $method)) 
		{
			return $this->$method($this->query);
		}
		require $this->view('404');
	}
	
	/**
	 * 
	 */
	private function index($query=null) 
	{
		$list = Post::all(array('lang'=>$this->cms->admin->lang));
		$this->current['new_item'] = $this->cms->url['add-post'];
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
			$_POST['categories'] = isset($_POST['categories']) ? implode(',', $_POST['categories']) : '0';
						
			if ($post = $this->cms->add('post', $_POST)) 
			{	
				$img_key = 'related_img';
				if ($this->cms->have_files($img_key))
				{
					if ($this->cms->add_post_files($post->id,$img_key)) 
					{
						$this->redirect_with_message(array('url'=>$this->cms->url['posts'], 'message'=>'post_created_media_added'));
						exit('This item was entered to the database. Click <a href="/admin">here to go back to the dashoard</a>');
					}
				}
				$this->redirect_with_message(array('url'=>$this->cms->url['posts'], 'message'=>'post_created'));
				exit('This item was entered to the database. Click <a href="/admin">here to go back to the dashoard</a>');
			}
		}
		// Pass some vars
		$this->current['token'] = $this->tokenize();
		$this->current['page_title'] = $this->cms->message('add_post');					
		// Data
		$sections = Section::all(array('parent'=>0,'lang'=>$this->cms->admin->lang));
		$langs = $this->cms->lang->get_active();
		$cats = Category::all(array('lang'=>$this->cms->admin->lang));
		require $this->load->layout('header', 'lib/cms');
		require $this->load->view('add', 'posts', 'lib/cms');
		require $this->load->layout('footer', 'lib/cms');	
	}
	
	/**
	 * 
	 */
	private function edit($query=null) 
	{
		if ($this->post_has_token()) 
		{
			$_POST['categories'] = isset($_POST['categories']) ? implode(',', $_POST['categories']) : '0';
			if ($this->cms->edit('post', $query[1], $_POST)) 
			{
				$img_key = 'related_img';
				if ($this->cms->have_files($img_key))
				{
					if ($this->cms->add_post_files($query[1],$img_key)) 
					{
						$this->redirect_with_message(array('url'=>$this->cms->url['posts'], 'message'=>'post_updated_media_added'));
						exit('This item was entered to the database. Click <a href="/admin">here to go back to the dashoard</a>');
					}
				}
				$this->redirect_with_message(array('url'=>$this->cms->url['posts'], 'message'=>'post_updated'));
				exit('This item was entered to the database. Click <a href="/admin">here to go back to the dashoard</a>');
			}
		}
		// Data
		$list = Post::all(array('identifier'=>$query[1]));
		$sections = Section::all(array('parent'=>0,'lang'=>$this->cms->admin->lang));
		$cats = Category::all(array('lang'=>$this->cms->admin->lang));
		$medias = Media::all(array('parent'=>$query[1],'lang'=>$this->cms->admin->lang));
		// Define current states
		$this->current['token'] = $this->tokenize();
		$this->current['page_title'] = $this->cms->message('edit_post');
		$this->current['is_edit'] = TRUE;
		$this->current['next_action'] = $this->cms->url['edit-post'].'/'.$query[1];
		require $this->load->layout('header', 'lib/cms');
		require $this->load->view('edit', 'posts', 'lib/cms');
		require $this->load->layout('footer', 'lib/cms');
	}
	
	/**
	 * 
	 */
	private function trash($query=null) 
	{
		if ($this->cms->trash('post', $query[1])) 
		{
			$this->redirect_with_message(array('url'=>$this->cms->url['posts'], 'message'=>'post_trashed'));
			exit($this->message('post_removed'));
		}
		$this->current['remove_confirm'] = "Estàs segur que vols borrar això?";
	}
	
	/**
	 * 
	 */
	private function untrash($query=null) 
	{
		if ($this->cms->untrash('post', $query[1])) 
		{
			$this->redirect_with_message(array('url'=>$this->cms->url['posts'], 'message'=>'post_untrashed'));
			exit($this->message('post_removed'));
		}
		// Pass some vars
		$this->current['remove_confirm'] = "Estàs segur que vols borrar això?";
	}
	
	/**
	 * 
	 */
	private function remove($query=null) 
	{
		if ($this->cms->remove('post', $query[1])) 
		{
			$this->redirect_with_message(array('url'=>$this->cms->url['posts'], 'message'=>'post_removed'));
			exit($this->message('post_removed'));
		}
		// Pass some vars
		$this->current['remove_confirm'] = "Estàs segur que vols borrar això?";
	}
}