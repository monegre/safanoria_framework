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

$config['underscore_routes'] = TRUE;
$config['display_errors'] = FALSE;

/** Database settings */
define ('DB_NAME', '[db_name]'); // Database name
define ('DB_USER', '[db_user]'); // Database user
define ('DB_PASS', '[db_pass]'); // Database pass
define ('DB_HOST', '[db_host]'); // Database host
define ('DB_CHARSET', 'utf8'); // Character encoding
define ('DB_DSN', 'mysql:host=[db_host];dbname=[db_name]'); // If you're ever using a rough PDO connection
define ('DB_TABLE_PREFIX', '[db_table_prefix]'); // Tables prefix
 

/** Configurations ends here. Go have a tea */
/** Sets common variables and paths to directories **/
$filename = '/settings.php';
if(file_exists(dirname(__FILE__).$filename))
{
	require_once(dirname(__FILE__).$filename);
}
else
{
	exit('We could not find the '.$filename.' file. This is a fatal error.');
}