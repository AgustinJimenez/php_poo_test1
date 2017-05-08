<?php namespace Config;
	class Request
	{
		private $url;
		private $arguments;

		public function __construct()
		{
			$this->url = $_SERVER['REQUEST_URI'];
		}
		public function get_url()
		{
			return $this->url;
		}

		public function get_argument()
		{
			$url_array = $this->convert_url_to_array();
			$argument = (int)end( $url_array );
			return $argument?$argument:null;
		}

		public function convert_url_to_array()
		{
			$requested_url = $this->get_url();
			$url_on_array = explode("/", $requested_url);
			unset($url_on_array[0]);
			array_values($url_on_array);
			return $url_on_array;
		}
	}
?>