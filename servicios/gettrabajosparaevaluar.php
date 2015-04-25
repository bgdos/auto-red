<?php
	session_start();
	header('Access-Control-Allow-Origin: *');
	
	require_once('../accesodatos/catalogos.php');
	require_once('../clases/usuario.php');
	

			if (isset($_GET['pagina']))
			{
				$evaluacion = Catalogos::evaluaciones('pagina');
				$json = '{
							"pagina" : '.$_GET['pagina'].',
							"evaluaciones" : [';
			}
			if (isset($_GET['usuario']))
			{
				$c = 0;
				$evaluacion = Catalogos::evaluaciones($c, $_GET['usuario']);
				$json = '{ "status" : 0, 
                            "evaluaciones" : [';
			}
            else
            {
                echo '{ "error" : "parametros incorrectos" }';
            }
			$primero = true;
			foreach ($evaluacion as $e)
			{
				$u = new Usuario($e->getUsuario());
				if ($primero) 
					$primero = false; 
				else 
					$json .=',';
				$json .= ' 	{
                                "id" : '.$e->getId().',
								"proveedor" :
                                    {
                                        "nombres" : "'.$u->getDatosPersonales()->getNombres().'",
                                        "apellidoPaterno":"'.$u->getDatosPersonales()->getApellidoPaterno().'",
								        "apellidoMaterno":"'.$u->getDatosPersonales()->getApellidoMaterno().'",
								        "foto":"'.$u->getDatosPersonales()->getFotografia().'"
                                    }
						      }';
			}
			$json .=']}';
			echo $json;	
?>
