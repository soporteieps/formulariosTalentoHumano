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
    <title>REPORTE</title>
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
    
    <div>
   		<form name="form1" method="post" >
        <table width="100%">
        	<tr>
            	<td colspan="5" align="center"><span class="style2"><font color="#003399" size="2" face="Arial, Helvetica, sans-serif">FILTROS DE BUSQUEDA</font></td>
            </tr>
        	<tr> 
   			<!--<td width="100"><span class="style2"><font color="#003399" size="2" face="Arial, Helvetica, sans-serif">*Cedula:</font></td>
    	   <td><font size="1" face="Arial, Helvetica, sans-serif"><input type="text" id="cedula" name="cedula"></input></font></td>-->
   		   <td width="100"><span class="style2"><font color="#003399" size="2" face="Arial, Helvetica, sans-serif">*Nombres:</font></td>
		   <td><font size="1" face="Arial, Helvetica, sans-serif">	
   			<select name="reemplazo" id="reemplazo"><option value="-3">---------------Todos---------------</option>
        <?php
        if($idperfil == '3'){
        	$departamento="select idpersona, nombre, apellido from persona where idpersonajefe='".$_SESSION["cedula"]."' and idpersona <>'".$_SESSION["idpersona"]."' and activo = 1 order by apellido";
        }
        elseif($idperfil == '2'){
			$departamento="select idpersona, nombre, apellido from persona where idpersonajefe='".$_SESSION["idpersonajefe"]."' and idpersona <>'".$_SESSION["idpersona"]."' and activo = 1 order by apellido";
        	//$departamento="select idpersona, nombre, apellido from persona where idpersonajefe='1716894702' order by apellido";
        }
			echo($departamento);
			$departamento1=query($departamento);
			while($lista_departamento=mysql_fetch_object($departamento1))
				{	
					if($reemplazo==$lista_departamento->idpersona)
					{
						echo "<option value='". $lista_departamento->idpersona ."'selected>".$lista_departamento->apellido." &nbsp;".$lista_departamento->nombre."</option>";
						}
						else
						
						{
						
						echo "<option value='". $lista_departamento->idpersona ."'>".$lista_departamento->apellido." &nbsp;".$lista_departamento->nombre."</option>";
						}
				}
		?>
	</select></font></td>
   			<!--</tr>
   			<tr>
  			<td width="100"><span class="style2"><font color="#003399" size="2" face="Arial, Helvetica, sans-serif">*Motivo :</font></td>
    		<td><font size="1" face="Arial, Helvetica, sans-serif">
		<select name='motivo' id='motivo'><option value="-2">---Seleccione Motivo---</option>
		<?php /*?> <?php
		 
			$motivo="select codigo, valor from catalogos where tipo = 'motivo'";
			echo($motivo);
			$motivo1=query($motivo);
			while($lista_motivo=mysql_fetch_object($motivo1))
				{	
					if($codigo==$lista_motivo->codigo) 
					{		
					echo "<option value='". $lista_motivo->codigo ."'selected>".$lista_motivo->valor."</option>";
					}
				
					else
				
					{
						
					echo "<option value='". $lista_motivo->codigo ."'>".$lista_motivo->valor."</option>";
						
					}
				}		
			?><?php */?>
		</select>
		</font>
		</td>-->
        <td width="100"><span class="style2"><font color="#003399" size="2" face="Arial, Helvetica, sans-serif">*Estado Autorización :</font></td>
    		<td><font size="1" face="Arial, Helvetica, sans-serif">
		<select name='estado_permiso' id='estado_permiso'><option value="-2">---Seleccione Estado---</option>
		 <?php
		 
			$motivo="select codigo,valor from catalogos where tipo = 'estado_permiso' order by codigo";
			echo($motivo);
			$motivo1=query($motivo);
			while($lista_motivo=mysql_fetch_object($motivo1))
				{	
					if($codigo==$lista_motivo->codigo) 
					{		
					echo "<option value='". $lista_motivo->codigo ."'selected>".$lista_motivo->valor."</option>";
					}
				
					else
				
					{
						
					echo "<option value='". $lista_motivo->codigo ."'>".$lista_motivo->valor."</option>";
						
					}
				}		
			?>
		</select>
		</font>
		</td>
		<td><input name='btnBuscar' id='btnBuscar' type='button' value="Buscar"></input>
		<input name='btnExcel' id='btnExcel' type='button' value="Exportar" onclick="exportarExcell1();"></input></td>

</span>
</tr>
    
			<tr>
            	<td colspan="5">
	                <div >
       					<table class="flexme3" style="display: none"></table>
                    </div>
                </td>
           </tr>
      </table>
         <br/>
    </div> 

 <div class="demo">
 
 <table style="border-style:none">

<td width="240" align="center" valign="middle">

<td width="140" align="center" bgcolor='#084164'><font color='#ffffff' size='2' face='Arial, Helvetica, sans-serif'><strong><left>cedula</left></strong></font></td>

                <td width="240" align="center" valign="middle">

 <?php
echo '<Input name="cedula" id="cedula" value='.$_SESSION["cedula"].' hidden class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;">';
 ?>
     
</td>
            
<td width="140" align="center" bgcolor='#084164'><font color='#ffffff' size='2' face='Arial, Helvetica, sans-serif'><strong><left>idperfil</left></strong></font></td>

<td width="240" align="center" valign="middle">

<?php
echo '<Input name="idperfil" id="idperfil" value= '.$_SESSION["idperfil"].' hidden class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;">';

?>                
</td>

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
			{display : 'Id', name : 'iddatopersonal', width : 30, sortable : true, align : 'left'},
			{display : 'Archivo', name : 'archivo', width : 40, sortable : true, align : 'left'},
			{display : 'Cédula', name : 'cedula', width : 60, sortable : true, align : 'left'},
			{display : 'Nombres', name : 'nombres', width : 200, sortable : true, align : 'left'}, 
			{display : 'Motivo', name : 'valor', width : 110, sortable : true, align : 'left'},
			{display : 'Fecha Inicio', name : 'fechainicio', width : 65, sortable : true, align : 'left'},
			{display : 'Fecha Fin', name : 'fechafin', width : 65, sortable : true, align : 'left'},
			{display : 'Hora Inicio', name : 'horainicio', width : 55, sortable : true, align : 'left'},
			{display : 'Hora Fin', name : 'horafin', width : 55, sortable : true, align : 'left'}, 
			{display : 'Observación', name : 'observaciones', width : 180, sortable : true, align : 'left'},
			{display : 'Autorización', name : 'estado_permiso', width : 60, sortable : true, align : 'left'}, 			  
			
			],
	
	searchitems : [ 
			{display : 'cedula', name : 'cedula', isdefault : true} 
			],
	
	sortname : "cedula",
	sortorder : "asc",
	usepager : true,
	title : 'REPORTE PERMISOS',
	useRp : false,
	rp : 100,
	showTableToggleBtn : true,
	width : 1080,
	height : 410,
	singleSelect: true
}); 

function exportarExcell(com, grid) {
	if (com == 'Exportar') {
		     $.ajax({  
                 type: "POST",  
                 url: "BusquedaGeneralExcel.php",  
				 data:'cedula='+$('#cedula').val()+'&idperfil='+$('#idperfil').val()+'&estado_permiso='+$('#estado_permiso').val(),
                 success: function(html){  
					    $("#datos_a_enviar").val(html);
     				 $("#FormularioExportacion").submit();			 
               }  
             });  
	} 	
}

function cargarAjax()
{
	var xmlhttp;
	if(window.XMLHttpRequest)
		xmlhttp = new XMLHttpRequest();
	else
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

	return xmlhttp;
}

function exportarExcell1()
{
	var datoEmpleado = $('#reemplazo').prop('selected', true).val();
	var estadoPermiso = $('#estado_permiso').prop('selected', true).val();

	var miAjax = cargarAjax();
	var fdata = new FormData();


	if(datoEmpleado < 0)
	{
		//todos los empleados 
		
		fdata.append('estadoPermiso', estadoPermiso);
		fdata.append('cedulaEmpleado', 0);

		

	}
	else
	{

		fdata.append('estadoPermiso', estadoPermiso);
		fdata.append('cedulaEmpleado', datoEmpleado);		
		
	}

	miAjax.open("POST", "ReporteExcel.php", true);

	miAjax.onload = function(e)
	{
		if(miAjax.status == 200)
		{
			window.open('http://10.2.74.21/formularios_talento_humano/Forms/Autorizaciones_Pendientes_Permisos/' + miAjax.responseText);
		}
		else
		{
			alert('No se puede crear el archivo excel');
		}
	};
	miAjax.send(fdata);
}

$(function() {
	
});

$(document).ready(function(){	
	$("#btnBuscar").click(function(event) {		
		$(".flexme3").flexOptions({params:[{name:'cedula', value: $('#cedula').val()},
										   {name:'motivo', value: $('#motivo').val()},
											{name:'reemplazo', value: $('#reemplazo').val()},
											{name:'estado_permiso', value: $('#estado_permiso').val()}
										  ]});
		$(".flexme3").flexReload();		
	});
})
</script>
            
    </body>
    </html>
    
