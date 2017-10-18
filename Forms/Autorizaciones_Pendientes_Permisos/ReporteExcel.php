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
$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'IDPERMISO');
$objPHPExcel->getActiveSheet()->SetCellValue('B2', 'CEDULA');
$objPHPExcel->getActiveSheet()->SetCellValue('C2', 'NOMBRES');
$objPHPExcel->getActiveSheet()->SetCellValue('D2', 'FECHA INICIO');
$objPHPExcel->getActiveSheet()->SetCellValue('E2', 'FECHA FIN');
$objPHPExcel->getActiveSheet()->SetCellValue('F2', 'HORA INICIO');
$objPHPExcel->getActiveSheet()->SetCellValue('G2', 'HORA FIN');
$objPHPExcel->getActiveSheet()->SetCellValue('H2', 'ARCHIVO');
$objPHPExcel->getActiveSheet()->SetCellValue('I2', 'ESTADO');
$objPHPExcel->getActiveSheet()->SetCellValue('J2', 'MOTIVO');

$sql = "";

if($cedulaEmpleado > 0)
{
	

	$sql = "SELECT dp.iddatopersonal as codigo,dp.cedula as cedula, dp.nombres as nombres, dp.apellidos as apellidos, dp.fechainicio as FechaInicio, dp.fechafin as FechaFin, dp.horainicio as HoraInicio, dp.horafin as HoraFin, dp.archivo as Link, case dp.autorizacion when 0 then 'rechazado' when -1 then 'pendiente' when 1 then 'autorizado' end as Autorizacion, c.valor as Motivo    
	FROM dato_personal dp
	INNER JOIN catalogos c ON c.cod_catalogo = dp.motivo
	WHERE dp.idpersonajefe = " . $cedulaJefe . " and dp.autorizacion = " . $estadoPermiso . " and dp.cedula = '" . $cedulaEmpleado . "'";
}
else
{
	$sql = "SELECT dp.iddatopersonal as codigo,dp.cedula as cedula, dp.nombres as nombres, dp.apellidos as apellidos, dp.fechainicio as FechaInicio, dp.fechafin as FechaFin, dp.horainicio as HoraInicio, dp.horafin as HoraFin, dp.archivo as Link, case dp.autorizacion when 0 then 'rechazado' when -1 then 'pendiente' when 1 then 'autorizado' end as Autorizacion,  c.valor as Motivo   
	FROM dato_personal dp
	INNER JOIN catalogos c ON c.cod_catalogo = dp.motivo
	WHERE dp.idpersonajefe = " . $cedulaJefe . " and dp.autorizacion = " . $estadoPermiso;
}

$result = query($sql);
//echo $sql;

while($res = mysql_fetch_object($result))
{
	$idCodigo = $res->codigo;
	$cedulaEmpleado = $res->cedula;
	$nombres = $res->nombres;
	$apellidos = $res->apellidos;
	$fechaInicio = $res->FechaInicio;
	$horaInicio = $res->HoraInicio;
	$horaFin = $res->HoraFin;
	$fechaFin = $res->FechaFin;
	if($res->Link != "")
		$link = $server . $res->Link;
	else
		$link = "";
	$estado = $res->Autorizacion;
	$motivo = $res->Motivo;

	$objPHPExcel->getActiveSheet()->SetCellValue('A' . $contador, $idCodigo);
	$objPHPExcel->getActiveSheet()->SetCellValue('B' . $contador, $cedulaEmpleado);
	$objPHPExcel->getActiveSheet()->SetCellValue('C' . $contador, $nombres . " " . $apellidos);
	$objPHPExcel->getActiveSheet()->SetCellValue('D' . $contador, $fechaInicio);
	$objPHPExcel->getActiveSheet()->SetCellValue('E' . $contador, $fechaFin);
	$objPHPExcel->getActiveSheet()->SetCellValue('F' . $contador, $horaInicio);
	$objPHPExcel->getActiveSheet()->SetCellValue('G' . $contador, $horaFin);
	if($res->Link != "")
		$objPHPExcel->getActiveSheet()->SetCellValue('H' . $contador, '=HYPERLINK("' . $link .'", "archivo")');
	else
		$objPHPExcel->getActiveSheet()->SetCellValue('H' . $contador, 'no tiene archivo');
	$objPHPExcel->getActiveSheet()->SetCellValue('I' . $contador, $estado);
	$objPHPExcel->getActiveSheet()->SetCellValue('J' . $contador, $motivo);
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