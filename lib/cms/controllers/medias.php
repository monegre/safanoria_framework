<?php
/**
 *
 * @package Safanoria
 * @subpackage Admin
 */

class Medias extends SF_Controller
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
		
		$this->current['page'] = 'media';
		
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
		$list = Media::all(array('lang'=>$this->administrator->clean['lang']));
		$this->current['new_item'] = $this->cms->url['add-media'];
		require $this->view('_header', 'cms');
		require $this->view('list', 'cms/media');
		require $this->view('_footer', 'cms');
		$this->performance->free($list);
	}
	
	/**
	 * 
	 */
	private function add($query=null) 
	{
		ini_set('memory_limit', '64M');
		if ($this->upload->upload()) 
		{
			$data = $this->upload->data();
			$data['nice_url'] = $data['file_name'];
			foreach ($_POST as $key => $value) 
			{ 
			 	$data[$key] = $value;
			}
			
			if ($this->cms->add('media', $data)) 
			{
				// Load Image processing class
				$this->image = $this->load_class('Image', 'system/libraries');
				// Process image
				$this->image->load($data['file_name'], 'resources/uploads');
				$this->image->resize_to_width(1000);
				$this->image->save($data['file_name'], 'resources/uploads');
				$this->image->resize_to_width(200);
				$this->image->save($data['file_name'], 'resources/uploads/thumbs');
				$this->image->destroy();
				// We're done
				$this->performance->free($data);
				$this->redirect_with_message(array('url'=>$this->cms->url['media'], 'message'=>'post_created'));
				exit('This item was entered to the database. Click <a href="/admin">here to go back to the dashoard</a>');
			}
		}
		// Pass some vars
		$this->current['token'] = $this->tokenize();
		$this->current['page_title'] = $this->cms->message('add_media');
		// Data
		$langs = $this->lang->get_active();				
		require $this->view('_header', 'cms');
		require $this->view('add', 'cms/media');
		require $this->view('_footer', 'cms');
	}
	
	/**
	 * 
	 */
	private function edit($query=null) 
	{
		if ($this->post_has_token()) 
		{
			$_POST['nice_url'] = $_POST['file_name'];
			if ($this->cms->edit('media', $query[1], $_POST)) 
			{
				$this->redirect_with_message(array('url'=>$this->cms->url['media'], 'message'=>'item_updated'));
				exit('This item was updated the database. Click <a href="/admin">here to go back to the dashboard</a>');
			}
		}
		$list = Media::all(array('identifier'=>$query[1]));
		// Define current states
		$this->current['token'] = $this->tokenize();
		$this->current['page_title'] = $this->cms->message('edit_media');
		$this->current['is_edit'] = TRUE;
		$this->current['next_action'] = $this->cms->url['edit-media'].'/'.$query[1];
		require $this->view('_header', 'cms');
		require $this->view('edit', 'cms/media');
		require $this->view('_footer', 'cms');
	}
	
	/**
	 * 
	 */
	private function remove($query=null) 
	{
		$data = Meta_content::find($query[1]);
		if ($this->cms->remove('media', $query[1])) 
		{
			if (file_exists('resources/uploads/'.$data->nice_url)) 
			{
				unlink('resources/uploads/'.$data->nice_url);
				unlink('resources/uploads/thumbs/'.$data->nice_url);
				$this->redirect_with_message(array('url'=>$this->cms->url['media'], 'message'=>'post_removed'));
				exit($this->message('post_removed'));
			} 
			
		}
	}
}