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
	public function view($file, $folder = null, $dir = 'app') 
	{		
		$file_path = ROOT.clean_path($dir).'/views/';
		$file_path .= isset($folder) ? clean_path($folder).'/' : null;
		$file_path .= $file.$this->ext;
		
		if (file_exists($file_path)) 
		{
			return $file_path;
		}

		throw new Exception("The requested view {$file} could not be found at {$file_path}");
	}
	
	/**
	 * Checks wheteher a file exists and returns it, or an error page
	 */
	public function layout($file, $dir = 'app', $folder = null) 
	{		
		$file_path = ROOT.clean_path($dir).'/views/layouts/';
		$file_path .= isset($folder) ? clean_path($folder).'/' : null;
		$file_path .= $file.$this->ext;
		
		if (file_exists($file_path)) 
		{
			return $file_path;
		}

		throw new Exception("The requested view {$file} could not be found at {$file_path}");
	}
	
	/**
	 * Model load
	 */
	public function model($file, $dir = 'app', $folder = null) 
	{		
		$file_path = ROOT.clean_path($dir).'/models/';
		$file_path .= isset($folder) ? clean_path($folder).'/' : null;
		$file_path .= $file.$this->ext;
		
		if (file_exists($file_path)) 
		{
			return $file_path;
		}

		throw new Exception("The requested model {$file} could not be found at {$file_path}");
	}
	
	/**
	 * Library load
	 */
//	public function library($file, $dir = 'lib/safanoria', $folder = null) 
//	{		
//		$file_path = ROOT.clean_path($dir).'/libraries/';
//		$file_path .= isset($folder) ? clean_path($folder).'/' : null;
//		$file_path .= $file.$this->ext;
//		
//		if (file_exists($file_path)) 
//		{
//			return $file_path;
//		}
//
//		throw new Exception("The requested library {$file} could not be found at {$file_path}");
//	}
}