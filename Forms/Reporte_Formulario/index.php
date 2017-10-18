<?php
header('Content-Type: text/html; charset=UTF-8');
  session_start(); 
  $s=session_name();
  include '../../lib/dbconfig.php';
  $_SESSION["tipo"] = $_GET['tipo'];
  
  //echo "idperfil=".$idperfil.", tipo=",$tipo."<br>";
  
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>REPORTE PERMISOS</title>
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
   		<form name="form1" method="post" accept-charset="UTF-8"> 
        <table width="67%">
        <tr>
          <td colspan="6" align="center"><span class="style2"><em><strong><font color="#003399" size="2" face="Arial, Helvetica, sans-serif">FILTROS DE BÚSQUEDA</font></strong></em></td>
        </tr>
        <tr>
           	<td width="253" align="left"><span class="style2"><em><strong><font color="#003399" size="1" face="Arial, Helvetica, sans-serif">Cédula:</font></strong></em></td>
           	<td width="194" align="left"><font size="1" face="Arial, Helvetica, sans-serif"><input type="text" id="cedula" name="cedula" width="100" maxlength="10"></input></td>
           	<td colspan="4" align="center"><span class="style2"><em><strong><font color="#003399" size="2" face="Arial, Helvetica, sans-serif">Fechas</font></strong></em></td>
       	  </tr>
	    <tr>
	      <td width="253" align="left"><em><strong><font color="#003399" size="1" face="Arial, Helvetica, sans-serif">Dirección/Unidad:</font></strong></em></td>
	      <td width="194" align="left"><font size="1" face="Arial, Helvetica, sans-serif">
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
          </select>
	      </font></td>
		  <td width="157"><span class="style2"><em><strong><font color="#003399" size="1" face="Arial, Helvetica, sans-serif">Desde:</font></strong></em></td>
        <td width="112"><font size="1" face="Arial, Helvetica, sans-serif"><input type="text" id="fechaConsultar" placeholder="Haga clic aquí" name="fechaConsultar" width="50" ></input></td>
        <td width="52"><em><strong><font color="#003399" size="1" face="Arial, Helvetica, sans-serif"> Hasta:</font></strong></em></td>
        <td width="112"><font size="1" face="Arial, Helvetica, sans-serif">
          <input type="text" id="fechaConsultar2" placeholder="Haga clic aquí" name="fechaConsultar2" width="50" />
          </input></td>
        </tr>
      <tr>
	    <td width="253"><span class="style2"><em><strong><font color="#003399" size="1" face="Arial, Helvetica, sans-serif">Motivo :</font></strong></em></td>
   		<td><font size="1" face="Arial, Helvetica, sans-serif">
		  <select name='motivo' id='motivo'><option value="-2">---Seleccione Motivo---</option>
		    <?php
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
		?>
	</select> </font></td>
        <td width="157"><span class="style2"><em><strong><font color="#003399" size="1" face="Arial, Helvetica, sans-serif">Estado Autorización :</font></strong></em></td>
          <td colspan="3"><font size="1" face="Arial, Helvetica, sans-serif">
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
             <input name='btnLimpiar' id='btnLimpiar' type='button' value="Limpiar"></input>
   			 <input name='btnBuscar' id='btnBuscar' type='button' value="Buscar"></input>
             </td>
        </tr>
   
   <? 	
			}
	?>
    	<tr>
           	<td colspan="6" align="center">
	             <div >
       				<table class="flexme3" style="display: none"></table>
    			</div>
           </td>
       </tr>
	</table>
    </form>
    </div>
<div class="demo">
 
 <table style="border-style:none; display:none ">
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
			{display : 'ID', name : 'iddatopersonal', width : 30, sortable : true, align : 'center'},
			{display : 'ARCHIVO', name : 'archivo', width : 50, sortable : true, align : 'center'},
			{display : 'CÉDULA', name : 'cedula', width : 70, sortable : true, align : 'left'},
			{display : 'NOMBRES', name : 'nombres', width : 150, sortable : true, align : 'left'}, 
			{display : 'APELLIDOS', name : 'apellidos', width : 150, sortable : true, align : 'left'},
			{display : 'MOTIVO', name : 'valor', width : 140, sortable : true, align : 'left'},
			{display : 'FECHA INICIO', name : 'fechainicio', width : 70, sortable : true, align : 'left'},
			{display : 'FECHA FIN', name : 'fechafin', width : 70, sortable : true, align : 'left'},
			{display : 'HORA INICIO', name : 'horainicio', width : 60, sortable : true, align : 'left'},
			{display : 'HORA FIN', name : 'horafin', width : 60, sortable : true, align : 'left'}, 
			{display : 'OBSERVACIONES', name : 'observaciones', width : 450, sortable : true, align : 'left'},
			{display : 'AUTORIZACIÓN', name : 'autorizacion', width : 80, sortable : true, align : 'center'},
			{display : 'ARCHIVO', name : 'archivo', width : 80, sortable : true, align : 'center', hide:'true'},
			],
	buttons : [
			{name : 'Exportar', bclass : 'export', onpress : exportarExcell},
			{separator : true}	
			],
	/*searchitems : [ 
			{display : 'cedula', name : 'dp.cedula', isdefault : true},
			],*/
	
	sortname : "fechainicio",
	sortorder : "desc",
	usepager : true,
	title : 'REPORTE PERMISOS',
	useRp : false,
	rp : 100,
	showTableToggleBtn : true,
/*	width : 1660,
	height : 550,*/
	width : 1050,
	height : 410,
	singleSelect: true
}); 

function exportarExcell(com, grid) 
{
  if (com == 'Exportar') 
  {
	$.ajax
	({  
       type: "POST",  
       url: "BusquedaGeneralExcel.php",
	   data:
	         'cedula='+$('#cedula').val()+
			 '&idperfil='+$('#idperfil').val()+
			 '&iddepartamento='+$('#iddepartamento').val()+
			 '&motivo='+$('#motivo').val()+
			 '&estado_permiso='+$('#estado_permiso').val()+
			 '&tipo='+$('#tipo').val()+
			 '&cedula_user='+$('#cedula_user').val()+
			 '&fechaConsultar='+$('#fechaConsultar').val()+
			 '&fechaConsultar2='+$('#fechaConsultar2').val()+
			 '&iddatopersonal='+$('#iddatopersonal').val(),
					 	
       success: function(html)
	   {  
		  $("#datos_a_enviar").val(html);
     	  $("#FormularioExportacion").submit();	 
       }  
    });  
  } 
}



 jQuery(function($){  
     //desde = document.form1.inicio.value;
     //hasta = document.form1.termino.value;
     $.datepicker.regional['es'] = {
     closeText: 'Cerrar',
     prevText: '&#x3c;Ant',
     nextText: 'Sig&#x3e;',
     currentText: 'Hoy',
     //minDate: new Date(desde.substr(0,4),(desde.substr(5,2)-1),desde.substr(8,10)),
     //maxDate: new Date(hasta.substr(0,4),(hasta.substr(5,2)-1),hasta.substr(8,10)),
     monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio', 'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
     monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
     dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
     dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
     dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
     weekHeader: 'Sm',
     dateFormat: 'yy/mm/dd',
     firstDay: 1,
     isRTL: false,
     showMonthAfterYear: false,
     yearSuffix: ''};
     $.datepicker.setDefaults($.datepicker.regional['es']);
  });    

$(document).ready(function()
{	
	$("#btnBuscar").click(function(event) 
	{
		$(".flexme3").flexOptions({params:[{name:'cedula', value: $('#cedula').val()},
										   {name:'iddepartamento', value: $('#iddepartamento').val()},
										   {name:'motivo', value: $('#motivo').val()},
										   {name:'estado_permiso', value: $('#estado_permiso').val()},
                                           {name:'fechaConsultar', value: $('#fechaConsultar').val()},
										   {name:'fechaConsultar2', value: $('#fechaConsultar2').val()}
										  ]});
		$(".flexme3").flexReload();		
	});
	
	
	
  $("#fechaConsultar").datepicker({ appendText: '' });
   $("#fechaConsultar2").datepicker({ appendText: ''});
  
  $("#btnLimpiar").click(function(event) 
	{
	    $('#cedula').focus();	
		$('#cedula').val('');
		$('#fechaConsultar').val('');
		$('#fechaConsultar2').val('');
		$('#iddepartamento').val('---Seleccione Direccion---');
		$('#motivo').val('---Seleccione Motivo---');
		$('#estado_permiso').val('---Seleccione Estado---');
		
		$(".flexme3").flexOptions({params:[{name:'cedula', value: $('#cedula').val()},
										   {name:'iddepartamento', value: $('#iddepartamento').val()},
										   {name:'motivo', value: $('#motivo').val()},
										   {name:'estado_permiso', value: $('#estado_permiso').val()},
                                           {name:'fechaConsultar', value: $('#fechaConsultar').val()},
										   {name:'fechaConsultar2', value: $('#fechaConsultar2').val()}
										  ]});
		$(".flexme3").flexReload();		
		//alert("holaaa");
	});
  
	
});


</script>
            
    </body>
    </html>
    
