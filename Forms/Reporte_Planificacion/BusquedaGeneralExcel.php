<?php
include ("../../lib/dbconfig.php");
$idperfil = $_POST['idperfil'];
$cedula_p = $_POST['cedula'];
$iddepartamento_p = $_POST['iddepartamento'];
$estado_permiso = $_POST['estado_permiso'];
$cedula_user = $_POST['cedula_user'];
$tipo = $_POST['tipo'];
$sort = "ORDER BY cedula,apellidos";

//$where = "";
$where_sql = "";

////REPORTE INDIVIDUAL
if($idperfil == '2' && $tipo == 'individual')
{
	$where_sql = "where cedula = '".$cedula_user."'";
}
//
////CUANDO ES REPORTE SOLICITA EN JEFE
if($idperfil == '3' && $tipo == 'individual')
{
	$where_sql = "where cedula = '".$cedula_user."'";
}
else
{
if($idperfil == '3' && $tipo == 'general')
	{
		$where_sql = " where pv.idpersonajefe = '".$cedula_user."'";
		
		if($cedula_p!=null && $cedula_p!='') 
		{
			$where_sql.=" and pv.cedula='$cedula_p'";
		}	
		if($estado_permiso != '-2' && $estado_permiso != '')
		{
			$where_sql.=" and pv.autorizacion='$estado_permiso'";
		}
	}
}
////CUANDO EL REPORTE SOLICITA RRHH
if($idperfil == '4' && $tipo == 'individual')
{
	$where_sql = "where cedula = '".$cedula_user."'";
}
else
{
if($idperfil == '4' && $tipo == 'general')
	{
		if($cedula_p!=null && $cedula_p!='') 
		{
			$where_sql=" where cedula='$cedula_p'";
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
				$where_sql.=" and pv.autorizacion='$estado_permiso'";
			}
			else
			{
				$where_sql.=" where pv.autorizacion='$estado_permiso'";
			}
		}
	}
}



	$sql = "select pv.idplan_vacaciones, pv.cedula, pv.nombres, pv.apellidos, pv.fecha_1_salida, pv.fecha_1_retorno,pv.fecha_2_salida, pv.fecha_2_retorno,pv.fecha_3_salida, pv.fecha_3_retorno,pv.fecha_4_salida, pv.fecha_4_retorno,pv.fecha_5_salida,
	pv.fecha_5_retorno,pv.fecha_6_salida, pv.fecha_6_retorno,
	ca.valor as autorizacion, pv.reemplazo 
	from plan_vacaciones pv
	inner join catalogos ca on (ca.codigo=pv.autorizacion and ca.tipo = 'estado_permiso') $where_sql $sort $limit";
	
	
	
//$result = mysql_query($sql,$conexion);
$result = query($sql);

		echo "<table id='reporte' border='1'>
		<tr>
			<th>Cedula</th>
			<th>Nombres</th>
			<th>Apellidos</th>
			<th>Fecha_1_salida</th>
			<th>Fecha_1_retorno</th>
			<th>Fecha_2_salida</th>
			<th>Fecha_2_retorno</th>
			<th>Fecha_3_salida</th>
			<th>Fecha_3_retorno</th>
			<th>Fecha_4_salida</th>
			<th>Fecha_4_retorno</th>
			<th>Fecha_5_salida</th>
			<th>Fecha_5_retorno</th>
			<th>Fecha_6_salida</th>
			<th>Fecha_6_retorno</th>
			<th>Reemplazo</th>
			<th>Autorizacion</th>
		</tr>";
		while($row = mysql_fetch_array($result))
		  {	
		  	
		  	$cedula = utf8_encode($row['cedula']);
		  	$nombres = utf8_encode($row['nombres']);
		  	$apellidos = utf8_encode($row['apellidos']);
		  	$fecha_1_salida = utf8_encode($row['fecha_1_salida']);
		  	$fecha_1_retorno = utf8_encode($row['fecha_1_retorno']);
		  	$fecha_2_salida = utf8_encode($row['fecha_2_salida']);
		  	$fecha_2_retorno = utf8_encode($row['fecha_2_retorno']);
		  	$fecha_3_salida = utf8_encode($row['fecha_3_salida']);
		  	$fecha_3_retorno = utf8_encode($row['fecha_3_retorno']);
		  	$fecha_4_salida = utf8_encode($row['fecha_4_salida']);
		  	$fecha_4_retorno = utf8_encode($row['fecha_4_retorno']);
		  	$fecha_5_salida = utf8_encode($row['fecha_5_salida']);
		  	$fecha_5_retorno = utf8_encode($row['fecha_5_retorno']);
		  	$fecha_6_salida = utf8_encode($row['fecha_6_salida']);
		  	$fecha_6_retorno = utf8_encode($row['fecha_6_retorno']);
		  	$reemplazo = utf8_encode($row['reemplazo']);
		  	$autorizacion = utf8_encode($row['autorizacion']);
		  	
	  	
		  	echo "<tr>";
		  	echo "<td align='left'>" . $cedula  . "</td>";
		  	echo "<td align='left'>" . $nombres . "</td>";
		  	echo "<td align='left'>" . $apellidos . "</td>";
		  	echo "<td align='left'>" . $fecha_1_salida . "</td>";
		  	echo "<td align='left'>" . $fecha_1_retorno . "</td>";
		  	echo "<td align='left'>" . $fecha_2_salida . "</td>";
		  	echo "<td align='left'>" . $fecha_2_retorno . "</td>";
		  	echo "<td align='left'>" . $fecha_3_salida . "</td>";
		  	echo "<td align='left'>" . $fecha_3_retorno . "</td>";
		  	echo "<td align='left'>" . $fecha_4_salida . "</td>";
		  	echo "<td align='left'>" . $fecha_4_retorno . "</td>";
		  	echo "<td align='left'>" . $fecha_5_salida . "</td>";
		  	echo "<td align='left'>" . $fecha_5_retorno . "</td>";
		  	echo "<td align='left'>" . $fecha_6_salida . "</td>";
		  	echo "<td align='left'>" . $fecha_6_retorno . "</td>";
		  	echo "<td align='left'>" . $reemplazo. "</td>";
		  	echo "<td align='left'>" . $autorizacion . "</td>";
		  	echo "</tr>";
		  }
		echo "</table>";
		//mysql_free_result($result);	
?>