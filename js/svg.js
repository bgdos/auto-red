//Dibujar Linea
function dibujarLinea(x1, y1, x2, y2, color)
{
	//crear linea
	var linea = document.createElementNS('http://www.w3.org/2000/svg', 'line');
	//punto inicial
	linea.setAttribute('x1', x1); linea.setAttribute('y1', y1); 
	//punto final
	linea.setAttribute('x2', x2); linea.setAttribute('y2', y2);
	//estilo linea
	linea.style.stroke = color; //color de linea
	linea.style.strokeWidth = '1px'; //grosor de la linea
	//regresar linea
	return linea;
}
//Dibujar Rectángulo
function dibujarRectangulo(x, y, alto, ancho, colorLinea, colorRelleno)
{
	//crear rectángulo
	var rect = document.createElementNS('http://www.w3.org/2000/svg', 'rect');
	//punto inicial
	rect.setAttribute('x', x); rect.setAttribute('y', y); 
	//ancho y alto
	rect.setAttribute('height', ancho); rect.setAttribute('width', alto);
	//estilo rectangulo
	rect.style.stroke = colorLinea; //color de linea
	rect.style.strokeWidth = '1px'; //grosor de la linea
	rect.style.fill = colorRelleno; //relleno
	//regresar rectángulo
	return rect;
}
//Dibujar Circulo
function dibujarCirculo()
{
	//crear circulo
	var c = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
	//centro
	c.setAttribute('cx', 100); c.setAttribute('cy', 200); 
	//radio
	c.setAttribute('r', 50); 
	//estilo del circulo
	c.style.stroke = '#882'; //color de linea
	c.style.strokeWidth = '2px'; //grosor de la linea
	c.style.fill = '#AA5'; //color de relleno
	//agregar circulo a svg
	s.appendChild(c);
}
// Dibujar Texto
function dibujarTexto(texto, x, y, ancla, tamano, color)
{
	//crear texto
	var t = document.createElementNS('http://www.w3.org/2000/svg', 'text');
	//texto
	t.innerHTML = texto;
	//posición
	t.setAttribute('x', x); t.setAttribute('y', y);
	//alineacion
	t.setAttribute('text-anchor', ancla);
	//font
	t.setAttribute('font-family', 'arial');
	t.setAttribute('font-size', tamano + 'pt');
	//color
	t.style.fill = color;
	//regresar texto
	return t;
}
//Dibujar Poligono
function dibujarPoligono()
{
	//crear poligono
	var p = document.createElementNS('http://www.w3.org/2000/svg', 'polygon');
	//generar atributo de puntos
	var puntos = [ [200,200], [300,200], [300,300], [400,300], [400,400], [200,400] ];
	var puntosString = '';
	for (var i = 0; i < puntos.length; i++)
	{
		puntosString += puntos[i][0] + ',' + puntos[i][1] + ' ';
	}
	puntosString += puntos[0][0] + ',' + puntos[0][1]; //regresar a punto original
	p.setAttribute('points',puntos);
	//estilo
	p.style.stroke = '#822'; //color de linea
	p.style.strokeWidth = '1px'; //grosor de la linea
	p.style.fill = '#A55'; //color de relleno
	//agregar poligono a svg
	s.appendChild(p);
}
//Funcion para dibujar el pie
function crearSVG(grafico, atributos) { //Recibe el tipo de grafico que se requiere y los atributos para crearlo
    var svg = document.createElementNS('http://www.w3.org/2000/svg', grafico); // se crea la figura
    for (var k in atributos)
        if (atributos.hasOwnProperty(k)) svg.setAttribute(k, atributos[k]);
    return svg;
}
