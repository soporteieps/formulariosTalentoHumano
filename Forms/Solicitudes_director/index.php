<?php
  session_start(); 
  $s=session_name();
  include '../../lib/dbconfig.php';
 // include("../../clases/cerrar_sesion.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>CONSULTA SOLICITUD DE VACACIONES</title>
    <link rel="stylesheet" type="text/css" href="../../css/style.css" />
    <link rel="stylesheet" type="text/css" href="../../css/flexigrid.css" />
    <link rel="stylesheet" href="../../css/themes/base/jquery.ui.all.css">
    <script src='../../js/jquery-1.6.4.min.js'></script> 
    <script type="text/javascript" src="../../js/flexigrid.pack.js"></script>  
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
    <script src="../../js/ieps/validaciones.js"></script>
 <style>
		  .flexigrid div.fbutton .export
		 {
			background: url('../../images/export.gif') no-repeat center left;
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

 <div class="demo">

<form action="./ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
<!--<p>Exportar a Excel <a href="#"><img src="../../images/export_to_pdf.jpg" class="botonExcel" /></a></p>-->
<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
</form>

</div>   

<script type="text/javascript">
$(".flexme3").flexigrid({
	url : 'listado.php',
	dataType : 'xml',
	colModel : [ 
			{display : 'Id', name : 'idsolicitud', width : 80, sortable : true, align : 'left'},
			{display : 'Cédula', name : 'cedula', width : 80, sortable : true, align : 'left'},
			{display : 'Nombres', name : 'nombres', width : 150, sortable : true, align : 'left'}, 
			{display : 'Apellidos', name : 'apellidos', width : 150, sortable : true, align : 'left'},
		//	{display : 'Direcci�n/Unidad', name : 'unidadoperativa', width : 150, sortable : true, align : 'left'},
			{display : 'Fecha_inicio', name : 'fecha_inicio', width : 150, sortable : true, align : 'left'},
			{display : 'Fecha_fin', name : 'fecha_fin', width : 150, sortable : true, align : 'left'}, 
			{display : 'Autorización', name : 'autorizacion', width : 60, sortable : true, align : 'left'}, 
			{display : 'Reemplazo', name : 'reemplazo', width : 300, sortable : true, align : 'left'}, 
			
			],
	buttons : [
	//		{name : 'Crear Formulario', bclass : 'crear', onpress : funciones},
	//		{name : 'Crear Planificacion_Vacaciones', bclass : 'crear', onpress : funciones},
			{name : 'Exportar', bclass : 'export', onpress : exportarExcell},
			{separator : true}
			
			],
	searchitems : [ 
			{display : 'cedula', name : 'cedula', isdefault : true} 
			],
	
	sortname : "cedula",
	sortorder : "asc",
	usepager : true,
	title : 'CONSULTA SOLICITUD DE VACACIONES',
	useRp : false,
	rp : 100,
	showTableToggleBtn : true,
	width : 1050,
	height : 410,
	singleSelect: true
}); 

/*function funciones(com, grid) {

	if (com == 'Crear Planificacion_Vacaciones') {
				document.location.href = "../../Planificacion_Vacaciones.php?action=insert";
	}
	*/
	//if (com == 'Exportar') {
//	     $.ajax({  
//            type: "POST",  
//            url: "BusquedaGeneralExcel.php",  
//            data: data, 
//			// data:'cod_provincia='+$('#cmbProvincia').val()+'&cod_certificado='+$('#cmbCertifi').val()+'&placa='+$('#cmbPlaca').val()+'&cod_estado='+$('#cmbEstado').val(),
//            success: function(html){  
//				    $("#datos_a_enviar").val(html);
//				 $("#FormularioExportacion").submit();
//				 
//          }  
//        });  
//} 

//}

function exportarExcell(com, grid) {
	if (com == 'Exportar') {
		     $.ajax({  
                 type: "POST",  
                 url: "BusquedaGeneralExcel.php",  
                 //data: data, 
				// data:'cod_provincia='+$('#cmbProvincia').val()+'&cod_certificado='+$('#cmbCertifi').val()+'&placa='+$('#cmbPlaca').val()+'&cod_estado='+$('#cmbEstado').val(),
                 success: function(html){  
					    $("#datos_a_enviar").val(html);
     				 $("#FormularioExportacion").submit();
					 
               }  
             });  
	} 
	
}

$(function() {
	
});
</script>
            
    </body>
    </html>
    
