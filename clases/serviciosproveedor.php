<?php
	require_once('../accesodatos/conexion.php');
	require_once('servicio.php');
	require_once('usuario.php');
	
	class ServiciosProveedor extends Conexion
	{
		private $idSP;
		private $servicio;
		private $proveedor;
		
		public function getIdSp(){return $this->idSP;}
		public function setIdSp($valor){$this->idSP = $valor;}
		public function getServicio(){return $this->servicio;}
		public function setServicio($valor){$this->servicio = new Servicio($valor);}
		public function getProveedor(){return $this->proveedor;}
		public function setProveedor($valor){$this->proveedor = new Usuario($valor);}
		public function __construct()
		{
			$argumentos = func_get_args();
			if(func_num_args() == 0)
			{
				$this -> idSP = 0;
				$this -> servicio = new Servicio();
				$this -> proveedor = new Usuario();
			}
			else if(func_num_args() == 1)
			{
				$this -> idSP = $argumentos[0];
				parent::abrirConexion();
				$instruccion = "SELECT sp_id_servicio, sp_id_proveedor FROM servicios_proveedor WHERE sp_id = ?";
				$comando = parent::$conexion -> prepare($instruccion);
				$comando -> bind_param('i', $argumentos[0]);
				$comando -> execute();
				$comando -> bind_result($idServicio, $idProveedor);
				$encontro = $comando -> fetch();
				mysqli_stmt_close($comando);
				parent::cerrarConexion();
				if($encontro)
				{
					$this -> servicio = new Servicio($idServicio);
					$this -> proveedor = new Usuario($idProveedor);
				}
				else
				{
					$this -> idSP = 0;
					$this -> servicio = new Servicio();
					$this -> proveedor = new Usuario();
				}
			}
		}
		public function Agregar($idProveedor, $idServicio)
		{
			$instruccion = 'insert into servicios_proveedor(sp_id_proveedor, sp_id_servicio) values("'.$idProveedor.'", '.$idServicio.')';
			parent::abrirConexion(); 
			$comando = parent::$conexion->prepare($instruccion);
			$comando->execute();
			mysqli_stmt_close($comando);
			parent::cerrarConexion();
			//return $resultado;
		}
	}
?>
