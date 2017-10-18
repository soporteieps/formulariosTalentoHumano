<?php

session_start();
$s=session_name();
include '../../lib/dbconfig.php';
$page = isset($_POST['page']) ? $_POST['page'] : 1;
$rp = isset($_POST['rp']) ? $_POST['rp'] : 50;
$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'cedula';
$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
$query = isset($_POST['query']) ? $_POST['query'] : false;
$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : false;
$usingSQL = true;
$page = $_POST['page'];
$rp = $_POST['rp'];
$sortname = $_POST['sortname'];
$sortorder = $_POST['sortorder'];

$idperfil = $_SESSION["idperfil"];
$idpersonajefe = $_SESSION["idpersonajefe"];
$cedula = $_SESSION["cedula"];
$idpersona = $_SESSION["idpersona"];

if (!$sortname) $sortname = 'name';
if (!$sortorder) $sortorder = 'desc';
$sort = "ORDER BY $sortname $sortorder";
if (!$page) $page = 1;
if (!$rp) $rp = 10;
$start = (($page-1) * $rp);
$limit = "LIMIT $start, $rp";

/*if($idperfil == '1'){
	//$sql = "select 	idplan_vacaciones, cedula, nombres, apellidos,case autorizacion when 1 then 'Autorizado' when 0 then 'Rechazado' end as autorizacion,reemplazo from plan_vacaciones";
	$sql = "select 	idsolicitud, cedula, nombres, apellidos, fecha_inicio, fecha_fin,
	case autorizacion when 1 then 'Autorizado' when 0 then 'Rechazado' end as autorizacion,reemplazo from solicitud_vacaciones";

}elseif($idperfil == '3'){
*/
	//$sql = "select idplan_vacaciones, cedula, nombres, apellidos,case autorizacion when 1 then 'Autorizado' when 0 then 'Rechazado' end as autorizacion,reemplazo from plan_vacaciones where idpersonajefe = '".$idpersona."' or cedula = '".$cedula."'";
	/*$sql = "select 	idsolicitud, cedula, nombres, apellidos, fecha_inicio, fecha_fin,
	case autorizacion when 1 then 'Autorizado' when 0 then 'Rechazado' end as autorizacion,
			reemplazo from solicitud_vacaciones where cedula = '".$cedula."'";// where idpersonajefe = (select idpersona from persona where cedula = '".$cedula."')";
	*/
	$sql = "select sv.idsolicitud, sv.cedula, sv.nombres, sv.apellidos, d.nombre, sv.fecha_inicio, sv.fecha_fin, sv.reemplazo, case sv.autorizacion when 1 then 'Autorizado' when 0 then 'Rechazado' end as autorizacion,p.idpersona, p.nombre, p.apellido from solicitud_vacaciones sv
inner join departamento d on (d.iddepartamento=sv.unidadoperativa)
inner join persona p on (p.idpersona=sv.reemplazo) where sv.cedula = '".$cedula."'";
	
/*}
else{
	$sql = "select 	idsolicitud, cedula, nombres, apellidos, fecha_inicio, fecha_fin,
	case autorizacion when 1 then 'Autorizado' when 0 then 'Rechazado' end as autorizacion,reemplazo from solicitud_vacaciones where cedula = '".$cedula."'";

}
  */ 
//$result = mysql_query($sql,$connect);
$result = query($sql);

		echo "<table id='reporte' border='1'>
		<tr>
			<th>Cedula</th>
			<th>Nombres</th>
			<th>Apellidos</th>
			<th>Fecha_inicio</th>
			<th>Fecha_fin</th>
			<th>Reemplazo</th>
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
		  	$autorizacion = utf8_encode($row['autorizacion']);
		  	
		  	
		  	echo "<tr>";
		  	echo "<td align='left'>" . $cedula  . "</td>";
		  	echo "<td align='left'>" . $nombres . "</td>";
		  	echo "<td align='left'>" . $apellidos . "</td>";
		  	echo "<td align='left'>" . $fecha_inicio . "</td>";
		  	echo "<td align='left'>" . $fecha_fin . "</td>";
		  	echo "<td align='left'>" . $reemplazo. "</td>";
		  	echo "<td align='left'>" . $autorizacion . "</td>";
		  	
		  	echo "</tr>";
		/*  $provincia = utf8_encode($row['provincia']);
			$placa = utf8_encode($row['placa']);
		  	$vehiculo = utf8_encode($row['vehiculo']);
			$conductor = utf8_encode($row['conductor']);
			$fecha_abastecimiento = utf8_encode($row['fecha_abastecimiento']); 
			$kilometraje_actual = utf8_encode($row['kilometraje_actual']); 
			$orden_abastecimiento = utf8_encode($row['orden_abastecimiento']); 
			$recibo_estac_servicio = utf8_encode($row['recibo_estac_servicio']); 
			$tipo_combustible = utf8_encode($row['tipo_combustible']); 
			$galones = utf8_encode($row['galones']); 
			$valor = utf8_encode($row['valor']); 
			$observaciones = utf8_encode($row['observaciones']); */
			/*  echo "<tr>";
			  echo "<td align='left'>" . $provincia  . "</td>";
			  echo "<td align='left'>" . $placa . "</td>";
  			  echo "<td align='left'>" . $vehiculo . "</td>";
			  echo "<td align='left'>" . $conductor . "</td>";
			  echo "<td align='left'>" . $fecha_abastecimiento. "</td>";
			  echo "<td align='left'>" . $kilometraje_actual . "</td>";
			  echo "<td align='left'>" . $orden_abastecimiento . "</td>";
			  echo "<td align='left'>" . $recibo_estac_servicio . "</td>";
			  echo "<td align='left'>" . $tipo_combustible . "</td>";
			  echo "<td align='left'>" . $galones . "</td>";
 			  echo "<td align='left'>" . $valor . "</td>";
              echo "<td align='left'>" . $observaciones . "</td>";
			  echo "</tr>";
			  */  
		  }
		echo "</table>";
		mysql_free_result($result);	
?>