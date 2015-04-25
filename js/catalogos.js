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

var proveedoresServicio1 = [];
var proveedoresServicio2 = [];
var proveedoresServicio3 = [];
var proveedoresServicio4 = [];
var proveedoresServicio5 = [];

var proveedores;

function cargarProveedores()
{
	
	var x = new XMLHttpRequest();
	x.open('GET', urlProveedores, true);
	x.onreadystatechange = function()
	{
		if (x.status == 200 & x.readyState == 4)
		{
			var respuesta = x.responseText;
			var respuestaJSON = JSON.parse(respuesta);
			proveedores = respuestaJSON.Proveedores;
			if(sessionStorage.idTipoPersonal == 2)
				Ubicacion(proveedores);
			var n1 = n2 = n3 = n4 = n5 = 0;
			for(var i = 0; i < proveedores.length; i++)
			{
				var proveedor = proveedores[i];
				var servicios = proveedor.SERVICIOS;
				var calificacion = proveedor.EVALUACIONES.GENERAL;
				for(var j = 0; j < servicios.length; j++)
				{
					var servicio = servicios[j];
					if(servicio.ID == 1)
					{
						if(calificacion!= null)
							"";
						else
							var calificacion = 0;
						if(sessionStorage.idTipoPersonal == 2)
							llenarTabla(document.getElementById('transmision'), proveedor, calificacion, a++, 1, n1);
						llenarTop5(document.getElementById('transmision2'), proveedor, calificacion, m++, 1);
						n1++;
					}
					else if(servicio.ID == 2)
					{
						if(calificacion!= null)
							"";
						else
							var calificacion = 0;
						if(sessionStorage.idTipoPersonal == 2)
							llenarTabla(document.getElementById('suspension'), proveedor, calificacion, b++, 2, n2);
						llenarTop5(document.getElementById('suspension2'), proveedor, calificacion, n++, 2);
						n2++;
					}
					else if(servicio.ID == 3)
					{
						if(calificacion!= null)
							"";
						else
							var calificacion = 0;
						if(sessionStorage.idTipoPersonal == 2)
							llenarTabla(document.getElementById('motor'), proveedor, calificacion, c++, 3, n3);
						llenarTop5(document.getElementById('motor2'), proveedor, calificacion, o++, 3);
						n3++;
					}
					else if(servicio.ID == 4)
					{
						if(calificacion!= null)
							"";
						else
							var calificacion = 0;
						if(sessionStorage.idTipoPersonal == 2)
							llenarTabla(document.getElementById('mofle'), proveedor, calificacion, d++, 4, n4);
						llenarTop5(document.getElementById('mofle2'), proveedor, calificacion, p++, 4);
						n4++
					}
					else if(servicio.ID == 5)
					{
						if(calificacion!= null)
							"";
						else
							var calificacion = 0;
						if(sessionStorage.idTipoPersonal == 2)
							llenarTabla(document.getElementById('electrico'), proveedor, calificacion, e++, 5, n5);
						llenarTop5(document.getElementById('electrico2'), proveedor, calificacion, q++, 5);
						n5++;
					}
					else{}
				}
			}
		}
	}
	x.send();
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
	for (var i = 0; i < proveedores.length; i++)
	{
		var p = proveedores[i];
		if (proveedor == p.USERNAME)
		{
			cargarInfo(p, serv);
			break;
		}
	}
}
function llenarSelect()
{
	var select = document.getElementById('varTipo');
	var object = document.createElement('option');
	object.value = "";
	object.text = "-";
	select.appendChild(object);
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
				registroUsuario();
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
function ordenarTablaProveedores()
{
	var motor = new table.sorter('motor');
	motor.init('motor', 1);
	var transmision = new table.sorter('transmision');
	transmision.init('transmision', 1);
	var mofle = new table.sorter('mofle');
	mofle.init('mofle', 1);
	var suspension = new table.sorter('suspension');
	suspension.init('suspension', 1);
	var electrico = new table.sorter('electrico');
	electrico.init('electrico', 1);
}
