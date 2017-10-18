<?php
$server = "10.2.74.50";//Dirección del servidor
$user = "root";
$pwd = "ieps000";
$basedatos = "formularios";//Base de datos a ser utilizada
$conexion = mysql_connect($server,$user,$pwd);
	function query($sql)
	{
		$server = "10.2.74.50";//Dirección del servidor
		$user = "root";
		$pwd = "ieps000";
		$basedatos = "formularios";//Base de datos a ser utilizada
		$connect = mysql_connect($server,$user,$pwd);
		mysql_select_db($basedatos, $connect);
		$result=mysql_query ($sql,$connect);//Realizo el query
		return ($result);//Retorno el resultado del query*/
		
	/*	$server = "localhost";//Dirección del servidor
		$user = "root";
		$pwd = "";
		$basedatos = "formularios";//Base de datos a ser utilizada
		$connect = mysql_connect($server,$user,$pwd);
		mysql_select_db($basedatos, $connect);
		$result=mysql_query ($sql,$connect);//Realizo el query
		return ($result);//Retorno el resultado del query*/
	}
?>