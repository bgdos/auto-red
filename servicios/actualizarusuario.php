<?php
	header('Access-Control-Allow-Origin: *');
	require_once('../clases/usuario.php');
	/*
	require_once('../clases/ubicacion.php');
	require_once('../clases/evaluacion.php');
	require_once('../clases/datospersonales.php');
	require_once('../clases/serviciosproveedor.php');
	*/
	
	if(isset($_POST['varUsuarioViejoA']) && isset($_POST['varContrasenaNuevaA']) && isset($_POST['varContrasenaNueva2A']))
	{
		/*ACTUALIZAR UN USUARIO*/
		if($_POST['varContrasenaNuevaA'] == $_POST['varContrasenaNueva2A'])
		{
			$usr = new Usuario($_POST['varUsuarioViejoA']);
			if($usr -> Actualizar($_POST['varUsuarioNuevoA'], $_POST['varContrasenaNuevaA']))
			{
				$json = '{"status":0, "error":"SIN ERRORES"}';
			}
			else
			{
				$json = '{"status":1, "error":"IMPOSIBLE REALIZAR UPDATE."}';
			}
		}
		else
		{
			$json = '{"status":2, "error":"LA CONTRASEÑA NO COINCIDE."}';
		}
	}
	else
	{
		$json = '{"status":3, "error":"NO SE RECIBIERON LOS PARAMETROS"}';
	}
	echo $json;
?>
