<?php
/**
 *
 * @package Safanoria
 * @subpackage Admin
 */

class Posts extends SF_Controller
{
	/**
	 * 
	 */
	public $current = [
	
		   'edit' => FALSE,
		   'page_title' => __CLASS__
		   
		   ];
	
	/**
	 * 
	 */
	function __construct($query=[]) 
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
		$list = Post::all(array('lang'=>$this->administrator->clean['lang']));
		$this->current['new_item'] = $this->cms->url['add-post'];
		require $this->view('_header', 'cms');
		require $this->view('list', 'cms');
		require $this->view('_footer', 'cms');
	}
	
	/**
	 * 
	 */
	private function add($query=null) 
	{
		if ($this->post_has_token()) 
		{						
			$_POST['categories'] = isset($_POST['categories']) ? implode(',', $_POST['categories']) : '';
						
			if ($post = $this->cms->add('post', $_POST)) 
			{	
				$img_key = 'related_img';
				if (isset($_FILES[$img_key]) && !empty($_FILES[$img_key])) 
				{	
					ini_set('memory_limit', '64M');
					$newfiles = $this->upload->normalize_file_array();
					for ($i = 0; $i < count($newfiles[$img_key]); $i++) 
					{
						if ($this->upload->upload($img_key,$newfiles[$img_key][$i])) 
						{
							$data = $this->upload->data();
							$img = $this->lang->get_lang_fields_off($_POST);
							$img["nice_url"] = $data["file_name"];
							
							if ($media = $this->cms->add('media', $img)) 
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
								
								$entries = Post::all(array('identifier'=>$post->id));
								foreach ($entries as $entry) 
								{
									$imgs = array();
									if ( ! empty($entry->related_img)) 
									{
										$imgs = explode(',', $entry->related_img);
									}	
									$imgs[] = $media->id;// We get the meta model, not the item's!
									$imgs = implode(',', $imgs);
									$entry->related_img = $imgs;
									$entry->save();
								}
							}
						}
					}
					// We're done
					$this->performance->free($data);
					$this->redirect_with_message(array('url'=>$this->cms->url['media'], 'message'=>'post_created'));
					exit('This item was entered to the database. Click <a href="/admin">here to go back to the dashoard</a>');
				}
				$this->redirect_with_message(array('url'=>$this->cms->url['posts'], 'message'=>'post_created_files_not_uploaded', 'class'=>'success'));
				exit('This item was entered to the database. Click <a href="/admin">here to go back to the dashoard</a>');
			}
		}
		// Pass some vars
		$this->current['token'] = $this->tokenize();
		$this->current['page_title'] = $this->cms->message('add_post');					
		// Data
		$sections = Section::all(array('lang'=>$this->administrator->clean['lang']));
		$langs = $this->lang->get_active();
		$cats = Category::all(array('lang'=>$this->administrator->clean['lang']));
		require $this->view('_header', 'cms');
		require $this->view('add', 'cms/posts');
		require $this->view('_footer', 'cms');	
	}
	
	/**
	 * 
	 */
	private function edit($query=null) 
	{
		if ($this->post_has_token()) 
		{
			$_POST['categories'] = isset($_POST['categories']) ? implode(',', $_POST['categories']) : '';
			if ($this->cms->edit('post', $query[1], $_POST)) 
			{
				$img_key = 'related_img';
				if (isset($_FILES[$img_key]) && !empty($_FILES[$img_key])) 
				{	
					ini_set('memory_limit', '64M');
					$newfiles = $this->upload->normalize_file_array();
					for ($i = 0; $i < count($newfiles[$img_key]); $i++) 
					{
						if ($this->upload->upload($img_key,$newfiles[$img_key][$i])) 
						{
							$data = $this->upload->data();
							$img = $this->lang->get_lang_fields_off($_POST);
							$img["nice_url"] = $data["file_name"];
							
							if ($media = $this->cms->add('media', $img)) 
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
								
								$entries = Post::all(array('identifier'=>$query[1]));
								foreach ($entries as $entry) 
								{
									$imgs = array();
									if ( ! empty($entry->related_img)) 
									{
										$imgs = explode(',', $entry->related_img);
									}	
									$imgs[] = $media->id; // We get the meta model, not the item's!
									$imgs = implode(',', $imgs);
									$entry->related_img = $imgs;
									$entry->save();
								}
								$this->redirect_with_message(array('url'=>$this->cms->url['posts'], 'message'=>'post_updated'));
								exit('This item was entered to the database. Click <a href="/admin">here to go back to the dashoard</a>');
							}
						}
					}
				}
				$this->redirect_with_message(array('url'=>$this->cms->url['posts'], 'message'=>'post_updated_files_not_uploaded'));
				exit('This item was entered to the database. Click <a href="/admin">here to go back to the dashoard</a>');
			}
		}
		// Data
		$list = $this->cms->find('Post','all', array('identifier'=>$query[1]));
		$sections = Section::all(array('lang'=>$this->administrator->clean['lang']));
		$cats = Category::all(array('lang'=>$this->administrator->clean['lang']));
		// Define current states
		$this->current['token'] = $this->tokenize();
		$this->current['page_title'] = $this->cms->message('edit_post');
		$this->current['is_edit'] = TRUE;
		$this->current['next_action'] = $this->cms->url['edit-post'].'/'.$query[1];
		require $this->view('_header', 'cms');
		require $this->view('edit', 'cms/posts');
		require $this->view('_footer', 'cms');
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