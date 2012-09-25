<?php
/**
 *
 * @package Safanoria
 * @subpackage CMS
 */
 
class Category extends ActiveRecord\Model
{
	static $validates_presence_of = array(
		array('title', 'message' => 'Title field cannot be empty')
	);
}