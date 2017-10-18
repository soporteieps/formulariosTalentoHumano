<?php
include ("../../lib/dbconfig.php");
$idperfil = $_POST['idperfil'];
$cedula = $_POST['cedula'];

$where = "";

if($idperfil == '3'){

	$where = "where idpersonajefe = (select idpersona from persona where cedula = '".$cedula."')";

}

if($idperfil == '2'){

	$where = "where cedula = '".$cedula."'";

}



	$sql = "select 	idplan_vacaciones, cedula, nombres, apellidos, fecha_1_salida, fecha_1_retorno,fecha_2_salida, fecha_2_retorno,fecha_3_salida, fecha_3_retorno,fecha_4_salida, fecha_4_retorno,fecha_5_salida,
	fecha_5_retorno,fecha_6_salida, fecha_6_retorno,
	case autorizacion when 1 then 'Autorizado' when 0 then 'Rechazado' end as autorizacion,reemplazo from plan_vacaciones where cedula = '".$cedula."'";


	
	
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