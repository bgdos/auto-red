<?php
	require_once('conexion.php');
	require_once('../clases/ubicacion.php');
	require_once('../clases/servicio.php');
	require_once('../clases/usuario.php');
	require_once('../clases/tipo.php');
	require_once('../clases/evaluacion.php');
	require_once('../clases/trabajo.php');
	
	class Catalogos extends Conexion
	{
		public static function Ubicaciones()
		{
			parent::abrirConexion();
			$ids = array();
			$lista = array();
			if (func_num_args() == 0)
			{
				$instruccion = "select ubi_id from ubicacion";
				$comando = parent::$conexion->prepare($instruccion);
			}
			$comando->execute();
			$comando->bind_result($id);
			while($comando->fetch())
				array_push($ids, $id);
			mysqli_stmt_close($comando);
			parent::cerrarConexion();
			for ($i = 0; $i < count($ids); $i++)
				array_push($lista, new Ubicacion($ids[$i]));
			return $lista;
		}
		public static function Servicios()
		{
			parent::abrirConexion();
			$ids = array();
			$lista = array();
			$argumentos = func_get_args();
			if (func_num_args() == 0)
			{
				$instruccion = "select ser_id from servicio";
				$comando = parent::$conexion->prepare($instruccion);
			}
			else
			{
				$inicio = ($argumentos[0] -1) * 3;
				$instruccion = "select ser_id from servicio limit ?, 3";
				$comando = parent::$conexion->prepare($instruccion);
				$comando -> bind_param('i', $inicio);
			}
			$comando->execute();
			$comando->bind_result($id);
			while($comando->fetch())
				array_push($ids, $id);
			mysqli_stmt_close($comando);
			parent::cerrarConexion();
			for ($i = 0; $i < count($ids); $i++)
				array_push($lista, new Servicio($ids[$i]));
			return $lista;
		}
		public static function Proveedores()
		{
			parent::abrirConexion();
			$ids = array();
			$lista = array();
			$argumentos = func_get_args();
			if (func_num_args() == 0)
			{
				$instruccion = "select usu_username from usuario where usu_id_tipo = 1 and usu_fecha_baja is null";
				$comando = parent::$conexion->prepare($instruccion);
			}
			else
			{
				$servicio = $argumentos[0];
				$instruccion = "SELECT sp_id_proveedor FROM servicios_proveedor WHERE sp_id_servicio = ?";
				$comando = parent::$conexion->prepare($instruccion);
				$comando -> bind_param('i', $servicio);
				/*$inicio = ($argumentos[0] -1) * 3;
				$instruccion = "select usu_username from usuario where usu_id_tipo = 1 and usu_fecha_baja is null limit ?, 3";
				$comando = parent::$conexion->prepare($instruccion);
				$comando -> bind_param('i', $inicio);*/
			}
			$comando->execute();
			$comando->bind_result($id);
			while($comando->fetch())
				array_push($ids, $id);
			mysqli_stmt_close($comando);
			parent::cerrarConexion();
			if (isset($servicio))
			{
				for ($i = 0; $i < count($ids); $i++)
				{
					array_push($lista, new Usuario($ids[$i]));
					for ($x = 0; $x < count($lista); $x++)
					{
						if (isset($lista[$x+1]))
						{
							for ($z = 0; $z < count($lista); $z++)
							{
								if (isset($lista[$z+1]))
								{
									$pro1 = new Evaluacion($lista[$z]->getNombreUsuario(), $servicio);
									$pro2 = new Evaluacion($lista[$z+1]->getNombreUsuario(), $servicio);
									if ($pro1->getGeneral() <  $pro2->getGeneral())
									{
										$temp = $lista[$z+1];
										$lista[$z+1] = $lista[$z];
										$lista[$z] = $temp;
									}
								}
							}
						}
					}
				}
			}
			else
			{
				for ($i = 0; $i < count($ids); $i++)
				{
					array_push($lista, new Usuario($ids[$i]));
					for ($x = 0; $x < count($lista); $x++)
					{
						if (isset($lista[$x+1]))
						{
							for ($z = 0; $z < count($lista); $z++)
							{
								if (isset($lista[$z+1]))
								{
									$pro1 = new Evaluacion($lista[$z]->getNombreUsuario());
									$pro2 = new Evaluacion($lista[$z+1]->getNombreUsuario());
									if ($pro1->getGeneral() <  $pro2->getGeneral())
									{
										$temp = $lista[$z+1];
										$lista[$z+1] = $lista[$z];
										$lista[$z] = $temp;
									}
								}
							}
						}
					}
				}
			}
			return $lista;
		}
		public static function Clientes()
		{
			parent::abrirConexion();
			$ids = array();
			$lista = array();
			$argumentos = func_get_args();
			if (func_num_args() == 0)
			{
				$instruccion = "select usu_username from usuario where usu_id_tipo = 2 and usu_fecha_baja is null";
				$comando = parent::$conexion->prepare($instruccion);
			}
			else
			{
				$inicio = ($argumentos[0] -1) * 5;
				$instruccion = "select usu_username from usuario where usu_id_tipo = 2 and usu_fecha_baja is null limit ?, 5";
				$comando = parent::$conexion->prepare($instruccion);
				$comando -> bind_param('i', $inicio);
			}
			$comando->execute();
			$comando->bind_result($id);
			while($comando->fetch())
				array_push($ids, $id);
			mysqli_stmt_close($comando);
			parent::cerrarConexion();
			for ($i = 0; $i < count($ids); $i++)
				array_push($lista, new Usuario($ids[$i]));
			return $lista;
		}
		public static function Evaluaciones()
		{
			parent::abrirConexion();
			$ids = array();
			$lista = array();
			$argumentos = func_get_args();
			if (func_num_args() == 0)
			{
				$instruccion = "select eva_id from evaluacion";
				$comando = parent::$conexion->prepare($instruccion);
				$comando->execute();
				$comando->bind_result($id);
				while($comando->fetch())
					array_push($ids, $id);
				mysqli_stmt_close($comando);
				parent::cerrarConexion();
				for ($i = 0; $i < count($ids); $i++)
					array_push($lista, new Evaluacion($ids[$i]));
				return $lista;
			}
			else if(func_num_args() == 1)
			{
				$instruccion = "select eva_id from evaluacion where eva_id_servicio = ?";
				$comando = parent::$conexion->prepare($instruccion);
				$comando -> bind_param('i', $argumentos[0]);
				$comando->bind_result($id);
				while($comando->fetch())
					array_push($ids, $id);
				mysqli_stmt_close($comando);
				parent::cerrarConexion();
				for ($i = 0; $i < count($ids); $i++)
					array_push($lista, new Evaluacion($ids[$i]));
				return $lista;
			}
			/*else if(func_num_args() == 2)
			{
				$instruccion = "select eva_id from evaluacion where eva_id_servicio = ? and eva_id_usuario = ?";
				$comando = parent::$conexion->prepare($instruccion);
				$comando -> bind_param('is', $argumentos[0], $argumentos[1]);
			}*/
			else if(func_num_args() == 2)
			{
				$instruccion = "select eva_id from evaluacion where eva_precio = ? and eva_id_cliente = ?";
				$comando = parent::$conexion->prepare($instruccion);
				$comando -> bind_param('is', $argumentos[0], $argumentos[1]);
				$comando->bind_result($id);
				while($comando->fetch())
					array_push($ids, $id);
				mysqli_stmt_close($comando);
				parent::cerrarConexion();
				for ($i = 0; $i < count($ids); $i++)
				{
					$e=new Evaluacion($ids[$i]);
					$t = new Trabajo($e->getTrabajo());
					if ($t->getEstatus()->getIdEstatus()== 3)
					{
						array_push($lista, $e);
					}
				}
					
				return $lista;
			}
		}
		public static function ServiciosProveedor()
		{
			parent::abrirConexion();
			$ids = array();
			$lista = array();
			$argumentos = func_get_args();
			if (func_num_args() == 0)
			{
				$instruccion = "select sp_id from servicios_proveedor";
				$comando = parent::$conexion->prepare($instruccion);
			}
			if (func_num_args() == 1)
			{
				$instruccion = "select sp_id from servicios_proveedor where sp_id_proveedor = ?";
				$comando = parent::$conexion->prepare($instruccion);
				$comando -> bind_param('s', $argumentos[0]);
			}
			$comando->execute();
			$comando->bind_result($id);
			while($comando->fetch())
				array_push($ids, $id);
			mysqli_stmt_close($comando);
			parent::cerrarConexion();
			for ($i = 0; $i < count($ids); $i++)
				array_push($lista, new ServiciosProveedor($ids[$i]));
			return $lista;
		}
		public static function Tipos()
		{
			parent::abrirConexion();
			$ids = array();
			$lista = array();
			$instruccion = "select tip_id from tipo";
			$comando = parent::$conexion->prepare($instruccion);
			$comando->execute();
			$comando->bind_result($id);
			while($comando->fetch())
				array_push($ids, $id);
			mysqli_stmt_close($comando);
			parent::cerrarConexion();
			for ($i = 0; $i < count($ids); $i++)
				array_push($lista, new Tipo($ids[$i]));
			return $lista;
		}
		public static function Trabajos()
		{
			parent::abrirConexion();
			$ids = array();
			$lista = array();
           		 $argumentos = func_get_args();
           		 if (func_num_args() == 0)
			{
				$instruccion = "select tra_id from trabajo";
				$comando = parent::$conexion->prepare($instruccion);
			}
            		else
            		{
				$proveedor = $argumentos[0];
                		$instruccion = "SELECT tra_id FROM trabajo WHERE tra_id_proveedor = ? AND  (tra_id_estatus = 1 OR tra_id_estatus = 2);";
                		$comando = parent::$conexion->prepare($instruccion);
				$comando -> bind_param('s', $proveedor);
            		}			
			$comando->execute();
			$comando->bind_result($id);
			while($comando->fetch())
				array_push($ids, $id);
			mysqli_stmt_close($comando);
			parent::cerrarConexion();
			for ($i = 0; $i < count($ids); $i++)
				array_push($lista, new Trabajo($ids[$i]));
			return $lista;
		}
	}
?>
