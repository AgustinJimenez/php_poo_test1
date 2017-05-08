<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title></title>
</head>
<body>


<?php
	
	define('DS', DIRECTORY_SEPARATOR);
	define('ROOT', realpath(dirname(__FILE__)).DS);
	define('URL', (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/");
	require_once "Config/Autoload.php";
	Config\Autoload::run();

	//print_r("requested url is= ".$_SERVER[REQUEST_URI]);

	$request = new Config\Request();

	Config\Enrutador::run($request);

	//require_once "Views/template.php";
	
	//Config\Enrutador::run(new Config\Request());
	

?>

</body>
</html>