<?php
/**
 *
 * @package Safanoria
 * @subpackage CMS
 */
 
class Meta_content extends ActiveRecord\Model
{
	static $validates_uniqueness_of = array(
		array('nice_url', 'message' => 'title is repeated!'),
//		array(array('nice_url','in_table'), 'message' => 'blah and bleh!')
	);
}