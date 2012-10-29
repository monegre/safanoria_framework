<?php 
/** 
 * Error class
 */

class Error
{
	public $error;
	
	/** 
	 * Error 404
	 */
	public function show_404($file='404') 
	{
		$views = ROOT . APP . VIEWS;
		$falls = ROOT . SYS . VIEWS;
		$ext = ".php";
	
		$n_file = isset($folder) ? clean_path($folder) . '/' : false;
		$n_file .= $file.$ext;
				
		if (file_exists($views.$n_file)) 
		{
			return $views.$n_file;
		} 
		else 
		{	
			if (file_exists($falls.$n_file)) 
			{ 
				return ($falls.$n_file);
			}
			return ($falls . '404.php');
		}	
	}
	
	/** 
	 * Error 404
	 */
	public function has_error($controller = null, $method = null, $query = null) 
	{
		if ( class_exists($controller)
			 && method_exists($controller, $method)) 
		{
			$this->error = 0;
		}
				
		if (is_array($query)) 
		{
			// Query is not in the database
			$record = Meta_content::find_by_nice_url($query[0]);
			
			if (count($record) == 0) 
			{
				$this->error = 1;
			}
		}
		
		if($this->error === 0)
		{
			return FALSE;
		} 
		
		return TRUE;
	}
}