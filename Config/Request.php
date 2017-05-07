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
				//$ruta = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
				//$ruta = explode("/", $ruta);
				$ruta = explode("/", $requested_url);
				unset($ruta[0]);//delete first element
				$ruta = array_values($ruta);//reorder keys
				//$ruta = array_filter($ruta);
				if($ruta[0] == "index.php")
					$this->controlador = "estudiantes";//index template 
				else
					$this->controlador = strtolower(array_shift($ruta));//obtiene alumnos de /alumnos/create

				$this->metodo = strtolower(array_shift($ruta));//obtiene create de /alumnos/create

				if(!$this->metodo)//si no hay mentodo que traiga index
					$this->metodo = "index";
					
				$this->argumento = $ruta;
			}
			else
			{
				$this->controlador = "estudiantes";
				$this->metodo = "index";
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