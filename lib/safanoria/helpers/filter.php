<?php
/**
 * A bunch of useful premade functions for easy filtering data
 *
 * @package Safanoria
 * @since 1.0
 */

/**
 *
 */ 
function is_email($email) {
	$pattern = "/^[_A-Za-z0-9-]+(\\.[_A-Za-z0-9-]+)*@[A-Za-z0-9]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$/";
	if (0 !== preg_match($pattern, $email)) {
		return $email;
	}
	return FALSE;
}

/**
 *
 */ 
function is_name($name) {
	$pattern = "/\S+/";
	if (0 !== preg_match($pattern, $name)) {
		return $name;
	}
	return FALSE;
}

/**
 *
 */ 
function is_password($pass) {
	$pattern = "/.{6,}/";
	if (0 !== preg_match($pattern, $pass)) {
		return $pass;
	}
	return FALSE;
}

/**
 *
 */ 
function is_phone($number) {
	$pattern = "/^[0-9\x20]+$/i";
	if (0 !== preg_match($pattern, $number)) {
		return $number;
	}
	return FALSE;
}

/**
 *
 */ 
function is_address($address) {
	$pattern = '/^[a-z0-9\x20\/\,\ª\º]+$/i';
	$pattern = '/^\p{L}[\p{L} _.-/]+$/u';
	$pattern = "/\S+/";
	if (0 !== preg_match($pattern, $address)) {
		return $address;
	}
	return FALSE;
}

/**
 *
 */ 
function is_url($string) {
	$pattern = "/\S+/";
//	$pattern = "/^\p{L}[\p{L} _.-]+$/u";
	if (0 !== preg_match($pattern, $string)) {
		return $string;
	}
	return FALSE;
}