<?php
include "../../Classes/PHPExcel.php";
include "../../Classes/PHPExcel/Writer/Excel2007.php";
include '../../lib/dbconfig.php';
session_start();


$cedulaEmpleado = $_POST['cedulaEmpleado'];
$estadoPermiso = $_POST['estadoPermiso'];
$cedulaJefe = $_SESSION["cedula"];

$server = "http://10.2.74.21/formularios_talento_humano/";

// Create new PHPExcel object
//echo date('H:i:s') . " Create new PHPExcel object\n";
$objPHPExcel = new PHPExcel();

// Set properties
//echo date('H:i:s') . " Set properties\n";
$objPHPExcel->getProperties()->setCreator("REPORTE DE PERMISOS");
$objPHPExcel->getProperties()->setLastModifiedBy("root");
$objPHPExcel->getProperties()->setTitle("REPORTE DE PERMISOS");
$objPHPExcel->getProperties()->setSubject("REPORTE DE PERMISOS");
$objPHPExcel->getProperties()->setDescription("REPORTE DE PERMISOS");


// Add some data
//echo date('H:i:s') . " Add some data\n";
$objPHPExcel->setActiveSheetIndex(0);
$contador = 3;
$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'REPORTE DE PERMISOS');
$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'CEDULA');
$objPHPExcel->getActiveSheet()->SetCellValue('B2', 'NOMBRES');
$objPHPExcel->getActiveSheet()->SetCellValue('C2', 'FECHA INICIO');
$objPHPExcel->getActiveSheet()->SetCellValue('D2', 'FECHA FIN');
$objPHPExcel->getActiveSheet()->SetCellValue('E2', 'ARCHIVO');
$objPHPExcel->getActiveSheet()->SetCellValue('F2', 'ESTADO');

$sql = "";

if($cedulaEmpleado > 0)
{
	

	$sql = "SELECT dp.cedula as cedula, dp.nombres as nombres, dp.apellidos as apellidos, dp.fechainicio as FechaInicio, dp.fechafin as FechaFin, dp.archivo as Link, case dp.autorizacion when 0 then 'rechazado' when -1 then 'pendiente' when 1 then 'autorizado' end as Autorizacion   
	FROM dato_personal dp
	WHERE dp.idpersonajefe = " . $cedulaJefe . " and dp.autorizacion = " . $estadoPermiso . " and dp.cedula = '" . $cedulaEmpleado . "'";
}
else
{
	$sql = "SELECT dp.cedula as cedula, dp.nombres as nombres, dp.apellidos as apellidos, dp.fechainicio as FechaInicio, dp.fechafin as FechaFin, dp.archivo as Link, case dp.autorizacion when 0 then 'rechazado' when -1 then 'pendiente' when 1 then 'autorizado' end as Autorizacion   
	FROM dato_personal dp
	WHERE dp.idpersonajefe = " . $cedulaJefe . " and dp.autorizacion = " . $estadoPermiso;
}

$result = query($sql);
//echo $sql;

while($res = mysql_fetch_object($result))
{
	$cedulaEmpleado = $res->cedula;
	$nombres = $res->nombres;
	$apellidos = $res->apellidos;
	$fechaInicio = $res->FechaInicio;
	$fechaFin = $res->FechaFin;
	$link = $server . $res->Link;
	$estado = $res->Autorizacion;

	$objPHPExcel->getActiveSheet()->SetCellValue('A' . $contador, $cedulaEmpleado);
	$objPHPExcel->getActiveSheet()->SetCellValue('B' . $contador, $nombres . " " . $apellidos);
	$objPHPExcel->getActiveSheet()->SetCellValue('C' . $contador, $fechaInicio);
	$objPHPExcel->getActiveSheet()->SetCellValue('D' . $contador, $fechaFin);	
	$objPHPExcel->getActiveSheet()->SetCellValue('E' . $contador, '=HYPERLINK("' . $link .'", "archivo")');
	$objPHPExcel->getActiveSheet()->SetCellValue('F' . $contador, $estado);
	$contador++;


}	

/*foreach ($_FILES as $key) 
{

	
	$nombreOriginal = $key['name'];	
	$archivoName = basename($nombreOriginal, ".pdf");
	$objPHPExcel->getActiveSheet()->SetCellValue('A' . $contador, $nombreOriginal);
	$objPHPExcel->getActiveSheet()->SetCellValue('B' . $contador, '=HYPERLINK("' . $ruta.$nombreOriginal.'","' . $archivoName .'")');
	$contador++;
}*/




// Rename sheet
//echo date('H:i:s') . " Rename sheet\n";
$objPHPExcel->getActiveSheet()->setTitle('Reporte');

		
// Save Excel 2007 file
//echo date('H:i:s') . " Write to Excel2007 format\n";
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('reporte.xlsx');

echo "reporte.xlsx";





?>