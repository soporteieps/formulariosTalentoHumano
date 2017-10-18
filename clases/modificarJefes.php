<?php
include "../lib/dbconfig.php";

//datos enviados desde el archivo js (crea_usuario.js)
$idperfil = $_POST['idperfil'];
$iddepartamento = $_POST['iddepartamento'];

//consultamos los jefes actuales
$consultaJefe =	"SELECT p.nombre as nombre, p.apellido as apellido, p.cedula as cedula, u.activo as activo, pu.idperfil as idenPerfil 
				FROM persona as p
				INNER JOIN usuario as u ON p.cedula = u.cedula
				INNER JOIN perfil_usuario as pu ON u.idusuario = pu.idusuario 
				WHERE pu.idperfil = $idperfil AND p.activo = 1 and (p.iddepartamento=1 or p.iddepartamento=$iddepartamento)
				GROUP BY p.cedula
				ORDER BY p.nombre, p.apellido";
//echo $consultaJefe . "<br>";
$resultadoJefe = query($consultaJefe);

//revisamos los valores de la consulta
$mensaje = "";
$cont = 0;
while($listaJefe = mysql_fetch_object($resultadoJefe))
{
	//revisamos cada resultado de la consulta
	$cont++;
	$cedulaJefe = $listaJefe->cedula;
	$nombreJefe = $listaJefe->nombre . " " . $listaJefe->apellido; 

	//el primer resultado sera seleccionado por defecto que es del jefe de coordinacion
	if($cedulaJefe == '0914320510')
		$mensaje = $mensaje . "<option value='" . $cedulaJefe . "' selected>" . $nombreJefe . "</option>";
	else
		$mensaje = $mensaje . "<option value='" . $cedulaJefe . "'>" . $nombreJefe . "</option>";
}

//devolvemos las opciones armadas en el while
echo $mensaje;
//echo $consultaJefe;

?>