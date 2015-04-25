<?php
	header('Access-Control-Allow-Origin: *');
    require_once('../clases/trabajo.php');
	
	if (isset($_GET['proveedor']) & isset($_GET['servicio']) & isset($_GET['cliente']) & isset($_GET['status']))
	{
		$trabajo = new trabajo($_GET['proveedor'], $_GET['servicio'], $_GET['cliente'], $_GET['status']);
		if ($trabajo->Agregar() !=0)
			echo '{ "status" : 0, "mensaje" : "Trabajo Asignado" }';
	}
	else
	{
		echo '{ "status" : 1, "mensaje" : "Parametros recibidos invalidos" }';
	}
?>
