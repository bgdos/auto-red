<?php
	require_once('../accesodatos/catalogos.php');
	header('Access-Control-Allow-Origin: *');
	
	/*if (isset($_GET['pagina']))
	{
		$proveedores = Catalogos::Proveedores('pagina');
		$json = '{
					"pagina" : '.$_GET['pagina'].',
					"Proveedores" : [';
	}*/
	if (isset($_GET['servicio']))
	{
		//leer encabezados
		$proveedores = Catalogos::Proveedores($_GET['servicio']);
		//inicio de json
		$json = '{
					"Proveedores" : [';
	}
	else
	{
		$proveedores = Catalogos::Proveedores();
		$json = '{ "Proveedores" : [';
	}
	$primero = true;
	foreach ($proveedores as $proveedor)
	{
		if ($primero) 
			$primero = false; 
		else 
			$json .=',';
		$json .= ' 	{
						"USERNAME" : "'.$proveedor->getNombreUsuario().'",
						"FECHA_DE_REGISTRO":"'.$proveedor->getFechaRegistro().'",
						"FECHA_DE_BAJA":"'.$proveedor->getFechaBaja().'",';
						
						if($proveedor->getDatosPersonales()->getIdUsuario() != null)
						{
							$json.='
										"NOMBRES":"'.$proveedor->getDatosPersonales()->getNombres().'",
										"APELLIDO_PATERNO":"'.$proveedor->getDatosPersonales()->getApellidoPaterno().'",
										"APELLIDO_MATERNO":"'.$proveedor->getDatosPersonales()->getApellidoMaterno().'",
										"GENERO":"'.$proveedor->getDatosPersonales()->getGenero().'",
										"FOTOGRAFIA":"'.$proveedor->getDatosPersonales()->getFotografia().'",
										"TELEFONO":"'.$proveedor->getDatosPersonales()->getTelefono().'",
										"CORREO":"'.$proveedor->getDatosPersonales()->getCorreo().'", 
										"DIR_CALLE":"'.$proveedor->getDatosPersonales()->getCalle().'",
										"DIR_COLONIA":"'.$proveedor->getDatosPersonales()->getColonia().'",
										"DIR_NUMERO":"'.$proveedor->getDatosPersonales()->getNumeroCalle().'",
										"DIR_CODIGO_POSTAL":'.$proveedor->getDatosPersonales()->getCP().',
										"DIR_CIUDAD":"'.$proveedor->getDatosPersonales()->getCiudad().'"
										';
						}
						else
						{
							$json.='
										"NOMBRES":"Sin registro",
										"APELLIDO_PATERNO":"Sin registro",
										"APELLIDO_MATERNO":"Sin registro",
										"GENERO":"Sin registro",
										"FOTOGRAFIA":"Sin registro",
										"TELEFONO":"Sin registro",
										"CORREO":"Sin registro", 
										"DIR_CALLE":"Sin registro",
										"DIR_COLONIA":"Sin registro",
										"DIR_NUMERO":"Sin registro",
										"DIR_CODIGO_POSTAL":"Sin registro",
										"DIR_CIUDAD":"Sin registro"
										';
						}
			
						if($proveedor -> getUbicacion() -> getId() != null)
						{
							$json.='
										,"ID_UBICACION":'.$proveedor -> getUbicacion() -> getId().',
										"LATITUD":'.$proveedor -> getUbicacion() -> getLatitud().',
										"LONGITUD":'.$proveedor -> getUbicacion() -> getLongitud().'';
						}
						$eva = $proveedor -> getEvaluaciones();
						if($eva->getGeneral() != 0)
						{
							$json.=',"EVALUACIONES":{
											"PRECIO":'.$eva ->  getPrecio().',
											"CALIDAD":'.$eva -> getCalidad().',
											"TIEMPO":'.$eva -> getTiempo().',
											"CONFIABILIDAD":'.$eva -> getConfiabilidad().',
											"ATENCION":'.$eva -> getAtencion().',
											"GENERAL":'.$eva -> getGeneral().'
											}';
						}
						else
						{
							$json.=',"EVALUACIONES":{
											"PRECIO":0,
											"CALIDAD":0,
											"TIEMPO":0,
											"CONFIABILIDAD":0,
											"ATENCION":0,
											"GENERAL":0
											}';
						}
						
						$trabs = Catalogos::Trabajos($proveedor->getNombreUsuario());
						if(count($trabs) > 0)
						{
							$json.=', "TRABAJOS":[';
							$segundo = true;
							foreach($trabs as $tra)
							{
								if ($segundo) 
									$segundo = false; 
								else 
									$json .=',';
								$json .= '{
											"ID":'.$tra ->  getId().',
											"SERVICIO":"'.$tra -> getServicio()->getDescripcion().'",
											"ESTATUS":"'.$tra -> getEstatus()->getDescripcion().'",
											"FECHA_FIN":"'.$tra -> getFechaFin().'"
											}';
							}
							$json.=']';
						}
						else
						{
							$json.=', "TRABAJOS":0';
						}
						$svcs = $proveedor -> getServicios();
						if(count($svcs) > 0)
						{
							$json.=',"SERVICIOS":[';
							$segundo = true;
							foreach($svcs as $svc)
							{
								if ($segundo) 
									$segundo = false; 
								else 
									$json .=',';
								$json .= '{
											"ID":'.$svc ->  getIdServicio().',
											"DESCRIPCION":"'.$svc -> getDescripcion().'"
											}';
							}
							$json .=']';
						}
		$json .='}';
	}
	$json .=']}';
	echo $json;
?>
