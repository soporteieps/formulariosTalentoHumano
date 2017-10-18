<?php
date_default_timezone_set('America/Guayaquil');

if (isset($_POST['view']) || isset($_GET['view'])){
	$view='';
	
	if(isset($_GET['view'])) {
		$view=$_GET['view'];
	} else {
		$view=$_POST['view'];
	}
	
	require_once('cartelera/general/view/'.$view.'View.php');
	
} else if (isset($_POST['controller']) || isset($_GET['controller'])){
	$controller='';
	
	if(isset($_GET['controller'])) {
		$controller=$_GET['controller'];
	} else {
		$controller=$_POST['controller'];
	}

	if($controller=='Noticia') {
		require_once('cartelera/general/util/'.$controller.'Cargar.php');
		
		session_start();
		
		NoticiaCargar::CargarRecursos('Controller');
		
		$noticiaController=new NoticiaController();
		
		$noticiaController->cargarParametrosQueryString();		
		$noticiaController->ejecutarParametrosQueryString();
		
	}
	
} else {
	echo('No existe pagina');
}
?>