<?php

/** 
 * Returns the string with accents replaced by plain characters
 * 
 * This function comes straight form the User Contributor Notes at the PHP Manual. 
 * Only the "tilde" type was added to the pattern, and was stripped in two different functions for convenience.
 * 
 * @author spcmky at gmail dot com
 * @link http://www.php.net/manual/en/function.preg-replace.php#90485 
 *
 * @access public
 * @param string
 * @return void
 */

/**
 * Returns a path/to/file with no opening or ending slashes
 */
function clean_path($string) {
	$levels = explode_filter("/", $string);
	return implode("/", $levels);
}

/**
 * 
 */
function replace_accents($string)
{
  $string = trim($string);
    
  if ( ctype_digit($string) )
  {
    return $string;
  }
  else 
  {      
    // replace accented chars
    $accents = '/&([A-Za-z]{1,2})(grave|acute|circ|cedil|uml|lig|tilde);/';
    $string_encoded = htmlentities($string,ENT_NOQUOTES,'UTF-8');

    $string = preg_replace($accents,'$1',$string_encoded);
  } 

  return $string;
} 

/** 
 * Returns a URL friendly string
 * 
 * This function comes straight form the User Contributor Notes at the PHP Manual. 
 * Only the "tilde" type was added to the pattern, and was stripped in two different functions for convenience.
 * 
 * @author spcmky at gmail dot com
 * @link http://www.php.net/manual/en/function.preg-replace.php#90485 
 *
 * @access public
 * @param string
 * @return void
 */
function to_friendly_url($string)
{
  if (is_array($string)) {
  	return array_map('to_friendly_url', $string);
  }
  
  $string = trim($string);
    
  if ( ctype_digit($string) )
  {
    return $string;
  }
  else 
  {      
    $string = replace_accents($string);
      
    // clean out the rest
    $replace = array('([\40])','([^a-zA-Z0-9-_\.])','(-{2,})');
    $with = array('-','','-');
    $string = preg_replace($replace,$with,$string); 
  } 

  return strtolower($string);
}
