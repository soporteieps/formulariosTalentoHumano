<?php
  session_start(); 
  $s=session_name();
  include '../../lib/dbconfig.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>ADMINISTRACIÓN DE USUARIOS</title>
    <link rel="stylesheet" type="text/css" href="../../css/style.css" />
    <link rel="stylesheet" type="text/css" href="../../css/flexigrid.css" />
    <script src='../../js/jquery-1.6.4.min.js'></script> 
    <script type="text/javascript" src="../../js/flexigrid.pack.js"></script>  
    <link rel="stylesheet" href="../../css/themes/base/jquery.ui.all.css">
    <script src="../../js/external/jquery.bgiframe-2.1.2.js"></script>
    <script src="../../js/ui/jquery.ui.core.js"></script>
    <script src="../../js/ui/jquery.ui.widget.js"></script>
    <script src="../../js/ui/jquery.ui.mouse.js"></script>
    <script src="../../js/ui/jquery.ui.button.js"></script>
    <script src="../../js/ui/jquery.ui.draggable.js"></script>
    <script src="../../js/ui/jquery.ui.position.js"></script>
    <script src="../../js/ui/jquery.ui.resizable.js"></script>
    <script src="../../js/ui/jquery.ui.dialog.js"></script>
    <script src="../../js/ui/jquery.effects.core.js"></script>    
    <script src="../../js/ui/jquery.ui.datepicker.js"></script> 
	<script src="../../js/jquery-ui-1.8.14.custom.min.js"></script>
    <script src="../../js/jquery-ui-timepicker-addon.js"></script> 
    <script src="../../js/validaciones.js"></script> 
    
    <script type="text/javascript" src="../../admin/js/validador_ci.js"></script>
	<script type="text/javascript" src="../../admin/js/crea_usuario.js"></script>
 <style>
	 .flexigrid div.fbutton .add
		 {
			background: url('../../images/add.png') no-repeat center left;
		 } 
	 .flexigrid div.fbutton .delete
		 {
			background: url('../../images/close.png') no-repeat center left;
		 }
	 .flexigrid div.fbutton .edit
		 {
			background: url('../../images/edit.png') no-repeat center left;
		 }
   </style>
</head>
    <body {background-image:url('images/paper2.gif');}>
     <div >
    
     <table align="center">
			<tr>
            	<td>
	                <div >
       					<table class="flexme3" style="display: none"></table>
                    </div>
                </td>
           </tr>
      </table>
         <br />
    </div> 


<script type="text/javascript">
$(".flexme3").flexigrid({
	url : 'listado.php',
	dataType : 'xml',
	colModel : [ 
			{display : 'Cedula', name : 'cedula', width : 80, sortable : true, align : 'left'},
			{display : 'Departamento', name : 'departamento', width : 350, sortable : true, align : 'left'}, 
			{display : 'Nombres', name : 'nombres', width : 300, sortable : true, align : 'left'}, 
			{display : 'Estado', name : 'activo', width : 80, sortable : true, align : 'left'}, 
			],
	buttons : [ 
			{name : 'Crear Usuario', bclass : 'add', onpress : funciones}, 
//			{name : 'Editar', bclass : 'edit', onpress : funciones}, 
//			{name : 'Eliminar', bclass : 'delete', onpress : funciones}, 
//			{separator : true}
			],
	searchitems : [ 
			{display : 'Nombres', name : 'p.nombre'},
			{display : 'Apellidos', name : 'p.apellido'},
			{display : 'Cédula', name : 'cedula', isdefault : true}
			],
	sortname : "cedula,nombres",
	sortorder : "asc",
	usepager : true,
	title : 'MANTENIMIENTO DE USUARIOS',
	useRp : true,
	rp : 50,
	showTableToggleBtn : true,
	width : 1050,
	height : 400,
	singleSelect: true
}); 

function funciones(com, grid) {
	if (com == 'Crear Usuario') {
		//alert('Esta seguro de aprobar a el/los trabajo(s) selecionado(s)='+cod_tipo_usuario);
			//if(cod_tipo_usuario == 3){
				//document.location.href = "../../carpeta.php";}
			//else if(cod_tipo_usuario == 1){
				//document.location.href = "../../ingreso_carpeta_administrador.php";
				document.location.href = "../../clases/crea_usuario.php?cod_usuario=0&accion=formulario";
			//}
	}	
}

$(function() {
	
});</script>
            
    </body>
    </html>
    
