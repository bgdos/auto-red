<?php
	header('Access-Control-Allow-Origin: *');
	require_once('../clases/usuario.php');
	require_once('../clases/ubicacion.php');
	require_once('../clases/evaluacion.php');
	require_once('../clases/datospersonales.php');
	require_once('../clases/serviciosproveedor.php');
	
	$json='{';
	//if(isset($_POST['varUsuarioR']) && isset($_POST['varContrasenaR']) && isset($_POST['varContrasena2R']) && isset($_POST['varTipo']))
	if(isset($_POST['varUsuarioR']) && isset($_POST['varContrasenaR']) && isset($_POST['varContrasena2R']) && isset($_POST['varTipo']) && isset($_POST['varNombre2']) && isset($_POST['varApPat']) && isset($_POST['varApMat']) && isset($_POST['varSexo']) &&  isset($_POST['varCalle']) && isset($_POST['varNumeroCalle']) && isset($_POST['varColonia']) && isset($_POST['varCP']) && isset($_POST['varCiudad']) &&  isset($_POST['varTelefono']) && isset($_POST['varCorreo']) && isset($_POST['varLatR']) && isset($_POST['varLongR']))
	{ 	/*REGISTRAR UN USUARIO*/
		$idUsuario = $_POST['varUsuarioR'];
		$idTipo = $_POST['varTipo'];
		$idServicios = $_POST['check_list'];
		$dp_nombre = $_POST['varNombre2'];
		$dp_apPat = $_POST['varApPat'];
		$dp_apMat = $_POST['varApMat'];
		$dp_Sexo = $_POST['varSexo'];
		$dir_calle = $_POST['varCalle'];
		$dir_numero = $_POST['varNumeroCalle'];
		$dir_colonia = $_POST['varColonia'];
		$dir_cp = $_POST['varCP'];
		$dir_ciudad = $_POST['varCiudad'];
		$dir_telefono = $_POST['varTelefono'];
		$dir_correo = $_POST['varCorreo'];
		$dp_foto =  null;
		$ubLat = $_POST['varLatR'];
		$ubLong = $_POST['varLongR'];
		$rutaFotos = '/home/u325612117/public_html/fotos/';
		
		if($_POST['varContrasenaR'] == $_POST['varContrasena2R'])
		{
			$usr = new Usuario();
			/*REGISTRAR USUARIO*/
			if($usr -> Agregar($idUsuario, $_POST['varContrasenaR'], $idTipo))
			{
				/*SUBIR FOTOGRAFIA*/
					if(isset($_FILES['Subir']))
					{
						$image = $_POST['Subir'];
						$imagenombre = $_FILES['Subir']['name'];
						$imagentipo = $_FILES['Subir']['type'];
						$imagenerror = $_FILES['Subir']['error'];
						$imagentemp = $_FILES['Subir']['tmp_name'];
						/*MOVER FOTOGRAFIA A UBICACION TEMPORAL*/
						if(is_uploaded_file($imagentemp)) 
						{
							/*MOVER FOTO A CARPETA DEL SERVIDOR*/
							if(move_uploaded_file($imagentemp, $rutaFotos.$imagenombre)) 
							{
								$dp_foto = $imagenombre;
							}
							else 
							{
								$dp_foto = null;
							}
						}
						else 
						{
							$dp_foto = null;
						}
					}
				/*REGISTRAR UBICACION*/
				if(isset($_POST['varLatR']) && isset($_POST['varLongR']))
				{
					$ubi = new Ubicacion($idUsuario, $ubLat, $ubLong);
					$ubi->Agregar();
				}
				else
				{
					
				}
				/*REGISTRAR SERVICIOS DEL PROVEEDOR*/
				if($idTipo == 1 && isset($_POST['check_list']))
				{
					/*REGISTRAR SERVICIOS QUE OFRECERA EL PROVEEDOR Y EVALUACIONES EN 0 PARA CADA SERVICIO*/
					foreach($idServicios as $idServicio)
					{
						$sp = new ServiciosProveedor();
						$sp->Agregar($idUsuario, $idServicio);
					}
				}
				else
				{
					
				}
				/*REGISTRAR DATOS PERSONALES*/
				if($dp_nombre != '' || $dir_colonia != '' || $dir_telefono!='')
				{
					$dp = new DatosPersonales();
					$dp->setIdUsuario($idUsuario);
					$dp->setNombres($dp_nombre);
					$dp->setApellidoPaterno($dp_apPat);
					$dp->setApellidoMaterno($dp_apMat);
					$dp->setGenero($dp_Sexo);
					$dp->setFotografia($dp_foto);
					$dp->setTelefono($dir_telefono);
					$dp->setCorreo($dir_correo);
					$dp->setCalle($dir_calle);
					$dp->setNumeroCalle($dir_numero);
					$dp->setColonia($dir_colonia);
					$dp->setCP($dir_cp);
					$dp->setCiudad($dir_ciudad);
					$dp->Agregar();
				}
				else
				{
					
				}
			}
			else
			{
				
			}
		}
		else
		{
			
		}
		$json.='"status":0';
	}
	else
	{
		$json.='"status":1';
	}
	
	$json.='}';
	echo $json;
?>
