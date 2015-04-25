<?php
	header('Access-Control-Allow-Origin: *');
    require_once('../clases/evaluacion.php');
	
	if (isset($_GET['id']) & isset($_GET['a']) & isset($_GET['c']) & isset($_GET['p']) & isset($_GET['t']) & isset($_GET['r']))
	{
		$evaluacion = new Evaluacion($_GET['id'], $_GET['a'], $_GET['c'], $_GET['p'], $_GET['t'], $_GET['r']);
		if ($evaluacion->Actualizar() != 0)
			echo '{ "status" : 0, "mensaje" : "Evaluación guardada, gracias" }';
		else
		{
			echo '{ "status" : 2, "mensaje" : "Ha sucedido un error, la evaluación no pudo guardarse." }';
		}
	}
	else
	{
		echo '{ "status" : 1, "mensaje" : "Parametros recibidos invalidos." }';
	}
?>
