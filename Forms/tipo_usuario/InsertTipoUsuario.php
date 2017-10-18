<?
error_reporting(0);
include '../../lib/dbconfig.php';
$Nombre = $_POST['Nombre'];
$Descripcion = $_POST['Descripcion'];
$cod_tipo_proyecto = $_POST['cod_tipo_usuario'];
$Validar=mysql_query("SELECT COUNT(*) as result FROM tipo_usuario",$conexion);
$result2=mysql_fetch_array($Validar);  

//if($result2['result']=='0')
//{
	$sql=mysql_query("insert into tipo_usuario (Nombre, Descripcion) values('$Nombre', '$Descripcion')",$conexion);	
//}

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
header("Content-type: text/x-json");
$json[validacion] = $result2['result'];
//$json[Codigo] = $Codigo;
echo json_encode($json);
mysql_free_result($Validar);
mysql_free_result($sql);		
include '../../lib/cerrar_conexion.php';
?>