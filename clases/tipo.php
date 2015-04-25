<?php
	require_once('../accesodatos/conexion.php');
	
	class Tipo extends Conexion
	{
		private $idTipo;
		private $descripcion;
		
		public function getIdTipo(){return $this->idTipo;}
		public function setIdTipo($valor){$this->idTipo = $valor;}
		public function getDescripcion(){return $this->descripcion;}
		public function setDescripcion($valor){$this->descripcion = $valor;}
		
		public function __construct()
		{
			$argumentos = func_get_args();
			if(func_num_args() == 0)
			{
				$this -> idTipo = 0;
				$this -> descripcion = '';
			}
			if(func_num_args() == 1)
			{
				$this -> idTipo = $argumentos[0];
				parent::abrirConexion();
				$instruccion = "SELECT tip_descripcion FROM tipo WHERE tip_id = ?";
				$comando = parent::$conexion -> prepare($instruccion);
				$comando -> bind_param('s', $this -> idTipo);
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
					$this -> idTipo = 0;
					$this -> descripcion = '';
				}
			}
		}
	}
?>
