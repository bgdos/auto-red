<?php
	require_once('../accesodatos/conexion.php');
	class Servicio extends Conexion
	{
		private $idServicio;
		private $descripcion;
		
		public function getIdServicio(){return $this->idServicio;}
		public function setIdServicio($valor){$this->idServicio = $valor;}
		public function getDescripcion(){return $this->descripcion;}
		public function setDescripcion($valor){$this->descripcion = $valor;}
		
		public function __construct()
		{
			$argumentos = func_get_args();
			if(func_num_args() == 0)
			{
				$this -> idServicio = 0;
				$this -> descripcion = '';
			}
			if(func_num_args() == 1)
			{
				$this -> idServicio = $argumentos[0];
				parent::abrirConexion();
				$instruccion = "SELECT ser_descripcion FROM servicio WHERE ser_id = ?";
				$comando = parent::$conexion -> prepare($instruccion);
				$comando -> bind_param('i', $this -> idServicio);
				$comando -> execute();
				$comando -> bind_result($descripcion);
				$encontro = $comando -> fetch();
				mysqli_stmt_close($comando);
				parent::cerrarConexion();
				if($encontro)
				{
					$this -> descripcion = $descripcion;
				}
				else
				{
					$this -> idServicio = 0;
					$this -> descripcion = '';
				}
			}
		}
	}
?>
