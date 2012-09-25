<?php

function Routing($url) 
{
	$controller = FALSE;
	$method 	= FALSE;
	$query 		= FALSE;
	$url_parts 	= array();
	
	$url_parts = clean_path($url);
	$url_parts = explode("/", $url);
	
	$pattern = "/-/";
	$replacement = "_";
	
	// Let's set the navigation lang
	session_start();
	if (preg_match('/^([a-z]{2})$/', $url_parts[0]))
	{
		$switcher = isset($url_parts[1]) ? $url_parts[1] : 'home';
		$_SESSION['lang'] = $url_parts[0];
	}
	else 
	{
		$switcher = $url_parts[0];
		$lang = new Lang;
		foreach ($lang->get_user_agent_langs() as $array) 
		{
			if ($lang->is_active($array[1])) 
			{
				$_SESSION['lang'] = $array[1];
				break;
			}
		}
		if ( ! isset($_SESSION['lang'])) 
		{
			$a = Lang::first();
			$_SESSION['lang'] = $a->code;
		}
	}
	
	switch ($switcher) 
	{
		// Admin area
		case 'admin':
			$controller = 'Admin';
			$method = isset($url_parts[1]) && $url_parts[1]!= 'admin' 
						? preg_replace($pattern,$replacement, $url_parts[1]) 
						: 'index';
			$count = count($url_parts);
			for ($i = 2; $i < $count; $i++) 
			{
				$query[] = $url_parts[$i];
			}
			break;
		// Sections with no controller of its own
		// Add yours here if necessary
		case 'home':
		case 'error':
			$controller = 'Home';
			$method = isset($url_parts[1]) && $url_parts[1]!= 'home' 
						? preg_replace($pattern,$replacement, $url_parts[1]) 
						: 'index';
			break;
		// Sections with controller of its own
		default:
			$controller = ucwords($url_parts[1]);			
			$method = isset($url_parts[2]) && !empty($url_parts[2]) 
						? preg_replace($pattern,$replacement, $url_parts[2]) 
						: 'index';			
			$count = count($url_parts);
			for ($i = 3; $i < $count; $i++) 
			{
				$query[] = $url_parts[$i];
			}
	}
	new $controller($method, $query);
}