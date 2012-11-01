<?php
/**
 * Basic functions, shared by both the admin panel and the skin
 */

function __autoload($class) 
{
	$dirs = array(
				0 => ROOT . LIB . CMS,
				1 => ROOT . LIB . CMS . CONTROLS,
				2 => ROOT . LIB . CMS . MODELS,
				3 => ROOT . LIB . CMS . LIBS,
				4 => ROOT . LIB . SYS . LIBS,
				5 => ROOT . LIB . SYS . CORE,
				6 => ROOT . APP . CONTROLS,
				7 => ROOT . APP . MODELS,
				8 => ROOT . APP . LIBS,
				9 => ROOT . LIB . CMS . CORE
			);
	
	$found = FALSE;
	$dir = null;
	for ($i = 0; $i < count($dirs); $i++) 
	{
		if (file_exists($dirs[$i] . strtolower($class) . '.php')) 
		{
			$found = TRUE;
			$dir = $dirs[$i];
			require ($dirs[$i] . strtolower($class) . '.php');
			break;
		}
		continue;
	}
	
	if ($found === FALSE) 
	{
		throw new Exception("The requested class {$class} could not be found in the directory {$dir}");	
	}
}