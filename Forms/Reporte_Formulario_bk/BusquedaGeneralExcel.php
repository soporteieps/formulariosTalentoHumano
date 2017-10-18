<?php
include ("../../lib/dbconfig.php");
$cedula_p = $_POST['cedula'];
$iddepartamento_p = $_POST['iddepartamento'];
$reemplazo_p = $_POST['reemplazo'];
$motivo_p = $_POST['motivo'];
$estado_permiso = $_POST['estado_permiso'];
//$where = "";
$where_sql = "";

if($idperfil == '4')
{
	$where_sql = "";
}

if($idperfil == '3')
{
	$where_sql = "where idpersonajefe = (select idpersona from persona where cedula = '".$cedula."')";
}

if($idperfil == '2')
{
	$where_sql = "where cedula = '".$cedula."'";
}
if($idperfil == '4'){
	$where_sql = "";	
	if($cedula_p!=null && $cedula_p!='') 
	{
		$where_sql=" where cedula='$cedula_p'";
	}

	if($motivo_p!=null && $motivo_p!='' && $motivo_p!='-2') 
	{
		if($where_sql<>'')
		{
			$where_sql.=" and motivo=$motivo_p";
		}
		else 
		{
			$where_sql=" where motivo=$motivo_p";
		}
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
			$where_sql.=" and dp.autorizacion='$estado_permiso'";
		}
		else
		{
			$where_sql.=" where dp.autorizacion='$estado_permiso'";
		}
	}
}                  
	$sql = "select dp.iddatopersonal, dp.cedula, dp.nombres, dp.apellidos, d.nombre, c.valor, dp.fechainicio, dp.fechafin, dp.horainicio, dp.horafin, 
ca.valor as autorizacion, 
dp.observaciones 
from dato_personal dp
inner join catalogos c on (c.codigo=dp.motivo and c.tipo = 'motivo')
inner join catalogos ca on (ca.codigo=dp.autorizacion and ca.tipo = 'estado_permiso')
inner join departamento d on (d.iddepartamento=dp.unidadoperativa) $where_sql";
                
$result = query($sql);

		echo "<table id='reporte' border='1'>
		<tr>
			<th>Cedula</th>
			<th>Nombres</th>
			<th>Apellidos</th>
			<th>Direccion/Unidad</th>
			<th>Motivo</th>
			<th>Fecha_Inicio</th>
			<th>Fecha_Fin</th>
			<th>Hora_Inicio</th>
			<th>Hora_Fin</th>
			<th>Observaciones</th>
			<th>Autorizacion</th>
		</tr>";
		while($row = mysql_fetch_array($result))
		  {	
		  	$cedula = utf8_encode($row['cedula']);
		  	$nombres = utf8_encode($row['nombres']);
		  	$apellidos = utf8_encode($row['apellidos']);
		  	$unidadoperativa = utf8_encode($row['nombre']);
		  	$motivo = utf8_encode($row['valor']);
		  	$fechainicio = utf8_encode($row['fechainicio']);
		  	$fechafin = utf8_encode($row['fechafin']);
		  	$horainicio = utf8_encode($row['horainicio']);
		  	$horafin = utf8_encode($row['horafin']);
		  	$observaciones = utf8_encode($row['observaciones']);
		  	$autorizacion = utf8_encode($row['autorizacion']);
		  	echo "<tr>";
		  	echo "<td align='left'>" . $cedula  . "</td>";
		  	echo "<td align='left'>" . $nombres . "</td>";
		  	echo "<td align='left'>" . $apellidos . "</td>";
		  	echo "<td align='left'>" . $unidadoperativa . "</td>";
		  	echo "<td align='left'>" . $motivo . "</td>";
		  	echo "<td align='left'>" . $fechainicio . "</td>";
		  	echo "<td align='left'>" . $fechafin . "</td>";
		  	echo "<td align='left'>" . $horainicio . "</td>";
		  	echo "<td align='left'>" . $horafin . "</td>";
		  	echo "<td align='left'>" . $observaciones . "</td>";
		  	echo "<td align='left'>" . $autorizacion . "</td>";
		  	echo "</tr>";
		  }
		echo "</table>";
?>