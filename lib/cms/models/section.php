<?php
/**
 *
 * @package Safanoria
 * @subpackage CMS
 */
 
class Section extends ActiveRecord\Model
{
	static $validates_presence_of = array(
		array('title', 'message' => 'Title field cannot be empty')
	);
	/*
	NOT WORKING! WHY?
	*/
	static $validates_numericality_of = array(
		array('display_order', 'only_integer' => true)
	);
}