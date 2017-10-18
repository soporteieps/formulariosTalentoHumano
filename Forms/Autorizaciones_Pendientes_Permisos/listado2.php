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

$cedula = $_SESSION['cedula'];
$idperfil = $_SESSION['idperfil'];

/*$idperfil = $_SESSION["idperfil"];
$idpersonajefe = $_SESSION["idpersonajefe"];
$cedula = $_SESSION["cedula"];
$idpersona = $_SESSION["idpersona"];
*/
if (!$sortname) $sortname = 'name';
if (!$sortorder) $sortorder = 'desc';
$sort = "ORDER BY $sortname $sortorder";
if (!$page) $page = 1;
if (!$rp) $rp = 10;
$start = (($page-1) * $rp);
$limit = "LIMIT $start, $rp";

$where = "";

if($idperfil == '3'){

                $where = "where idpersonajefe = (select idpersona from persona where cedula = '".$cedula."')";

}
/*
if($idperfil == '2'){

                $where = "where cedula = '".$cedula."'";

                }

*/ 

function countRec($where) {

                                 $sql = "SELECT count(cedula) FROM dato_personal $where";

                $result = query($sql);

                while ($row = mysql_fetch_array($result)) {

                               return $row[0];

                }

}

//$sql = "select iddatopersonal, cedula, nombres, apellidos, motivo, fechainicio, fechafin, horainicio, horafin, case autorizacion when 1 then 'Autorizado' when 0 then 'Rechazado' end as autorizacion from dato_personal $where";
$sql = "select dp.iddatopersonal, dp.cedula, dp.nombres, dp.apellidos, d.nombre, c.valor, dp.fechainicio, dp.fechafin, dp.horainicio, dp.horafin, case autorizacion when 1 then 'Autorizado' when 0 then 'Rechazado' end as autorizacion, dp.observaciones, dp.archivo from dato_personal dp
inner join catalogos c on (c.codigo=dp.motivo)
inner join departamento d on (d.iddepartamento=dp.unidadoperativa) $where";
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
	$xml .= "<row id='".$row['iddatopersonal']."'>";
	$xml .= "<cell><![CDATA[<A HREF=../../formulario.php?iddatopersonal=".$row['iddatopersonal']."&action=update>".$row['iddatopersonal']."</A>]]></cell>";
//	$xml .= "<cell><![CDATA[".utf8_encode($row['iddatopersonal'])."]]></cell>";
	
	
	if($row['archivo'] <> "")
	
	{
	
	
		//	$xml .= "<cell><![CDATA[".utf8_encode($row['archivo'])."]]></cell>";
		$xml .= "<cell><![CDATA[<A HREF='../../".$row['archivo']."' target='_blank'><img src='../../images/carpeta.jpg' alt='Descargar' height='25' width='25'></img></A>]]></cell>";
	}
	
	else
	{
	
	}
	
//	$xml .= "<cell><![CDATA[<A HREF='../../".$row['archivo']."' target='_blank'><img src='../../images/carpeta.jpg' alt='Descargar' height='25' width='25'></img></A>]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['cedula'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['nombres'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['apellidos'])."]]></cell>";
//	$xml .= "<cell><![CDATA[".utf8_encode($row['unidadoperativa'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['valor'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['fechainicio'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['fechafin'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['horainicio'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['horafin'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['observaciones'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['autorizacion'])."]]></cell>";
	
	
	
	$xml .= "</row>";
}

$xml .= "</rows>";
echo $xml;

$_SESSION["cedula"] = $cedula;
$_SESSION["idpersona"] = $idpersona;
?>
