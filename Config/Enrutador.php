<?php namespace Config;
	class Enrutador
	{
		//new Config\Estudiante()
		//new Config\Seccion()
		private $url_controlador;
		private $controlador_funcion;
		private static $direccion_de_rutas;


		public function set_route_datas($direccion_de_rutas = [])
		{
			self::$direccion_de_rutas = $direccion_de_rutas;
		}

		public function get_route_datas($argument = null)
		{
			if($argument)
			{
				$controller_attr = explode("@", self::$direccion_de_rutas[$argument]['uses'] );
				$controller = array_shift($controller_attr);
				$method = array_shift($controller_attr);
				self::$direccion_de_rutas[$argument]['controller'] = $controller;
				self::$direccion_de_rutas[$argument]['method'] = $method;

				return self::$direccion_de_rutas[$argument];
			}
			else
				return self::$direccion_de_rutas;
		}

		public static function run(Request $request)
		{
			self::cargar_rutas_por_defecto();
			$array_url = $request->url_to_array();
			$url_controller = self::url_controller($array_url);
			$controlador = $url_controller?$url_controller[0]:"";
			$metodo = $url_controller?$url_controller[1]:"";
			$argumento = end($array_url);
			$ruta_archivo_controlador = ROOT . "Controllers" . DS . $controlador .".php";

			if(is_readable($ruta_archivo_controlador))
			{
				require_once $ruta_archivo_controlador;
				$mostrar = "Controllers\\" . $controlador;
			print_r($mostrar);
				$controlador = new $mostrar;

				print_r($controlador);
				if(isset($argumento))
					$datos = call_user_func_array(array($controlador, $metodo), $argumento);
				else
					$datos = call_user_func(array($controlador, $metodo));
			}

			//cargar vista
			$ruta_archivo_controlador = ROOT . "Views" . DS . $request->getControlador() . DS . $request->getMetodo() . ".php";

			if (is_readable($ruta_archivo_controlador)) 
				require_once $ruta_archivo_controlador;
			else
				print "No se encontro la ruta";
		}

		public static function url_controller($array_url = null)
		{
			if(!$array_url)
				return null;
			else
			{
				$routes = self::get_route_datas();
				$index = array_shift($array_url);
				$controller_method = isset($routes[$index])?$routes[$index]["uses"]:null;
				$controller_method = explode("@", $controller_method);
				return $controller_method;
			}
		}

		public static function cargar_rutas_por_defecto()
		{
			self::set_route_datas([
				'estudiantes' => 
				[
					"model" => "Estudiante",
					'uses' => 'estudiantesController@index'
				],
				'estudiantes/create' => 
				[
					"model" => "Estudiante",
					'uses' => 'estudiantesController@agregar'
				],
				'estudiantes/edit' => 
				[
					"model" => "Estudiante",
					'uses' => 'estudiantesController@editar'
				],
				'estudiantes/show' => 
				[
					"model" => "Estudiante",
					'uses' => 'estudiantesController@mostrar'
				],
				'estudiantes/delete' => 
				[
					"model" => "Estudiante",
					'uses' => 'estudiantesController@eliminar'
				],
				'secciones' => 
				[
					"model" => "Estudiante",
					'uses' => 'ClienteController@index'
				]
			]);
		}



	}
?>