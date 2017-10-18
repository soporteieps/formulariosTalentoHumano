<?php
include '../../lib/dbconfig.php';
$page = isset($_POST['page']) ? $_POST['page'] : 1;
$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'Cedula';
$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
$query = isset($_POST['query']) ? $_POST['query'] : false;
$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : false;
$usingSQL = true;
function countRec($fname,$tname) {
	$sql = "SELECT count($fname) FROM $tname ";
	$result = query($sql);
	while ($row = mysql_fetch_array($result)) {
		return $row[0];
	}
}
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
if ($query) $where = " WHERE $qtype LIKE '%".$query."%' ";

$sql = "SELECT idperfil,nombre/*,Descripcion*/ FROM perfil $where $sort $limit";

$result = query($sql);

//$total = countRec('cod_tipo_usuario','tipo_usuario');
$total = countRec('idperfil','perfil');
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
	$xml .= "<row id='".$row['idperfil']."'>";
	$xml .= "<cell><![CDATA[".$row['idperfil']."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['nombre'])."]]></cell>";	
	//$xml .= "<cell><![CDATA[".utf8_encode($row['Descripcion'])."]]></cell>";	
	$xml .= "</row>";
}

$xml .= "</rows>";
echo $xml;