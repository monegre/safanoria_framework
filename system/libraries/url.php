<?php
/**
 * URL class
 * Gets off you the boring job of writing URLs 
 * 
 * @package Safanoria
 * @subpackage Libraries
 * @author Carles Jove i Buxeda
 *
 * 		 
 */

class Url
{
	public $full_path;
	public $segments = array();	

	/**
	 * Returns the full path to a database object
	 * @param int
	 * @param bool
	 * @return string
	 */
	public function full_path_to($id, $absolute = TRUE)
	{
		$meta = Meta_content::find($id);

		$this->segments[] = $meta->nice_url;
		$this->segments = self::get_parent_urls($meta->parent);
		array_unshift($this->segments, $_SESSION['lang']);
		
		$this->full_path = implode('/', $this->segments);

		if ($absolute === TRUE) 
		{
			$this->full_path = '/'.$this->full_path;
		}

		return $this->full_path;
	}

	/**
	 * Recursively looks for a parent object in the database
	 *
	 * @param int
	 * @return array
	 */
	private function get_parent_urls($parent)
	{
		if ($parent > 0) 
		{
			$meta = Meta_content::find($parent);
			array_unshift($this->segments, $meta->nice_url);
			return self::get_parent_urls($meta->parent);
		}
		return $this->segments;
	}

	/**
	 * Returns full path to database object in array
	 *
	 * @return array
	 */
	public function get_segments()
	{
		return $this->segments;
	}
}