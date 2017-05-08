<?php namespace Config;
	class Request
	{
		private $controlador;
		private $metodo;
		private $argumento;
		public function __construct()
		{
			$requested_url = $_SERVER[REQUEST_URI];
			if($requested_url)
			{
				$url_on_array = explode("/", $requested_url);
				unset($url_on_array[0]);
				$controlador = array_shift($url_on_array);
				$metodo = array_shift($url_on_array);
				$argumento = array_shift($url_on_array);

				$this->controlador = $controlador;

				$this->metodo = $metodo;

				if(is_numeric($argumento))
					$this->argumento = is_numeric($argumento)?(int)$argumento:null;
				else
					return null;
			}
		}
		public function getControlador()
		{
			return $this->controlador;
		}
		public function getMetodo()
		{
			return $this->metodo;
		}
		public function getArgumento()
		{
			return $this->argumento;
		}
	}
?>