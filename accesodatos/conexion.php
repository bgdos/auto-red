<?php
	class Conexion
	{
		private static $servidor = 'myserver';
		private static $baseDatos = 'mybd';
		private static $usuario = 'myusr';
		private static $contrasena = 'mypass';
		protected static $conexion;
		
		protected static function abrirConexion()
		{
			self::$conexion = new mysqli(self::$servidor, self::$usuario, self::$contrasena, self::$baseDatos);
			if (self::$conexion->connect_errno) 
			{ 
				echo 'Error al conectarse al servidor de MySQL : '.self::$conexion->connect_error;
				die;
			}
		}
		protected static function cerrarConexion()
		{
			self::$conexion->close();
		}
	}
?>
