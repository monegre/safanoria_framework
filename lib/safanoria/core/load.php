<?php
/**
 * Load class
 */

class Load
{
	/**
	 * Possible views directories.
	 * Add your own if necessary
	 */
	private $view_dirs;

	/**
	 * Default file extension
	 */
	private $ext = ".php";

	function __construct()
	{
		$this->view_dirs = array(
			0 => ROOT.APP.VIEWS, // App views
			1 => ROOT.LIB.CMS.VIEWS, // CMS views
		);
	}

	/**
	 * Checks wheteher a file exists and returns it, or an error page
	 */
	public function view($file, $folder = null, $dir = 'app/views') 
	{		
		$file_path = ROOT.clean_path($dir).'/';
		$file_path .= isset($folder) ? clean_path($folder) . '/' : false;
		$file_path .= $file.$this->ext;

		// for ($i=0; $i < count($this->view_dirs); $i++) 
		// { 
		// 	if (file_exists($this->view_dirs[$i].$n_file)) 
		// 	{
		// 		return $this->view_dirs[$i].$n_file;
		// 	}
		// 	continue;
		// }
		
		if (file_exists($file_path)) 
			{
				return $file_path;
			}

		throw new Exception("The requested view {$file} could not be found at {$file_path}");
	}
}