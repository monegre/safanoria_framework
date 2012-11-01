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
$config['enable_database'] = TRUE;


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