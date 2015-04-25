<?php
	session_start();
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: token');
	
	require_once('../accesodatos/catalogos.php');
	require_once('generartoken.php');
	
	if (isset($_GET['idProveedor']))
	{
		$sps = Catalogos::ServiciosProveedor($_GET['idProveedor']);
		$json = '{
					"serviciosproveedor" : [';
	}
	else
	{
		$sps = Catalogos::ServiciosProveedor();
		$json = '{ "serviciosproveedor" : [';
	}
	$primero = true;
	foreach ($sps as $sp)
	{
		if ($primero) 
			$primero = false; 
		else 
			$json .=',';
		$json .= '{
						"id" : '.$sp->getIdSP().',
						"servicio" : "'.$sp->getServicio()->getDescripcion().'",
						"proveedor" : "'.$sp->getProveedor()->getDatosPersonales()->getNombres().'",
						"calificacion" : "'.$sp->getProveedor()->getCalificacion()->EvaluacionGeneral().'"
					}';
	}
		$json .=']}';
	echo $json;
?>
