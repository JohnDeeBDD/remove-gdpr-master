<?php

namespace GdprRollbackFeatures;

function autoload($className){

	$NS = __NAMESPACE__;
	$NSlenght = strlen($NS);
	$front = substr($className, 0, $NSlenght);
	
	if ($front != $NS){
		return;
	}
	$NSlenght = $NSlenght + 1;
	$className = substr($className, $NSlenght);
	$plugin_dir_path = plugin_dir_path(__FILE__);
	
	//Check for ".class.php":
	$fileName = $plugin_dir_path .$className . '.class.php';

	if (file_exists($fileName)) {
		include_once($fileName);
	}else{
		//Check for ".trait.php":
		$fileName = $plugin_dir_path . $className . '.trait.php';
		if (file_exists($fileName)) {
			include_once($fileName);
		}
	}
}

$autoloadFunctionName = __NAMESPACE__. "\autoload";
spl_autoload_register($autoloadFunctionName);