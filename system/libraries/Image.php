<?php
/**
 * Image processing class
 * ! Based on GD !
 *
 * This class starts from Simon Jarvis' SimpleImage class,
 * which can be found at: http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php
 * 
 * @author Simon Jarvis
 * @author Carles Jove i Buxeda
 * @package Safanòria
 * @subpackage Libraries
 * @license http://www.gnu.org/licenses/gpl.html
 */
 
class Image 
{
	/**
	 *
	 */
	function __construct($args=[]) 
	{
		if (count($args) > 0) 
		{
			$this->initialize($args);
		}
	}
	
	/**
	 * Not in use
	 */
	function initialize($args=[]) 
	{
		/*
		
		array( 
				["file_name"] => string(19) "tropa-al-celler.jpg" 
				["file_type"] => string(10) "image/jpeg" 
				["full_path"] => string(37) "resources/uploads/tropa-al-celler.jpg" 
				["file_size"] => int(59925) 
				["is_image"] => bool(true) 
				["image_width"] => int(604) 
				["image_height"] => int(402) 
				["image_type"] => string(4) "jpeg" 
				["image_size_str"] => string(24) "width="604" height="402"" 
			)
		*/
		$this->file_name = $args['file_name'];
		$this->file_type = $args['file_type'];
		$this->file_size = $args['file_size'];
		$this->full_path = $args['full_path'];
		$this->is_image = $args['is_image'];
		$this->image_width = $args['image_width'];
		$this->image_height = $args['image_height'];
		$this->image_type = $args['image_type'];
		$this->image_size_str = $args['image_size_str'];
	}
	
	/**
	 * Set Image Properties
	 *
	 * Uses GD to determine the width/height/type of image
	 *
	 * @param	string
	 * @return	void
	 */
	private function set_image_properties($path = '')
	{
		if (function_exists('getimagesize'))
		{
			if (FALSE !== ($D = @getimagesize($path)))
			{
				$this->image_width		= $D['0'];
				$this->image_height		= $D['1'];
				$this->image_type 		= $D['2'];
				$this->image_size_str	= $D['3'];  // string containing height and width
			}
		}
	}
	
	/**
	 * Loads the image and creates a handle
	 */
	public function load($file, $directory='resources/uploads') 
	{		
		// Sanitize path
		$this->directory = clean_path($directory);
		$this->file = $this->directory.'/'.$file;
		
		$this->set_image_properties($this->file);
		
		switch ($this->image_type) 
		{
			case 1: // GIF
				$this->src_img = imagecreatefromgif($this->file);
				break;
			case 2: // JPEG
				$this->src_img = imagecreatefromjpeg($this->file);
				break;
			case 3: // PNG
				
				$this->src_img = imagecreatefrompng($this->file);
				break;
		}
	}
	


	/**
	 * Stores final file in the server
	 */
	public function save($filename, $directory='resources/uploads', $compression=90, $permissions=null) 
	{
		// Sanitize path
		$this->directory = clean_path($directory);
		$this->dst_img_path = $this->directory.'/'.$filename;
		
		// Attempt to create file's directory if it doesn't exist
		if ( ! file_exists($this->directory)) 
		{
			if ( ! mkdir($this->directory,0777,TRUE)) 
			{
				die('There was an error trying to create the images directories. Please, create them manually at ' . $this->directory . ' in your public folder. Thank you.');
			}
		}
		
		switch ($this->image_type) 
		{
			case 1: // GIF
				imagegif($this->dst_img,$this->dst_img_path);
				break;
			case 2: // JPEG
				imagejpeg($this->dst_img,$this->dst_img_path,$compression);
				break;
			case 3: // PNG
				imagepng($this->dst_img,$this->dst_img_path);
				break;
		}
		
		if( $permissions != null) 
		{
			chmod($this->dst_img,$permissions);
		}
	
		return TRUE;
//		return FALSE;
	}
	
	/**
	 *
	 */
	public function destroy() 
	{
		//  Kill the file handles
		imagedestroy($this->dst_img);
		imagedestroy($this->src_img);
	}

	/**
	 *
	 */
	function resize($width,$height) 
	{
		$this->dst_img = imagecreatetruecolor($width, $height);

		if ($this->image_type == 3) // png we can actually preserve transparency
		{
			imagealphablending($this->dst_img, FALSE);
			imagesavealpha($this->dst_img, TRUE);
		}
		
		// If resizing the x/y axis must be zero
		$this->x_axis = 0;
		$this->y_axis = 0;

		imagecopyresampled($this->dst_img, $this->src_img, 0, 0, $this->x_axis, $this->y_axis, $width, $height, $this->get_image_width(), $this->get_image_height());
		
//		imagepng($this->dst_img,'resources/uploads/olaasdfasdfasdfasdfla.png');
	}
	
	/**
	 *
	 */
	function resize_to_height($height) 
	{
		if ($this->get_image_height() <= $height) 
		{
			$width = $this->get_image_width();
			$height = $this->get_image_height();
		}
		else 
		{
			$ratio = $height / $this->get_image_height();
			$width = $this->get_image_width() * $ratio;
		}
		$this->resize($width,$height);
	}

	/**
	 *
	 */
	function resize_to_width($width) 
	{
		if ($this->get_image_width() <= $width) 
		{
			$width = $this->get_image_width();
			$height = $this->get_image_height();
		}
		else 
		{
			$ratio = $width / $this->get_image_width();
			$height = $this->get_image_height() * $ratio;
		}
		$this->resize($width,$height);
	}

	/**
	 *
	 */
	function scale($scale) 
	{
		$width = $this->get_image_width() * $scale/100;
		$height = $this->get_image_height() * $scale/100;
		$this->resize($width,$height);
	}
	
	/**
	 *
	 */
	function output($image_type=IMAGETYPE_JPEG) 
	{
		if( $image_type == IMAGETYPE_JPEG ) 
		{
			imagejpeg($this->dst_img);
		} 
		elseif( $image_type == IMAGETYPE_GIF ) 
		{
			imagegif($this->dst_img);
		} 
		elseif( $image_type == IMAGETYPE_PNG ) 
		{
			imagepng($this->dst_img);
		}
	}

	/**
	 *
	 */
	function get_image_width() 
	{
		return imagesx($this->src_img);
	}

	/**
	 *
	 */
	function get_image_height() 
	{
		return imagesy($this->src_img);
	}
}