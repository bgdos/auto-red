<?php
	require_once('../accesodatos/conexion.php');
	require_once('servicio.php');
	require_once('trabajo.php');
	require_once('usuario.php');
	
	class Evaluacion extends Conexion
	{
		private $id;
		private $usuario;
		private $cliente;
		private $servicio;
		private $trabajo;
		private $precio;
		private $calidad;
		private $tiempo;
		private $confiabilidad;
		private $atencion;
		private $general;
		
		public function getId(){return $this->id;}
		public function setId($valor){$this->id = $valor;}
		public function getUsuario(){return $this->usuario;}
		public function setUsuario($valor){$this->usuario = new Usuario($valor);}
		public function getCliente(){return $this->cliente;}
		public function setCliente($valor){$this->cliente = new Usuario($valor);}
		public function getServicio(){return $this->servicio;}
		public function setServicio($valor){$this->servicio = $valor;}
		public function getTrabajo(){return $this->trabajo;}
		public function setTrabajo($valor){$this->trabajo = new Trabajo($valor);}
		public function getPrecio(){return $this->precio;}
		public function setPrecio($valor){$this->precio = $valor;}
		public function getCalidad(){return $this->calidad;}
		public function setCalidad($valor){$this->calidad = $valor;}
		public function getTiempo(){return $this->tiempo;}
		public function setTiempo($valor){$this->tiempo = $valor;}
		public function getConfiabilidad(){return $this->confiabilidad;}
		public function setConfiabilidad($valor){$this->confiabilidad = $valor;}
		public function getAtencion(){return $this->atencion;}
		public function setAtencion($valor){$this->atencion = $valor;}
		public function getGeneral(){return $this->general;}
		public function setGeneral($valor){$this->general = $valor;}
		
		public function __construct()
		{
			$argumentos = func_get_args();
			if(func_num_args() == 0)
			{
				$this -> id = 0;
				$this -> usuario = '';
				$this -> servicio = 0;
				$this -> cliente = '';
				$this -> trabajo = 0;
				$this -> precio = 0;
				$this -> calidad = 0;
				$this -> tiempo = 0;
				$this -> confiabilidad = 0;
				$this -> atencion = 0;
				$this -> general = 0;
			}
			if(func_num_args() > 0 && func_num_args() <3)
			{
				parent::abrirConexion();
				if(func_num_args() == 1)
				{
					if(is_string($argumentos[0]))
					{
						$usuario = $argumentos[0];
						$id = 0;
						$trabajo = 0;
						$instruccion = "select eva_id_servicio, (SUM(eva_precio)/count(*)), (SUM(eva_calidad)/count(*)), (SUM(eva_tiempo)/count(*)), (SUM(eva_confiabilidad)/count(*)), (SUM(eva_atencion)/count(*)), (((SUM(eva_precio)/count(*))+(SUM(eva_calidad)/count(*))+(SUM(eva_tiempo)/count(*))+(SUM(eva_confiabilidad)/count(*))+(SUM(eva_atencion)/count(*)))/5) from evaluacion where eva_id_usuario = ? AND eva_precio> 0 GROUP BY eva_id_usuario";
						$comando = parent::$conexion -> prepare($instruccion);
						$comando -> bind_param('s', $argumentos[0]);
						$comando -> execute();
						$comando -> bind_result($idServicio, $precio,$calidad, $tiempo, $confiabilidad, $atencion, $general);
					}
					else if(is_int($argumentos[0]))
					{
						$id = $argumentos[0];
						$general = 0;
						$instruccion = "select eva_id_usuario, eva_id_trabajo, eva_id_servicio, eva_precio, eva_calidad, eva_tiempo, eva_confiabilidad, eva_atencion from evaluacion where eva_id = ?";
						$comando = parent::$conexion -> prepare($instruccion);
						$comando -> bind_param('i', $argumentos[0]);
						$comando -> execute();
						$comando -> bind_result($usuario, $trabajo, $idServicio,  $precio, $calidad, $tiempo, $confiabilidad, $atencion);
					}
				}
				else if(func_num_args() == 2)/*SI RECIBE DOS TRAE LA EVALUACION POR SERVICIOS*/
				{
					/*$id = 0;
					$trabajo = 0;
					$usuario = "";*/
					$instruccion = "select eva_id_servicio, (SUM(eva_precio)/count(*)), (SUM(eva_calidad)/count(*)), (SUM(eva_tiempo)/count(*)), (SUM(eva_confiabilidad)/count(*)), (SUM(eva_atencion)/count(*)), (((SUM(eva_precio)/count(*))+(SUM(eva_calidad)/count(*))+(SUM(eva_tiempo)/count(*))+(SUM(eva_confiabilidad)/count(*))+(SUM(eva_atencion)/count(*)))/5) from evaluacion where eva_id_usuario = ? and eva_id_servicio = ?";
					$comando = parent::$conexion -> prepare($instruccion);
					$comando -> bind_param('si', $argumentos[0], $argumentos[1]);
					$comando -> execute();
					$comando -> bind_result($idServicio, $precio, $calidad, $tiempo, $confiabilidad, $atencion, $general);
				}
				$encontro = $comando -> fetch();
				mysqli_stmt_close($comando);
				parent::cerrarConexion();
				if($encontro)
				{
					$this -> id = $id;
					$this -> usuario = $usuario;
					$this -> cliente = '';
					$this -> servicio = $idServicio;
					$this -> trabajo = $trabajo;
					$this -> precio = $precio;
					$this -> calidad = $calidad;
					$this -> tiempo = $tiempo;
					$this -> confiabilidad = $confiabilidad;
					$this -> atencion = $atencion;
					$this -> general = $general;
				}
				else
				{
					$this -> id = 0;
					$this -> usuario = '';
					$this -> cliente = '';
					$this -> servicio = 0;
					$this -> trabajo = $trabajo;
					$this -> precio = 0;
					$this -> calidad = 0;
					$this -> tiempo = 0;
					$this -> confiabilidad = 0;
					$this -> atencion = 0;
					$this -> general = 0;
				}
			}
			if(func_num_args() == 6)/*id, precio, calidad, confiabilidad, atencion, servicio*/
			{
				$this -> id= $argumentos[0];
				$this -> usuario = '';
				$this -> cliente = '';
				$this -> servicio = 0;
				$this -> trabajo = 0;
				$this -> precio = $argumentos[1];
				$this -> calidad = $argumentos[2];
				$this -> tiempo = $argumentos[3];
				$this -> confiabilidad = $argumentos[4];
				$this -> atencion = $argumentos[5];
				$this -> general = 0;
			}
		}
		public function Agregar($proveedor, $servicio, $cliente)
		{
			$instruccion = 'insert into evaluacion(eva_id_usuario, eva_id_servicio, eva_id_cliente, eva_id_trabajo, eva_precio, eva_calidad, eva_tiempo, eva_confiabilidad, eva_atencion) values(?, ?, ?, ?, ?, ?, ?, ?, ?);';
			parent::abrirConexion(); 
			$comando = parent::$conexion->prepare($instruccion);
			$comando->bind_param('sisiiiiii', $proveedor, $servicio, $cliente, $this->servicio, $this->precio, $this->calidad, $this->tiempo, $this->confiabilidad, $this->atencion);
			$resultado = $comando->execute();
			mysqli_stmt_close($comando);
			parent::cerrarConexion();
			return $resultado;
		}
		public function Actualizar()
		{
			parent::abrirConexion();
			$instruccion = 'UPDATE evaluacion SET eva_precio = ?, eva_calidad = ?, eva_tiempo = ?, eva_confiabilidad = ?, eva_atencion = ? WHERE eva_id = ?;';
			$comando = parent::$conexion->prepare($instruccion);
			$comando->bind_param('iiiiii', $this -> precio, $this -> calidad, $this -> tiempo, $this -> confiabilidad, $this -> atencion, $this -> id);
			$resultado = $comando->execute();
			mysqli_stmt_close($comando);
			parent::cerrarConexion();
			return $resultado;
		}	
	}
?>
