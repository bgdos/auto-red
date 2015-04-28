//objeto XMLHttpRequest
var v = new XMLHttpRequest();
//valores
//var precio = parseFloat(sessionStorage.calPrecio).toFixed(2);
var datos = [parseFloat(parseFloat(sessionStorage.calPrecio).toFixed(2)), parseFloat(parseFloat(sessionStorage.calCalidad).toFixed(2)), parseFloat(parseFloat(sessionStorage.calTiempo).toFixed(2)), parseFloat(parseFloat(sessionStorage.calConfiabilidad).toFixed(2)), parseFloat(parseFloat(sessionStorage.calAtencion).toFixed(2))];
//var datos = [precio, 4, 5, 4, 5];
var total =0;
//timer
var idTimer = 0;
// contador de info
var infop = 0;
//trabajos
var trabajos;
//evaluaciones
var evaluaciones;

var titulosY =  [ 'Precio', 'Calidad', 'Tiempo', 'Confiabilidad', 'Atención'];

var colores = ['#1787ce', '#db6262', '#b64ed9', 'rgb(111, 103, 103)', '#256462' ];

function iniciar(){
	validar();
	slides();
Chat() ;
	if (sessionStorage.idTipoPersonal == 1)
	{
		datosProveedor(); 
		cargarProveedores();
		cargarTrabajos();
		graficar();
		dibujarPie();
		rating();
		//setInterval(function(){cargarTrabajos();}, 15000);
	}
	else if (sessionStorage.idTipoPersonal == 2)
	{
		datosCliente();
		cargarProveedores();  
		TrabajosParaEvaluar();
		//tiempoCliente();
		//setInterval(function(){TrabajosParaEvaluar();}, 15000);
	}
}
//mostrar gráficas
function graficar()
{
    var svgBar = document.getElementById('svgBarra');
    var linea = dibujarLinea(130, 50, 130,300, "#1f7dd2" ); svgBarra.appendChild(linea);
    linea = dibujarLinea(130, 300, 480,300, "#1f7dd2" ); svgBarra.appendChild(linea);
    var texto = dibujarTexto("0", 130, 320, "middle", 12, "#1f7dd2"); svgBarra.appendChild(texto);
    texto = dibujarTexto("0", 130, 45, "middle", 12, "#1f7dd2"); svgBarra.appendChild(texto);
    
    var x = 50;
    var y = 165;
    for (var i = 0; i < titulosY.length; i++)
	{
		linea = dibujarLinea(130, x, 480,x, "#d3d3d3" ); svgBarra.appendChild(linea);
        texto = dibujarTexto(titulosY[i], 10, x +30, "right", 12, "#1f7dd2"); svgBarra.appendChild(texto);
        x += 50;
        linea = dibujarLinea(y, 50, y,305, "#d3d3d3" ); svgBarra.appendChild(linea);
        y += 35;
        linea = dibujarLinea(y, 50, y,305, "#d3d3d3" ); svgBarra.appendChild(linea);
        texto = dibujarTexto(i+1, y, 320, "middle", 12, "#1f7dd2"); svgBarra.appendChild(texto);
        texto = dibujarTexto(i+1, y, 45, "middle", 12, "#1f7dd2"); svgBarra.appendChild(texto);
        y += 35;
	}
    x = 50;
    y = 110;
    for (var i = 0; i < titulosY.length; i++)
	{	
        var rectangulo = dibujarRectangulo(130, x +5, datos[i]*70, 40, "#5e91c6", colores[i]); svgBarra.appendChild(rectangulo);
        texto = dibujarTexto(datos[i], y + (datos[i] *70) , x +30, "middle", 12, "#CCCCCC"); svgBarra.appendChild(texto); // testo dentro de la barra
        x += 50;
	}
}
function dibujarPie()
{
	var svgPie = document.getElementById("svgPie");
	dibujarArcos(svgPie, datos); // datos para el pie
}
//Funcion para dibujar los arcos
function dibujarArcos(svg, datosPie){
    var total = datosPie.reduce(function (accu, that) { return that + accu; }, 0);
    var anguloSector = datosPie.map(function (v) { return 360 * v / total; });
    
    x= 20; y=35;
    
    for (var i = 0; i < titulosY.length; i++)
	{
        texto = dibujarTexto(titulosY[i],x, y , "right", 12, "#1f7dd2"); svg.appendChild(texto);
        var rectangulo = dibujarRectangulo(x-15, y-10, 10, 10, "#5e91c6", colores[i]); svg.appendChild(rectangulo);
        x += 120;
        
	}

    var anguloInicio = 0;
    var anguloFin = 0;
    for (var i=0; i<anguloSector.length; i++){
        anguloInicio = anguloFin;
        anguloFin = anguloInicio + anguloSector[i];
        var x = 250;
        var y = 200;
        var r = 150;

        var x1,x2,y1,y2 ;

        x1 = parseInt(Math.round(x + r * Math.cos(Math.PI*anguloInicio/180)));
        y1 = parseInt(Math.round(y + r * Math.sin(Math.PI*anguloInicio/180)));

        x2 = parseInt(Math.round(x + r*Math.cos(Math.PI*anguloFin/180)));
        y2 = parseInt(Math.round(y + r*Math.sin(Math.PI*anguloFin/180)));
        
        

        var d = "M"+x +","+y+"  L" + x1 + "," + y1 + "  A"+r+","+r+" 0 " + 
                ((anguloFin-anguloInicio > 180) ? 1 : 0) + ",1 " + x2 + "," + y2 + " z";
        //alert(d); // enable to see coords as they are displayed
        var c = parseInt(i / anguloSector.length * 360);
        var arcos = crearSVG("path", {d: d, fill: colores[i], stroke:"#CCCCCC", strokewidth:"2px"}); 
        svg.appendChild(arcos);
        for (var t = 0; t < datosPie.length; t++)
            total += datosPie[t];
        //dibujarTexto dentro de  los arcos(texto, x, y, ancla, tamano, color)
        var texto = dibujarTexto(((100/total)*datosPie[i]).toFixed(2)+"%", (x1+x2) /2, ((y1+y2)/2) ,"middle", "15", "#CCCCCC"); svg.appendChild(texto);
        arcos.onclick = (function (etiquetas, originalData) { 
          return function(event) {
            alert(etiquetas+" : " + originalData);
          }
        })(titulosY[i], datosPie[i]);
    }
}
function rating()
{
	var estrella = "star";
    if (sessionStorage.calGral >= 0 && sessionStorage.calGral < 1.6)
        estrella +="1";
    if (sessionStorage.calGral >= 1.6 && sessionStorage.calGral < 2.6)
        estrella +="2";
    if (sessionStorage.calGral >= 2.6 && sessionStorage.calGral < 3.6)
        estrella +="3";
    if (sessionStorage.calGral >= 3.6 && sessionStorage.calGral< 4.6)
        estrella +="4";
    if (sessionStorage.calGral >= 4.6)
        estrella +="5";
    document.getElementById(estrella).checked=true;
}
function slides()
{
    slide1();
    setTimeout(function(){slide2();}, 3000);
    setTimeout(function(){slide3();}, 6000);
    setTimeout(function(){slides();}, 9000);
}

function slide1()
{
    document.getElementById("slide1").style.display = "block";
    document.getElementById("slide2").style.display = "none";
    document.getElementById("slide3").style.display = "none";
}
function slide2()
{
    document.getElementById("slide1").style.display = "none";
    document.getElementById("slide2").style.display = "block";
    document.getElementById("slide3").style.display = "none";
}
function slide3()
{
    document.getElementById("slide1").style.display = "none";
    document.getElementById("slide2").style.display = "none";
    document.getElementById("slide3").style.display = "block";
}
function cargarFotoNueva(event) {
    	var vistaPrevia = document.getElementById('usrFoto');
    	vistaPrevia.setAttribute("src", URL.createObjectURL(event.target.files[0]));
};
function abrirInfo(){
    //$(".infoProveedor").slideDown("slow");
    var info = document.getElementById("informacion").style.display = "block";
    
}
function cerrarInfo(){
    //$(".infoProveedor").slideUp("slow");
    document.getElementById("informacion").style.display = "none";
}
function abrirEvaluar(){
    //$(".evaluar").slideDown("slow");
    var info = document.getElementById("evaluar").style.display = "block";
    
}
function cerrarEvaluar(){
    //$(".evaluar").slideUp("slow");
    document.getElementById("evaluar").style.display = "none";
}
function agregarTrabajo()
{
	var proveedor = document.getElementById("user").innerHTML;
	var servicio = document.getElementById("service").innerHTML;
	var url = 'http://auto-red.wc.lt/servicios/asignartrabajo.php?proveedor=' + proveedor + '&servicio=' + servicio + '&cliente=' + sessionStorage.user  + '&status=' + 2;
	v.open('GET', url, true);
	v.send();
	v.onreadystatechange = function()
	{
		if (v.status == 200 & v.readyState == 4)
		{
			var respuestaJSON = JSON.parse(v.responseText);
			console.log(respuestaJSON.mensaje); 
			cerrarInfo();
			alert(respuestaJSON.mensaje);
		}
	}
}
function registrar()
{
	window.location = "registro.html";
}
function cargarTrabajos()
{
	var url = 'http://auto-red.wc.lt/servicios/gettrabajos.php?usuario=' + sessionStorage.user ;
	v.open('GET', url, true);
	v.send();
	v.onreadystatechange = function()
	{
        if (v.status == 200 & v.readyState == 4)
		{
            var respuestaJSON = JSON.parse(v.responseText);
            if (respuestaJSON.status == 0)
			{
				trabajos = respuestaJSON.trabajos;
				var notificacion;
				var  noti;
				if (notificacion = document.getElementById("notificacion"))
					noti = parseInt(document.getElementById("notificacion").innerHTML);
				else if (notificacion = document.getElementById("notificacion1"))
					noti = parseInt(document.getElementById("notificacion1").innerHTML);
                if (trabajos.length > noti)
                {
					infop = 0;
					mostrarTrabajos(trabajos, notificacion);
				}	
			}
			else
			{
				window.location = 'error.html';
			}
		}
            
    }
}
function cargarTrabajos2()
{
	var url = 'http://auto-red.wc.lt/servicios/gettrabajos.php?usuario=' + sessionStorage.user ;
	v.open('GET', url, true);
	v.send();
	v.onreadystatechange = function()
	{
        if (v.status == 200 & v.readyState == 4)
		{
            var respuestaJSON = JSON.parse(v.responseText);
            if (respuestaJSON.status == 0)
			{
				trabajos = respuestaJSON.trabajos;
				var notificacion;
				var  noti;
				if (notificacion = document.getElementById("notificacion"))
					noti = parseInt(document.getElementById("notificacion").innerHTML);
				else if (notificacion = document.getElementById("notificacion1"))
					noti = parseInt(document.getElementById("notificacion1").innerHTML);
				mostrarTrabajos(trabajos, notificacion);	
			}
			else
			{
				window.location = 'error.html';
			}
	   }
            
    }
}
//mostrar trabajos
function mostrarTrabajos(trabajos, notificacion)
{
	var tabla = document.getElementById('trabajos');
    var filas = tabla.getElementsByTagName("tr");
    if (trabajos.length > 0)
    {
		notificacion.innerHTML = trabajos.length;
		while (filas.length > 0)
		{
				tabla.deleteRow(filas.length-1);
				filas.length--;
			
		}
	}
    for (var i = 0; i < trabajos.length; i++)
	{
		var trabajo = trabajos[i];
		var cliente = trabajo.cliente;
		var servicio = trabajo.servicio;
		var estatus = trabajo.estatus;
		
		var tr = tabla.insertRow(i);
		tr.style.cssText = 'cursor:pointer;';
		var td = tr.insertCell(0);
		var td1 = tr.insertCell(1);
		var td2 = tr.insertCell(2);
		var td3 = tr.insertCell(3);
		var td4 = tr.insertCell(4);
		
		tr.onclick = function(){ubicacionCliente(this);}
		
		//cargar trabajo
        td.innerHTML = i+1;
        td1.innerHTML = cliente.nombres + ' ' + cliente.apellidoPaterno;
        td2.innerHTML = servicio.descripcion;
        td3.innerHTML = estatus.descripcion;
        if (estatus.id == 2)
        {
            var boton = document.createElement('span');
            boton.innerHTML = '<button id="btnProveedorA" class="boton" onclick="cambiarStatusTrabajo('+trabajo.id + ','+ 1 + ');">Aceptar</button><button id="btnProveedorC" class="boton" onclick="cambiarStatusTrabajo('+trabajo.id +','+ 4 +');}">Cancelar</button>';
            td4.appendChild(boton);
            notificacion.id = "notificacion1";
        }
        else
        {
            var boton = document.createElement('span');
            boton.innerHTML = '<button id="btnProveedor" class="boton" onclick="cambiarStatusTrabajo('+trabajo.id + ',' + 3 + ');">Finalizar</button>';
            td4.appendChild(boton);
        }
	}
	if (trabajos.length > 0)
	{
		if (infop == 0)
		{
			infop = 1;
			abrirEvaluar();
		}
	} 
	
}
//cambiar status de trabajo
function cambiarStatusTrabajo(id, estatus)
{
	var v = new XMLHttpRequest();
    var url = 'http://auto-red.wc.lt/servicios/cambiarstatustrabajo.php?id=' + id  + '&estatus=' + estatus;
	v.open('GET', url, true);
	v.send();
	v.onreadystatechange = function()
	{
		if (v.status == 200 & v.readyState == 4)
		{
			var respuestaJSON = JSON.parse(v.responseText);
			alert(respuestaJSON.mensaje);
			cargarTrabajos2();
		}
	}
}
//informacion de proveedor
function cargarInfo(p, servicio)
{
	var ft = document.getElementById('fotoInfo');
	if(p.FOTOGRAFIA != "")
	{
		ft.setAttribute('src', 'http://auto-red.wc.lt/fotos/' + p.FOTOGRAFIA);
	}
	else
	{
		ft.setAttribute('src', 'http://auto-red.wc.lt/fotos/default.jpg');
	}
	document.getElementById("user").innerHTML = p.USERNAME;
	document.getElementById("service").innerHTML = servicio;
	var nombre = document.getElementById("nombres");
	nombres.innerHTML = p.NOMBRES + " " + p.APELLIDO_PATERNO + " " + p.APELLIDO_MATERNO;
	var cal = document.getElementById("cal");
	var cali = parseFloat(p.EVALUACIONES.GENERAL).toFixed(2);
	cal.innerHTML = "Calificación: <b>" + cali + "</b>";
	var dir = document.getElementById("dir");
	dir.innerHTML = "Dirección: <b>Col. " + p.DIR_COLONIA + ", Calle " + p.DIR_CALLE + ", No. " + p.DIR_NUMERO + ", CP. " +p.DIR_CODIGO_POSTAL + ", " + p.DIR_CIUDAD + ", BC" + "</b>";
	var tel = document.getElementById("tel");
	tel.innerHTML = "Telefono:  <b>" + p.TELEFONO + "</b>";
	var mail = document.getElementById("mail");
	mail.innerHTML = "Email:  <b>" + p.CORREO + "</b>";
	var jobs = document.getElementById("jobs");
	if(p.TRABAJOS.length >0)
	{
		jobs.innerHTML = "Trabajos en proceso: <b>" + p.TRABAJOS.length + "</b>";
	}
	else
	{
		jobs.innerHTML = "Trabajos en proceso: <b>0</b>";
	}
	
	var estrella = "star";
    if (cali >= 0 && cali < 1.6)
        estrella +="1";
    if (cali >= 1.6 && cali < 2.6)
        estrella +="2";
    if (cali >= 2.6 && cali < 3.6)
        estrella +="3";
    if (cali >= 3.6 && cali< 4.6)
        estrella +="4";
    if (cali >= 4.6)
        estrella +="5";
    document.getElementById(estrella).checked=true;
    abrirInfo();
    ubicacionProveedor(p);
}
//Ubicacion del cliente
function ubicacionCliente(i) {
	var trabajo = trabajos[i.rowIndex-1];
	var lat = trabajo.cliente.ubicacion.latitud;
	var lon = trabajo.cliente.ubicacion.longitud;
    myOptions = {zoom:16,center:new google.maps.LatLng(lat, lon), mapTypeId: google.maps.MapTypeId.ROADMAP};
    icon = 'http://google-maps-icons.googlecode.com/files/home.png';
    map = new google.maps.Map(document.getElementById("map"), myOptions);
    infowindow = new google.maps.InfoWindow({content:"<b>"+ trabajo.cliente.nombres + " " + trabajo.cliente.apellidoPaterno +"</b></br><b>Dirección:</b> " + trabajo.cliente.direccion +"<br><b>Telefono: </b>" + trabajo.cliente.telefono });
    iniciarMapa(lat, lon, map, infowindow, icon);
}
//Ubicacion de proveedor
function ubicacionProveedor(p) {
	var lat = p.LATITUD;
	var lon = p.LONGITUD;
    myOptions = {zoom:16,center:new google.maps.LatLng(lat, lon), mapTypeId: google.maps.MapTypeId.ROADMAP};
    icon = 'http://google-maps-icons.googlecode.com/files/carrepair.png';
    map = new google.maps.Map(document.getElementById("map2"), myOptions);
    infowindow = new google.maps.InfoWindow({content:"<b>"+ p.NOMBRES + " " + p.APELLIDO_PATERNO + "</b></br><b>Dirección:</b> " + p.DIR_CALLE + " " + p.DIR_NUMERO + ", Col." + p.DIR_COLONIA + ", CP. " +p.DIR_CODIGO_POSTAL + ", " + p.DIR_CIUDAD + ",BC"  +"<br><b>Telefono: </b>" + p.TELEFONO });
    iniciarMapa(lat, lon, map, infowindow, icon);
}
//Detectar Ubicacion
function obtenerUbicacion() {
    var x = document.getElementById("ubicacion");//variable para desplegar las coordenadas
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(mostrarPosicion, mostrarError); // genera el mapa y manda error en caso de no encontrar la ubicacion
    } else { 
        alert("La Geolocalización no es soportada  por este navegador.");
    }
}
//mostrar la posicion actual
function mostrarPosicion(position) {
    myOptions = {zoom:16,center:new google.maps.LatLng(position.coords.latitude, position.coords.longitude),mapTypeId: google.maps.MapTypeId.ROADMAP};
    lat = position.coords.latitude;
    lon = position.coords.longitude;
    nombre = "Mark";
    icon = 'http://google-maps-icons.googlecode.com/files/home.png';
    map = new google.maps.Map(document.getElementById("map"), myOptions);
    infowindow = new google.maps.InfoWindow({content:"<b>Tu ubicación actual:</b></br>Latitud: " + lat+"</br>longitud:" + lon});
    iniciarMapa(lat, lon, map, infowindow, icon);
    x.innerHTML = "Latitud: " + lat + "<br>Longitud: " + lon;
	if(window.location == 'http://auto-red.wc.lt/registro.html')
	{
		var getLat = document.getElementById('varLatR');			//LOS PUSE PARA OBTENER LATITUD Y LONGITUD DE LA POSICION ACTUAL DEL USUARIO QUE SE REGISTRE...
		var getLong = document.getElementById('varLongR');		//DE AQUI SE MANDA A DOS TEXTBOXS INVISIBLES PARA GUARDAR ESA POSICION EN LA BD.
		getLat.setAttribute('value', lat);
		getLong.setAttribute('value', lon);
	}
}
//Evaluar Proveedor
function evaluar()
{
    var atencion = document.getElementsByName("rating1");
    var calidad = document.getElementsByName("rating2");
    var precio = document.getElementsByName("rating3");
    var tiempo = document.getElementsByName("rating4");
    var responsabilidad = document.getElementsByName("rating5");
    for (var i = 0; i < atencion.length; i++) {       
        if (atencion[i].checked) {
            var a = atencion[i].value;
            break;
        }
    }
    for (var i = 0; i < calidad.length; i++) {       
        if (calidad[i].checked) {
            var c = calidad[i].value;
            break;
        }
    }
    for (var i = 0; i < precio.length; i++) {       
        if (precio[i].checked) {
            var p = precio[i].value;
            break;
        }
    }
    for (var i = 0; i < tiempo.length; i++) {       
        if (tiempo[i].checked) {
            var t = tiempo[i].value;
            break;
        }
    }
    for (var i = 0; i < responsabilidad.length; i++) {       
        if (responsabilidad[i].checked) {
            var r = responsabilidad[i].value;
            break;
        }
    }
    if (a && c && p && t && r)
		GuardarEvaluacion(a, c, p, t, r);
		//alert("Atencion: " + a + ", Calidad: " +c + ", Precio: " + p + ", Tiempo: " + t + ", Responsabilidad: " + r);
	else
		alert("Error: Tienes que evaluar las 5 categorias");
}
//guardar evaluacion
function GuardarEvaluacion(a, c, p, t, r)
{
	var id = document.getElementById("et").innerHTML;
	var v = new XMLHttpRequest();
    var url = 'http://auto-red.wc.lt/servicios/guardarevaluacion.php?id=' + id  + '&a=' + a  + '&c=' + c  + '&p=' + p  + '&t=' + t  + '&r=' + r;
	v.open('GET', url, true);
	v.send();
	v.onreadystatechange = function()
	{
		if (v.status == 200 & v.readyState == 4)
		{
			var respuestaJSON = JSON.parse(v.responseText);
			if (respuestaJSON.status == 0)
				cerrarEvaluar();
			console.log(respuestaJSON.mensaje);
			alert(respuestaJSON.mensaje); 
		}
		
	}
}
//Ubicacion de proveedores
function Ubicacion(p){
	var myOptions = {zoom:15,center:new google.maps.LatLng(sessionStorage.latitud, sessionStorage.longitud),mapTypeId: google.maps.MapTypeId.ROADMAP};
	map = new google.maps.Map(document.getElementById("map"), myOptions);
	var icon = 'http://google-maps-icons.googlecode.com/files/carrepair.png';

    var texto;
    var i;
    
    for (i = 0; i < p.length; i++) {//marcadores de proveedores
		var prov = p[i];
		texto = "<b>" + p[i].NOMBRES + "</b><br>" + p[i].DIR_CALLE + " " + p[i].DIR_NUMERO + ", Col." + p[i].DIR_COLONIA + ", CP. " +p[i].DIR_CODIGO_POSTAL + ", " + p[i].DIR_CIUDAD + ",BC" ;
		var loc = new google.maps.LatLng(p[i].LATITUD, p[i].LONGITUD);
        marcador(map, loc, texto,icon, prov);
	}
	// usuario principal
	if (document.getElementById('selectUbicacion').value==1)
	{
		icon = 'http://google-maps-icons.googlecode.com/files/home.png';
		marker = new google.maps.Marker({
		map: map, icon: icon, position: new google.maps.LatLng(sessionStorage.latitud, sessionStorage.longitud)});
		infowindow = new google.maps.InfoWindow({content:"<b>"+ sessionStorage.nombre + ' ' + sessionStorage.apellidoPaterno +"</b><br/>" + sessionStorage.dirCalle + ' ' + sessionStorage.dirNumero + ' ' +sessionStorage.dirColonia + "<br/>" + sessionStorage.dirCiudad});
		google.maps.event.addListener(marker, "click", function(){infowindow.open(map,marker);});
		infowindow.open(map,marker);
	}
	else
	{
		if (navigator.geolocation) {
			icon = 'http://google-maps-icons.googlecode.com/files/home.png';
			navigator.geolocation.getCurrentPosition(posicion, mostrarError);
		} 
		else 
		{ 
			alert("La Geolocalización no es soportada  por este navegador.");
		}
	}
}
//Opcion Ubicacion cliente
function UCliente(n){
	var p = proveedores;
	var myOptions = {zoom:15,center:new google.maps.LatLng(sessionStorage.latitud, sessionStorage.longitud),mapTypeId: google.maps.MapTypeId.ROADMAP};
	map = new google.maps.Map(document.getElementById("map"), myOptions);
	var icon = 'http://google-maps-icons.googlecode.com/files/carrepair.png';

    var texto;
    var i;
    
    for (i = 0; i < p.length; i++) {//marcadores de proveedores
		var prov = p[i];
		texto = "<b>" + p[i].NOMBRES + "</b><br>" + p[i].DIR_CALLE + " " + p[i].DIR_NUMERO + ", Col." + p[i].DIR_COLONIA + ", CP. " +p[i].DIR_CODIGO_POSTAL + ", " + p[i].DIR_CIUDAD + ",BC" ;
		var loc = new google.maps.LatLng(p[i].LATITUD, p[i].LONGITUD);
        marcador(map, loc, texto,icon, prov);
	}
	if (n == "1")
    {
		// usuario principal
		icon = 'http://google-maps-icons.googlecode.com/files/home.png';
		marker = new google.maps.Marker({
			map: map, icon: icon, position: new google.maps.LatLng(sessionStorage.latitud, sessionStorage.longitud)});
			infowindow = new google.maps.InfoWindow({content:"<b>"+ sessionStorage.nombre + ' ' + sessionStorage.apellidoPaterno +"</b><br/>" + sessionStorage.dirCalle + ' ' + sessionStorage.dirNumero + ' ' +sessionStorage.dirColonia + "<br/>" + sessionStorage.dirCiudad});
			google.maps.event.addListener(marker, "click", function(){infowindow.open(map,marker);});
			infowindow.open(map,marker);
	}
	else
	{
        if (navigator.geolocation) {
			icon = 'http://google-maps-icons.googlecode.com/files/home.png';
			navigator.geolocation.getCurrentPosition(posicion, mostrarError);
		} else { 
			alert("La Geolocalización no es soportada  por este navegador.");
		}
	}
}
//marcadores en el mapa
function marcador(map, loc, texto, icon, p) {
    var marker = new google.maps.Marker({map: map, icon: icon, position: loc, clickable: true});
    marker.info = new google.maps.InfoWindow({content:texto});
    google.maps.event.addListener(marker, 'click', function() {
        marker.info.open(map, marker);
        cargarInfo(p);
    });
}
//iniciar mapa
function iniciarMapa(lat, lon, map, infowindow, icon){
    marker = new google.maps.Marker({icon: icon, map: map,position: new google.maps.LatLng(lat ,lon)});
    google.maps.event.addListener(marker, "click", function(){infowindow.open(map,marker);});
    infowindow.open(map,marker);}
//regresar coordenadas
function posicion(pos) {
	var crd = pos.coords;
	icon = 'http://google-maps-icons.googlecode.com/files/home.png';
    marker = new google.maps.Marker({
			map: map, icon: icon, position: new google.maps.LatLng(crd.latitude, crd.longitude)});
			infowindow = new google.maps.InfoWindow({content:"<b>"+ sessionStorage.nombre + ' ' + sessionStorage.apellidoPaterno +"</b><br/>" + sessionStorage.dirCalle + ' ' + sessionStorage.dirNumero + ' ' +sessionStorage.dirColonia + "<br/>" + sessionStorage.dirCiudad});
			google.maps.event.addListener(marker, "click", function(){infowindow.open(map,marker);});
			infowindow.open(map,marker);
}
//mostrar error en caso de que no se pueda detectar la ubicacion actual
function mostrarError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            x.innerHTML = "El usuario ha negado el acceso a la Geolocalización."
            break;
        case error.POSITION_UNAVAILABLE:
            x.innerHTML = "La información de tu ubicación no esta disponible."
            break;
        case error.TIMEOUT:
            x.innerHTML = "Ha finalizado el tiempo de espera para obtener la Geolocalización."
            break;
        case error.UNKNOWN_ERROR:
            x.innerHTML = "Ha occurrido un error."
            break;
    }
}
//trabajos para evaluar
function TrabajosParaEvaluar()
{
	var v = new XMLHttpRequest();
    var url = 'http://auto-red.wc.lt/servicios/gettrabajosparaevaluar.php?usuario=' + sessionStorage.user;
	v.open('GET', url, true);
	v.send();
	v.onreadystatechange = function()
	{
		if (v.status == 200 & v.readyState == 4)
		{
			respuestaJSON = JSON.parse(v.responseText);
			console.log(respuestaJSON.status);
			evaluaciones = respuestaJSON.evaluaciones;
			if (evaluaciones.length > 0)
			{
				for (var i=0; i < evaluaciones.length; i++)
				{
					CargarEvaluar(evaluaciones[i]);
				}
			}
		}		
	}
    
}
function CargarEvaluar(e)
{
	document.getElementById("ep").innerHTML = e.proveedor.nombres + " " + e.proveedor.apellidoPaterno;
	document.getElementById("et").innerHTML = e.id;
	if(e.proveedor.foto != "")
	{
		document.getElementById("efoto").setAttribute('src', 'http://auto-red.wc.lt/fotos/' + e.proveedor.foto);
	}
	else
	{
		document.getElementById("efoto").setAttribute('src', 'http://auto-red.wc.lt/fotos/default.jpg');
	}
	abrirEvaluar();
}
function registroUsuario()
{
    if (document.getElementById("varTipo").value != 1)
        document.getElementById("servicio").style.display = "none";
    else
        document.getElementById("servicio").style.display = "block";
}
function revisarCheckBoxes()
{
	var si_no_hay_errores = false;
    if (document.getElementById("varContrasenaR").value != document.getElementById("varContrasena2R").value)
    {
		document.getElementById("botonR").value = "Error";
        	document.getElementById("botonR").disabled = true;
        	document.getElementById("alertaContrasena").style.display = "block";
		si_no_hay_errores  = false;
	}
	else
	{
		if (document.getElementById("varTipo").value == 1)
		{
			if (document.getElementById("servicios1").checked==false &&
			document.getElementById("servicios2").checked==false &&
			document.getElementById("servicios3").checked==false &&
			document.getElementById("servicios4").checked==false &&
			document.getElementById("servicios5").checked==false)
			{
				document.getElementById("botonR").value = "Error";
				document.getElementById("botonR").disabled = true;
				document.getElementById("alertaServicios").style.display = "block";
				si_no_hay_errores  = false;
			} 
		}
	}
}
function quitarNotificacion()
{
    if (document.getElementById("alertaServicios").style.display == "block")
    {
        document.getElementById("alertaServicios").style.display = "none";
	}
	if (document.getElementById("alertaContrasena").style.display == "block")
    {
        document.getElementById("alertaContrasena").style.display = "none";
	}
	document.getElementById("botonR").disabled = false;
	document.getElementById("botonR").value = "Registrar";
}
//<!--Start of Tawk.to Script-->
var $_Tawk_API={},$_Tawk_LoadStart=new Date();
function Chat(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/553ab2feea5c5e4d205d024a/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
}
//<!--End of Tawk.to Script-->
