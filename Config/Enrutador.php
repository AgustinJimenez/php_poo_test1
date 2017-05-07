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
			$controlador = self::get_route_datas( $request->getControlador() )['controller'];
			$metodo = self::get_route_datas( $request->getControlador() )['method'];
			$ruta_archivo_controlador = ROOT . "Controllers" . DS . $controlador .".php";
			$argumento = $request->getArgumento();
			if(is_readable($ruta_archivo_controlador))
			{
				require_once $ruta_archivo_controlador;
				$mostrar = "Controllers\\" . $controlador;
				$controlador = new $mostrar;
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

		public function cargar_rutas_por_defecto()
		{
			self::set_route_datas([
				'alumnos' => 
				[
					"model" => "Estudiante",
					'uses' => 'estudiantesController@index'
				],
				'alumnos/create' => 
				[
					"model" => "Estudiante",
					'uses' => 'estudiantesController@agregar'
				],
				'alumnos/edit' => 
				[
					"model" => "Estudiante",
					'uses' => 'estudiantesController@editar'
				],
				'alumnos/show' => 
				[
					"model" => "Estudiante",
					'uses' => 'estudiantesController@mostrar'
				],
				'alumnos/delete' => 
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