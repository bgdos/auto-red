<?php
	require_once('../accesodatos/catalogos.php');
	header('Access-Control-Allow-Origin: *');

	$servicios = Catalogos::Servicios();
	$json = '{ "SERVICIOS" : [';
	$primero = true;
	foreach ($servicios as $ser)
	{
		if ($primero) 
			$primero = false; 
		else 
			$json .=',';
		$json .= ' 	{
					"ID" : '.$ser->getIdServicio().',
					"DESCRIPCION" : "'.$ser->getDescripcion().'"
				}';
	}
	$json .=']}';
	echo $json;	
?>
