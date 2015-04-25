<?php
	require_once('../accesodatos/conexion.php');
	
	Class Ubicacion extends Conexion
	{
		private $id;
		private $idUsuario;
		private $latitud;
		private $longitud;
		
		public function getId() {return $this->id;}
		public function setId($value) {$this->id = $value;}
		public function getIdUsuario() {return $this->idUsuario;}
		public function setIdUsuario($value) {$this->idUsuario = $value;}
		public function getLatitud() {return $this->latitud;}
		public function setLatitud($value) {$this->latitud = $value;}
		public function getLongitud(){return $this->longitud;}
		public function setLongitud($value) {$this->longitud = $value;}
		
		public function __construct()
		{
			$argumentos = func_get_args();
			if (func_num_args() == 0)
			{
				$this->id = 0;
				$this -> idUsuario = '';
				$this->latitud = 0;
				$this->longitud = 0;
			}
			if (func_num_args() == 1)
			{
				$this -> idUsuario = $argumentos[0];
				parent:: abrirConexion();
				$instruccion = "select ubi_id, ubi_latitud, ubi_longitud FROM ubicacion WHERE ubi_id_usuario = ?";
				$comando = parent::$conexion -> prepare($instruccion);
				$comando -> bind_param('s', $this -> idUsuario);
				$comando->execute();
				$comando->bind_result($id, $latitud, $longitud);
				$encontro = $comando->fetch();
				mysqli_stmt_close($comando);
				parent::cerrarConexion();
				if($encontro)
				{
					$this->id = $id;
					$this->latitud = $latitud;
					$this->longitud = $longitud;
				}
				else
				{
					$this->id = '';
					$this -> idUsuario = '';
					$this->latitud = 0;
					$this->longitud = 0;
				}
			}
			if (func_num_args() == 3)
			{
				$this -> idUsuario = $argumentos[0];
				$this -> latitud = $argumentos[1];
				$this -> longitud = $argumentos[2];
			}
		}
		public function Agregar()
		{
			parent::abrirConexion();
			$instruccion = "INSERT INTO ubicacion(ubi_id_usuario, ubi_latitud, ubi_longitud) VALUES(?, ?, ?);";
			$comando = parent::$conexion->prepare($instruccion);
			$comando->bind_param('sdd', $this -> idUsuario, $this->latitud, $this->longitud);
			$comando->execute();
			mysqli_stmt_close($comando);
			parent::cerrarConexion();
		}
	}
?>
