var url='http://auto-red.wc.lt/servicios/gettoken.php';
var urlFotos = 'http://auto-red.wc.lt/fotos/';
var token ='';
var x = new XMLHttpRequest();
var login;
//var idTimer = 0;

function obtenerToken(login)
{
	x.open('POST', url, true);
	if (login == 1)
		var datos = new FormData(document.getElementById('login'));
	else if (login == 2)
		var datos = new FormData(document.getElementById('login2'));
	
	x.onreadystatechange = function()
	{
		if (x.status == 200 & x.readyState == 4)
		{
			var respuesta = x.responseText;
			var respuestaJSON = JSON.parse(respuesta);
			if (respuestaJSON.status == 0)
			{
				sessionStorage.user = respuestaJSON.USERNAME;
				sessionStorage.fechaRegistro = respuestaJSON.FECHA_DE_REGISTRO;
				sessionStorage.fechaBaja = respuestaJSON.FECHA_DE_BAJA;
				
				sessionStorage.nombre = respuestaJSON.NOMBRES;
				sessionStorage.apellidoPaterno = respuestaJSON.APELLIDO_PATERNO;
				sessionStorage.apellidoMaterno = respuestaJSON.APELLIDO_MATERNO;
				sessionStorage.sexo = respuestaJSON.GENERO;
				sessionStorage.fotografia = respuestaJSON.FOTOGRAFIA;
				sessionStorage.direccion = respuestaJSON.DIRECCION;
				sessionStorage.telefono = respuestaJSON.TELEFONO;
				sessionStorage.correo = respuestaJSON.CORREO;

				sessionStorage.dirCalle = respuestaJSON.CALLE;
				sessionStorage.dirNumero = respuestaJSON.NUMERO_CALLE;
				sessionStorage.dirColonia = respuestaJSON.COLONIA;
				sessionStorage.dirCP = respuestaJSON.CP;
				sessionStorage.dirCiudad = respuestaJSON.CIUDAD;
				
				sessionStorage.idTipoPersonal = respuestaJSON.ID_TIPO_USUARIO;
				sessionStorage.descripcionTipoPersonal = respuestaJSON.DESCRIPCION_TIPO;
				
				sessionStorage.idUbicacion = respuestaJSON.ID_UBICACION;
				sessionStorage.idUbicacionUsuario = respuestaJSON.USUARIO_UBICACION;
				sessionStorage.latitud = respuestaJSON.LATITUD;
				sessionStorage.longitud = respuestaJSON.LONGITUD;
				
				sessionStorage.calPrecio = respuestaJSON.PRECIO;
				sessionStorage.calCalidad = respuestaJSON.CALIDAD;
				sessionStorage.calTiempo = respuestaJSON.TIEMPO;
				sessionStorage.calConfiabilidad = respuestaJSON.CONFIABILIDAD;
				sessionStorage.calAtencion = respuestaJSON.ATENCION;
				sessionStorage.calGral = respuestaJSON.EVALUACION_GENERAL;
				sessionStorage.token = respuestaJSON.TOKEN;
				
				if(respuestaJSON.VEHICULO_MATRICULA != null)
				{
					sessionStorage.vehiculoMatricula = respuestaJSON.VEHICULO_MATRICULA;
					sessionStorage.vehiculoDuenio = respuestaJSON.VEHICULO_DUENIO;
					sessionStorage.vehiculoDescripcion = respuestaJSON.VEHICULO_DESCRIPCION;
				}
				else
				{
					sessionStorage.vehiculoDescripcion = 'Sin registro.';
				}
				if(sessionStorage.idTipoPersonal == 1)
				{
					window.location = 'proveedor.html';
				}
				else if(sessionStorage.idTipoPersonal == 2)
				{
					window.location = 'cliente.html';
				}
			}
			else
			{
				window.location = 'error.html';
			}
		}
	}
	x.send(datos);
}
function cerrarSesion()
{
	sessionStorage.clear();
}
function validar()
{
	if(sessionStorage.fechaRegistro != '' && sessionStorage.fechaBaja == '')/*SI LA FECHA DE BAJA AUN NO ESTA REGISTRADA, EL USUARIO SI EXISTE*/
	{
		if(sessionStorage.idTipoPersonal == 1)
		{
			if (window.location.href != 'http://auto-red.wc.lt/proveedor.html')
				window.location = 'proveedor.html';
		}
		else if(sessionStorage.idTipoPersonal == 2)
		{
			if (window.location.href != 'http://auto-red.wc.lt/cliente.html')
				window.location = 'cliente.html';
		}
		else
			window.location = 'index.html';
	}
	else
	{
		window.location = 'error.html';/*SI LA FECHA DE BAJA NO ES NULL ENTONCES EL USUARIO YA SE DIO DE BAJA*/
	}
}
function validar2()
{
	if(sessionStorage.fechaRegistro != '' && sessionStorage.fechaBaja == '')/*SI LA FECHA DE BAJA AUN NO ESTA REGISTRADA, EL USUARIO SI EXISTE*/
	{
		if(sessionStorage.idTipoPersonal == 1)
		{
			if (window.location.href != 'http://auto-red.wc.lt/perfil.html')
				window.location = 'perfil.html';
		}
		else if(sessionStorage.idTipoPersonal == 2)
		{
			if (window.location.href != 'http://auto-red.wc.lt/perfilc.html')
				window.location = 'perfilc.html';
		}
		else
			window.location = 'index.html';
	}
	else
	{
		window.location = 'error.html';/*SI LA FECHA DE BAJA NO ES NULL ENTONCES EL USUARIO YA SE DIO DE BAJA*/
	}
}
function datosProveedor()
{
	cargarFoto();
	document.getElementById('varNombre').innerHTML = sessionStorage.nombre;
	document.getElementById('varNombre2').innerHTML = sessionStorage.nombre + ' ' + sessionStorage.apellidoPaterno  + ' ' + sessionStorage.apellidoMaterno +"<span>Aqui se muestra tu calificación general por las 5 categorias evaluadas.</span>";
	document.getElementById('Cal').innerHTML = "Calificacion: <b>"+ parseFloat(sessionStorage.calGral).toFixed(2) +"</b>";
	//idTimer = setInterval('cargarProveedores();', 5000);
}
function datosPerfilProveedor()
{
	cargarFoto();
	document.getElementById('varNombre').innerHTML = sessionStorage.nombre;
	document.getElementById('varNombre2').value = sessionStorage.nombre;
	document.getElementById('varApPat').value = sessionStorage.apellidoPaterno;
	document.getElementById('varApMat').value = sessionStorage.apellidoMaterno;
	document.getElementById('varTelefono').value = sessionStorage.telefono;
	document.getElementById('varCorreo').value = sessionStorage.correo;
	document.getElementById('varUsuarioViejo').value = sessionStorage.user;
	
	document.getElementById('varNumeroCalle').value = sessionStorage.dirNumero;
	document.getElementById('varCalle').value = sessionStorage.dirCalle;
	document.getElementById('varColonia').value = sessionStorage.dirColonia;
	document.getElementById('varCP').value = sessionStorage.dirCP;
	document.getElementById('varCiudad').value = sessionStorage.dirCiudad;
	llenarSelect();
}
function datosCliente()
{
	cargarFoto();
	document.getElementById('varNombre').innerHTML = sessionStorage.nombre ;
	document.getElementById('varNombre2').innerHTML = sessionStorage.nombre + ' ' + sessionStorage.apellidoPaterno  + ' ' + sessionStorage.apellidoMaterno;
	document.getElementById('varAutomovil').innerHTML = sessionStorage.vehiculoDescripcion;
	document.getElementById('varDireccion').innerHTML = 'Colonia ' + sessionStorage.dirColonia +' Calle ' + sessionStorage.dirCalle + ' Numero ' + sessionStorage.dirNumero;
}
function datosPerfilCliente()
{
	cargarFoto();
	document.getElementById("varNombre").innerHTML = sessionStorage.nombre ;
	document.getElementById("varNombre2A").value = sessionStorage.nombre;
	document.getElementById('varApPatA').value  = sessionStorage.apellidoPaterno;
	document.getElementById('varApMatA').value = sessionStorage.apellidoMaterno;
	document.getElementById('varTelefonoA').value = sessionStorage.telefono;
	document.getElementById('varCorreoA').value = sessionStorage.correo;
	document.getElementById('varUsuarioViejoA').value = sessionStorage.user;
	document.getElementById('varUsuarioNuevoA').value = sessionStorage.user;
	
	document.getElementById('varNumeroCalleA').value = sessionStorage.dirNumero;
	document.getElementById('varCalleA').value = sessionStorage.dirCalle;
	document.getElementById('varColoniaA').value = sessionStorage.dirColonia;
	document.getElementById('varCPA').value = sessionStorage.dirCP;
	document.getElementById('varCiudadA').value = sessionStorage.dirCiudad;
}
function cargarFoto()
{
	if(sessionStorage.fotografia != "")
	{
		var foto = document.getElementById('varFoto');
		foto.setAttribute('src', urlFotos + sessionStorage.fotografia);
		try
		{
			var foto = document.getElementById('varFoto2');
			foto.setAttribute('src', urlFotos + sessionStorage.fotografia);
		}catch(err){}
	}
	else
	{
		var foto = document.getElementById('varFoto');
		foto.setAttribute('src', urlFotos + 'default.jpg');
		try
		{
			var foto = document.getElementById('varFoto2');
			foto.setAttribute('src', urlFotos +  'default.jpg');
		}catch(err){}
	}
}
