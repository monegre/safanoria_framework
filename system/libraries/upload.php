<?php
/**
 * File Uploading class
 * Uses PHP's GD native extension
 * 
 * @package Safanoria
 * @subpackage CMS
 * @author Carles Jove i Buxeda & ExpressionEngine Dev Team (see note below)
 *
 * Note: Part of this class is based on CodeIgniter's Upload class.
 * 		 
 */

class Upload extends Safanoria
{
	// Some settings
	private $allowed_types 		= array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png');	
	private $max_width 			= 1500; // Max width for regular images
	private $thumb_width 		= 350; // Max width for thumb images
	
	/*
	 * REMEMBER: 
	 * These paths are relative to the public/ directory
	 */
	private $upload_path 	= "resources/uploads/";
	
	/*
	 * You can set those, too.
	 */
	private $memory_limit 		= 12;
	private $max_file_size 		= 5000000; // 4,8Mb aprox  | 5964148=6Mb
	
	/**
	 * These are just returned values. Don't edit.
	 */
	public $file_tmp = '';			
	public $file_name = '';
	public $file_type = '';
	public $file_size = '';
	public $image_width = '';
	public $image_height = '';
	public $image_type = '';
	public $image_size_str = '';
	
	/**
	 * 
	 */
	function __construct() 
	{
//		parent::__construct();
	}
	
	/**
	 * 
	 */
	public function upload($field = 'file', $file=null) 
	{ 					
		if ($_SERVER['REQUEST_METHOD'] == 'POST') 
		{
			// Attempt to create file's directory if it doesn't exist
			if ( ! file_exists($this->upload_path)) 
			{
				if ( ! mkdir($this->upload_path,0777,TRUE)) 
				{
					die('There was an error trying to create the images directories. Please, create them manually at ' . $this->upload_path . ' in your public folder. Thank you.');
				}
			}
			
			if (isset($file)) 
			{
				$this->file = $file;
				$this->file_tmp = $file['tmp_name'];				
				$this->file_name = to_friendly_url($file["name"]);
				$this->file_type = $file["type"];
				$this->file_size = $file["size"];
			}
			else {
				$this->file = $_FILES[$field];
				$this->file_tmp = $_FILES[$field]['tmp_name'];				
				$this->file_name = to_friendly_url($_FILES[$field]["name"]);
				$this->file_type = $_FILES[$field]["type"];
				$this->file_size = $_FILES[$field]["size"];
			}
			
			
			// Validate file type
			if ( ! in_array($this->file_type, $this->allowed_types)) 
			{
				$this->errors['type'] = "Invalid fyle type";
			} 
			// Validate file size
			if ($this->file_size > $this->max_file_size) 
			{
				$this->errors['size'] = "File too big";
			}
			// Validate file exists
			if (file_exists($this->upload_path.$this->file_name)) 
			{
				$this->errors[$field] = $this->file_name . " already exists. ";
			}
			
			// Is valid
			if ( count($this->errors) === 0 ) 
			{	
				move_uploaded_file($this->file_tmp, $this->upload_path.$this->file_name);
				
				/*
				 * Set the finalized image dimensions
				 * This sets the image width/height (assuming the
				 * file was an image).  We use this information
				 * in the "data" function.
				 */
				$this->set_image_properties($this->upload_path.$this->file_name);
				return TRUE;
			}
			return FALSE;
		}		
	}
		
	/**
	 * Validate the image
	 *
	 * @author CodeIgniter
	 * @return bool
	 */
	public function is_image($filetype=null)
	{
		if (isset($filetype)) {
			$this->file_type = $filetype;
		}
		
		// IE will sometimes return odd mime-types during upload, so here we just standardize all
		// jpegs or pngs to the same file type.
	
		$png_mimes  = array('image/x-png');
		$jpeg_mimes = array('image/jpg', 'image/jpe', 'image/jpeg', 'image/pjpeg');
	
		if (in_array($this->file_type, $png_mimes))
		{
			$this->file_type = 'image/png';
		}
	
		if (in_array($this->file_type, $jpeg_mimes))
		{
			$this->file_type = 'image/jpeg';
		}
	
		$img_mimes = array(
							'image/gif',
							'image/jpeg',
							'image/png',
						);
	
		return (in_array($this->file_type, $img_mimes, TRUE)) ? TRUE : FALSE;
	}
	/**
	 * @author http://php.net/manual/en/features.file-upload.multiple.php#109437
	 */
	public function normalize_file_array() 
	{
		$newfiles = array(); 
		foreach($_FILES as $fieldname => $fieldvalue) 
		    foreach($fieldvalue as $paramname => $paramvalue) 
		        foreach((array)$paramvalue as $index => $value) 
		            $newfiles[$fieldname][$index][$paramname] = $value; 
		return $newfiles; 
	}
	
	/**
	 * Set Image Properties
	 *
	 * Uses GD to determine the width/height/type of image
	 *
	 * @param	string
	 * @return	void
	 */
	public function set_image_properties($path = '')
	{
		if ( ! $this->is_image())
		{
			return;
		}

		if (function_exists('getimagesize'))
		{
			if (FALSE !== ($D = @getimagesize($path)))
			{
				$types = array(1 => 'gif', 2 => 'jpeg', 3 => 'png');

				$this->image_width		= $D['0'];
				$this->image_height		= $D['1'];
				$this->image_type		= ( ! isset($types[$D['2']])) ? 'unknown' : $types[$D['2']];
				$this->image_size_str	= $D['3'];  // string containing height and width
			}
		}
	}
	
	/**
	 * Finalized Data Array
	 *
	 * Returns an associative array containing all of the information
	 * related to the upload, allowing the developer easy access in one array.
	 *
	 * @return array
	 */
	public function data()
	{				
		return array (
						'file_name'			=> $this->file_name,
						'file_type'			=> $this->file_type,
						'full_path'			=> $this->upload_path.$this->file_name,
						'file_size'			=> $this->file_size,
						'full_path' 		=> $this->upload_path.$this->file_name,
						'is_image'			=> $this->is_image(), // bool
						'image_width' 		=> $this->image_width,
						'image_height' 		=> $this->image_height,
						'image_type'		=> $this->image_type,
						'image_size_str'	=> $this->image_size_str,
					);
	}
}