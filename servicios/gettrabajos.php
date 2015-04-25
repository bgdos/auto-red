<?php
	session_start();
	header('Access-Control-Allow-Origin: *');
	
	require_once('../accesodatos/catalogos.php');
	

			if (isset($_GET['pagina']))
			{
				$trabajo = Catalogos::trabajos('pagina');
				$json = '{
							"pagina" : '.$_GET['pagina'].',
							"trabajos" : [';
			}
			if (isset($_GET['usuario']))
			{
				$trabajo = Catalogos::trabajos($_GET['usuario']);
				$json = '{ "status" : 0, 
                            "trabajos" : [';
			}
            else
            {
                echo '{ "error" : "parametros incorrectos" }';
            }
			$primero = true;
			foreach ($trabajo as $t)
			{
				if ($primero) 
					$primero = false; 
				else 
					$json .=',';
				$json .= ' 	{
                                "id" : '.$t->getId().',
								"proveedor" :
                                    {
                                        "nombres" : "'.$t->getProveedor()->getDatosPersonales()->getNombres().'",
                                        "apellidoPaterno":"'.$t->getProveedor()->getDatosPersonales()->getApellidoPaterno().'",
								        "apellidoMaterno":"'.$t->getProveedor()->getDatosPersonales()->getApellidoMaterno().'"
                                    },
								"servicio" :
                                    { 
                                        "id" :'.$t->getServicio()->getIdServicio().',
                                        "descripcion" : "'.$t->getServicio()->getDescripcion().'"
                                    },
                                "cliente" :
                                    {
                                        "nombres" : "'.$t->getCliente()->getDatosPersonales()->getNombres().'",
                                        "apellidoPaterno" : "'.$t->getCliente()->getDatosPersonales()->getApellidoPaterno().'",
								        "apellidoMaterno" : "'.$t->getCliente()->getDatosPersonales()->getApellidoMaterno().'",
								        "direccion" : "'.$t->getCliente()->getDatosPersonales()->getCalle() .' ' .$t->getCliente()->getDatosPersonales()->getNumeroCalle() .', Colonia: ' .$t->getCliente()->getDatosPersonales()->getColonia() .', CP: '.$t->getCliente()->getDatosPersonales()->getCP() .', ' .$t->getCliente()->getDatosPersonales()->getCiudad() .', BC",
								        "telefono" : "' .$t->getCliente()->getDatosPersonales()->getTelefono() .'",
                                        "ubicacion" : 
                                            {
                                                "latitud" :'.$t->getCliente()->getUbicacion()->getLatitud().',
                                                "longitud" :'.$t->getCliente()->getUbicacion()->getLongitud().'
                                            }
                                    },
                                "estatus" : 
                                    {
                                        "id" : '.$t->getEstatus()->getIdEstatus().',
                                        "descripcion" : "'.$t->getEstatus()->getDescripcion().'"
						            }
						      }';
			}
			$json .=']}';
			echo $json;	
?>
