<?php 
/**
 * Checks PHP version
 * Checks whether to display errors or not
 * Defines paths to core directories (alphabetically ordered)
 * Includes everything you need to run Safanòria
 *
 * You really shouldn't change any of these unless you have good reasons
 * and know what you are doing. 
 */ 

/** Required PHP version */
if ( ! defined('PHP_VERSION_ID') OR PHP_VERSION_ID < 50300) 
{
	die('Safanoria requires PHP 5.3 or higher');
}

/** 
 * Display errors. FALSE by default
 * Only set to TRUE on developement 
 */
if ($config['display_errors'] === TRUE) 
{
	ini_set('display_errors', 'On');
	error_reporting(E_ALL | E_STRICT);
//	error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR | E_STRICT);
} 
else 
{
	ini_set('display_errors', 'Off');
}

/** Define the root of Safanòria's installation */
 if ( !defined('ROOT') )
 	define('ROOT', dirname(dirname(__FILE__)) . '/');

/** Store first level directories */
define ('APP'		, 'app/');
define ('CONFIG'	, 'config/');
define ('DB'		, 'db/');
//define ('DOC'		, 'doc/');
define ('LIB'		, 'lib/');
define ('PUB'		, 'public/');

/** Store second level directories */
define ('AR'		, 'active_record/');
define ('CMS'		, 'cms/');
define ('SYS'		, 'safanoria/');

/** Store third level directories */
define ('CLASSES'	, 'classes/');
define ('CONTROLS'	, 'controllers/');
define ('CORE'		, 'core/');
//define ('FALLS'		, 'fallbacks/');
define ('HELPS'		, 'helpers/');
define ('LANG'		, 'langs/');
define ('LIBS'		, 'libraries/');
define ('MODELS'	, 'models/');
define ('MODULES'	, 'modules/');
define ('VIEWS'		, 'views/');

/** Include URLs for global usage */
require ( ROOT . CONFIG . 'url.php');
require ( ROOT . LIB . SYS . LIBS . 'memory.php');

/** Include global functions */
require ( ROOT . LIB . SYS . HELPS . 'setters.php');
require ( ROOT . LIB . SYS . HELPS . 'filter.php');
require ( ROOT . LIB . SYS . HELPS . 'escape.php');
require ( ROOT . LIB . SYS . HELPS . 'clean.php');
require ( ROOT . LIB . SYS . CORE . 'functions.php');

/** Include core classes */
require ( ROOT . LIB . SYS . CORE . 'safanoria.php');
require ( ROOT . LIB . SYS . CORE . 'controller.php');

/** Include Active Record files */
require ( ROOT . LIB . AR . 'Singleton.php');
require ( ROOT . LIB . AR . 'Config.php');
require ( ROOT . LIB . AR . 'Utils.php');
require ( ROOT . LIB . AR . 'DateTime.php');
require ( ROOT . LIB . AR . 'Model.php');
require ( ROOT . LIB . AR . 'Table.php');
require ( ROOT . LIB . AR . 'ConnectionManager.php');
require ( ROOT . LIB . AR . 'Connection.php');
require ( ROOT . LIB . AR . 'SQLBuilder.php');
require ( ROOT . LIB . AR . 'Reflections.php');
require ( ROOT . LIB . AR . 'Inflector.php');
require ( ROOT . LIB . AR . 'CallBack.php');
require ( ROOT . LIB . AR . 'Exceptions.php');

spl_autoload_register('__autoload');

ActiveRecord\Config::initialize(function($cfg)
{
	$cfg->set_model_directory(ROOT . APP . MODELS);
	// $cfg->set_connections(array('development' => 'mysql://user:pass@localhost/mydb;charset=utf8'));
	$cfg->set_connections(array('development' => 'mysql://'.DB_USER.':'.DB_PASS.'@'.DB_HOST.'/'.DB_NAME.';charset='.DB_CHARSET.''));
});