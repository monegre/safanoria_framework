<?php
/**
 * Basic functions, shared by both the admin panel and the skin
 */

function __autoload($class) 
{
	// SYS
	if (file_exists(ROOT . SYS . CONTROLS . strtolower($class) . '.php')) 
	{
		require_once( ROOT . SYS . CONTROLS . strtolower($class) . '.php' );
	}
	elseif (file_exists(ROOT . SYS . MODELS . strtolower($class) . '.php')) 
	{
		require_once( ROOT . SYS . MODELS . strtolower($class) . '.php' );
	}
	elseif (file_exists(ROOT . SYS . LIBS . strtolower($class) . '.php')) 
	{
		require_once( ROOT . SYS . LIBS . strtolower($class) . '.php' );
	}
	elseif (file_exists(ROOT . SYS . CORE . strtolower($class) . '.php')) 
	{
		require_once( ROOT . SYS . CORE . strtolower($class) . '.php' );
	}
	// APP
	elseif (file_exists(ROOT . APP . CONTROLS . strtolower($class) . '.php')) 
	{
		require_once( ROOT . APP . CONTROLS . strtolower($class) . '.php' );
	}
	elseif (file_exists(ROOT . APP . MODELS . strtolower($class) . '.php')) 
	{
		require_once( ROOT . APP . MODELS . strtolower($class) . '.php' );
	}
	elseif (file_exists(ROOT . APP . LIBS . strtolower($class) . '.php')) 
	{
		require_once( ROOT . APP . LIBS . strtolower($class) . '.php' );
	}
	else 
	{
		require show_404();	
	}
}

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
 * Returns input field content according to this rule:
 * 1. If $_POST content was submitted, it'd be returned in the first place
 * 2. If $global is passed, its content will be returned
 * 3. If $alternate is passed and no $_POST is passed, its content will be returned even if $global is passed
 *
 * Please notice: $alternate is meant for forms that need to handle up to three different kinds of data: 
 * 		I.e: a new address form that shows $global['name'] by default, but that after submission needs to print $_POST['name'], and when retrieving from database for edition purposes needs to print $alternate['name']
 */
function input_for($field, &$global=null, &$alternate=null) {

	$clean = array();
	
	// Post submitted => we want it
	if ( isset($_POST[$field]) ) {
		$clean[$field] = h($_POST[$field]);
		return $clean[$field];
	}
	// $_POST not submited => try other options
	else {
		
		if ( isset($alternate) && !isset($global) ) {
			$clean[$field] = $alternate[$field];
			return $clean[$field];
		} 
		if ( isset($global) ) {
			$clean[$field] = $global[$field];
			return $clean[$field];
		}
		if ( !isset($alternate, $global) ) {
			$clean[$field] = set_index($_POST, $field);
			return $clean[$field];
		}
	}	
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
function show_404($file='404') {
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