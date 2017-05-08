<?php namespace Config;
	class Request
	{
		private $url;

		public function __construct()
		{
		}
		public function url_to_array()
		{
			$requested_url = $_SERVER['REQUEST_URI'];
			$url_on_array = explode("/", $requested_url);
			unset($url_on_array[0]);
			array_values($url_on_array);
			$url_on_array;
			return $url_on_array;
		}
	}
?>