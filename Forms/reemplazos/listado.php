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

if (!$sortname) $sortname = 'name';
if (!$sortorder) $sortorder = 'desc';
$sort = "ORDER BY $sortname $sortorder";
if (!$page) $page = 1;
if (!$rp) $rp = 10;
$start = (($page-1) * $rp);
$limit = "LIMIT $start, $rp";

$where = "";

function countRec($where) {
	$sql = "SELECT count(s.id_subrrogacion)from subrrogacion s 
	inner join departamento d on(s.id_departamento = d.iddepartamento)
	inner join persona p1 on(s.id_jefesubrrogado = p1.cedula)
	inner join persona p2 on(s.id_jefesubrrogante = p2.cedula) $where";
	$result = query($sql);
	while ($row = mysql_fetch_array($result))
	{
		return $row[0];
	}
}

$sql = "select s.id_subrrogacion, 
	s.id_departamento, 
	d.nombre as departamento, 
	s.id_jefesubrrogado, 
	concat(p1.nombre,' ',p1.apellido)jefesubrrogado , 
	s.id_jefesubrrogante, 
	concat(p2.nombre,' ',p2.apellido)jefesubrrante , 
	s.fecha_inicio, s.fecha_fin, s.fecha_registro, s.observacion,
	case s.activo 
		when 1 then 'Activo'
		else 'Inactivo'
	end activo
	from subrrogacion s 
	inner join departamento d on(s.id_departamento = d.iddepartamento)
	inner join persona p1 on(s.id_jefesubrrogado = p1.idpersona)
	inner join persona p2 on(s.id_jefesubrrogante = p2.idpersona)";


$total = countRec($where);
$result = query($sql);

$rows = array();
while ($row = mysql_fetch_array($result)) {
	$rows[] = $row;
}

header("Content-type: text/xml");
$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$xml .= "<rows>";
$xml .= "<page>$page</page>";
$xml .= "<total>$total</total>";
foreach($rows AS $row){
	$xml .= "<row id='".$row['id_subrrogacion']."'>";
	$xml .= "<cell><![CDATA[<A HREF=../../Subrrogaciones.php?id_subrrogacion=".$row['id_subrrogacion']."&action=edita>".$row['id_subrrogacion']."</A>]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['id_departamento'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['departamento'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['id_jefesubrrogado'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['jefesubrrogado'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['id_jefesubrrogante'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['jefesubrrante'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['fecha_registro'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['fecha_inicio'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['fecha_fin'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['activo'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['observacion'])."]]></cell>";
	
	$xml .= "</row>";
}

$xml .= "</rows>";
echo $xml;

$_SESSION["cedula"] = $cedula;
$_SESSION["idpersona"] = $idpersona;
?>
