<?php
include("../lib/dbconfig.php");
session_start(); 
$usuario=$_POST['usuario'];
$contrasena=$_POST['contrasena'];
$activo=$_POST['activo'];
//echo "Hola:".$username."---".md5($password);

//$consulta="select u.cod_usuario, u.cod_tipo_usuario, u.nombre_usuario, u.user_name, u.password, 
  //         u.cod_area from usuario u  
//			where u.user_name='".$username."' and u.password='".md5($password)."'";
			
	$consulta="select u.idusuario, u.usuario, u.contrasena,u.activo, u.cedula,pu.idperfil,p.idpersonajefe,p.idpersona,p.nombre,p.apellido, u.ingreso
				from usuario u
				inner join perfil_usuario pu on(pu.idusuario = u.idusuario)
				inner join persona p on(p.cedula = u.cedula) where usuario='".$usuario."' and contrasena='".$contrasena."' and p.activo=1";
	/****************INICIO registro en el logs de monitoreo de uso del sistema*******************/
	logs($consulta,$usuario, true);		
	/******************FIN registro en el logs de monitoreo de uso del sistema*******************/		
	$result=query($consulta);
	echo "result=".$result."<br>";
	//Si no se autoriza el ingreso regresa a la pantalla de validación
	if(!isset($result))
		{
		header('Location: ../index.php');
		
			
					echo "no entro<br>";
		}
	
	if(isset($result))
	{
		//Registra las variables de la sesión y direcciona al menú principal
		while($usuario=mysql_fetch_object($result))
				{	
					$_SESSION["idusuario"]=$usuario->idusuario;
					$_SESSION["username"]=$usuario->usuario;
					$_SESSION["password"]=$usuario->contrasena;
					$_SESSION["usuario"]=$usuario->usuario;
					$_SESSION["contrasena"]=$usuario->contrasena;
					$_SESSION["cedula"]=$usuario->cedula;
					$_SESSION["idperfil"]=$usuario->idperfil;
					$_SESSION["idpersonajefe"]=$usuario->idpersonajefe;
					$_SESSION["idpersona"]=$usuario->idpersona;
					$_SESSION["nombre"]=$usuario->nombre;
					$_SESSION["apellido"]=$usuario->apellido;
					$ingreso=$usuario->ingreso;
				}
		//header('Location: ../Admin/admin.php');
		
		if($ingreso!="")
		{
			if($ingreso==0)
				header('Location: ../Forms/Cambiar_Clave/clave.php');
			else
				header('Location: ../menu/mainMenu.php');
		}else
				header('Location: ../menu/mainMenu.php');
		
		//header('Location: ../menu/mainMenu.php');
		
		echo "perfil ".$_SESSION["idperfil"]."<br>";
		echo "jefe ". $_SESSION["idpersonajefe"]."<br>";
		echo "idpersona ". $_SESSION["idpersona"]."<br>";
		echo "nombre ". $_SESSION["nombre"]."<br>";
		echo "apellido ". $_SESSION["apellido"]."<br>";
		
	}
?>
