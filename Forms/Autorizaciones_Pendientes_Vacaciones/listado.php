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

if($idperfil == '2'){

                $where = "where cedula = '".$cedula."'";

                }

 

function countRec($where) {

                                 $sql = "SELECT count(cedula) FROM solicitud_vacaciones $where";

                $result = query($sql);

                while ($row = mysql_fetch_array($result)) {

                               return $row[0];

                }

}

//$sql = "select idsolicitud, cedula, nombres, apellidos, unidadoperativa, case autorizacion when 1 then 'Autorizado' when 0 then 'Rechazado' end as autorizacion,reemplazo from solictud_vacaciones $where";
$sql = "select sv.idsolicitud, sv.cedula, sv.nombres, sv.apellidos, d.nombre, sv.fecha_inicio, sv.fecha_fin, sv.reemplazo, case sv.autorizacion when 1 then 'Autorizado' when 0 then 'Rechazado' end as autorizacion from solicitud_vacaciones sv
inner join departamento d on (d.iddepartamento=sv.unidadoperativa)  $where";


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
	$xml .= "<row id='".$row['idsolicitud']."'>";
	$xml .= "<cell><![CDATA[<A HREF=../../Solicitud_Vacaciones.php?idsolicitud=".$row['idsolicitud']."&action=update>".$row['idsolicitud']."</A>]]></cell>";
//	$xml .= "<cell><![CDATA[".utf8_encode($row['idsolicitud'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['cedula'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['nombres'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['apellidos'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['fecha_inicio'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['fecha_fin'])."]]></cell>";
//	$xml .= "<cell><![CDATA[".utf8_encode($row['nombre'])."]]></cell>";
//	$xml .= "<cell><![CDATA[".utf8_encode($row['reemplazo'])."]]></cell>";
	$xml .= "<cell><![CDATA[".utf8_encode($row['autorizacion'])."]]></cell>";
//	$xml .= "<cell><![CDATA[".utf8_encode($cedula)."]]></cell>";
//	$xml .= "<cell><![CDATA[".utf8_encode($idperfil)."]]></cell>";
	$xml .= "</row>";
}

$xml .= "</rows>";
echo $xml;

$_SESSION["cedula"] = $cedula;
$_SESSION["idpersona"] = $idpersona;
?>
