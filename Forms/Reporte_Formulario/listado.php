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
$iddepartamento_p = $_POST['iddepartamento'];
$reemplazo_p = $_POST['reemplazo'];
$motivo_p = $_POST['motivo'];
$estado_permiso = $_POST['estado_permiso'];

$fechaConsultar = $_POST['fechaConsultar'];
$fechaConsultar2 = $_POST['fechaConsultar2'];
$archivo = $_POST['archivo'];
//$iddatopersonal = $_POST['iddatopersonal'];

if (!$sortname) $sortname = 'name';
if (!$sortorder) $sortorder = 'desc';
$sort = "ORDER BY $sortname $sortorder";
if (!$page) $page = 1;
if (!$rp) $rp = 10;
$start = (($page-1) * $rp);
$limit = "LIMIT $start, $rp";

//$where = "";
$where_sql = "";

if($idperfil == '4')
{
	$where_sql = "";
}

if($_SESSION['tipo'] == 'individual')
{
	$where_sql = "where cedula = '".$_SESSION['cedula']."'";
}


//$where_sql = "where cedula = '".$cedula."'";

function countRec($where_sql)
{
	$sql = "SELECT count(dp.cedula) from dato_personal dp
           inner join catalogos c on (c.codigo=dp.motivo and c.tipo = 'motivo')
           inner join catalogos ca on (ca.codigo=dp.autorizacion and ca.tipo = 'estado_permiso')  $where_sql";
	$result = query($sql);
	while ($row = mysql_fetch_array($result)) 
	{
		return $row[0];
	}
}

//CUANDO ES REPORTE SOLICITA EN JEFE
if($idperfil == '3' && $_SESSION['tipo'] == 'general'){
	$where_sql = "where idpersonajefe = '".$_SESSION['cedula']."'";
	
	if($cedula_p!=null && $cedula_p!='') 
	{
		$where_sql.=" and cedula='$cedula_p'";
	}

	if($motivo_p!=null && $motivo_p!='' && $motivo_p!='-2') 
	{
			$where_sql.=" and motivo=$motivo_p";
	}
		
	if($estado_permiso != '-2' && $estado_permiso != '')
	{
			$where_sql.=" and dp.autorizacion='$estado_permiso'";
	}
	
	if($fechaConsultar != '' && $fechaConsultar2 != '')
	{
			$where_sql.=" and dp.fechainicio >='$fechaConsultar' and dp.fechafin <= '$fechaConsultar2'";
	}
}

//CUANDO EL REPORTE SOLICITA RRHH O EL ADMINISTRADOR
if(($idperfil == '1' || $idperfil == '4') && $_SESSION['tipo'] == 'general'){

	$where_sql = "";

	if($cedula_p!=null && $cedula_p!='') 
	{
		$where_sql=" where cedula='$cedula_p'";
	}

	if($motivo_p!=null && $motivo_p!='' && $motivo_p!='-2') 
	{
		if($where_sql<>'')
		{
			$where_sql.=" and motivo=$motivo_p";
		}
		else 
		{
			$where_sql=" where motivo=$motivo_p";
		}
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
			$where_sql.=" and dp.autorizacion='$estado_permiso'";
		}
		else
		{
			$where_sql.=" where dp.autorizacion='$estado_permiso'";
		}
	}
	
	if($fechaConsultar != '' && $fechaConsultar2 != '')
	{
		if($where_sql<>'')
		{
			$where_sql.=" and dp.fechainicio >='$fechaConsultar' and dp.fechafin <= '$fechaConsultar2'";
		}
		else
		{
			$where_sql.=" where dp.fechainicio >='$fechaConsultar' and dp.fechafin <= '$fechaConsultar2'";
		}
	}
}

$sql = "select dp.iddatopersonal, dp.archivo, dp.cedula, dp.nombres, dp.apellidos, 
c.valor,
dp.fechainicio, dp.fechafin, dp.horainicio, dp.horafin, 
ca.valor as autorizacion,
dp.observaciones,dp.archivo
from dato_personal dp
inner join catalogos c on (c.codigo=dp.motivo and c.tipo = 'motivo')
inner join catalogos ca on (ca.codigo=dp.autorizacion and ca.tipo = 'estado_permiso') $where_sql $sort $limit";


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
	
	$xml .= "<cell><![CDATA[<A HREF=../../cambiar_observacion.php?id=".$row['iddatopersonal']."&action=update>".$row['iddatopersonal']."</A>]]></cell>";	
	if($row['archivo'] <> "" )
	{
		$xml .= "<cell><![CDATA[<A HREF='../../".(utf8_encode($row['archivo']))."' target='_blank'><img src='../../images/carpeta.jpg' alt='Descargar' height='25' width='25'></img></A>]]></cell>";
	
	}
	else
	{
		$xml .= "<cell><![CDATA[ ]]></cell>";	
	}
	//$xml .= "<cell><![CDATA[".utf8_encode($row['iddatopersonal'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['cedula'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['nombres'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['apellidos'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['valor'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['fechainicio'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['fechafin'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['horainicio'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['horafin'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['observaciones'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['autorizacion'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['archivo'])."]]></cell>";
	$xml .= "</row>";
}
$xml .= "</rows>";
echo $xml;
?>
