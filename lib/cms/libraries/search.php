<?php
/**
 * Safanoria's Search class
 *
 * @author Carles Jove i Buxeda
 * @version 1.0
 */

class Search
{
	public $terms = array();
	private $cond;
	private $default_columns = array('title', 'content');
	private $matches;

	/**
	 * @param string | Words to look matches for
	 * @param array | Database columns to check
	 * @return string
	 */
	public function set_query($query, $conditions=null)
	{	
		$this->query = $query;

		// Set terms
		$this->terms = explode(" ", $this->query);
		array_unshift($this->terms, $this->query);
		
		// Columns
		if (is_array($conditions)) 
		{
			foreach ($conditions as $column) 
			{
				$this->columns[] = $column;
			}
		}
		else 
		{
			foreach ($this->default_columns as $column) 
			{
				$this->columns[] = $column;
			}
		}

		// Generate SQL query
		foreach ($this->terms as $term) 
		{
			foreach ($this->columns as $column) 
			{
				$this->cond[] = "$column LIKE '%$term%'";
			}
		}
		return $this->cond = implode(" OR ", $this->cond);
	}
	
	/**
	 * Sets conditions
	 * 
	 * This functions is an alternative to set_query in case you 
	 * do not want to get results() with a SQL LIKE
	 * 
	 * @param array | Database query
	 */
	public function set_conditions($condtions)
	{	
		return $this->cond = $condtions;
	}

	/**
	 *
	 */
	public function results($models, $args) 
	{
		//$model = ucfirst($model);
		$this->user_nav_lang = isset($args['lang']) 
								? $args['lang'] 
								: $_SESSION['lang']; // Safanòria has a lang stored in SESSION by default
		
		if ( ! is_array($models)) 
		{
			$models = explode('.',$models);
		}
		// Get all models nevermind the language

		foreach ($models as $model) 
		{
			$results = $model::all(array('conditions' => $this->cond));
			// Get identifiers for new query
			foreach ($results as $result) 
			{
				$this->matches[] = $result->identifier;
			}
			// Filter matches by lang
			$finds[] = $model::all(array(
									'conditions' => array('lang=? AND identifier in(?)', $this->user_nav_lang, $this->matches)
									)
							);
		}
		
		// $finds is a multilevel array 
		// with a key for each model
		// Two models => count($finds) = 2
		for ($i = 0; $i < count($finds); $i++) 
		{
			foreach ($finds[$i] as $k) 
			{
				$list[] = $k;
			}
		}
		
		return $list;
	}
}