var x = new XMLHttpRequest();
var urlProveedores = 'http://auto-red.wc.lt/servicios/getproveedores.php';
var urlTipos = 'http://auto-red.wc.lt/servicios/gettipos.php';
var urlServicios = 'http://auto-red.wc.lt/servicios/getservicios.php';
var a=1;
var b=1;
var c=1;
var d=1;
var e=1;

var m=1;
var n=1;
var o=1;
var p=1;
var q=1;

//tablas
var tabla;
var tabla2;

var motor = [];
var transmision = [];
var mofles = [];
var suspension = [];
var electrico = [];

var proveedores;

function cargarProveedores()
{
	
	var x = new XMLHttpRequest();
	x.open('GET', urlProveedores, true);
	x.send();
	x.onreadystatechange = function()
	{
		if (x.status == 200 & x.readyState == 4)
		{
			var respuesta = x.responseText;
			var respuestaJSON = JSON.parse(respuesta);
			proveedores = respuestaJSON.Proveedores;
			if(sessionStorage.idTipoPersonal == 2)
			{
				Ubicacion(proveedores);
				llenarArreglos1();
			}
		}
	}
}
function llenarArreglos1()
{
	var urlserv = urlProveedores + '?servicio=' + 1;
	tabla = document.getElementById('transmision');
	tabla2 = document.getElementById('transmision2');
	var x = new XMLHttpRequest();
	x.open('GET', urlserv , true);
	x.send();
	x.onreadystatechange = function()
	{
		if (x.status == 200 & x.readyState == 4)
		{
			var respuesta = x.responseText;
			var respuestaJSON = JSON.parse(respuesta);
			transmision = respuestaJSON.Proveedores;
			for (var i = 0; i < transmision.length; i++)
			{
				llenarTabla(tabla, transmision[i], transmision[i].EVALUACIONES.GENERAL, a++, 1, i);
				llenarTop5(tabla2, transmision[i], transmision[i].EVALUACIONES.GENERAL, m++, 1);
			}
			llenarArreglos2();
		}
	}
}
function llenarArreglos2()
{
	var urlserv = urlProveedores + '?servicio=' + 2;
	tabla = document.getElementById('suspension');
	tabla2 = document.getElementById('suspension2');
	var x = new XMLHttpRequest();
	x.open('GET', urlserv , true);
	x.send();
	x.onreadystatechange = function()
	{
		if (x.status == 200 & x.readyState == 4)
		{
			var respuesta = x.responseText;
			var respuestaJSON = JSON.parse(respuesta);
			suspension = respuestaJSON.Proveedores;
			for (var i = 0; i < suspension.length; i++)
			{
				llenarTabla(tabla, suspension[i], suspension[i].EVALUACIONES.GENERAL, b++, 2, i);
				llenarTop5(tabla2, suspension[i], suspension[i].EVALUACIONES.GENERAL, n++, 2);
			}
			llenarArreglos3();
		}
	}
}
function llenarArreglos3()
{
	var urlserv = urlProveedores + '?servicio=' + 3;
	tabla = document.getElementById('motor');
	tabla2 = document.getElementById('motor2');
	var x = new XMLHttpRequest();
	x.open('GET', urlserv , true);
	x.send();
	x.onreadystatechange = function()
	{
		if (x.status == 200 & x.readyState == 4)
		{
			var respuesta = x.responseText;
			var respuestaJSON = JSON.parse(respuesta);
			motor = respuestaJSON.Proveedores;
			for (var i = 0; i < motor.length; i++)
			{
				llenarTabla(tabla, motor[i], motor[i].EVALUACIONES.GENERAL, c++, 3, i);
				llenarTop5(tabla2, motor[i], motor[i].EVALUACIONES.GENERAL, o++, 3);
			}
			llenarArreglos4();
		}
	}
}
function llenarArreglos4()
{
	var urlserv = urlProveedores + '?servicio=' + 4;
	tabla = document.getElementById('mofle');
	tabla2 = document.getElementById('mofle2');
	var x = new XMLHttpRequest();
	x.open('GET', urlserv , true);
	x.send();
	x.onreadystatechange = function()
	{
		if (x.status == 200 & x.readyState == 4)
		{
			var respuesta = x.responseText;
			var respuestaJSON = JSON.parse(respuesta);
			mofles = respuestaJSON.Proveedores;
			for (var i = 0; i < mofles.length; i++)
			{
				llenarTabla(tabla, mofles[i], mofles[i].EVALUACIONES.GENERAL, d++, 4, i);
				llenarTop5(tabla2, mofles[i], mofles[i].EVALUACIONES.GENERAL, p++, 4);
				n++;
			}
			llenarArreglos5();
		}
	}
}
function llenarArreglos5()
{
	var urlserv = urlProveedores + '?servicio=' + 5;
	tabla = document.getElementById('electrico');
	tabla2 = document.getElementById('electrico2');
	var x = new XMLHttpRequest();
	x.open('GET', urlserv , true);
	x.send();
	x.onreadystatechange = function()
	{
		if (x.status == 200 & x.readyState == 4)
		{
			var respuesta = x.responseText;
			var respuestaJSON = JSON.parse(respuesta);
			electrico = respuestaJSON.Proveedores;
			for (var i = 0; i < electrico.length; i++)
			{
				llenarTabla	(tabla, electrico[i], electrico[i].EVALUACIONES.GENERAL, e++, 5, i);
				llenarTop5(tabla2, electrico[i], electrico[i].EVALUACIONES.GENERAL, q++, 5);
				n++;
			}
		}
	}
}
function llenarTabla(top, prov, cal, id, serv, n)
{
	//if(top.tBodies.length <= 4)
	//{
		var tr = top.insertRow(n);
		tr.style.cssText = 'cursor:pointer;';
		tr.setAttribute('onclick','LlenarInfo("'+prov.USERNAME+ '",' + serv + ');');
		var td1 = tr.insertCell(0);
		td1.innerHTML = id;
		var td2 = tr.insertCell(1);
		td2.innerHTML = prov.NOMBRES;
		var td3 = tr.insertCell(2);
		var cali = parseFloat(cal).toFixed(2);
		td3.innerHTML = cali;
	//}
}
function llenarTop5(top, prov, cal, id, serv)
{
	if(top.tBodies.length <= 4)
	{
		var tbody = document.createElement('tbody');
		var tr = document.createElement('tr');
		tr.style.cssText = 'cursor:pointer;';
		
		//if(sessionStorage.idTipoPersonal == 2)
			tbody.setAttribute('onclick','LlenarInfo("'+prov.USERNAME+ '",' + serv + ');');

		var td1 = document.createElement('td');
		td1.appendChild(document.createTextNode(id));
		tr.appendChild(td1);
		var td2 = document.createElement('td');	
		td2.appendChild(document.createTextNode(prov.NOMBRES));
		tr.appendChild(td2);
		var td3 = document.createElement('td');
		var cali = parseFloat(cal).toFixed(2);
		td3.appendChild(document.createTextNode(cali));
		tr.appendChild(td3);
		tbody.appendChild(tr);
		top.appendChild(tbody);
	}
}
function LlenarInfo(proveedor, serv)
{
	var arreglo;
	if (serv == null)
		arreglo = proveedores;
	if (serv == 1)
		arreglo = transmision;
	if (serv == 2)
		arreglo = suspension;
	if (serv == 3)
		arreglo = motor;
	if (serv == 4)
		arreglo = mofles;
	if (serv == 5)
		arreglo = electrico;
	for (var i = 0; i < arreglo.length; i++)
	{
		var p = arreglo[i];
		if (proveedor == p.USERNAME)
		{
			cargarInfo(p, serv);
			break;
		}
	}
}
function llenarSelect()
{
	//var x = new XMLHttpRequest();
	x.open('GET', urlTipos, true);
	x.onreadystatechange = function()
	{
		if (x.status == 200 & x.readyState == 4)
		{
			var respuesta = x.responseText;
			var respuestaJSON = JSON.parse(respuesta);
			var tipos = respuestaJSON.TIPOS;
			var select = document.getElementById('varTipo');
			for(var i = 0; i < tipos.length; i++)
			{
				var tipo = tipos[i];
				var object = document.createElement('option');
				object.setAttribute('id', 'varTipoR'+tipo.ID);
				object.value = tipo.ID;
				object.text = tipo.DESCRIPCION;
				select.appendChild(object);
			}
		}
	}
    x.send();
}
function llenarServicios()
{
	//var x = new XMLHttpRequest();
	x.open('GET', urlServicios, true);
	x.onreadystatechange = function()
	{
		if (x.status == 200 & x.readyState == 4)
		{
			var servicios = JSON.parse(x.responseText);
			var select = document.getElementById('varFiltroServicios');
			var cleanObject = document.createElement('option');
			cleanObject.text = 'Todos';
			cleanObject.value = 0;
			select.appendChild(cleanObject );
			for(var i = 0; i < servicios.SERVICIOS.length; i++)
			{
				var ser = servicios.SERVICIOS[i];
				var object = document.createElement('option');
				//object.setAttribute('id', 'varTipoR'+ser.ID);
				object.value = ser.ID;
				object.text = ser.DESCRIPCION;
				select.appendChild(object);
			}
		}
	}
    x.send();
}
function proveedoresServicio(idServicio)
{
	if(idServicio==0)
		Ubicacion(proveedores);
	if(idServicio==1)
		Ubicacion(transmision);
	if(idServicio==2)
		Ubicacion(suspension);
	if(idServicio==3)
		Ubicacion(motor);
	if(idServicio==4)
		Ubicacion(mofles);
	if(idServicio==5)
		Ubicacion(electrico);
}
