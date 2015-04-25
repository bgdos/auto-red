<?php
	class Conexion
	{
		private static $servidor = 'mysql.hostinger.mx';
		private static $baseDatos = 'u325612117_auto';
		private static $usuario = 'u325612117_root';
		private static $contrasena = 'adivina';
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
