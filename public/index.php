<?php 
/** 
 * This file loads the config.php file, which will set some basics
 * Config.php will load settings.php, which will define paths to files and load all of necessary libraries
 *
 * This file also calls de Routing() function, which calls the correspondent controller
 */

require_once ( dirname(dirname(__FILE__)) . '/config/config.php' );

/** Get the $url and send it to the router */
$url = isset($_GET['url']) ? $_GET['url'] : "home";
Routing($url);