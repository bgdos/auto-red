<?php
	require_once('../accesodatos/conexion.php');
	
	class DatosPersonales extends Conexion
	{
		private $idUsuario;
		private $nombres;
		private $apellidoPaterno;
		private $apellidoMaterno;
		private $genero;
		private $fotografia;
		private $telefono;
		private $correo;
		private $calle;
		private $numeroCalle;
		private $colonia;
		private $cp;
		private $ciudad;
		
		public function getIdUsuario(){return $this->idUsuario;}
		public function setIdUsuario($valor){$this->idUsuario = $valor;}
		public function getNombres(){return $this->nombres;}
		public function setNombres($valor){$this->nombres = $valor;}
		public function getApellidoPaterno(){return $this->apellidoPaterno;}
		public function setApellidoPaterno($valor){$this->apellidoPaterno = $valor;}
		public function getApellidoMaterno(){return $this->apellidoMaterno;}
		public function setApellidoMaterno($valor){$this->apellidoMaterno = $valor;}
		public function getGenero(){return $this->genero;}
		public function setGenero($valor){$this->genero = $valor;}
		public function getFotografia(){return $this->fotografia;}
		public function setFotografia($valor){$this->fotografia = $valor;}
		public function getTelefono(){return $this->telefono;}
		public function setTelefono($valor){$this->telefono = $valor;}
		public function getCorreo(){return $this->correo;}
		public function setCorreo($valor){$this->correo = $valor;}
		public function getCalle(){return $this->calle;}
		public function setCalle($valor){$this->calle = $valor;}
		public function getNumeroCalle(){return $this->numeroCalle;}
		public function setNumeroCalle($valor){$this->numeroCalle = $valor;}
		public function getColonia(){return $this->colonia;}
		public function setColonia($valor){$this->colonia = $valor;}
		public function getCP(){return $this->cp;}
		public function setCP($valor){$this->cp = $valor;}
		public function getCiudad(){return $this->ciudad;}
		public function setCiudad($valor){$this->ciudad = $valor;}
		
		public function __construct()
		{
			$argumentos = func_get_args();
			if(func_num_args() == 0)
			{
				$this -> idUsuario = '';
				$this -> nombres = '';
				$this -> apellidoPaterno = '';
				$this -> apellidoMaterno = '';
				$this -> genero = '';
				$this -> fotografia = '';
				$this -> telefono = '';
				$this -> correo = '';
				$this -> calle = '';
				$this -> numeroCalle = '';
				$this -> colonia = '';
				$this -> cp = 0;
				$this -> ciudad = '';
			}
			if(func_num_args() == 1)
			{
				$this->idUsuario = $argumentos[0];
				parent::abrirConexion();
				$instruccion = "SELECT dp_nombre, dp_apellido_paterno, dp_apellido_materno, dp_genero, dp_fotografia, dp_telefono, dp_correo, dp_calle, dp_numero_calle, dp_colonia, dp_codigo_postal, dp_ciudad FROM datos_personales WHERE dp_id_usuario = ?";
				$comando = parent::$conexion->prepare($instruccion);
				$comando->bind_param('s', $this->idUsuario);
				$comando->execute();
				$comando->bind_result($nombres, $apellidoPaterno, $apellidoMaterno, $genero, $fotografia, $telefono, $correo, $calle, $numeroCalle, $colonia, $cp, $ciudad);
				$encontro = $comando->fetch();
				mysqli_stmt_close($comando);
				parent::cerrarConexion();
				if ($encontro)
				{
					$this -> nombres = $nombres;
					$this -> apellidoPaterno = $apellidoPaterno;
					$this -> apellidoMaterno = $apellidoMaterno;
					$this -> genero = $genero;
					$this -> fotografia = $fotografia;
					$this -> telefono = $telefono;
					$this -> correo = $correo;
					$this -> calle = $calle;
					$this -> numeroCalle = $numeroCalle;
					$this -> colonia = $colonia;
					$this -> cp = $cp;
					$this -> ciudad = $ciudad;
				}
				else
				{
					$this -> idUsuario = '';
					$this -> nombres = '';
					$this -> apellidoPaterno = '';
					$this -> apellidoMaterno = '';
					$this -> genero = '';
					$this -> fotografia = '';
					$this -> telefono = '';
					$this -> correo = '';
					$this -> calle = '';
					$this -> numeroCalle = '';
					$this -> colonia = '';
					$this -> cp = 0;
					$this -> ciudad = '';
				}
			}
		}
		public function Agregar()
		{
			$instruccion = 'insert into datos_personales(dp_id_usuario, dp_nombre, dp_apellido_paterno, dp_apellido_materno, dp_genero, dp_telefono, dp_correo, dp_calle, dp_numero_calle, dp_colonia, dp_codigo_postal, dp_ciudad, dp_fotografia) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
			parent::abrirConexion(); 
			$comando = parent::$conexion->prepare($instruccion);
			$comando->bind_param('ssssssssssiss', $this->idUsuario, $this->nombres, $this->apellidoPaterno, $this->apellidoMaterno, $this->genero, $this->telefono, $this->correo, $this->calle, $this->numeroCalle, $this->colonia, $this->cp, $this->ciudad, $this->fotografia);
			$resultado = $comando->execute();
			mysqli_stmt_close($comando);
			parent::cerrarConexion();
			return $resultado;
		}
	}
?>
