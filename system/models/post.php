<?php
/**
 *
 * @package Safanoria
 * @subpackage CMS
 */
 
class Post extends ActiveRecord\Model
{
	static $validates_presence_of = array(
		array('title', 'message' => 'This field cannot be empty'),
		array('content', 'message' => 'This field cannot be empty'),
		array('description', 'message' => 'This field cannot be empty'),
		array('author', 'message' => 'Posts must have an author'),
		array('section', 'message' => 'Posts must belong to a site section')
	);
}