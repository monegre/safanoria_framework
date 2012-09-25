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

/** 
 * Display errors. FALSE by default
 * Only set to TRUE on developement 
 */
$display_errors = FALSE;
if ($display_errors === TRUE) {
	ini_set('display_errors', 'On');
	error_reporting(E_ALL | E_STRICT);
//	error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR | E_STRICT);
} else {
	ini_set('display_errors', 'Off');
}

/**
 * Database settings  
 */
define ('DB_NAME', '[db_name]'); // Database name
define ('DB_USER', '[db_user]'); // Database user
define ('DB_PASS', '[db_pass]'); // Database pass
define ('DB_HOST', '[db_host]'); // Database host
define ('DB_CHARSET', 'utf8'); // Character encoding
define ('DB_DSN', 'mysql:host=[db_host];dbname=[db_name]'); // If you're ever using a rough PDO connection
define ('DB_TABLE_PREFIX', '[db_table_prefix]'); // Tables prefix
 
/**
 * Edition ends here. Go have a tea.
 */
/** Define the root of Safanòria's installation */
 if ( !defined('ROOT') )
 	define('ROOT', dirname(dirname(__FILE__)) . '/');

/** Sets common variables and paths to directories **/
require_once (ROOT . 'config/settings.php');