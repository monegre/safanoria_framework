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
$config['display_errors'] = TRUE;

/** Database settings */
define ('DB_NAME', 'guadalupe'); // Database name
define ('DB_USER', 'root'); // Database user
define ('DB_PASS', 'root'); // Database pass
define ('DB_HOST', 'localhost'); // Database host
define ('DB_CHARSET', 'utf8'); // Character encoding
define ('DB_DSN', 'mysql:host=localhost;dbname=guadalupe'); // If you're ever using a rough PDO connection
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