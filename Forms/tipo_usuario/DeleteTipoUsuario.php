<?
error_reporting(0);
include '../../lib/dbconfig.php';
$items = rtrim($_POST['items'],",");
$sql = "DELETE FROM `tipo_usuario` WHERE `cod_tipo_usuario` IN ($items)";
$result = query($sql);

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
header("Content-type: text/x-json");
$json = "";
$json .= "{\n";
$json .= "query: '".$sql."',\n";
$json .= "cod_tipo_usuario: $items \n";
$json .= "}\n";
echo json_encode($json);
?>