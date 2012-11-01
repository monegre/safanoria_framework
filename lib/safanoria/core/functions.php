<?php
/**
 * Basic functions, shared by both the admin panel and the skin
 */

/**
 * Checks whether a string is empty or not
 */
function explode_filter_empty($string) { 	
	if (empty($string)) {
		return FALSE;
	}
	return TRUE;
} 

/**
 * Returns an exploded array with no empty strings 
 */
function explode_filter($delimiter, $str) { 
	$parts = explode($delimiter, $str); 
	return(array_filter($parts, "explode_filter_empty")); 
} 
 
/**
 *
 */
function &get_instance() {
	return Safanoria::get_instance();
}

/**
 *
 */
// function show_404($file='404') {
// 	$views = ROOT . APP . VIEWS;
// 	$falls = ROOT . LIB . CMS . VIEWS;
// 	$ext = ".php";

// 	$n_file = isset($folder) ? clean_path($folder) . '/' : false;
// 	$n_file .= $file.$ext;
			
// 	if (file_exists($views.$n_file)) 
// 	{
// 		return $views.$n_file;
// 	} 
// 	else 
// 	{	
// 		if (file_exists($falls.$n_file)) 
// 		{ 
// 			return ($falls.$n_file);
// 		}
// 		return ($falls . '404.php');
// 	}	
// }