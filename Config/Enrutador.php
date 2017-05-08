<?php namespace Config;
	class Enrutador
	{
		//new Config\Estudiante()
		//new Config\Seccion()
		private $url_controlador;
		private $controlador_funcion;
		private static $direccion_de_rutas;
		public static function run(Request $request)
		{
			self::cargar_rutas_por_defecto();
			$array_url = $request->convert_url_to_array();
			$controller_and_his_method = self::get_controller_and_method( $request->get_url() );
			$controlador = $controller_and_his_method['controller'];
			$metodo = $controller_and_his_method['method'];
			$argumento = $request->get_argument();
			$ruta_archivo_controlador = ROOT . "Controllers" . DS . $controlador .".php";
			self::call_controller($ruta_archivo_controlador, $controlador, $metodo, $argumento);
			$view_path = self::view('template');
			self::call_view($view_path);
		}
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

		public static function call_view($view_path = "")
		{
			if (is_readable($view_path)) 
				require_once $view_path;
			else
				print "No se encontro la ruta";
		}
		public static function call_controller($ruta_archivo_controlador = "", $controlador = "", $metodo = "", $argumento = null)
		{
			if(is_readable($ruta_archivo_controlador))
			{
				require_once $ruta_archivo_controlador;
				$mostrar = "Controllers\\" . $controlador;
				$controlador = new $mostrar;
				$datos = self::call_controller_method($controlador, $metodo, $argumento);
			}
			else
				print "No se encontro la ruta";
		}

		public static function call_controller_method($controlador, $metodo, $argumento)
		{
			if( $argumento )
				$datos = call_user_func_array(array($controlador, $metodo), [$argumento]);
			else
				$datos = call_user_func(array($controlador, $metodo));

			return $datos;
		}

		public function view($path)
		{
			$view_path = ROOT . "Views/" . $path . ".php";
			return $view_path;
		}

		public static function get_controller_and_method($index)
		{
			$index = ltrim($index, '/');
			$routes_list = self::get_route_datas();
			$controller_method = $routes_list[$index]['uses'];
			$controller_and_method = explode("@", $controller_method);
			$controlador = $controller_and_method?$controller_and_method[0]:"";
			$metodo = $controller_and_method?$controller_and_method[1]:"";
			return ['controller' => $controlador, 'method' => $metodo];
			
		}

		public static function cargar_rutas_por_defecto()
		{
			self::set_route_datas
			([
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