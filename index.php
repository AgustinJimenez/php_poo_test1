<?php
	define('DS', DIRECTORY_SEPARATOR);
	define('ROOT', realpath(dirname(__FILE__)).DS);
	define('URL', (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/");
	require 'vendor/autoload.php';
	require 'Config/database.php';
	require_once "Config/Autoload.php";
	Config\Autoload::run();
	//print_r("requested url is= ".$_SERVER[REQUEST_URI]);
	$request = new Config\Request();
	Config\Enrutador::run($request);
	//require_once "Views/template.php";
	
?>