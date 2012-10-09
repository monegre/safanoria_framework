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
	private $default_columns =array('title', 'content');

	/**
	 * @param string | Words to look matches for
	 * @param array | Database columns to check
	 * @return string
	 */
	public function generate_conditions($query, $conditions=null)
	{	
		$this->query = $query;

		// Set terms
		$this->terms = explode(" ", $this->query);
		array_unshift($this->terms, $this->query);
		
		// Columns
		if (is_array($$conditions)) 
		{
			foreach ($$conditions as $column) 
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

		var_dump($this->columns);

		// Generem condicions
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
	 *
	 */
	public function get_results_for($model) 
	{
		$model = ucfirst($model);
		
		// Cerquem a TOTS els projectes, independentment de la llengua	
		$results = $model::all(array('conditions' => array($this->cond)));
		
		// Fem un grupe amb els identificadors
		foreach ($results as $result) 
		{
			$matches[] = $result->identifier;
		}
		
		// Recerca final filtrada ja per l'idioma
		$results = $model::all(array(
									'conditions' => array('lang=? AND identifier in(?)', $this->user_nav_lang, $matches)
									)
								);
	}
}