<?php
session_start();


	//error_reporting(-1);
	//ini_set('display_errors', 1);
	
		
	$application_folder = 'application';
	$system_path = '';
	
	if (realpath($system_path) != false)
	{
		$system_path = realpath($system_path).'/';
	}

	$system_path = rtrim($system_path, '/').'/';
	
	define('BASEPATH', str_replace("\\", "/", $system_path));
	
	define("BASE_URL", "http://" . $_SERVER['HTTP_HOST']. '/mailhack/');	
	
	spl_autoload_register(function ($class) 
	{
		$class_n = explode('_',$class);
		if($class_n[0] == 'm')
		{
			include  BASEPATH.'/application/models/'.$class . '.php';
		}
		else
		{
			include  BASEPATH.'/system/core/'.$class . '.php';
		}
	});
	
	
	
	if(isset($_REQUEST["module"]) && isset($_REQUEST["method"]) && (isset($_SESSION["_USER"]) || $_REQUEST["module"]=='welcome' || $_REQUEST["module"]=='cron'))
	{
		
		$filename = BASEPATH.'application/modules/'.$_REQUEST["module"].'.php';		
		if (file_exists($filename)) 
		{
			$class = $_REQUEST["module"];
			$method = $_REQUEST["method"];

			include $filename;
			$handle = new $class();
			$handle->$method();
		}
		else 
		{
			//не обработано
		}
	}
	else
	{		
		$filename = BASEPATH.'application/modules/welcome.php';
		
		if (file_exists($filename)) 
		{
			$class = "welcome";
			$method = "index";
			
			include $filename;
			$handle = new $class();
			$handle->$method();		
		}		
	}
	
	function debug($arr)
	{
		echo '<pre>';
		print_r($arr);
		echo '</pre>';
	}

?>