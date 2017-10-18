<?php
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Rico 2.0</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<base target="content">

<script src="./src/rico.js" type="text/javascript"></script>
<script type='text/javascript'>
Rico.loadModule('Accordion','Corner');

var acc;
Rico.onLoad( function() {
  $('RicoVersion').innerHTML=Rico.Version;
  $('ProtoVersion').innerHTML=Prototype.Version;
  Rico.Corner.round('menuheader');
  acc=new Rico.Accordion( '.accordionTabTitleBar', '.accordionTabContentBox', {panelHeight:100} );
  WinResize();
  setTimeout(function() {Event.observe(top, "resize", WinResize, false);},100);
});

function CalcAccHt() {
  var winht=RicoUtil.windowHeight();
  var txtht=$('accordion1').offsetTop;
  var titleht=acc.titles.length * acc.titles[0].offsetHeight;
  return Math.max(winht-txtht-titleht-30,60);
}

function WinResize(e) {
  acc.options.panelHeight=CalcAccHt();
  acc.initContent();
}

</script>

<style type="text/css">
html {
  padding: 10px;
}
body {
  font-family: Arial, Tahoma, Verdana;
  background: #4f4f4f;
  color: #fff;
  margin: 2px;
  overflow: hidden;
}
div.top {
  margin: 6px 0px;
  padding-left: 5px;
  font-size: 11px;
}

#accordion1 {
  width: 99%;
}

div.selected, div.hover {
  background-color:#63699C;
  color:#FFFFFF;
  font-weight:bold;
  height: 22px;
  padding-left: 5px;
}

.accordionTabTitleBar {
  background-color:#6B79A5;
  color:#CED7EF;
  height: 22px;
  font-weight : normal;
  padding-left: 5px;
  padding-top: 5px;
  overflow: hidden;

  border-bottom:1px solid #182052;
  border-style:solid none;
  border-top:1px solid #BDC7E7;
  border-width:1px 0px;
  font-size:12px;
}

.accordionTabContentBox {
  font-size: 11px;
  padding-left: 5px;
  overflow: auto;
}

#menuheader {
  background-color: #1381d4;
  position: relative;
  width: 99%;
}

#menuheader p {
  padding: 1em;
  margin: 0px;
  font-weight: bold;
  font-size:11pt;
}

ul {
  margin:3px 0 0 0;
  padding: 0px;
}
ul li {
  background: url(rico/documentos/client/images/phokus/blt-01.gif) no-repeat;  
  list-style: none;
  padding: 0 0 0 16px;
  margin: 4px 0;
  font-size: 11px;
}

a {
  color: #9999ff;
  text-decoration: none;
}
a:hover {
  text-decoration: underline;
}
div.subhead {
  font-weight: bold;
  margin-top:18px;
  margin-bottom:3px;
}
</style>
<!--[if lt IE 7]>
  <style type="text/css">
ul li {
   height: 1%;
}
 </style>
<![endif]-->
</head>


<body>
<div id="menuheader">
<p>@GESDOC-IEPS <span id='RicoVersion'></span>
<br><span style="font-weight:normal;font-size:smaller;">Utilizando 
version: </span><span style="font-weight:normal;font-size:smaller;"><span id='ProtoVersion'></span></span>
<p>Hola <?php echo $_SESSION["usuario"]?></p>
</div>

<div class='top'>
<ul>
</ul>
</div>

<div id="accordion1">

  <div class="accordionTabTitleBar">Gestion &amp; Documentos</div>
  <div id='overview' class="accordionTabContentBox">
<ul>
<li><a href='welcome.html' target='mainFrame' class='menu'>Bienvenido a @GESDOC-IEPS!</a>
</ul>

</div>
  <?php
if($_SESSION["cod_tipo_usuario"]==1 || $_SESSION["cod_tipo_usuario"]==2 || $_SESSION["cod_tipo_usuario"]==3)
	{ ?>
  <div class="accordionTabTitleBar">Gestionar Documentos:</div>
  <div id='Accordion' class="accordionTabContentBox">
<div class='subhead'>
<IMG src='images/documento.jpg' width='50' height='50'>
</div>


<ul>

  <?php
if($_SESSION["cod_tipo_usuario"]==1 || $_SESSION["cod_tipo_usuario"]==2 || $_SESSION["cod_tipo_usuario"]==3)
	{ ?>
        <!--<li><a href='./rico/documentos/php/lista_carpetas.php' target='mainFrame' class='menu'>Carpetas Archivo</a>        -->
       <!--<li><a href='./rico/documentos/php/lista_documentos.php' target='mainFrame' class='menu'>Registrar Documento</a>-->
        <li><a href='./Forms/registro_carpetas/index.php' target='mainFrame' class='menu'>Carpetas Archivo</a>  
        <li><a href='./Forms/registro_documentos/index.php' target='mainFrame' class='menu'>Registrar Documento</a>        
	<?php 	
    }
    ?>
     <li><a href='./informes/produccion.php' target='mainFrame' class='menu'>Detalle Produccion Cronologica</a></li>
     <li><a href='./informes/produccion_total.php' target='mainFrame' class='menu'>Total Produccion Cronologica</a></li>
     </ul>
  </div>
<?php 	
}
?>


  <?php
if($_SESSION["cod_tipo_usuario"]==1 || $_SESSION["cod_tipo_usuario"]==2 || $_SESSION["cod_tipo_usuario"]==3)
	{ ?>
  <div class="accordionTabTitleBar">Visualizacion de Documentos:</div>
  <div id='Accordion' class="accordionTabContentBox">
<div class='subhead'>
<IMG src='images/productos.jpg' width='116' height='116'>
</div>

<ul>
       <!--<li><a href='./rico/documentos/php/lista_carpetas_tramite.php' target='mainFrame' class='menu'>Documentos Registrados</a></li>-->
       <li><a href='./Forms/visor_documentos/index.php' target='mainFrame' class='menu'>Documentos Registrados</a></li>
       <li><a href='./rico/documentos/php/lista_expedientes.php' target='mainFrame' class='menu'>Expedientes Registrados</a></ul>
  </div>
<?php 	
}
?>

  <?php
if($_SESSION["cod_tipo_usuario"]==1 || $_SESSION["cod_tipo_usuario"]==3)
	{ ?>

  <div class="accordionTabTitleBar">Transferencia Archivos:</div>
  <div id='php' class="accordionTabContentBox">
<div class='subhead'>
<IMG src='images/carpeta.jpg' width='50' height='50'>
</div>
<p>

<div class='subhead'>Archivo de Tramite:</div>
<ul>
     <li><a href='admin/procesarExpurgo.php' target='mainFrame' class='menu'>Expurgo Archivo Tramite</a></li>
     <li><a href='selec_area.php' target='mainFrame' class='menu'>Transferencia Primaria</a>
</ul>

<div class='subhead'>Archivo de Concentracion:</div>

<ul>
       <li><a href='admin/procesarDepuracion.php' target='mainFrame' class='menu'>Depuracion Archivo Concentracion</a></li>
       <li><a href='selec_area_concen.php' target='mainFrame' class='menu'>Transferencia Secundaria</a></li>

</ul>

<div class='subhead'>Informes Carpetas:</div>
<ul>
<li><a href='./informes/carpetas.php' target='mainFrame' class='menu'>Reporte Contenido Carpetas</a></li>
</ul>
 </div>
<?php 	
}
?>

<?php
if($_SESSION["cod_tipo_usuario"] == 1)
	{
?>
  <div class="accordionTabTitleBar">Administración Aplicativo :</div>
  <div id='admin' class="accordionTabContentBox">
<div class='subhead'>
<IMG src='images/Icono_usuario.jpg' width='50' height='50'>
</div>

    <p>Esta opcion permite dar mantenimiento a todos los usuarios del Aplicativo, asi como tambien definir una perfil de usuario, el mismo que se vera reflejado en la configuración de las opciones del mismo.

<p>
<div class='subhead'>Usuarios Aplicativo:</div>
<ul>
<li><a href="./admin/tiposusu.php" target='mainFrame' class="menu">Tipo de Usuarios</a>
<!--<li><a href="./admin/usuarios.php" target='mainFrame' class="menu">Usuarios</a>-->
<li><a href="Forms/usuarios/index.php" target='mainFrame' class="menu">Usuarios</a>

</ul>
  </div>
 <?php 	
}
?>

  <div class="accordionTabTitleBar">Actualizar Clave Acceso:</div>
  <div id='clave' class="accordionTabContentBox">
<div class='subhead'>
<IMG src='imagenes/llave.jpg' width='50' height='50'>
</div>

<p>
<p><a href="./admin/clave.php" target='mainFrame' class="menu">Cambiar Clave</a></p>
<p><a href="./clases/logout.php" target="_parent" class="menu">Salir</a></p>

<p class="powered">Desarrollado por:</p>
<p class="powered">Gesti&oacute;n de Tecnolog&iacute;a</p>
<p class="powered">IEPS - 2013</p>
<p class="powered"><a href="mailto:marcelo.lema@ieps.gov.ec?cc=angelo.sigsi@ieps.gov.ec&subject=DOCUMENTOS" class="powered">marcelo.lema@ieps.gov.ec</a></p>
<p class="powered"><a href="mailto:angelo.sigsi@ieps.gov.ec?cc=marcelo.lema@ieps.gov.ec&subject=DOCUMENTOS" class="powered">angelo.sigsi@ieps.gov.ec</a></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</div></div>
</body></html>
