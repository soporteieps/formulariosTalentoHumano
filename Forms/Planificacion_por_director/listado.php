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

                $where = "where cedula = '".$_SESSION['cedula']."'";

               

 

function countRec() {

                                 $sql = "SELECT count(cedula) FROM plan_vacaciones";

                $result = query($sql);

                while ($row = mysql_fetch_array($result)) {

                               return $row[0];

                }

}

$sql = "select idplan_vacaciones, cedula, nombres, apellidos,case autorizacion when 1 then 'Autorizado' when 0 then 'Rechazado' end as autorizacion,reemplazo from plan_vacaciones $where";


$result = query($sql);

$total = countRec($cedula);

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
	//$xml .= "<cell><![CDATA[<A HREF=../../Planificacion_Vacaciones.php?idplan_vacaciones=".$row['idplan_vacaciones']."&action=update>".$row['idplan_vacaciones']."</A>]]></cell>";
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
?>
