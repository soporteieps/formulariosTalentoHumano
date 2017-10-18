<?php
session_start();
$s=session_name();
include '../../lib/dbconfig.php';
$idperfil = $_POST['idperfil'];
$cedula_p = $_POST['cedula'];
$iddepartamento_p = $_POST['iddepartamento'];
$estado_permiso = $_POST['estado_permiso'];
$cedula_user = $_POST['cedula_user'];
$tipo = $_POST['tipo'];
$sort = "ORDER BY sv.fecha_inicio";
$where_sql = "";

////REPORTE INDIVIDUAL
if($idperfil == '2' && $tipo == 'individual')
{
	$where_sql = "where sv.cedula = '".$_SESSION['cedula']."'";
}
//
////CUANDO ES REPORTE SOLICITA EN JEFE
if($idperfil == '3' && $tipo == 'individual')
{
	$where_sql = "where sv.cedula = '".$_SESSION['cedula']."'";
}
else
{
	if($idperfil == '3' && $tipo == 'general')
	{
		$where_sql = " where sv.idpersonajefe = '".$_SESSION['cedula']."'";
		
		if($cedula_p!=null && $cedula_p!='') 
		{
			$where_sql.=" and sv.cedula='$cedula_p'";
		}	
		if($estado_permiso != '-2' && $estado_permiso != '')
		{
			$where_sql.=" and sv.autorizacion='$estado_permiso'";
		}
	}
}

////CUANDO EL REPORTE SOLICITA RRHH
if($idperfil == '4' && $tipo == 'individual')
{
	$where_sql = "where sv.cedula = '".$_SESSION['cedula']."'";
}
else
{
	if($idperfil == '4' && $tipo == 'general')
	{
		if($cedula_p!=null && $cedula_p!='') 
		{
			$where_sql=" where sv.cedula='$cedula_p'";
		}
		
		if($iddepartamento_p!=null && $iddepartamento_p!='' && $iddepartamento_p!='-1') 
		{	
			if($where_sql<>'')
			{
				$where_sql.=" and unidadoperativa=$iddepartamento_p";
			}
			else 
			{
				$where_sql=" where unidadoperativa=$iddepartamento_p";
			}
		}
		if($estado_permiso != '-2' && $estado_permiso != '')
		{
			if($where_sql<>'')
			{
				$where_sql.=" and sv.autorizacion='$estado_permiso'";
			}
			else
			{
				$where_sql.=" where sv.autorizacion='$estado_permiso'";
			}
		}
	}
}

	$sql = "select sv.idsolicitud, sv.cedula, sv.nombres, sv.apellidos, d.nombre, sv.fecha_inicio, sv.fecha_fin, sv.reemplazo, case sv.autorizacion when 1 then 'Autorizado' when 0 then 'Rechazado' end as autorizacion,p.idpersona, p.nombre, p.apellido 
	from solicitud_vacaciones sv
	inner join departamento d on (d.iddepartamento=sv.unidadoperativa)
	inner join persona p on (p.idpersona=sv.reemplazo) 
	inner join catalogos ca on (ca.codigo=sv.autorizacion and ca.tipo = 'estado_permiso') 
	$where_sql $sort";

$result = query($sql);

		echo "<table id='reporte' border='1'>
		<tr>
			<th>Cedula</th>
			<th>Nombres</th>
			<th>Apellidos</th>
			<th>Fecha_inicio</th>
			<th>Fecha_fin</th>
			<th>Cedula Reemplazo</th>
			<th>Nombre Reemplazo</th>
			<th>Apellido Reemplazo</th>
			<th>Autorizacion</th>		
		</tr>";
		while($row = mysql_fetch_array($result))
		  {		
		  	$cedula = utf8_encode($row['cedula']);
		  	$nombres = utf8_encode($row['nombres']);
		  	$apellidos = utf8_encode($row['apellidos']);
		  	$fecha_inicio = utf8_encode($row['fecha_inicio']);
		  	$fecha_fin = utf8_encode($row['fecha_fin']);
		  	$reemplazo = utf8_encode($row['reemplazo']);
		  	$nombre = utf8_encode($row['nombre']);
		  	$apellido = utf8_encode($row['apellido']);
		  	$autorizacion = utf8_encode($row['autorizacion']);		  	
		  	echo "<tr>";
		  	echo "<td align='left'>" . $cedula  . "</td>";
		  	echo "<td align='left'>" . $nombres . "</td>";
		  	echo "<td align='left'>" . $apellidos . "</td>";
		  	echo "<td align='left'>" . $fecha_inicio . "</td>";
		  	echo "<td align='left'>" . $fecha_fin . "</td>";
		  	echo "<td align='left'>" . $reemplazo. "</td>";
		  	echo "<td align='left'>" . $nombre. "</td>";
		  	echo "<td align='left'>" . $apellido. "</td>";
		  	echo "<td align='left'>" . $autorizacion . "</td>";
		  	echo "</tr>";
		  }
		echo "</table>";
		mysql_free_result($result);	
?>