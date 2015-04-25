<?php
	require_once('../accesodatos/conexion.php');
	require_once('usuario.php');
	require_once('automovil.php');
	require_once('servicio.php');
	require_once('estatus.php');
	
	class Trabajo extends Conexion
	{
		private $id;
		private $proveedor;
		private $servicio;
		private $cliente;
		private $estatus;
		private $fechaInicio;
		private $fechaFin;
		
		function getId(){return $this->id;}
		function setId($value) {$this->id = $value;}
		function getProveedor(){return $this->proveedor;}
		function setProveedor($value){$this->proveedor = new Usuario($value);}
		function getServicio(){return $this->servicio;}
		function setServicio($value){$this->servicio = new Servicio($value);}
		function getCliente(){return $this->cliente;}
		function setCliente($value){$this->cliente = new Usuario($value);}
		function getEstatus(){return $this->estatus;}
		function setEstatus($value){$this->estatus = new Estatus($value);}
		function getFechaInicio(){return $this->fechaInicio;}
		function setFechaInicio($value) {$this->fechaInicio = $value;}
		function getFechaFin(){return $this->fechaFin;}
		function setFechaFin($value) {$this->fechaFin = $value;}
		
		public function __construct()
		{
			$argumentos = func_get_args();
			if (func_num_args() == 0)
			{
				$this->id = 0;
				$this->proveedor = new Usuario();
				$this->servicio = new Servicio();
				$this->cliente = new Usuario();
				$this->estatus = new Estatus();
				$this->fechaInicio = "";
				$this->fechaFin = "";
			}
			if (func_num_args() == 1)
			{
				$this->id = $argumentos[0];
				parent::abrirConexion();
				$instruccion = 'SELECT tra_id_proveedor, tra_id_servicio, tra_id_cliente, tra_id_estatus, tra_fecha_inicio, tra_fecha_fin FROM trabajo WHERE tra_id = ?';
				$comando = parent::$conexion->prepare($instruccion);
				$comando -> bind_param('s', $this -> id);
				$comando->execute();
				$comando->bind_result($idProveedor, $idServicio, $idCliente, $idEstatus, $fInicio, $fFin);
				$encontro = $comando->fetch();
				mysqli_stmt_close($comando);
				parent::cerrarConexion();
				if ($encontro)
				{
					$this->proveedor = new Usuario($idProveedor);
					$this->servicio = new Servicio($idServicio);
					$this->cliente = new Usuario($idCliente);
					$this->estatus = new Estatus($idEstatus);
					$this->fechaInicio = $fInicio;
					$this->fechaFin = $fFin;
				}
				else
				{
					$this->id = 0;
					$this->proveedor = new Usuario();
					$this->servicio = new Servicio();
					$this->cliente = new Usuario();
					$this->estatus = new Estatus();
					$this->fechaInicio = new Date();
					$this->fechaFin = new Date();
				}
			}
			if (func_num_args() == 2)
			{
				$this->id = $argumentos[0];
				$this->proveedor = new Usuario();
				$this->servicio = new Servicio();
				$this->cliente = new Usuario();
				$this->estatus = $argumentos[1];
				$this->fechaInicio = "";
				$this->fechaFin = "";
			}
			if (func_num_args() == 4)
			{
				$this->id = 0;
				$this->proveedor = $argumentos[0];
				$this->servicio = $argumentos[1];
				$this->cliente = $argumentos[2];
				$this->estatus = $argumentos[3];
				$this->fechaInicio = "";
				$this->fechaFin = "";
			}
		}
		public function Agregar()
		{
			parent::abrirConexion();
			$instruccion = 'INSERT INTO trabajo(tra_id_proveedor, tra_id_servicio, tra_id_cliente, tra_id_estatus, tra_fecha_inicio) VALUES(?, ?, ?, ?, now());';
			$comando = parent::$conexion->prepare($instruccion);
			$comando->bind_param('sisi', $this->proveedor, $this->servicio, $this->cliente, $this->estatus);
			$resultado = $comando->execute();
			mysqli_stmt_close($comando);
			parent::cerrarConexion();
			return $resultado;
		}
		public function Terminar()
		{
			parent::abrirConexion();
			$instruccion = 'UPDATE trabajo SET tra_fecha_fin = now() WHERE tra_id = ?;';
			$comando = parent::$conexion->prepare($instruccion);
			$comando->bind_param('i', $this->getId());
			$resultado = $comando->execute();
			mysqli_stmt_close($comando);
			parent::cerrarConexion();
			return $resultado;
		}
		public function Actualizar()
		{
			parent::abrirConexion();
			$instruccion = 'UPDATE trabajo SET tra_id_estatus = ? WHERE tra_id = ?;';
			$comando = parent::$conexion->prepare($instruccion);
			$comando->bind_param('ii', $this->estatus,$this->id);
			$resultado = $comando->execute();
			mysqli_stmt_close($comando);
			parent::cerrarConexion();
			return $resultado;
		}
	}
?>
