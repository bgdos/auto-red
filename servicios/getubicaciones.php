<?php
	session_start();
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: token');
	
	require_once('../accesodatos/catalogos.php');
	require_once('generartoken.php');
	$encabezados = getallheaders();
	if (isset($encabezados['token']))
	{
		$tokenrecibido = $encabezados['token'];
		$tokenvalido = generarToken($_SESSION('usuario'));
		if ($tokenrecibido == $tokenvalido)
		{
			//se recibio una pagina
			if (isset($_GET['pagina']))
			{
				//leer encabezados
				$ubicaciones = Catalogos::Ubicaciones('pagina');
				//inicio de json
				$json = '{
							"pagina" : '.$_GET['pagina'].',
							"ubicaciones" : [';
			}
			else
			{
				//leer ubicaciones
				$ubicaciones = Catalogos::ubicaciones();
				//inicio json
				$json = '{ "ubicaciones" : [';
			}
			$primero = true;
			foreach ($ubicacion as $ubi)
			{
				if ($primero) 
					$primero = false; 
				else 
					$json .=',';
				$json .= ' 	{
								"latitud" : '.$ubi->getLatitud().',
								"longitud" : '.$ubi->getLongitud().'
						}';
			}
			$json .=']}';
			echo $json;	
		}
		else
			echo '{ "error" : "Token Invalido" }';
	}
	else
		echo '{ "error" : "Token no Recibido" }';
?>
