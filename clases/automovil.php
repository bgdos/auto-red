<?php
	require_once('../accesodatos/conexion.php');
	
	class Automovil extends Conexion
	{
		private $id;
		private $idUsuario;
		private $descripcion;
		
		public function getId() {return $this->id;}
		public function setId($value) {$this->id = $value;}
		public function getIdUsuario() {return $this->idUsuario;}
		public function setIdUsuario($value) {$this->idUsuario = $value;}
		public function getDescripcion() {return $this->descripcion;}
		public function setDescripcion($value) {$this->descripcion = $value;}
		
		public function __construct()
		{
			$argumentos = func_get_args();
			if (func_num_args() == 0)
			{
				$this -> id = '';
				$this -> idUsuario = '';
				$this -> descripcion = '';
			}
			if (func_num_args() == 1)
			{
				$this -> idUsuario = $argumentos[0];
				parent::abrirConexion();
				$instruccion = "SELECT aut_id, aut_descripcion FROM automovil WHERE aut_duenio = ?";
				$comando = parent::$conexion->prepare($instruccion);
				$comando -> bind_param('s', $this -> idUsuario);
				$comando -> execute();
				$comando -> bind_result($id, $descripcion);
				$encontro = $comando->fetch();
				mysqli_stmt_close($comando);
				parent::cerrarConexion();
				if ($encontro)
				{
					$this -> id = $id;
					$this -> descripcion = $descripcion;
				}
				else
				{
					$this -> id = '';
					$this -> idUsuario = '';
					$this -> descripcion = '';
				}
			}
			if (func_num_args() == 3)
			{
				$this -> id = $argumentos[0];
				$this -> descripcion = $argumentos[1];
				$this -> idUsuario = $argumentos[2];
			}
		}
		public function Agregar()
		{
			parent::abrirConexion();
			$instruccion = "INSERT INTO automovil(aut_id, aut_descripcion, aut_duenio) VALUES('?', '?', ?);";
			$comando = parent::$conexion -> prepare($instruccion);
			$comando = bind_param('s, s, s', $this -> id, $this -> descripcion, $this -> IdUsuario());
			$comando->execute();
			mysqli_stmt_close($comando);
			parent::cerrarConexion();
		}
	}
?>
