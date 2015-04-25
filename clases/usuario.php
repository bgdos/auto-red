<?php
	require_once('../accesodatos/conexion.php');
	require_once('tipo.php');
	require_once('datospersonales.php');
	require_once('ubicacion.php');
	require_once('automovil.php');
	require_once('evaluacion.php');
	require_once('servicio.php');
	
	class Usuario extends Conexion
	{
		private $nombreUsuario;
		private $tipo;
		private $datosPersonales;
		private $ubicacion;
		private $automovil;
		private $fechaRegistro;
		private $fechaBaja;
		private $evaluaciones;
		private $servicios = array();
		
		public function getNombreUsuario(){return $this->nombreUsuario;}
		public function setNombreUsuario($valor){$this->nombreUsuario = $valor;}
		public function getTipo(){return $this->tipo;}
		public function setTipo($valor){$this->tipo = new Tipo($valor);}
		public function getDatosPersonales(){return $this->datosPersonales;}
		public function setDatosPersonales($valor){$this->datosPersonales = new DatosPersonales($valor);}
		public function getUbicacion(){return $this->ubicacion;}
		public function setUbicacion($valor){$this->ubicacion = new Ubicacion($valor);}
		public function getAutomovil(){return $this->automovil;}
		public function setAutomovil($valor){$this->automovil = new Automovil($valor);}
		public function getFechaRegistro(){return $this->fechaRegistro;}
		public function setFechaRegistro($valor){$this->fechaRegistro = $valor;}
		public function getFechaBaja(){return $this->fechaBaja;}
		public function setFechaBaja($valor){$this->fechaBaja = $valor;}
		public function getEvaluaciones(){return $this->evaluaciones;}
		public function setEvaluaciones($valor){$this->evaluaciones = $valor;}
		public function getServicios(){return $this->servicios;}
		public function setServicios($valor){$this->servicios = $valor;}
		
		public function __construct()
		{
			$argumentos = func_get_args();
			if(func_num_args() == 0)
			{
				$this -> nombreUsuario = '';
				$this -> tipo = new Tipo();
				$this -> datosPersonales = new DatosPersonales();
				$this -> ubicacion = new Ubicacion();
				$this -> automovil = new Automovil();
				$this -> fechaRegistro = '';
				$this -> fechaBaja = '';
				$this -> evaluaciones = '';
				$this -> servicios = array();
			}
			else if(func_num_args() == 1)
			{
				$this -> nombreUsuario = $argumentos[0];
				parent::abrirConexion();
				$instruccion = "SELECT usu_id_tipo, usu_fecha_registro, usu_fecha_baja FROM usuario WHERE usu_username = ?";
				$comando = parent::$conexion -> prepare($instruccion);
				$comando -> bind_param('s', $this -> nombreUsuario);
				$comando -> execute();
				$comando -> bind_result($idTipo, $fechaRegistro, $fechaBaja);
				$encontro = $comando -> fetch();
				mysqli_stmt_close($comando);
				parent::cerrarConexion();
				if($encontro)
				{
					$this -> tipo = new Tipo($idTipo);
					$this -> datosPersonales = new DatosPersonales($this -> nombreUsuario);
					$this -> ubicacion = new Ubicacion($this -> nombreUsuario);
					$this -> automovil = new Automovil($this -> nombreUsuario);
					$this -> fechaRegistro = $fechaRegistro;
					$this -> fechaBaja = $fechaBaja;
					$this -> evaluaciones =	new Evaluacion($argumentos[0]);
					parent::abrirConexion();
					$ids = array();
					$instruccion = "select sp_id_servicio from servicios_proveedor where sp_id_proveedor = ?";
					$comando = parent::$conexion -> prepare($instruccion);
					$comando -> bind_param('s', $this -> nombreUsuario);
					$comando->execute();
					$comando->bind_result($id);
					while($comando->fetch())
						array_push($ids, $id);
					mysqli_stmt_close($comando);
					parent::cerrarConexion();
					for ($i = 0; $i < count($ids); $i++)
					{
						array_push($this -> servicios, new Servicio($ids[$i]));
					}
				}
				else
				{
					$this -> tipo = new Tipo();
					$this -> datosPersonales = new DatosPersonales();
					$this -> ubicacion = new Ubicacion();
					$this -> automovil = new Automovil();
					$this -> nombreUsuario = '';
					$this -> fechaRegistro = '';
					$this -> fechaBaja = '';
					$this -> evaluaciones = 0;
				}
			}
			else if(func_num_args() == 2)
			{
				$this -> nombreUsuario = $argumentos[0];
				$this->password = $argumentos[1];
				parent::abrirConexion();
				$instruccion = "SELECT usu_id_tipo, usu_fecha_registro, usu_fecha_baja FROM usuario WHERE usu_username = ? AND usu_password = sha1(?)";
				$comando = parent::$conexion -> prepare($instruccion);
				$comando -> bind_param('ss', $this -> nombreUsuario, $this->password);
				$comando -> execute();
				$comando -> bind_result($idTipo, $fechaRegistro, $fechaBaja);
				$encontro = $comando -> fetch();
				mysqli_stmt_close($comando);
				parent::cerrarConexion();
				if($encontro)
				{
					$this -> tipo = new Tipo($idTipo);
					$this -> datosPersonales = new DatosPersonales($this -> nombreUsuario);
					$this -> ubicacion = new Ubicacion($this -> nombreUsuario);
					$this -> automovil = new Automovil($this -> nombreUsuario);
					$this -> fechaRegistro = $fechaRegistro;
					$this -> fechaBaja = $fechaBaja;
					$this -> evaluaciones = new Evaluacion($this -> nombreUsuario);
				}
				else
				{
					$this -> tipo = new Tipo();
					$this -> datosPersonales = new DatosPersonales();
					$this -> ubicacion = new Ubicacion();
					$this -> automovil = new Automovil();
					$this -> nombreUsuario = '';
					$this -> fechaRegistro = '';
					$this -> fechaBaja = '';
					$this -> evaluaciones = 0;
				}
			}
		}
		public function Agregar($username, $password, $idTipo)
		{
			$instruccion = 'insert into usuario(usu_username, usu_password, usu_id_tipo, usu_fecha_registro) values(?, sha1(?), ?, now())';
			parent::abrirConexion(); 
			$comando = parent::$conexion->prepare($instruccion);
			$comando->bind_param('ssi', $username, $password, $idTipo);
			$resultado = $comando->execute();
			mysqli_stmt_close($comando);
			parent::cerrarConexion();
			return $resultado;
		}
		public function Actualizar($usuario, $password)
		{
				$instruccion = 'update usuario set usu_username = ?, usu_password = sha1(?) where usu_username = ?;';
				parent::abrirConexion(); 
				$comando = parent::$conexion->prepare($instruccion);
				$comando->bind_param('sss', $usuario, $password, $this->nombreUsuario);
				$resultado = $comando->execute();
				mysqli_stmt_close($comando);
				parent::cerrarConexion();
				return $resultado;
		}
		public function Baja($password)
		{
			$instruccion = 'update usuario set usu_fecha_baja = now() where usu_username = ? and usu_password = sha1(?)';
			parent::abrirConexion();
			$comando = parent::$conexion->prepare($instruccion);
			$comando->bind_param('ss', $this->nombreUsuario, $password);
			$resultado = $comando->execute();
			mysqli_stmt_close($comando);
			parent::cerrarConexion();
			return $resultado;
		}
	}
?>
