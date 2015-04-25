var urlRegistroUsuario = 'http://auto-red.wc.lt/servicios/registrousuario.php';
var urlFoto= 'http://auto-red.wc.lt/servicios/subirFoto.php';
var x = new XMLHttpRequest();

function registrarUsuario()
{
	var datos = new FormData(document.getElementById('forma2'));
	x.open('POST', urlRegistroUsuario, true);
	//var ft = document.getElementById('usrFoto').value;
	x.onreadystatechange = function()
	{
		if (x.status == 200 & x.readyState == 4)
		{
			var r= JSON.parse(x.responseText);
			
			alert(r.status);
		}
	}
	x.send(datos );
}
function actualizarUsuario()
{
	/*var datos = new FormData(document.getElementById('forma2'));
	x.open('POST', urlFoto, true);
	x.onreadystatechange = function()
	{
		if (x.status == 200 & x.readyState == 4)
		{
			var respuestaJSON = JSON.parse(x.responseText);
			alert(respuestaJSON.status);
		}
	}
	x.send(datos );*/
	alert('POR EL MOMENTO NO ES POSIBLE REALIZAR MODIFICACIONES.');
}
