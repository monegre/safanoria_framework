<?php
/** 
 * Lang class  
 */
 
class Lang extends ActiveRecord\Model
{
	
//	public $admin = array();
//	public $nav = array();
	
//	public function __construct() 
//	{
//		
//		
//		
//		$this->nav = array(
//							 	'id' => '1',
//							 	'name' => 'català',
//							 	'code' => 'ca',
//							 	'regional' => 'es_ca',
//							 );
//	}
	
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
	 * Returns an array with the active site languages
	 * 
	 */
	public function get_active() 
	{
		return Lang::all();
	}
	
	/**
	 * Returns an array of world languages
	 * 
	 */
	public function get_list() 
	{
		return self::$a_languages;
	}
	
	/**
	 * Returns the name of language from the two letter code
	 */
	public function get_name($code) 
	{
		$hola = Lang::all(array('code'=>$code));
		foreach ($hola as $lang) {
			$name = $lang->name;
		}
		return $name;
	}
	
	/**
	 * Returns TRUE is is an active language
	 */
	public function is_active($code) 
	{
		$langs = Lang::all(array('code'=>$code));
		foreach ($langs as $lang) 
		{
			if($lang->code == $code)
				return TRUE;
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
	
	/**
	 * An array with a lot of languages.
	 * Not in use, but could be useful at some point.
	 */
	static $a_languages = array(
		'af' => 'Afrikaans',
		'sq' => 'Albanian',
//		'ar-dz' => 'Arabic (Algeria)',
//		'ar-bh' => 'Arabic (Bahrain)',
//		'ar-eg' => 'Arabic (Egypt)',
//		'ar-iq' => 'Arabic (Iraq)',
//		'ar-jo' => 'Arabic (Jordan)',
//		'ar-kw' => 'Arabic (Kuwait)',
//		'ar-lb' => 'Arabic (Lebanon)',
//		'ar-ly' => 'Arabic (libya)',
//		'ar-ma' => 'Arabic (Morocco)',
//		'ar-om' => 'Arabic (Oman)',
//		'ar-qa' => 'Arabic (Qatar)',
//		'ar-sa' => 'Arabic (Saudi Arabia)',
//		'ar-sy' => 'Arabic (Syria)',
//		'ar-tn' => 'Arabic (Tunisia)',
//		'ar-ae' => 'Arabic (U.A.E.)',
//		'ar-ye' => 'Arabic (Yemen)',
		'ar' => 'Arabic',
		'hy' => 'Armenian',
		'as' => 'Assamese',
		'az' => 'Azeri',
		'eu' => 'Basque',
		'be' => 'Belarusian',
		'bn' => 'Bengali',
		'bg' => 'Bulgarian',
//		'es-ar' => 'Spanish (Argentina)',
//		'es-bo' => 'Spanish (Bolivia)',
//		'es-cl' => 'Spanish (Chile)',
//		'es-co' => 'Spanish (Colombia)',
//		'es-cr' => 'Spanish (Costa Rica)',
//		'es-do' => 'Spanish (Dominican Republic)',
//		'es-ec' => 'Spanish (Ecuador)',
//		'es-sv' => 'Spanish (El Salvador)',
//		'es-gt' => 'Spanish (Guatemala)',
//		'es-hn' => 'Spanish (Honduras)',
//		'es-mx' => 'Spanish (Mexico)',
//		'es-ni' => 'Spanish (Nicaragua)',
//		'es-pa' => 'Spanish (Panama)',
//		'es-py' => 'Spanish (Paraguay)',
//		'es-pe' => 'Spanish (Peru)',
//		'es-pr' => 'Spanish (Puerto Rico)',
//		'es-us' => 'Spanish (United States)',
//		'es-uy' => 'Spanish (Uruguay)',
//		'es-ve' => 'Spanish (Venezuela)',
		'es' => 'Castellano',
		'ca' => 'Català',
//		'zh-cn' => 'Chinese (China)',
//		'zh-hk' => 'Chinese (Hong Kong SAR)',
//		'zh-mo' => 'Chinese (Macau SAR)',
//		'zh-sg' => 'Chinese (Singapore)',
//		'zh-tw' => 'Chinese (Taiwan)',
		'zh' => 'Chinese',
		'hr' => 'Croatian',
		'cs' => 'Czech',
		'da' => 'Danish',
		'div' => 'Divehi',
//		'nl-be' => 'Dutch (Belgium)',
		'nl' => 'Dutch (Netherlands)',
//		'en-au' => 'English (Australia)',
//		'en-bz' => 'English (Belize)',
//		'en-ca' => 'English (Canada)',
//		'en-ie' => 'English (Ireland)',
//		'en-jm' => 'English (Jamaica)',
//		'en-nz' => 'English (New Zealand)',
//		'en-ph' => 'English (Philippines)',
//		'en-za' => 'English (South Africa)',
//		'en-tt' => 'English (Trinidad)',
//		'en-gb' => 'English (United Kingdom)',
//		'en-us' => 'English (United States)',
//		'en-zw' => 'English (Zimbabwe)',
		'en' => 'English',
		'us' => 'English (United States)',
		'et' => 'Estonian',
		'fo' => 'Faeroese',
		'fa' => 'Farsi',
		'fi' => 'Finnish',
//		'fr-be' => 'French (Belgium)',
//		'fr-ca' => 'French (Canada)',
//		'fr-lu' => 'French (Luxembourg)',
//		'fr-mc' => 'French (Monaco)',
//		'fr-ch' => 'French (Switzerland)',
		'fr' => 'French (France)',
		'mk' => 'FYRO Macedonian',
		'gd' => 'Gaelic',
		'ka' => 'Georgian',
//		'de-at' => 'German (Austria)',
//		'de-li' => 'German (Liechtenstein)',
//		'de-lu' => 'German (Luxembourg)',
//		'de-ch' => 'German (Switzerland)',
		'de' => 'German (Germany)',
		'el' => 'Greek',
		'gu' => 'Gujarati',
		'he' => 'Hebrew',
		'hi' => 'Hindi',
		'hu' => 'Hungarian',
		'is' => 'Icelandic',
		'id' => 'Indonesian',
//		'it-ch' => 'Italian (Switzerland)',
		'it' => 'Italian (Italy)',
		'ja' => 'Japanese',
		'kn' => 'Kannada',
		'kk' => 'Kazakh',
		'kok' => 'Konkani',
		'ko' => 'Korean',
		'kz' => 'Kyrgyz',
		'lv' => 'Latvian',
		'lt' => 'Lithuanian',
		'ms' => 'Malay',
		'ml' => 'Malayalam',
		'mt' => 'Maltese',
		'mr' => 'Marathi',
		'mn' => 'Mongolian (Cyrillic)',
		'ne' => 'Nepali (India)',
//		'nb-no' => 'Norwegian (Bokmal)',
//		'nn-no' => 'Norwegian (Nynorsk)',
		'no' => 'Norwegian (Bokmal)',
		'or' => 'Oriya',
		'pl' => 'Polish',
//		'pt-br' => 'Portuguese (Brazil)',
		'pt' => 'Portuguese (Portugal)',
		'pa' => 'Punjabi',
		'rm' => 'Rhaeto-Romanic',
		'ro-md' => 'Romanian (Moldova)',
		'ro' => 'Romanian',
		'ru-md' => 'Russian (Moldova)',
		'ru' => 'Russian',
		'sa' => 'Sanskrit',
		'sr' => 'Serbian',
		'sk' => 'Slovak',
		'ls' => 'Slovenian',
		'sb' => 'Sorbian',
		'sx' => 'Sutu',
		'sw' => 'Swahili',
//		'sv-fi' => 'Swedish (Finland)',
		'sv' => 'Swedish',
		'syr' => 'Syriac',
		'ta' => 'Tamil',
		'tt' => 'Tatar',
		'te' => 'Telugu',
		'th' => 'Thai',
		'ts' => 'Tsonga',
		'tn' => 'Tswana',
		'tr' => 'Turkish',
		'uk' => 'Ukrainian',
		'ur' => 'Urdu',
		'uz' => 'Uzbek',
		'vi' => 'Vietnamese',
		'xh' => 'Xhosa',
		'yi' => 'Yiddish',
		'zu' => 'Zulu' 
		);
}