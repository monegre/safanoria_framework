<?php
/**
 *
 * @package Safanoria
 * @subpackage Admin
 */

class Langs extends SF_Controller
{
	/**
	 * 
	 */
	public $current = array(
				'edit' => FALSE,
		   		'page_title' => __CLASS__,
			);
		   	
	/**
	 * 
	 */
	function __construct($query=array()) 
	{
		parent::__construct();
		
		$this->query = $query;
		/* Empty queries are set to 'index' for convenience, 
			so invalid URLs like method/an-invalid-action can return an error page as a default case
		*/
		$this->query[0] = isset($this->query[0]) && !empty($this->query[0]) ? $this->query[0] : 'index';
		$method	= $this->query[0];
		
		if ( ! Admin_user::is_logged()) 
		{
			return $this->login();
		}
		
		$this->current['page'] = $this->current['page_title'];
		
		if (method_exists($this, $method)) 
		{
			return $this->$method($this->query);
		}
		require $this->view('404');
	}
	
	/**
	 * 
	 */
	private function add($query=null) 
	{
		if ($this->post_has_token()) 
		{
			$langs = $this->lang->get_list();
			
			foreach ($langs as $code => $name) 
			{
				if ($_POST['lang'] == $code) 
				{
					$_POST['code'] = $code;
					$_POST['name'] = $name;
					$_POST['regional'] = $code;
				}
			}
			// Important
			unset($_POST['lang'],$_POST['token'],$_POST['submit']);
			
			if (Lang::create($_POST)) 
			{
				$this->redirect_with_message(array('url'=>$this->cms->url['index'], 'message'=>'post_created'));
				exit('This item was entered to the database. Click <a href="/admin">here to go back to the dashoard</a>');
			}
		}
		// Pass some vars
		$this->current['token'] = $this->tokenize();
		$this->current['page_title'] = $this->cms->message('add_lang');
		$this->current['next_action'] = $this->cms->url['add_lang'];
		// Fields
		$langs = $this->lang->get_list();
		
		require $this->view('_header', 'cms');
		require $this->view('add', 'cms/langs');
		require $this->view('_footer', 'cms');
	}
}