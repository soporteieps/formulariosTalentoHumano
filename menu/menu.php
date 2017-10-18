<?php
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Rico 2.0</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<base target="content">

<script src="../rico/src/rico.js" type="text/javascript"></script>
<script type='text/javascript'>
Rico.loadModule('Accordion','Corner');
var acc;
Rico.onLoad( function() {
  $('RicoVersion').innerHTML="";
  $('ProtoVersion').innerHTML="";
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
	margin-top: 2px;
	margin-bottom: 2px;
	margin-left: 2px;
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
  background-color: #4D4D4D;
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
  background: url(../rico_borrar/documentos/client/images/phokus/blt-01.gif) no-repeat;  
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
 <p><span id='RicoVersion'></span></p> 
 <br><span style="font-weight:normal;font-size:smaller;"></span><span style="font-weight:normal;font-size:smaller;"><span id='ProtoVersion'></span></span>
 
<p>BIENVENIDO</p> <?php echo $_SESSION["nombre"]?>&nbsp;<?php echo $_SESSION["apellido"]?><span style="font-weight:normal;font-size:smaller;"></br>
<br><?php echo $_SESSION["usuario"]?> </span><span style="font-weight:normal;font-size:smaller;"></span>
</div>

<div class='top'>
<ul>
</ul>
</div>

<div id="accordion1">

  <div class="accordionTabTitleBar">Información</div>
  <div id='overview' class="accordionTabContentBox">
  <ul>
<li><a href='welcome.html' target='mainFrame' class='menu'>Bienvenido</a>
 </ul> 
</div>

<!--  <div class="accordionTabTitleBar">Asistencias:</div>
  <div id='Accordion' class="accordionTabContentBox">
<div class='subhead'>

</div>

<ul>  
	<li><a href='../Asistencia.php' target='mainFrame' class='menu'>Asistencias</a></li> 
	
</ul>
  </div>
-->
<?php

if($_SESSION["idperfil"]==1 || $_SESSION["idperfil"]==3)
                {?>
<div class="accordionTabTitleBar">Autorizaciones Pendientes:</div>
  <div id='Accordion' class="accordionTabContentBox">
<div class='subhead'>
<!-- <IMG src='../images/documento.jpg' width='50' height='50'> -->
</div>

<ul>  
	<li><a href='../Forms/Autorizaciones_Pendientes_Permisos/index.php' target='mainFrame' class='menu'>Permisos</a></li>
	<li><a href='../Forms/Autorizaciones_Pendientes_Plan_Vacaciones/index.php' target='mainFrame' class='menu'>Plan Vacaciones</a></li>
	<li><a href='../Forms/Autorizaciones_Pendientes_Vacaciones/index.php' target='mainFrame' class='menu'>Vacaciones</a></li>
	 
	
</ul>
  </div>
  
<?php  
}
?>
  <div class="accordionTabTitleBar">Planificación Vacaciones:</div>
  <div id='Accordion' class="accordionTabContentBox">
<div class='subhead'>
<!-- <IMG src='../images/documento.jpg' width='50' height='50'> -->
</div>

<ul>
 <!-- 	<li><a href='../Forms/formulario/index.php' target='mainFrame' class='menu'>Formulario</a></li> -->  
 <!-- 	<li><a href='../Forms/Planificacion_Vacaciones/index.php' target='mainFrame' class='menu'>Crear</a></li> -->
 <li><a href='../Planificacion_Vacaciones.php' target='mainFrame' class='menu'>Crear</a></li> 
	<li><a href='../Forms/Reporte_Planificacion/index.php?tipo=individual' target='mainFrame' class='menu'>Consultar Planificaciones</a></li>
<!--	<li><a href='../Forms/Solicitud_Vacaciones/index.php' target='mainFrame' class='menu'>Solicitud Vacaciones</a></li> -->
 

</ul>
  </div>
  

 <div class="accordionTabTitleBar">Solicitud de Vacaciones:</div>
  <div id='Accordion' class="accordionTabContentBox">
<div class='subhead'>
<!-- <IMG src='../images/documento.jpg' width='50' height='50'> -->
</div>

<ul>
 <!-- 	<li><a href='../Forms/formulario/index.php' target='mainFrame' class='menu'>Formulario</a></li> -->  
 <!--	<li><a href='../Forms/Solicitud_Vacaciones/index.php' target='mainFrame' class='menu'>Crear</a></li> -->
	<li><a href='../Solicitud_Vacaciones.php' target='mainFrame' class='menu'>Crear</a></li>
	<li><a href='../Forms/Reporte_Solicitudes/index.php?tipo=individual' target='mainFrame' class='menu'>Consultar Vacaciones</a></li>
<!--	<li><a href='../Forms/Solicitud_Vacaciones/index.php' target='mainFrame' class='menu'>Solicitud Vacaciones</a></li> -->
<!--	<li><a href='../cartelera_jquery/GlobalController.php?view=CargaLote' target='mainFrame' class='menu'>Asistencia</a></li>-->


</ul>
  </div>
  

<div class="accordionTabTitleBar">Solicitud de Permisos:</div>
  <div id='Accordion' class="accordionTabContentBox">
<div class='subhead'>
<!-- <IMG src='../images/documento.jpg' width='50' height='50'> -->
</div>

<ul>  
<!--<li><a href='../Forms/formulario/index.php' target='mainFrame' class='menu'>Crear</a></li>-->
	<li><a href='../formulario.php' target='mainFrame' class='menu'>Crear</a></li>
	<li><a href='../Forms/Reporte_Formulario/index.php?tipo=individual' target='mainFrame' class='menu'>Consultar Permisos</a></li>

</ul>
</div>

<?php

if($_SESSION["idperfil"]==1 || $_SESSION["idperfil"]==3 || $_SESSION["idperfil"]==4 )
{?>
<div class="accordionTabTitleBar">Reportes</div>
  <div id='Accordion' class="accordionTabContentBox">
<div class='subhead'>
<!-- <IMG src='../images/documento.jpg' width='50' height='50'> -->
</div>

<ul>
	<li><a href='../Forms/Reporte_Formulario/index.php?tipo=general' target='mainFrame' class='menu'>Reporte Permisos</a></li>
	<li><a href='../Forms/Reporte_Planificacion/index.php?tipo=general' target='mainFrame' class='menu'>Reporte Plan Vacaciones</a></li>
	<li><a href='../Forms/Reporte_Solicitudes/index.php?tipo=general' target='mainFrame' class='menu'>Reporte Solicitudes de Vacaciones</a></li>
</ul>
  </div>

<?php  
}
?>


<?php
if($_SESSION["idperfil"] == 1)
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
<li><a href="../Forms/tipo_usuario/index.php" target='mainFrame' class="menu">Tipo de Usuarios</a>
<li><a href="../Forms/usuarios/index.php" target='mainFrame' class="menu">Usuarios</a>
<li><a href="../Forms/subrrogaciones/index.php" target='mainFrame' class="menu">Subrogaciones</a>
<li><a href="../Reemplazo.php" target='mainFrame' class="menu">Reemplazos Jefe Inmediato</a>

</ul>
  </div>
 <?php 	
}
?>

<div class="accordionTabTitleBar">Cambiar Clave:</div>
  <div id='Accordion' class="accordionTabContentBox">
<div class='subhead'>
<!-- <IMG src='../images/documento.jpg' width='50' height='50'> -->
</div>

<ul>
<li><a href='../Forms/Cambiar_Clave/clave.php' target='_top' class='menu'>Cambiar Clave</a></li>
</ul>
  </div>


  <div class="accordionTabTitleBar">Salir del sistema:</div>
  <div id='clave' class="accordionTabContentBox">
<div class='subhead'>
<!-- <IMG src='../images/llave.jpg' width='50' height='50'> -->
</div>
<p>
<p><h><a href="../general/logout.php" target="_parent" class="menu">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Salir</a></h></p>
<br></br>

<p class="powered">Desarrollado por:</p>

<p class="powered">Direcci&oacute;n de Talento Humano</p>
<p class="powered">Gesti&oacute;n de Tecnolog&iacute;a</p>

<p class="powered">IEPS - 2014</p>


<p class="powered"><a href="mailto:angelo.sigsi@ieps.gob.ec?cc=marcelo.lema@ieps.gob.ec&subject=ACTORES" class="powered">angelo.sigsi@ieps.gob.ec</a></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</div>
</body></html>
