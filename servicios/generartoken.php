<?php
	function generarToken()
	{
		$token = '';
		$zona = 'America/Tijuana';
		date_default_timezone_set($zona);
		$hoy = new DateTime();
		$argumentos = func_get_args();
		if (func_num_args() == 1)
		{
			$token = sha1($argumentos[0].(date_format($hoy,'Ymd')));
		}
		return $token;
	}
?>
