<?php
/**
 * Defines the base configurations of Safanòria installation.
 *
 * - Database settings
 * - Table prefix (if any)
 * - Root URI (BASE_URL)
 *
 * Loads settings.php
 */

/** Display errors. False by default */
/** Only set to true on production */
$display_errors = TRUE;
if ($display_errors == TRUE) {
	ini_set('display_errors', 'On');
	error_reporting(E_ALL | E_STRICT);
//	error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR | E_STRICT);
}

/**
 * Database settings  
 */
define('DB_NAME', 'safanoria-pro');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8');
define('DB_DSN', 'mysql:host=localhost;dbname=safanoria-pro');
/** Prefix added to the tables on installation. Change for multiple installations */
define('DB_TABLE_PREFIX', '');
 
/**
 * Edition ends here. Go have a tea.
 */

/** Base URL of Cucuts directory  **/
if ( !defined('ROOT') )
 	define('ROOT', dirname(dirname(__FILE__)) . '/');
 	
/**
 * Load settings. This file will load necessary files 
 * and define paths to basic directories 
 */
require_once (ROOT . 'system/core/settings.php');