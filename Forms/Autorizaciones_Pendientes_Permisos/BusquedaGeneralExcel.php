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

//$idperfil = $_POST['idperfil'];
//$cedula = $_POST['cedula'];

$where = "";

if($idperfil == '3'){

                $where = "where idpersonajefe = (select idpersona from persona where cedula = '".$cedula."')";

}

if($idperfil == '2'){

                $where = "where cedula = '".$cedula."'";

                }

                $sql = "select dp.iddatopersonal, dp.cedula, dp.nombres, dp.apellidos, d.nombre, c.valor, dp.fechainicio, dp.fechafin, dp.horainicio, dp.horafin, case autorizacion when 1 then 'Autorizado' when 0 then 'Rechazado' end as autorizacion, dp.observaciones from dato_personal dp
                inner join catalogos c on (c.codigo=dp.motivo)
                inner join departamento d on (d.iddepartamento=dp.unidadoperativa) $where";
	
//$result = mysql_query($sql,$conexion);
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
		//mysql_free_result($result);	
?>