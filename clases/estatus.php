<?php
	require_once('../accesodatos/conexion.php');
	
	class Estatus extends Conexion
	{
		private $idEstatus;
		private $descripcion;
		
		public function getIdEstatus(){return $this->idEstatus;}
		public function setIdEstatus($valor){$this->idEstatus = $valor;}
		public function getDescripcion(){return $this->descripcion;}
		public function setDescripcion($valor){$this->descripcion = $valor;}
		
		public function __construct()
		{
			$argumentos = func_get_args();
			if(func_num_args() == 0)
			{
				$this -> idEstatus = 0;
				$this -> descripcion = '';
			}
			if(func_num_args() == 1)
			{
				$this -> idEstatus = $argumentos[0];
				parent::abrirConexion();
				$instruccion = "SELECT est_descripcion FROM estatus WHERE est_id = ?";
				$comando = parent::$conexion -> prepare($instruccion);
				$comando -> bind_param('i', $this -> idEstatus);
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
					$this -> idEstatus = 0;
					$this -> descripcion = '';
				}
			}
		}
	}
?>
