<?php 
/**
 * CMS class
 * The actions that a logged in user (Admin User) can perform, related to content and settings
 *
 * @package Safanoria
 * @subpackage CMS
 *
 */

class Cms extends Safanoria
{			
	public $url = array(
				'index'	=> '/admin',
				'login'	=> '/admin/login',
				'logout'	=> '/admin/logout',
				'login-error'	=> '/admin/login/error',
					
			 	'sections' => '/admin/sections',
			 	'add-section' => '/admin/sections/add',
			 	'edit-section' => '/admin/sections/edit',
				 	
				'categories' => '/admin/categories',
			 	'add-category' => '/admin/categories/add',
			 	'edit-category' => '/admin/categories/edit',
			 	
			 	'posts' => '/admin/posts',
			 	'add-post' => '/admin/posts/add',
			 	'edit-post' => '/admin/posts/edit',
			 	
			 	'media' => '/admin/medias',
			 	'add-media' => '/admin/medias/add',
			 	'edit-media' => '/admin/medias/edit',
				 	
			 	'add_lang' => '/admin/langs/add',
			 	'edit_lang' => '/admin/langs/edit',
				 	
			 	'settings' => '/admin/settings',
			 	'users' => '/admin/users',
			 	'profile' => '/admin/profile',
				 	
			 	'trash' => '/admin/trash',
				 	
			 	'publish' => '/admin/publish',
				'edit' => '/admin/edit',
			);
	
	public $post_status = array(
				'draft' 	=> 'draft',
				'public' 	=> 'public',
				'private' 	=> 'private',
				'trash' 	=> 'trash'
			);
	
	/**
	 * 
	 */
	function __construct() 
	{
		$SF =& get_instance();
		$this->lang = $SF->lang;		
		$this->security = $SF->security;
		$this->upload = $SF->upload;
		$this->administrator = $SF->administrator;
		// Load Image processing class
		$this->image = $this->load_class('image', 'system/libraries');
		// Load database manually
		// This should be improved in futre versions
		$this->DB = $this->load_class('database', 'system/core');
		$this->DB = $this->DB->connect();	
	}
	
	/**
	 * Adds a new record in the database.
	 * The records will have a unique record at the meta_contents table,
	 * and one for each active language at the corresponding table
	 *
	 * @param $type the type of content to be added (i.e. section, post, etc)
	 * @param $data an array containing the data to be inserted. I.e. $_POST
	 */
	public function add($type, $data=array())
	{
		// We no longer need 'em
		if (isset($data['token'], $data['submit'], $_SESSION['token'])) 
		{
			unset($data['token'], $data['submit'], $_SESSION['token']);
		}

		// You didn't turn off magic_quotes? Fuck off.
		if ( in_array( strtolower( ini_get( 'magic_quotes_gpc' ) ), array( '1', 'on' ) ) )
		{
		    $data = array_map( 'stripslashes_deep', $data );
		}
		
		$this->post = $data;
					
		// We need 'em for meta content
		if (isset($this->post['nice_url'])) // This is a too poor method
		{
			$args['nice_url'] = to_friendly_url($this->post['nice_url']);	
		}
		if( ! isset($this->post['nice_url']) && isset($this->post['title_'.$this->administrator->clean['lang'].''])) 
		{
			$args['nice_url'] = to_friendly_url($this->post['title_'.$this->administrator->clean['lang'].'']);
		}
		
		if (is_array($type)) // This is a too poor method
		{
			$args['in_table'] = $type[1];
			$type = $type[0];
		} 
		else 
		{
			$args['in_table'] = $type.'s';
		}
		
		// We need to create the model first, in order to validate data
		$meta = new Meta_content($args);
		// Now we can validate data
		// NOTE: At this point, nice_url and in_table are being validated!
		foreach ($args as $key => $value) 
		{
			if ($meta->is_invalid($key)) 
			{ 
				$this->errors[$key] = $meta->errors->on($key);
			}
		}
		
		if(0 === count($this->errors)) 
		{	
			$model = ucfirst($type);
			// Build the post array
			$this->post = $this->create_lang_array($this->post);
			// Create a model for each post language
			foreach ($this->post as $this->key => $this->value) 
			{
				$entry = new $model($this->post[$this->key]);
				foreach ($this->post[$this->key] as $key => $value) 
				{
					// Validate each post language
					if ($entry->is_invalid($key)) 
					{
						$this->errors[$key] = $entry->errors->on($key);
					}
				}
			}

			if(0 === count($this->errors)) 
			{
				$saved = array();
				$saved[] = $meta->save();
				foreach (array_keys($this->post) as $lang) 
				{ 
				 	$this->post[$lang]['identifier'] = $meta->id; 
				 	$this->post[$lang]['lang'] = $lang; 
				 	$this->post[$lang]['nice_url'] = $meta->nice_url;
				}
				/*
				Not sure if this is the only method.
				If possible, should find a way not to
				recreate the models again
				*/
				foreach ($this->post as $this->key => $this->value) 
				{
					$entry = new $model($this->post[$this->key]);
					foreach ($this->post[$this->key] as $key => $value) 
					{
						$saved[] = $entry->save();
					}
				}
				if (count($saved) > 0) 
				{
					return $meta;	
				}
			}
		}
		return FALSE;	
	}

	/**
	 * Adds and Uploads post attached files
	 *
	 */
	public function add_post_files($parent, $file_key='file', $options=array())
	{
		$defaults = array(
			'memory' => 64,
			'sizes' => array(
				200 => 'resources/uploads/thumbs',
				1000 => 'resources/uploads',
			),
		);

		foreach ($defaults as $key => $value) 
		{
			if ( ! isset($options[$key])) 
			{
				$options[$key] = $defaults[$key];
			}
		}

		// Validate	
		$id = (int) $parent;

		if (isset($_FILES[$file_key]) && !empty($_FILES[$file_key])) 
		{	
			ini_set('memory_limit', $options['memory'].'M');
			$newfiles = $this->upload->normalize_file_array();
			for ($i = 0; $i < count($newfiles[$file_key]); $i++) 
			{
				if ($this->upload->upload($file_key,$newfiles[$file_key][$i])) 
				{
					$data = $this->upload->data();
					$img = $this->lang->get_lang_fields_off($_POST);
					$img["nice_url"] = $data["file_name"];
					$img["file_name"] = $data["file_name"];
					$img["file_type"] = $data["file_type"];
					$img["parent"] = $id;
							
					if ($media = $this->add('media', $img)) 
					{
						// Process image
						$this->image->load($data['file_name'], 'resources/uploads');

						foreach ($options['sizes'] as $key => $value) 
						{
							$size = (int) $key;
							$dir = isset($value) ? $value : $size;

							$this->image->resize_to_width($size);
							$this->image->save($data['file_name'], $dir);
						}
						$this->image->destroy();
					}
				}
			}
			return TRUE;
		}
		return FALSE;
	}
		
	/**
	 * 
	 */
	public function edit($type, $id, $data=array()) 
	{
		$this->identifier = (int) $id;
		
		// We no longer need 'em
		if (isset($data['token'], $data['submit'], $_SESSION['token'])) 
		{
			unset($data['token'], $data['submit'], $_SESSION['token']);
		}

		// You didn't turn off magic_quotes? Fuck off.
		if ( in_array( strtolower( ini_get( 'magic_quotes_gpc' ) ), array( '1', 'on' ) ) )
		{
		    $data = array_map( 'stripslashes_deep', $data );
		}

		$this->post = $data;
		// We need 'em for meta content
		if (isset($this->post['nice_url'])) 
		{
			$this->post['nice_url'] = to_friendly_url($this->post['nice_url']);
		} 
		
		// Read the meta model
		$meta = Meta_content::find($this->identifier);
		// Pass the nice_url value in case it has changed
		$meta->nice_url = isset($this->post['nice_url']) ? $this->post['nice_url'] : $meta->nice_url;
		// Validate data
		// ! At this point, only nice_url is being validated! 
		// But leave the foreach in case we change it
		foreach ($this->post as $key => $value) 
		{
			if ($meta->is_invalid($key)) 
			{
				$this->errors[$key] = $meta->errors->on($key);
			}
		}
		
		if(0 === count($this->errors)) 
		{				
			$model = ucfirst($type);
			// Build the post array
			$this->post = $this->create_lang_array($this->post);
			// Create a model for each post language for validating purposes
			foreach ($this->post as $this->key => $this->value) 
			{
				$entry = new $model($this->post[$this->key]);
				foreach ($this->post[$this->key] as $key => $value) 
				{
					// Validate each post language
					if ($entry->is_invalid($key)) 
					{
						$this->errors[$key] = $entry->errors->on($key);
					}
				}
			}
			
			if(0 === count($this->errors)) 
			{
				$saved = array();
				$saved[] = $meta->save();
				foreach ($this->post as $this->key => $this->value) 
				{
					$entry = $model::find_by_identifier_and_lang($meta->id,$this->key);
					// Assing new values to the model
					foreach ($this->post[$this->key] as $key => $value) 
					{
						$entry->$key = $this->post[$this->key][$key];
					}
					$saved[] = $entry->save();
				}
				if (count($saved) > 0) 
				{
					return TRUE;	
				}
			}
			return FALSE;		
		}
	}
	
	/**
	 * 
	 */
	public function trash($type, $id) 
	{
		$model = ucfirst($type);
		$this->identifier = (int) $id;
		
		$entries = $model::all(array('identifier'=>$this->identifier));
		$count = count($entries);
		
		foreach ($entries as $entry) 
		{
			$entry->status = $this->post_status['trash'];
			$saved[] = $entry->save();
		}
		if (count($saved) === $count) 
		{
			return TRUE;	
		}
		return FALSE;
	}
	
	/**
	 * 
	 */
	public function untrash($type, $id) 
	{
		$model = ucfirst($type);
		$this->identifier = (int) $id;
		
		$entries = $model::all(array('identifier'=>$this->identifier));
		$count = count($entries);
		
		foreach ($entries as $entry) 
		{
			$entry->status = $this->post_status['draft'];
			$saved[] = $entry->save();
		}
		if (count($saved) === $count) 
		{
			return TRUE;	
		}
		return FALSE;
	}
	
	/**
	 * 
	 */
	public function remove($type, $id) 
	{
		$model = ucfirst($type);
		$this->identifier = (int) $id;
		
		$entries = $model::all(array('identifier'=>$this->identifier));
		$count = count($entries);
		
		foreach ($entries as $entry) 
		{
			$deleted[] = $entry->delete();
		}
		if (count($deleted) === $count) 
		{
			$meta = Meta_content::find($this->identifier);
			if ($meta->delete()) 
			{
				return TRUE;	
			}
		}
		return FALSE;
	}
	
	/**
	 * 
	 */
	public function file_path($data) 
	{
//		if ( ! is_array($data)) {
//			return FALSE;
//		}
		
		if (isset($data->file_type) && $this->upload->is_image($data->file_type)) 
		{
			$kind = 'uploads/thumbs';
		}
		
		return '/resources/'.$kind.'/'.$data->file_name;
	}
						
	/**
	 * Returns an array with languages
	 */
	public function create_lang_array($post) 
	{
		$array = array();
		foreach ($post as $key => $value) 
		{	
			if (preg_match('/^(_)+([a-z]{2})/', substr($key, -3))) 
			{		
				$lang = substr($key, -2);
				$n_key = substr($key, 0, -3);
				
				$array[$lang][$n_key] = $value;			
			}
			else 
			{
				foreach (array_keys($array) as $lang) 
				{ 
				 	$array[$lang][$key] = $value; 
				}
			}
		}
		return $array;
	}
	
	/**
	 * Returns the current URL with the requested language
	 */
	function switch_lang($lang) {
		// Check current URI
		$current_url = $_SERVER["REQUEST_URI"];	
		// Get path beyond language mark /ca/
		$path = substr($current_url, 4);
		
		if ($this->lang->is_active($lang)) 
		{
			return '/'.$lang.'/'.$path;
		}
		exit('The language you requested is not available');
	}
	
	/**
	 * Returns this library version, 
	 * as defined at the top of this document
	 */
	public function version() 
	{
		return $this->version;	
	}
}