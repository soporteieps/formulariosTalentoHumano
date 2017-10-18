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

	$sql = "select 	iddatopersonal, cedula, nombres, apellidos, unidadoperativa, motivo, fechainicio, fechafin,	case autorizacion when 1 then 'Autorizado' when 0 then 'Rechazado' end as autorizacion from dato_personal where cedula = '".$cedula."'";


//$result = mysql_query($sql,$connect);
$result = query($sql);

		echo "<table id='reporte' border='1'>
		<tr>
			<th>Cedula</th>
			<th>Nombres</th>
			<th>Apellidos</th>
			<th>Fechainicio</th>
			<th>Fechafin</th>
			<th>Horainicio</th>
			<th>Horafin</th>
			<th>Motivo</th>
			<th>Autorizacion</th>
			
				
		</tr>";
		while($row = mysql_fetch_array($result))
		  {	
		  	
		  	$cedula = utf8_encode($row['cedula']);
		  	$nombres = utf8_encode($row['nombres']);
		  	$apellidos = utf8_encode($row['apellidos']);
		  	$fechainicio = utf8_encode($row['fechainicio']);
		  	$fechafin = utf8_encode($row['fechafin']);
		  	$horaincio = utf8_encode($row['horainicio']);
		  	$horafin = utf8_encode($row['horafin']);
		  	$motivo = utf8_encode($row['motivo']);
		  	$autorizacion = utf8_encode($row['autorizacion']);
		  	
		  	
		  	echo "<tr>";
		  	echo "<td align='left'>" . $cedula  . "</td>";
		  	echo "<td align='left'>" . $nombres . "</td>";
		  	echo "<td align='left'>" . $apellidos . "</td>";
		  	echo "<td align='left'>" . $fechainicio . "</td>";
		  	echo "<td align='left'>" . $fechafin . "</td>";
		  	echo "<td align='left'>" . $horainicio . "</td>";
		  	echo "<td align='left'>" . $horafin . "</td>";
		  	echo "<td align='left'>" . $motivo . "</td>";
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