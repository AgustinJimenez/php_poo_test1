<?php namespace Models;

	class Conexion
	{

		private $datos = array
		(
			"host" => "localhost",
			"user" => "root",
			"pass" => "root",
			"db" => "test1"
		);

		private $con;

		public function __construct()
		{
			$this->con = new \mysqli($this->datos['host'], $this->datos['user'], $this->datos['pass'], $this->datos['db']);
		}

		public function consultaSimple($sql)
		{
			$this->con->query($sql);
		}

		public function consultaRetorno($sql)
		{
			$datos = $this->con->query($sql);

			while ( $tmp = mysqli_fetch_assoc($datos) ) 
				$tmp_array[] = $tmp;
			
			return isset($tmp_array)?$tmp_array:null;
		}
	}

?>