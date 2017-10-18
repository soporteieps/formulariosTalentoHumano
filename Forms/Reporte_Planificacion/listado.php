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

//$cedula_p = $_POST['cedula'];
if($_POST['query'] != null && $_POST['query'] != '')
	$cedula_p = $_POST['query'];
else
	$cedula_p = $_POST['cedula'];

$iddepartamento_p = $_POST['iddepartamento'];
$reemplazo_p = $_POST['reemplazo'];
$estado_permiso = $_POST['estado_permiso'];

if (!$sortname) $sortname = 'name';
if (!$sortorder) $sortorder = 'desc';
$sort = "ORDER BY $sortname $sortorder";
if (!$page) $page = 1;
if (!$rp) $rp = 10;
$start = (($page-1) * $rp);
$limit = "LIMIT $start, $rp";

$where = "";
$where_sql = "";

function countRec($where) {
	$sql = "SELECT count(pv.cedula) FROM plan_vacaciones pv $where";
	$result = query($sql);
	while ($row = mysql_fetch_array($result)) {
		return $row[0];
	}
}

////REPORTE INDIVIDUAL
if($idperfil == '2' && $tipo == 'individual')
{
	$where_sql = "where cedula = '".$_SESSION['cedula']."'";
}
//
////CUANDO ES REPORTE SOLICITA EN JEFE
if($idperfil == '3' && $tipo == 'individual')
{
	$where_sql = "where cedula = '".$_SESSION['cedula']."'";
}
else
{
	if($idperfil == '3' && $tipo == 'general')
	{
		$where_sql = " where pv.idpersonajefe = '".$_SESSION['cedula']."'";
		
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
	$where_sql = "where cedula = '".$_SESSION['cedula']."'";
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

////CUANDO EL REPORTE SOLICITA ADMINISTRADOR
if($idperfil == '1' && $tipo == 'individual')
{
	if($cedula_p == null || $cedula_p == '')
		$where_sql = '';
	else
		$where_sql = "where pv.cedula = '".$cedula_p."'";
}
else
{
	if($idperfil == '1' && $tipo == 'general')
	{
		if($cedula_p!=null && $cedula_p!='') 
		{
			$where_sql=" where pv.cedula='$cedula_p'";
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

	$sql = "select pv.idplan_vacaciones, pv.cedula, pv.nombres, pv.apellidos,
	ca.valor as autorizacion,
	pv.reemplazo 
	from plan_vacaciones pv
	inner join catalogos ca on (ca.codigo=pv.autorizacion and ca.tipo = 'estado_permiso')
$where_sql $sort $limit";


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
	$xml .= "<row id='".$row['idplan_vacaciones']."'>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['idplan_vacaciones'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['cedula'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['nombres'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['apellidos'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['autorizacion'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['reemplazo'])."]]></cell>";
	$xml .= "</row>";
}

$xml .= "</rows>";

echo $xml;


$_SESSION["cedula"] = $cedula;
$_SESSION["idpersona"] = $idpersona;
?>
