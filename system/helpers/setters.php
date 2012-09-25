<?php
/**
 * A bunch of useful premade functions for easy setting vars and arrays	
 *
 * @package Safanoria
 * @since 1.0
 */
 
/**
 * Sets unset keys in array 
 * Please note that this function is just meant for setting strings, but it doesn't filter nor escape them
 */
function set_array($array) 
{
	foreach ($array as $key => $value) 
	{		
		$array = isset($array[$key]) ? $array[$key] : '';
	}
	return $array;
}

/** 
 * Checks whether an array key is set and returns it if true, and $default if false 
 */
function set_index(&$array, $key, $default = NULL) 
{
    return isset($array[$key]) ? $array[$key] : $default;
}