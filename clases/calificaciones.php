<?php
	require_once('../accesodatos/conexion.php');
	
	class Calificaciones extends Conexion
	{
		private $idUsuario;
		private $precio;
		private $calidad;
		private $tiempo;
		private $atencion;
		private $confiabilidad;
		
		public function getIdPersonal(){return $this->idUsuario;}
		public function setIdPersonal($valor){$this->idUsuario = $valor;}
		public function getPrecio(){return $this->precio;}
		public function setPrecio($valor){$this->precio = $valor;}
		public function getCalidad(){return $this->calidad;}
		public function setCalidad($valor){$this->calidad = $valor;}
		public function getTiempo(){return $this->tiempo;}
		public function setAtencion($valor){$this->atencion = $valor;}
		public function getAtencion(){return $this->atencion;}
		public function setTiempo($valor){$this->tiempo = $valor;}
		public function getConfiabilidad(){return $this->confiabilidad;}
		public function setConfiabilidad($valor){$this->confiabilidad = $valor;}
		
		public function __construct()
		{
			$argumentos = func_get_args();
			if(func_num_args() == 0)
			{
				$this -> idUsuario = '';
				$this -> precio = 0;
				$this -> calidad = 0;
				$this -> tiempo = 0;
				$this -> atencion= 0;
				$this -> confiabilidad = 0;
			}
			if(func_num_args() == 1)
			{
				$this -> idUsuario = $argumentos[0];
				parent::abrirConexion();
				$instruccion = "SELECT (SUM(eva_precio)/count(*)), (SUM(eva_calidad)/count(*)), (SUM(eva_tiempo)/count(*)), (SUM(eva_atencion)/count(*)), (SUM(eva_confiabilidad)/count(*)) FROM evaluacion WHERE eva_id_usuario = ? AND eva_precio>0 GROUP BY eva_id_usuario";
				$comando = parent::$conexion -> prepare($instruccion);
				$comando -> bind_param('s', $this -> idUsuario);
				$comando -> execute();
				$comando -> bind_result($sprecio, $scalidad, $stiempo, $satencion, $sconfiabilidad);
				$encontro = $comando -> fetch();
				mysqli_stmt_close($comando);
				parent::cerrarConexion();
				if($encontro)
				{
					$this->precio, $sprecio;
					$this->calidad, $scalidad;
					$this->tiempo, $stiempo;
					$this->atencion, $satencion;
					$this->confiabilidad, $sconfiabilidad;
				}
				else
				{
					$this->precio, 0;
					$this->calidad, 0;
					$this->tiempo, 0;
					$this->atencion, 0;
					$this->confiabilidad, 0;
				}
			}
		}
		function Precio()
		{
			$gral = this -> precio;
			return $gral;
		}
		function Calidad()
		{
			$gral = $this -> calidad;
			return $gral;
		}
		function Tiempo()
		{
			$gral = $this -> tiempo;
			return $gral;
		}
		function Atencion()
		{
			$gral = $this -> atencion;
			return $gral;
		}
		function Confiabilidad()
		{
			$gral = $this -> confiabilidad;
			return $gral;
		}
		function EvaluacionGeneral()
		{
			$p=0;
			$c=0;
			$t=0;
			$a=0;
			$cf=0;
			$gral=0;
			$p = $this -> precio;
			$c = $this -> calidad;
			$t = $this -> tiempo;
			$a = $this -> atencion;
			$cf = $this -> confiabilidad;
			$gral = ($p+$c+$t+$a+$cf) /5;
			return $gral;
		}
	}
?>
