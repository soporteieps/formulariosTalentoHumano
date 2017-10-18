<?
error_reporting(0);
include '../../lib/dbconfig.php';
$cod_proyecto = $_POST['cod_tipo_usuario'];
$Nombre = trim($_POST['Nombre']);
$Descripcion = trim($_POST['Descripcion']);


$Validar=mysql_query("SELECT COUNT(*) as result FROM tipo_usuario where cod_tipo_usuario<>'$cod_tipo_usuario'",$conexion);
$result2=mysql_fetch_array($Validar);  

//if($result2['result']=='0')
//{
	$sql = mysql_query("UPDATE tipo_usuario SET Nombre='$Nombre',Descripcion='$Descripcion' where cod_tipo_usuario=".(int)$cod_tipo_usuario,$conexion);
//}

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
header("Content-type: text/x-json");
$json[validacion] = $result2['result'];
echo json_encode($json);
mysql_free_result($Validar);	
mysql_free_result($sql);	
include '../../lib/cerrar_conexion.php';
?>