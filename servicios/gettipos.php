<?php
	require_once('../accesodatos/catalogos.php');
	header('Access-Control-Allow-Origin: *');
	
	$tipos = Catalogos::Tipos();
	$json = '{ "TIPOS" : [';
	$primero = true;
	foreach ($tipos as $tp)
	{
		if ($primero) 
			$primero = false; 
		else 
			$json .=',';
		$json .= ' 	{
						"ID" : '.$tp->getIdTipo().',
						"DESCRIPCION" : "'.$tp->getDescripcion().'"
					}';
	}
	$json .=']}';
	echo $json;
?>
