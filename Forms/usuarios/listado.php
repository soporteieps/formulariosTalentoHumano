<?php
session_start(); 
$s=session_name();
include '../../lib/dbconfig.php';
$page = isset($_POST['page']) ? $_POST['page'] : 1;
$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'idpersona';
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
if ($query) $where = " WHERE $qtype LIKE '%".$query."%' ";

function countRec($qtype, $query) {
	//$sql = "SELECT count($fname) FROM $tname ";
	$sql = "select count(p.idpersona) from  persona p inner join departamento d on(p.iddepartamento = d.iddepartamento) where ".$qtype." LIKE '%".$query."%'";
	
	$result = query($sql);
	while ($row = mysql_fetch_array($result)) {
		return $row[0];
	}
}
//$sql = "SELECT u.cod_usuario,u.ci_usuario,u.nombres_usuario,u.user_name,u.password FROM usuario as u $where $sort $limit";

$sql = "select p.cedula,d.nombre as departamento,p.cedula,concat(p.nombre,' ',p.apellido) as nombres,
		case p.activo when 1 then 'Activo' when 0 then 'Inactivo' end as activo
		from persona p inner join departamento d on(p.iddepartamento = d.iddepartamento)
		$where $sort $limit";

$result = query($sql);

$total = countRec($qtype, $query);
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
	$xml .= "<row id='".$row['cod_usuario']."'>";
	$xml .= "<cell><![CDATA[<A HREF=../../clases/crea_usuario.php?cod_usuario_aux=".$row['cedula']."&accion=edita>".$row['cedula']."</A>]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['departamento'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['nombres'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['activo'])."]]></cell>";
	$xml .= "</row>";
}

$xml .= "</rows>";
echo $xml;