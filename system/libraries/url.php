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
		$this->segments = self::check_lang();
		
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
	 * Checks whether a URL requires language flag
	 *
	 * This method counts the active languages in the
	 * database. If more than one, a language flag will
	 * be pushed as the first segment of the URL. 
	 * Otherwise, the URL will be returned as is.
	 */
	private function check_lang()
	{
		$lang = new Lang;
		
		$count = count($lang->get_active());

		if ($count > 1 && $lang->is_active($_SESSION['lang'])) 
		{
			array_unshift($this->segments, $_SESSION['lang']);
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