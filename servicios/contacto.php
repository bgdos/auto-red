<?php
  // validar que existan los datos
if (isset($_POST['email']) & 
   isset($_POST['nombre']) & 
   isset($_POST['asunto']) & 
   isset($_POST['mensaje'])) 
   {
        // variables
 
        $email_to = "juans@auto-red.wc.lt, juans@translead.com, kris_1992_10_03@hotmail.com, krishnam@auto-red.wc.lt "; // required
        $email_from = $_POST['email']; // required
        $email_subject = $_POST['asunto']; // required
        $first_name = $_POST['nombre']; // required
        $email_message = $_POST['mensaje']; // required
     
 
        // create email headers

        $headers = 'From: '.$email_from."\r\n".

        'Reply-To: '.$email_from."\r\n" .

        'X-Mailer: PHP/' . phpversion();

        if (@mail($email_to, $email_subject, $email_message, $headers))
        {
            //echo '{ "status" : 0, "mensaje" : "Correo enviado, nos contactaremos con usted en las proximas 24 hrs." }';
            ?>
<!DOCTYPE HTML>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Contacto | Auto-Red - Tu red de servicios automotrices</title>
        <link href="../css/estilo.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="../js/funciones.js"></script>
    </head>
    <body onload="slides();">
        <!-- header  -->
        <div class="fila">
            <div class="header">
                <!-- Logo -->
                <div class="logo">
                    <a href="../index.html"><img src="../images/logo.png" alt="Auto-Red" style="display:block;float:left;"></a>
                </div>
                <!-- login -->
                <form class="login" id="login">
                    <div class="campos">
                        <input id="varUsuario" name="varUsuario" type="text" placeholder="Usuario" class="campo"></input>
                        <input id="varContrasena" name="varContrasena" type="password" placeholder="Contraseña" class="campo"></input>
                        <input type="button" class="boton" value="Ingresar" id="boton" onclick="obtenerToken(1);"/>
                    </div>
                </form>
            </div>
            <div class="col-12">
                <div class="nav">
                    <ul>
                        <li><a href="../index.html">Inicio</a></li>
                        <li><a href="../servicios.html">Servicios</a></li>
                        <li class="activo"><a href="../contacto.html">Contacto</a></li>
                        <li class="ultimo"><a href="../registro.html">Registro</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- contenido  -->
        <div class="fila">
            <!-- contenido general de la pagina -->
            <!-- Error -->
            <div class="error" id="id2">
                <h1>Mensaje Enviado<br>
                    <img src="http://www.lonuevodehoy.com/wp-content/uploads/2013/03/email-imagen.jpg" id="error">
                    <br>Nos comunicaremos con usted<b><br> en las proximas 24 horas</b>.
                </h1>
            </div>
            
        </div>
        <!-- footer -->
        <div class="fila">
            <div class="col-12">
                <div class="nav">
                    <ul>
                        <li><a href="../index.html">Inicio</a></li>
                        <li><a href="../servicios.html">Servicios</a></li>
                        <li class="activo"><a href="../contacto.html">Contacto</a></li>
                        <li class="ultimo"><a href="/gistro.html">Registro</a></li>
                    </ul>
                </div>
                <div class="footer">
                    <h1><b>Auto-Red </b>Tu red personal de auto servicios</h1>
                    <p>
		      <b>Desarrollado por: </b>SOLTIC Enterprise S.A.
		      <br>
                      <b>Direccion:</b>Carretera libre a Tecate Km10, El Refugio
                      <br>
                      <b>Telefono:</b>(664) 650-9525
                      <br>
                      <b>Correo:</b>
                      <a href="mailto: juans@auto-red.wc.lt">juans@auto-red.wc.lt</a>, 
		      <a href="mailto: krishnam@auto-red.wc.lt">krishnam@auto-red.wc.lt</a>
		      <br><b>Auto-Red ©, SOLTIC Enterprise ® </b>2015 
                </div>
            </div>
        </div>
    </body>
</html>
<?php
            
        }
    
else
    {
    ?>
<!DOCTYPE HTML>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Error | Auto-Red - Tu red de servicios automotrices</title>
        <link href="../css/estilo.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="../js/funciones.js"></script>
    </head>
    <body onload="slides();">
        <!-- header  -->
        <div class="fila">
            <div class="header">
                <!-- Logo -->
                <div class="logo">
                    <a href="index.html"><img src="images/logo.png" alt="Auto-Red" style="display:block;float:left;"></a>
                </div>
                <!-- login -->
                <form class="login" id="login">
                    <div class="campos">
                        <input id="varUsuario" name="varUsuario" type="text" placeholder="Usuario" class="campo"></input>
                        <input id="varContrasena" name="varContrasena" type="password" placeholder="Contraseña" class="campo"></input>
                        <input type="button" class="boton" value="Ingresar" id="boton" onclick="obtenerToken(1);"/>
                    </div>
                </form>
            </div>
            <div class="col-12">
                <div class="nav">
                    <ul>
                        <li><a href="../index.html">Inicio</a></li>
                        <li><a href="../servicios.html">Servicios</a></li>
                        <li class="activo"><a href="../contacto.html">Contacto</a></li>
                        <li class="ultimo"><a href="../registro.html">Registro</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- contenido  -->
        <div class="fila">
            <!-- contenido general de la pagina -->
            <!-- Error -->
            <div class="error" id="id2">
                <h1>Ups! ha habido un<br>
                    <img src="images/fixing-exe-errors.jpg" id="error">
                    <br><b>Existen Datos invalidos</b><span>Por favor regresa y llena los campos faltantes.</span>
                </h1>
            </div>
            
        </div>
        <!-- footer -->
        <div class="fila">
            <div class="col-12">
                <div class="nav">
                    <ul>
                        <li><a href="../index.html">Inicio</a></li>
                        <li><a href="../servicios.html">Servicios</a></li>
                        <li class="activo"><a href="../contacto.html">Contacto</a></li>
                        <li class="ultimo"><a href="/gistro.html">Registro</a></li>
                    </ul>
                </div>
                <div class="footer">
                    <h1><b>Auto-Red </b>Tu red personal de auto servicios</h1>
                    <p>
		      <b>Desarrollado por: </b>SOLTIC Enterprise S.A.
		      <br>
                      <b>Direccion:</b>Carretera libre a Tecate Km10, El Refugio
                      <br>
                      <b>Telefono:</b>(664) 650-9525
                      <br>
                      <b>Correo:</b>
                      <a href="mailto: juans@auto-red.wc.lt">juans@auto-red.wc.lt</a>, 
		      <a href="mailto: krishnam@auto-red.wc.lt">krishnam@auto-red.wc.lt</a>
		      <br><b>Auto-Red ©, SOLTIC Enterprise ® </b>2015 
                </div>
            </div>
        </div>
    </body>
</html>
<?php    }
}
 
?>
