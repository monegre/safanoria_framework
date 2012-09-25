<?php
/**
 * A simple function to centralize URLs and return them
 */
$url = array (
	'' => '',
);
function url($string, $other=null) 
{
	global $url;
	if (isset($other)) {
		return $url[$other];
	}
	
	return $url[$string];
}