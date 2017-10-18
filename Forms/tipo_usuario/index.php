<?php
  session_start(); 
  $s=session_name();
  include '../../lib/dbconfig.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>ADMINISTRACIÓN DE TIPOS DE USUARIO</title>
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
    <body>
    <div >
    <div id="dialog-form" title="ADMINISTRACIÓN DE TIPOS DE USUARIO">
        <p class="validateTips">Información</p>
        <form>
        <fieldset style="padding:0; border:0; margin-top:25px;">
          	<table width="300px" style="border-style:none">
            <tr>
                <td>
                	<label for="lblNombre" style="display:block">Nombre: </label>
                </td>
                <td>
                	<input type="text" name="txtNombre" id="txtNombre" value="" class="text ui-widget-content ui-corner-all"  style="margin-bottom:12px; width:95%; padding: .4em;"/>
                </td>
            </tr>
            <tr>
            	<td>
                	<label for="lblDescripcion" style="display:block">Descripción: </label>
                </td>
                <td>
                	<input type="text" name="txtDescripcion" id="txtDescripcion"  maxlength="100" value="" class="text ui-widget-content ui-corner-all"  style="margin-bottom:12px; width:95%; padding: .4em;"/>
                </td>
            </tr>
            <!--<tr>
            	<td>
                	<label for="lblTipoProyecto" style="display:block">Tipo de Proyecto: </label>
                </td>
                <td>
                	<select name="txtCodTipoProyecto" id="txtCodTipoProyecto" class="text ui-widget-content ui-corner-all"  style="margin-bottom:12px; width:95%; padding: .4em;">
                        <option value="">--Seleccione--</option>
                        <?php /*?><?php
							include '../../lib/conexion.php';
                            $resultTipoProyecto=mysql_query("select * from tipo_proyecto ORDER BY Nombre",$conexion);
                    		if ($rowTipoProyecto = mysql_fetch_array($resultTipoProyecto)){ 
                            	do {
                        ?>
                            		<option value="<?php echo $rowTipoProyecto["cod_tipo_proyecto"] ?>"><?php echo $rowTipoProyecto["Nombre"];?></option>
                        <?php 
                            		} while ($rowTipoProyecto = mysql_fetch_array($resultTipoProyecto)); 
                        	}
                        	mysql_free_result($resultTipoProyecto);
                        ?> <?php */?>
                    </select>
                </td>
            </tr>-->
            </table>
            <input type="text" name="txtValidate" id="txtValidate" value="false" style="display:none" class="text ui-widget-content ui-corner-all"  style="margin-bottom:12px; width:95%; padding: .4em;"/>
            <input type="text" name="txtTipoUsuario" id="txtTipoUsuario" value="" style="display:none" class="text ui-widget-content ui-corner-all"  style="margin-bottom:12px; width:95%; padding: .4em;"/>
        </fieldset>
        </form>
    </div>
     <table align="center">
			<tr>
            	<td>
	                <div >
			        <table class="flexme3" style="display: none"></table>
                    </div >
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
			{display : 'ID', name : 'idperfil', width : 40, sortable : true, align : 'center'},
			{display : 'NOMBRE', name : 'nombre', width : 150, sortable : true, align : 'center'}, 
			//{display : 'DESCRIPCIÓN', name : 'Descripcion', width : 150, sortable : true, align : 'center'},  
			],
	buttons : [ 
			/*{name : 'Insertar', bclass : 'add', onpress : test}, 
			{name : 'Editar', bclass : 'edit', onpress : test}, 
			{name : 'Eliminar', bclass : 'delete', onpress : test}, */
			{separator : true}
			],
	searchitems : [ 
			{display : 'Nombre', name : 'nombre', isdefault : true} 
			],
	sortname : "idperfil",
	sortorder : "asc",
	usepager : true,
	title : 'MANTENIMIENTO TIPO DE USUARIO',
	useRp : true,
	rp : 15,
	showTableToggleBtn : true,
	width : 550,
	height : 300,
	singleSelect: true
}); 

function test(com, grid) {
	if (com=='Eliminar')
    {
		if($('.trSelected',grid).length>0){
		    if(confirm('Desea Eliminar el registro?')){
			    var items = $('.trSelected',grid);
				var itemlist ='';
        		for(i=0;i<items.length;i++){
					itemlist+= items[i].id.substr(3)+",";
				}
			  $.ajax({
				 type: "POST",
				 dataType: "json",
				 url: "DeleteTipoUsuario.php",
				 data: "items="+itemlist,
				 success: function(data){
					 alert("registro eliminado Correctamente");
					 $(".flexme3").flexReload();
				 }
			   });
			   $(".flexme3").flexReload();
			  }
	       } else {
			return false;
		}
	} else if (com == 'Insertar') {						
		$( "#txtValidate" ).val('false');
		$( "#dialog-form" ).dialog( "open" );
	}else if (com == 'Editar') { 
		$('.trSelected', grid).each(function() { 
			var id = $(this).attr('id'); 
			id = id.substring(id.lastIndexOf('row')+3);
			$('.trSelected td div',grid).attr("id", function (arr) {
			  return "div-id" + arr;
			});
			$('.trSelected td div',grid).html(function() {
				  $( "#txtTipoUsuario" ).val($('#div-id0').text());
  				  $( "#txtNombre" ).val(jQuery.trim($('#div-id1').text()));
				  $( "#txtDescripcion" ).val(jQuery.trim($('#div-id2').text()));
			});
			$( "#txtValidate" ).val('true');							  
			$( "#dialog-form" ).dialog( "open" );
			$('.trSelected td div',grid).removeAttr("id")
		 }); 
	} 
	
}
$(function() {
	$( "#dialog:ui-dialog" ).dialog( "destroy" );
	var txtNombre = $( "#txtNombre" ),
 		txtDescripcion = $( "#txtDescripcion" ),
		allFields = $( [] ).add( txtNombre ).add( txtDescripcion ),
		tips = $( ".validateTips" );
	
	function updateTips( t ) {
		tips
			.text( t )
			.addClass( "ui-state-highlight" );
		setTimeout(function() {
			tips.removeClass( "ui-state-highlight", 1500 );
		}, 500 );
	}
//
//	function checkLength( o, n, min, max ) {
//		if ( o.val().length > max || o.val().length < min ) {
//			o.addClass( "ui-state-error" );
//			updateTips( "Longitud  de " + n + " debe estar entre " +
//				min + " y " + max + "." );
//			return false;
//		} else {
//			return true;
//		}
//	}
//
//	function checkRegexp( o, regexp, n ) {
//		if ( !( regexp.test( o.val() ) ) ) {
//			o.addClass( "ui-state-error" );
//			updateTips( n );
//			return false;
//		} else {
//			return true;
//		}
//	}

	function validate(element,message) {
		if(element.val() == "")
		{
			alert(message);
			return false;
		}
		else
			return true;
	}
	
	$( "#dialog-form" ).dialog({
		autoOpen: false,
		height: 300,
		width: 350,
		modal: true,
		buttons: {
			"Guardar": function() {
				var bValid = true;
				allFields.removeClass( "ui-state-error" );
				bValid = validate(txtNombre,"Ingrese un Nombre");
				if(!bValid) return;
				if ( bValid ) {
					if($( "#txtValidate" ).val()=='true'){
						$.ajax({
						type: "POST",
						dataType: "json",
						url: "UpdateTipoUsuario.php",
						data: "Nombre="+txtNombre.val()+"&Descripcion="+txtDescripcion.val()+"&cod_tipo_usuario="+$("#txtTipoUsuario").val(),
						success: function(data){
						  if(data.validacion > '0')
								  {
									  alert("Actualizado correctamente");
									  $(".flexme3").flexReload();
									  $( "#dialog-form" ).dialog( "close" );
								  }
								  else
									  alert( "Error al Actualizar una Distrito");
						}
					});
					}else{
						
					   $.ajax({
						  type: "POST",
						  dataType: "json",
						  url: "InsertTipoUsuario.php",
						  data: "Nombre="+txtNombre.val()+"&Descripcion="+txtDescripcion.val(),
						  success: function(data){
								  if(data.validacion > '0')
								  {
									  alert("Guardado correctamente");
									  $(".flexme3").flexReload();
									  $( "#dialog-form" ).dialog( "close" );
								  }
								  else
									  alert( "Error al Insertar un Tipo de Variable");
						  }
					   });
						
					}
				//}		
			}
			},
			Cancelar: function() {
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			allFields.val( "" ).removeClass( "ui-state-error" );
		}
	});
});
</script>
            
    </body>
    </html>
    
