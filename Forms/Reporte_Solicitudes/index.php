<?php
  session_start(); 
  $s=session_name();
  include '../../lib/dbconfig.php';
  $_SESSION["tipo"] = $_GET['tipo'];
  $tipo = $_GET['tipo'];
 // include("../../clases/cerrar_sesion.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>SUBRROGACIONES</title>
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
    
     <?php 
  if(($idperfil == '1' || $idperfil == '3' || $idperfil == '4') && $tipo == 'general'){
  	?>
  	
     <div>
   		<form name="form1" method="post"> 
        <table width="100%">
        <tr>
           	<td colspan="6" align="center"><span class="style2"><em><strong><font color="#003399" size="2" face="Arial, Helvetica, sans-serif">FILTROS DE BUSQUEDA</font></strong></em></td>
        </tr>
	    <tr>
   			<td width="100"><span class="style2"><em><strong><font color="#003399" size="2" face="Arial, Helvetica, sans-serif">*Cedula:</font></strong></em></td>
		    <td><font size="1" face="Arial, Helvetica, sans-serif"><input type="text" id="cedula" name="cedula" maxlength="10"></input></font></td>
             <?php 
				if(($idperfil == '1' || $idperfil == '4')  && $tipo == 'general'){	
			?>	
   			<td width="150"><span class="style2"><em><strong><font color="#003399" size="2" face="Arial, Helvetica, sans-serif">*Direccion/Unidad:</font></strong></em></td>
   			<td><font size="1" face="Arial, Helvetica, sans-serif"> 
   			<select name="iddepartamento" id="iddepartamento">
   			 <option value="-1">---Seleccione Direccion---</option>
   			 
		     <?php
				
					$departamento="select iddepartamento,nombre from departamento where activo = 1 order by nombre";	
					$departamento1=query($departamento);
					while($lista_departamento=mysql_fetch_object($departamento1))
						{		
								echo "<option value='". $lista_departamento->iddepartamento ."'>".$lista_departamento->nombre."</option>";
						}
			?>
			</select></font></td>
            <? 	
				}
			?>
			<td width="100"><span class="style2"><em><strong><font color="#003399" size="2" face="Arial, Helvetica, sans-serif">*Estado Autorización :</font></strong></em></td>
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
    	</tr>
        <tr>
        	<td colspan="6" align="center">
	   			 <input name='btnBuscar' id='btnBuscar' type='button' value="Buscar"></input>
            </td>
   		</tr>
   <? 	
			}
	?>
    
        <tr>
            <td colspan="6">   
                 <table align="center">
                        <tr>
                            <td>
                                <div >
                                    <table class="flexme3" style="display: none"></table>
                                </div>
                            </td>
                       </tr>
                  </table>
            </td>
        </tr>
	</table>
</form>
</div>

 <div class="demo">
 
 <table style="border-style:none; display: ">
     <tr>
        <td bgcolor='#084164'><font color='#ffffff' size='2'>Cedula</font></td>
        <td>
         <?php
        echo '<Input name="cedula_user" id="cedula_user" value='.$_SESSION["cedula"].' disabled="disabled">';
         ?> 
        </td>
        <td bgcolor='#084164'><font color='#ffffff' size='2'>Perfil</font></td>
        <td>
        <?php
        echo '<Input name="idperfil" id="idperfil" value= '.$_SESSION["idperfil"].' disabled="disabled">';
        ?>                
        </td>
        <td bgcolor='#084164'><font color='#ffffff' size='2'>Tipo</font></td>
        <td>
        <?php
        echo '<Input name="tipo" id="tipo" value= '.$_SESSION["tipo"].' disabled="disabled">';
        ?>                
        </td>
      </tr>
  </table>

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
			{display : 'Id', name : 'idsolicitud', width : 40, sortable : true, align : 'left'},
			{display : 'Cédula', name : 'cedula', width : 80, sortable : true, align : 'left'},
			{display : 'Nombres', name : 'nombres', width : 120, sortable : true, align : 'left'}, 
			{display : 'Apellidos', name : 'apellidos', width : 120, sortable : true, align : 'left'},
			{display : 'Fecha Inicio', name : 'fecha_inicio', width : 60, sortable : true, align : 'left'},
			{display : 'Fecha Fin', name : 'fecha_fin', width : 60, sortable : true, align : 'left'}, 
		//	{display : 'Cedula Reemplazo', name : 'reemplazo', width : 200, sortable : true, align : 'left'},
			{display : 'Nombre Reemplazo', name : 'nombre', width : 120, sortable : true, align : 'left'},
			{display : 'Apellido Reemplazo', name : 'apellido', width : 120, sortable : true, align : 'left'},
			{display : 'Autorización', name : 'autorizacion', width : 80, sortable : true, align : 'left'},			 
		//	{display : 'cedula', name : 'cedula', width : 80, sortable : true, align : 'left'}, 
		//	{display : 'idperfil', name : 'idperfil', width : 20, sortable : true, align : 'left'}, 
			
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
	
	sortname : "fecha_inicio",
	sortorder : "asc",
	usepager : true,
	title : 'REPORTE SOLICITUD DE VACACIONES',
	useRp : false,
	rp : 100,
	showTableToggleBtn : true,
	width : 1050,
	height : 410,
	singleSelect: true
}); 

function exportarExcell(com, grid) {
	if (com == 'Exportar') {
		     $.ajax({  
                 type: "POST",  
                 url: "BusquedaGeneralExcel.php",  
				 data:'cedula='+$('#cedula').val()+'&idperfil='+$('#idperfil').val()+'&iddepartamento='+$('#iddepartamento').val()+'&estado_permiso='+$('#estado_permiso').val()+'&tipo='+$('#tipo').val()+'&cedula_user='+$('#cedula_user').val(),
                 success: function(html){  
					    $("#datos_a_enviar").val(html);
     				 $("#FormularioExportacion").submit();
					 
               }  
             });  
	} 
	
}

$(function() {
	
});

$(document).ready(function(){	
	$("#btnBuscar").click(function(event) {
		$(".flexme3").flexOptions({params:[{name:'cedula', value: $('#cedula').val()},
										   {name:'iddepartamento', value: $('#iddepartamento').val()},
										   {name:'estado_permiso', value: $('#estado_permiso').val()}
									//	   {name:'motivo', value: $('#motivo').val()},
									//	   {name:'reemplazo', value: $('#reemplazo').val()}
										  ]});
		$(".flexme3").flexReload();		
	});
})

</script>
            
    </body>
    </html>
    
