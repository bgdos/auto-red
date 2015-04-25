<?php
	header('Access-Control-Allow-Origin: *');
    require_once('../clases/trabajo.php');
	
	if (isset($_GET['id']) & isset($_GET['estatus']))
	{
		$trabajo = new trabajo($_GET['id'], $_GET['estatus']);
		if ($trabajo->Actualizar() !=0)
			echo '{ "status" : 0, "mensaje" : "Trabajo Actualizado" }';
	}
	else
	{
		echo '{ "status" : 1, "mensaje" : "Parametros recibidos invalidos" }';
	}
?>
