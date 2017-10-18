<?php
include_once('cartelera/framework/util/Constantes.php');

session_start();

//include '../../lib/dbconfig.php';

$output_dir = str_replace("uploads","cargar_lote",Constantes::$strPathBaseUploadsToComplete);//"uploads/";
$output_dir_tabla ="";

if(isset($_FILES["myfile"])) {
	$ret = array();

	$error =$_FILES["myfile"]["error"];
	
	$post =$_POST;
	
	$modulo =$_POST["modulo"];
	
	if($modulo!=null && $modulo!='') {
		$tabla =$_POST["tabla"];
		$columna =$_POST["columna"];
		
		$output_dir_tabla=$modulo.'/'.$tabla.'/'.$columna.'/';
		
		$output_dir=$output_dir.$output_dir_tabla;
		
		$_SESSION["PATH_UPLOADS_ACTUAL"]=$output_dir;
		
		if(!file_exists($output_dir)) {
		    mkdir($output_dir,"0777",true);		  
		}
	}
	
	//You need to handle  both cases
	//If Any browser does not support serializing of multiple files using FormData() 
	if(!is_array($_FILES["myfile"]["name"])) //single file
	{		
		//$_FILES["myfile"]["name"]="111_".$_FILES["myfile"]["name"];
		
 	 	$fileName = $_FILES["myfile"]["name"];
 	 	
 	 	$id =$_POST["id"];	
		if($id!=null && $id!='' && $id>0) {
			$_FILES["myfile"]["name"]=$id."_".$_FILES["myfile"]["name"];
			$fileName = $_FILES["myfile"]["name"];
		}						
 	 	
 	 	move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName);
 	 	
 	 	
 	 	//localhost:3306
 	 	$mysqlLink = mysql_pconnect('localhost', 'root', '') or die('Could not connect: ' . mysql_error()); 	 	
 	 	mysql_select_db('formularios') or die('Could not select database');

 	 	
 	 /*	$dbhost='localhost'; //Host del mysql
 	 	$dbuser='root'; //Usuario del mysql
 	 	$dbpass=''; // del mysql
 	 	$db='formularios'; //db donde se creará la tabla users
 	 	$conec = mysql_connect("$dbhost","$dbuser","$dbpass");
 	 	mysql_select_db("$db");*/
 	 	$sql = "TRUNCATE TABLE asistencias";
 	 	
 	 	mysql_query($sql,$mysqlLink) or die('Query failed: ' . mysql_error());
 	 	//$cambiar=mysql_query($sql);
 	 	/*if($cambiar){
 	 		echo "Se a eliminado correctamente los datos.<br>";
 	 	}else{
 	 		echo "No se pudo eliminar los datos.<br>";
 	 	}*/
 	 	
 	 	$path_file=$output_dir.$fileName;
 	 	
		$file_data = fopen($path_file, "r") or die("Unable to open file!");
		$line='';
		$line_columns='';
		$i=0;
		
		while(!feof($file_data)) {
			$line=fgets($file_data);
			$line_columns=explode("\t",$line);
			
			
			
			$sQuery="";
			
			if($i==0) {
				$i++;
				continue;
			} 
			
			$sQuery=getQueryInsert($line_columns);
			
			guardarAsistencia($sQuery,$mysqlLink);
			
			$i++;
		}
		
 	 	
    	$ret[]= $fileName;
	}
	else  //Multiple files, file[]
	{
	  $fileCount = count($_FILES["myfile"]["name"]);
	  
	  for($i=0; $i < $fileCount; $i++) {
	  	$fileName = $_FILES["myfile"]["name"][$i];
		move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName);
	  	$ret[]= $fileName;
	  }	
	}
	
    echo json_encode($ret);
 }
 
function getQueryInsert($line_columns) {
 	$sQuery="";
 	$fecha=date("Y/m/d");
 	$hora=date("h:i:s");

 	$fechahora_columns=explode(" ",$line_columns[4]);
 	
 	$fecha_datos=$fechahora_columns[0];
 	$hora_datos=$fechahora_columns[0];
 	
 	$hora_datos1=$fechahora_columns[1];
 	$hora_datos2=$fechahora_columns[2];
 	$hora_datos3=$fechahora_columns[3];
 	$hora_datos4=$fechahora_columns[4];
 	$hora_datos5=$fechahora_columns[5];
 	
 	$fecha_columns=explode("/",$fecha_datos);
 	$fecha_datos=$fecha_columns[2]."-".$fecha_columns[0]."-".$fecha_columns[1];
 	
	
 	
 	$sQuery.="INSERT INTO formularios.asistencias(codigo,unidadoperativa,dia,fecha,hora_entrada,hora_salida_lunch,hora_retorno_lunch,hora_salida,hora_salida_permiso, hora_retorno_permiso, atrasos,salidas_tempranas,ausencia) ";
 	$sQuery.="VALUES ('$line_columns[0]','$line_columns[2]','$line_columns[5]','$line_columns[6]','$hora_datos','$hora_datos1','$hora_datos2','$hora_datos3','$hora_datos4','$hora_datos5',0,0,0);";
 	
 	
 	
 	return $sQuery;
 }
 
 function guardarAsistencia($sQuery,$mysqlLink) {
	
 	try {
 			
 		//mysql_query('SET AUTOCOMMIT=0;',$mysqlLink) or die('Query failed: ' . mysql_error());
 
 		mysql_query($sQuery,$mysqlLink) or die('Query failed: ' . mysql_error());
 
 	} catch(Exception $e) {
 		throw $e;
 	}
 		 	
 }
 ?>