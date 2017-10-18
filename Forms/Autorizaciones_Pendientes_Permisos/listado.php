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

$cedula_p = $_POST['cedula'];
$codigo_p = $_POST['motivo'];
$reemplazo_p = $_POST['reemplazo'];
$estado_permiso= $_POST['estado_permiso'];


$cedula = $_SESSION['cedula'];
$idperfil = $_SESSION['idperfil'];



if (!$sortname) $sortname = 'name';
if (!$sortorder) $sortorder = 'desc';
$sort = "ORDER BY $sortname $sortorder";
if (!$page) $page = 1;
if (!$rp) $rp = 10;
$start = (($page-1) * $rp);
$limit = "LIMIT $start, $rp";

$where_sql = "";


if($idperfil == '3'){
	//$where_sql = "where idpersonajefe = (select idpersona from persona where cedula = '".$cedula."')  and autorizacion='".$estado_permiso."'";
	$where_sql = "where idpersonajefe = (select idpersona from persona where cedula = '".$cedula."')";
}
/*
if($cedula_p!=null && $cedula_p!='') {
	$where_sql.=" and cedula='$cedula_p'";
}*/

/*if($codigo_p!=null && $codigo_p!='' && $codigo_p!='-2') {
	$where_sql.=" and dp.motivo=$codigo_p";
}*/

if($reemplazo_p!=null && $reemplazo_p!='' && $reemplazo_p!='-3') {
	$where_sql.=" and dp.idpersona=$reemplazo_p";
}


if($estado_permiso != '-2' && $estado_permiso != '')
{
	$where_sql.=" and dp.autorizacion='$estado_permiso'";
}


//echo "where_sql=".$where_sql."<br> ,estado_permiso=".$estado_permiso; 

function countRec($where_sql) {
	$sql = "SELECT count(dp.cedula) FROM dato_personal dp $where_sql";
	$result = query($sql);
	while ($row = mysql_fetch_array($result)) 
	{
		return $row[0];
    }
}

$sql = "select dp.iddatopersonal, dp.cedula, concat(dp.nombres,' ',dp.apellidos) as nombres, d.nombre, c.valor, dp.fechainicio, dp.fechafin, dp.horainicio, dp.horafin, ca.valor as estado_permiso, dp.observaciones, dp.archivo 
from dato_personal dp
inner join catalogos c on (c.codigo=dp.motivo and c.tipo = 'motivo')
inner join catalogos ca on (ca.codigo=dp.autorizacion and ca.tipo = 'estado_permiso')
inner join departamento d on (d.iddepartamento=dp.unidadoperativa) $where_sql order by dp.fechainicio desc";




$total = countRec($where_sql);
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
	$xml .= "<row id='".$row['iddatopersonal']."'>";
	$xml .= "<cell><![CDATA[<A HREF=../../formulario.php?iddatopersonal=".$row['iddatopersonal']."&action=update>".$row['iddatopersonal']."</A>]]></cell>";
	if($row['archivo'] <> "")	
	{
		$xml .= "<cell><![CDATA[<A HREF='../../".$row['archivo']."' target='_blank'><img src='../../images/carpeta.jpg' alt='Descargar' height='25' width='25'></img></A>]]></cell>";
	}
	
	else
	{
		$xml .= "<cell><![CDATA[".utf8_encode($row['archivo'])."]]></cell>";
	}
	
	//$xml .= "<cell><![CDATA[".$cedula_p."]]></cell>";
	$xml .= "<cell><![CDATA[".$row['cedula']."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['nombres'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['valor'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['fechainicio'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['fechafin'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['horainicio'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['horafin'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['observaciones'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['estado_permiso'])."]]></cell>";
	$xml .= "</row>";
}

$xml .= "</rows>";
echo $xml;


$_SESSION["cedula"] = $cedula;
$_SESSION["idpersona"] = $idpersona;
?>
