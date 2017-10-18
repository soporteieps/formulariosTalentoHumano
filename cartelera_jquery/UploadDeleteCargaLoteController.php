<?php
include_once('cartelera/framework/util/Constantes.php');

session_start();

//PHP5.3-namespace com\bydan\framework\seguridad\util;

//$output_dir = "uploads/";
$output_dir = str_replace("uploads","cargar_lote",Constantes::$strPathBaseUploadsToComplete);

if($_SESSION['PATH_UPLOADS_ACTUAL']!=null) {
	$output_dir =$_SESSION['PATH_UPLOADS_ACTUAL'];
}

if(isset($_POST["op"]) && $_POST["op"] == "delete" && isset($_POST['name'])) {
	$fileName =$_POST['name'];
	$filePath = $output_dir. $fileName;
	
	if (file_exists($filePath)) {
        unlink($filePath);
    }

    echo "Deleted File ".$fileName."<br>";
}

?>