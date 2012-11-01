<?php
/** 
 * Locale class
 * This is a draft, currently not in use
 * This class should do some basic locale functions unrealated to a database  
 */
 
class Locale
{	
	/**
	 * Returns an ordered array with the user agent language preferences.
	 *
	 * @author Harald Hope
	 * @link http://techpatterns.com/downloads/php_language_detection.php
	 * @version 0.3.6
	 * @copyright 8 December 2008
	 * @returns array | FALSE
	 */
	public function get_user_agent_langs()
	{
		// init
		$user_languages = array();
	
		//check to see if language is set
		if ( isset( $_SERVER["HTTP_ACCEPT_LANGUAGE"] ) )
		{
			$languages = strtolower( $_SERVER["HTTP_ACCEPT_LANGUAGE"] );
			// $languages = ' fr-ch;q=0.3, da, en-us;q=0.8, en;q=0.5, fr;q=0.3';
			// need to remove spaces from strings to avoid error
			$languages = str_replace( ' ', '', $languages );
			$languages = explode( ",", $languages );
	
			foreach ( $languages as $language_list )
			{
				// pull out the language, place languages into array of full and primary
				// string structure:
				$temp_array = array();
				// slice out the part before ; on first step, the part before - on second, place into array
				$temp_array[0] = substr( $language_list, 0, strcspn( $language_list, ';' ) );//full language
				$temp_array[1] = substr( $language_list, 0, 2 );// cut out primary language
				//place this array into main $user_languages language array
				$user_languages[] = $temp_array;
			}
			return $user_languages;
		}
		return FALSE;
	}
	
	/**
	 * Strips off the languaged flagged keys
	 */
	function get_lang_fields_off($post) 
	{
		$array = array();
		foreach ($post as $key => $value) 
		{	
			if (preg_match('/^(_)+([a-z]{2})/', substr($key, -3))) 
			{		
				$array[$key] = $value;			
			}
		}
		return $array;
	}
}