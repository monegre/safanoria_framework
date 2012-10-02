<?php
/**
 * A bunch of useful premade functions for easy escaping data
 *
 * @package Safanoria
 * @since 1.0
 */

/**  Just to clean strings easily */
function h($string) {
	if (is_array($string)) {
		return array_map('h', $string);
	}
	return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

/**  Just to escape strings easily */
function escape($string) {
	mysql_connect(DB_HOST, DB_USER, DB_PASS);
	return mysql_real_escape_string($string);
}

/**  Just to escape strings easily */
function sql($string) {
	if (is_array($string)) {
		return array_map('sql', $string);
	}
	mysql_connect(DB_HOST, DB_USER, DB_PASS);
	return mysql_real_escape_string($string);
}

/** Returns all values in array with backslashed stripped off */
function stripslashes_deep($string) {
    if (is_array($string)) {
    	return array_map('stripslashes_deep', $string);
	}
    return stripslashes($string);
}