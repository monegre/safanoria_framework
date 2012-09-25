<?php
/**
 *
 * @package Safanoria
 * @subpackage CMS
 */
 
class Media extends ActiveRecord\Model
{
	static $validates_presence_of = array(
		array('title', 'message' => 'This field cannot be empty'),
		array('content', 'message' => 'This field cannot be empty'),
		array('description', 'message' => 'This field cannot be empty')
	);
}