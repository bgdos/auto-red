var x = new XMLHttpRequest();
var urlProveedores = 'http://auto-red.wc.lt/servicios/getproveedores.php';
var proveedoresServicio1 = [];
var proveedoresServicio2 = [];
var proveedoresServicio3 = [];
var proveedoresServicio4 = [];
var proveedoresServicio5 = [];
var proveedores;

function proveedoresServicio(idServicio)
{
	var x = new XMLHttpRequest();
	x.open('GET', urlProveedores, true);
	x.onreadystatechange = function()
	{
		if (x.status == 200 & x.readyState == 4)
		{
			var respuestaJSON = JSON.parse(x.responseText);
			proveedores = respuestaJSON.Proveedores;
			
			for(var i = 0; i < proveedores.length; i++)
			{
				var proveedor = proveedores[i];
				var servicios = proveedor.SERVICIOS;
				for(var j = 0; j < servicios.length; j++)
				{
					var servicio = servicios[j];
					if(servicio.ID == 1)
					{
						proveedoresServicio1.push(proveedor);
					}
					else if(servicio.ID == 2)
					{
						proveedoresServicio2.push(proveedor);
					}
					else if(servicio.ID == 3)
					{
						proveedoresServicio3.push(proveedor);
					}
					else if(servicio.ID == 4)
					{
						proveedoresServicio4.push(proveedor);
					}
					else if(servicio.ID == 5)
					{
						proveedoresServicio5.push(proveedor);
					}
				}
			}
			/*ordenarArray(proveedoresServicio1);
			ordenarArray(proveedoresServicio2);
			ordenarArray(proveedoresServicio3);
			ordenarArray(proveedoresServicio4);
			ordenarArray(proveedoresServicio5);*/
			if(idServicio==0)
				Ubicacion(proveedores);
			if(idServicio==1)
				Ubicacion(proveedoresServicio1);
			else if(idServicio==2)
				Ubicacion(proveedoresServicio2);
			else if(idServicio==3)
				Ubicacion(proveedoresServicio3);
			else if(idServicio==4)
				Ubicacion(proveedoresServicio4);
			else if(idServicio==5)
				Ubicacion(proveedoresServicio5);
			if (document.getElementById('selectUbicacion').value==1)
				UCliente(1);
			else
				UCliente(2);
		}
	}
	x.send();
}
function ordenarArray(array)
{
	for(var i =0; i < array.length-1; i++)
	{
		var max = i;
		for(var j = i + 1; j <array.length; j++)
		{
			var p1 = array[j];
			var serv1 = p1.SERVICIOS;
			var cal1 = p1.EVALUACIONES;
			
			var p2 = array[max];
			var serv2 = p2.SERVICIOS;
			var cal2 = p2.EVALUACIONES;
			
			var cal1=array[j].EVALUACIONES[serv1.length-1].GENERAL;
			var cal2=array[max].EVALUACIONES[serv2.length-1].GENERAL;
			if(cal1 > cal2)
			{
				max = j;
			}
		}
		if(i != max)
		{
			var aux = array[i];
			array[i] = array[max];
			array[max] = aux;
		}
	}
}
