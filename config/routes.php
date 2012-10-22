<?php
/**
 * Routes
 *
 * Here you can re-map URL requests to specific controller functions.
 * Typically there is a one-to-one relationship between a URL string
 * and its corresponding controller class/method. The segments in a
 * URL normally follow this pattern:
 *
 *  example.com/class/method/id/
 *
 * In some instances, however, you may want to remap this relationship
 * so that a different class/function is called than the one
 * corresponding to the URL.
 *
 *  Example:
 *  $route['canela/en-rama'] = 'class/my_method';
 */

$route['default_controller'] = 'home';
$route['default_method'] = 'index';

// Custom routes
$route['biografia'] = 'home/biografia';
$route['terapia-individual'] = 'home/terapia';
$route['grups-de-crianca'] = 'home/grupos';