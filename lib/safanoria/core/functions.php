<?php
/**
 * Basic functions, shared by both the admin panel and the skin
 */

function __autoload($class) 
{
	$dirs = array(
				1 => ROOT . LIB . CMS . CONTROLS,
				2 => ROOT . LIB . CMS . MODELS,
				3 => ROOT . LIB . SYS . LIBS,
				4 => ROOT . LIB . SYS . CORE,
				5 => ROOT . APP . CONTROLS,
				6 => ROOT . APP . MODELS,
				7 => ROOT . APP . LIBS
			);
	
	$found = FALSE;
	
	for ($i = 1; $i <= count($dirs); $i++) 
	{
		if (file_exists($dirs[$i] . strtolower($class) . '.php')) 
		{
			$found = TRUE;
			$dir = $dirs[$i];
			require ($dirs[$i] . strtolower($class) . '.php');
			break;
		}
		continue;
	}
	
	if ($found === FALSE) 
	{
		throw new Exception("The requested class {$class} could not be found in the directory {$dir}");	
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
	$falls = ROOT . LIB . CMS . VIEWS;
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