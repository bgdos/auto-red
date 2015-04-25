<?php
	session_start();
	header('Access-Control-Allow-Origin: *');
	require_once('../clases/usuario.php');
	require_once('generartoken.php');
	
	if (isset($_POST['varUsuario']) & isset($_POST['varContrasena']))
	{
		$usuario = $_POST['varUsuario'];
		$contrasena = $_POST['varContrasena'];
		$usuario = new Usuario($usuario, $contrasena);
		if ($usuario->getFechaRegistro()!='')
		{
			$_SESSION['sesionUsuario'] = $usuario->getNombreUsuario();
			
			$json= ' {
						"status" : 0,
						"USERNAME" : "'.$usuario->getNombreUsuario().'",
						"FECHA_DE_REGISTRO":"'.$usuario->getFechaRegistro().'",
						"FECHA_DE_BAJA":"'.$usuario->getFechaBaja().'",
						
						"NOMBRES":"'.$usuario->getDatosPersonales()->getNombres().'",
						"APELLIDO_PATERNO":"'.$usuario->getDatosPersonales()->getApellidoPaterno().'",
						"APELLIDO_MATERNO":"'.$usuario->getDatosPersonales()->getApellidoMaterno().'",
						"GENERO":"'.$usuario->getDatosPersonales()->getGenero().'",
						"FOTOGRAFIA":"'.$usuario->getDatosPersonales()->getFotografia().'",
						"TELEFONO":"'.$usuario->getDatosPersonales()->getTelefono().'",
						"CORREO":"'.$usuario->getDatosPersonales()->getCorreo().'",
						
						"CALLE":"'.$usuario->getDatosPersonales()->getCalle().'",
						"NUMERO_CALLE":"'.$usuario->getDatosPersonales()->getNumeroCalle().'",
						"COLONIA":"'.$usuario->getDatosPersonales()->getColonia().'",
						"CP":"'.$usuario->getDatosPersonales()->getCP().'",
						"CIUDAD":"'.$usuario->getDatosPersonales()->getCiudad().'",
						
						"ID_TIPO_USUARIO":'.$usuario -> getTipo() -> getIdTipo().',
						"DESCRIPCION_TIPO":"'.$usuario -> getTipo() -> getDescripcion().'",
						
						"TOKEN" : "'.generarToken($usuario->getNombreUsuario()).'"';
						
						if($usuario -> getUbicacion() -> getId() != null)
						{
							$json.=',
										"ID_UBICACION":'.$usuario -> getUbicacion() -> getId().',
										"LATITUD":'.$usuario -> getUbicacion() -> getLatitud().',
										"LONGITUD":'.$usuario -> getUbicacion() -> getLongitud().'
							';
						}
						if($usuario -> getTipo() -> getIdTipo() == 1)
						{
							$eva = $usuario -> getEvaluaciones();
							$json.=',
										"PRECIO":'.$eva -> getPrecio().',
										"CALIDAD":'.$eva -> getCalidad().',
										"TIEMPO":'.$eva -> getTiempo().',
										"CONFIABILIDAD":'.$eva -> getConfiabilidad().',
										"ATENCION":'.$eva -> getAtencion().',
										"EVALUACION_GENERAL":'.$eva -> getGeneral().'
							}';
						}
						else
						{
							$json.=',
										"VEHICULO_MATRICULA":"'.$usuario -> getAutomovil() -> getId().'",
										"VEHICULO_DUENIO":"'.$usuario -> getAutomovil() -> getIdUsuario().'",
										"VEHICULO_DESCRIPCION":"'.$usuario -> getAutomovil() -> getDescripcion().'"
							}';
						}
					echo $json;
		}
		else
		{
			echo '{ "status" : 1, "error" : "Acceso Denegado" }';
		}
	}
	else
	{
		echo '{ "status" : 2, "error" : "Parametros Incompletos" }';
	}
?>
