<?php 

session_start();
include_once('cartelera/framework/util/Constantes.php');

?>
<html>
<head>
	<title></title>
	<script type="text/javascript" src="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/jquery-1.10.2.js"></script>
		
		<script type="text/javascript" src="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/pluggin/jquery.form.js"></script>
		<script type="text/javascript" src="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/pluggin/jquery.popupWindow.js"></script>
					
		<script type="text/javascript" src="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/ui/jquery.ui.datepicker.js"></script>				
		<script type="text/javascript" src="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/ui/jquery.ui.core.js"></script>
		<script type="text/javascript" src="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/ui/jquery.ui.core.js"></script>
		<script type="text/javascript" src="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/ui/jquery.ui.effect.js"></script>
		<script type="text/javascript" src="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/ui/jquery.ui.widget.js"></script>
		<script type="text/javascript" src="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/ui/jquery.ui.tabs.js"></script>
		<script type="text/javascript" src="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/ui/jquery.ui.mouse.js"></script>
		<script type="text/javascript" src="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/ui/jquery.ui.draggable.js"></script>
		<script type="text/javascript" src="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/ui/jquery.ui.position.js"></script>
		<script type="text/javascript" src="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/ui/jquery.ui.slider.js"></script>
		
		<script type="text/javascript" src="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/ui/jquery.ui.menu.js"></script>
		<script type="text/javascript" src="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/ui/jquery.ui.autocomplete.js"></script>
		
		<script type="text/javascript" src="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/ui/jquery.ui.resizable.js"></script>
		<script type="text/javascript" src="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/ui/jquery.ui.dialog.js"></script>
		
		<script type="text/javascript" src="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/ui/jquery.ui.effect-blind.js"></script>
		<script type="text/javascript" src="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/ui/jquery.ui.effect-explode.js"></script>
		
		<script type="text/javascript" src="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/ui/jquery.ui.button.js"></script>
		
		<script type="text/javascript" src="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/ui/jquery.ui.tooltip.js"></script>
		
		<script type="text/javascript" src="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/pluggin/jquery.validate.js"></script>		
		<script type="text/javascript" src="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/pluggin/jquery.datetimepicker.js"></script>
		<script type="text/javascript" src="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/pluggin/jquery.uploadfile.js"></script>		
		<script type="text/javascript" src="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/pluggin/select2.js"></script>
		<script type="text/javascript" src="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/pluggin/DataTables-1.10.0/media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" src="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/pluggin/jstree3_0/jstree.js"></script>	
		
		<link rel="stylesheet" type="text/css" href="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/themes/<?php echo(Constantes::$STRTHEME)?>/jquery-ui.css" type="text/css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/themes/<?php echo(Constantes::$STRTHEME)?>/jquery.ui.theme.css" type="text/css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/pluggin/jquery.datetimepicker.css" type="text/css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/pluggin/uploadfile.css" type="text/css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/pluggin/select2.css" type="text/css"/>		
		<link rel="stylesheet" type="text/css" href="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/pluggin/DataTables-1.10.0/media/css/jquery.dataTables.css" type="text/css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/pluggin/DataTables-1.10.0/media/css/dataTables.jqueryui.css" type="text/css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo(Constantes::$strPathBaseJavaScriptToComplete) ?>jquery-ui-1.10.4/pluggin/jstree3_0/themes/default/style.css" type="text/css"/>
		
</head>
<body>	
	<form id="frmParametros" name="frmParametros">
		<table>
			<tr>
				<td>Cargar</td>
				<td>
					<input id="path_archivo" name="path_archivo" type="text" class="inputnormal" readonly>
						<a id="link_path_archivo" href="#" target="_blank"></a>
					<div id="div_path_archivo" class="inputnormal">Cargar</div>
				</td>
			</tr>
			<tr>
			
	
				<td colspan="2" align="right"><button id="btnCargar" type="button">Procesar</button></td>
			</tr>
		</table>
	</form>
	<div id="datos">
	</div>
</body>
<?php include_once(Constantes::$strPathBaseJavaScriptToComplete.'/cartelera/general/jquery/CargaLoteJQuery.js'); ?>
</html>									
	