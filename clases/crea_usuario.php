<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Usuarios</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../Forms/css/admin.css" rel="stylesheet" type="text/css">
</head>
<body>
<link rel="STYLESHEET" type="text/css" href="../dhtmlxcalendar/codebase/dhtmlxcalendar.css">
<script>
      window.dhx_globalImgPath="../dhtmlxcalendar/codebase/imgs/";picker
</script>
<script  src="../dhtmlxcalendar/codebase/dhtmlxcommon.js"></script>
<script  src="../dhtmlxcalendar/codebase/dhtmlxcalendar.js"></script>

<link rel="stylesheet" type="text/css" href="../js/jquery-ui-timepicker-addon.css" />
<link rel="stylesheet" type="text/css" href="../css/jquery-ui-1.7.2.custom.css" />
<link rel="stylesheet" type="text/css" href="../css/myStyle.css" />

<script type="text/javascript" src="../js/jquery-ui-1.10.4/jquery-1.10.2.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.10.4/ui/jquery.ui.datepicker.js"></script>				
<script type="text/javascript" src="../js/jquery-ui-1.10.4/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.10.4/ui/jquery.ui.effect.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.10.4/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.10.4/ui/jquery.ui.tabs.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.10.4/ui/jquery.ui.mouse.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.10.4/ui/jquery.ui.draggable.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.10.4/ui/jquery.ui.position.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.10.4/ui/jquery.ui.slider.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.10.4/ui/jquery.ui.menu.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.10.4/ui/jquery.ui.autocomplete.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.10.4/ui/jquery.ui.resizable.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.10.4/ui/jquery.ui.dialog.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.10.4/ui/jquery.ui.effect-blind.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.10.4/ui/jquery.ui.effect-explode.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.10.4/ui/jquery.ui.button.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.10.4/ui/jquery.ui.tooltip.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.10.4/pluggin/jquery.validate.js"></script>		
<script type="text/javascript" src="../js/jquery-ui-1.10.4/pluggin/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.10.4/pluggin/jquery.uploadfile.js"></script>		
<script type="text/javascript" src="../js/jquery-ui-1.10.4/pluggin/DataTables-1.10.0/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.10.4/pluggin/jstree3_0/jstree.js"></script>	
<script src="../js/jquery-ui-1.10.4/pluggin/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="../js/validador_ci.js"></script>
<script type="text/javascript" src="../js/crea_usuario.js"></script>

<script>
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
	
$(document).ready(function() {
	$("#fecha_ingreso_ieps").datepicker({ appendText: ' Haga click para introducir una fecha' });
	$("#fecha_salida_ieps").datepicker({ appendText: ' Haga click para introducir una fecha' });
   });
</script>
</body>
<?php
include("../lib/dbconfig.php");
include("mail.php");
include '../../clases/checkZonaByProvincia.php';
//include('../../clases/mail.php');


if ($accion=="formulario" || $accion=="edita")
{
	daFormulario($cod_usuario_aux, $accion);
}
if ($accion=="crea")
{
    insetUsuario($idpersona_aux,$iddepartamento_aux,$idpersonajefe_aux,$cedula_aux,$nombre_aux,$apellido_aux,$grupo_ocupacional_aux,$modalidad_contratacion_aux,$correo_aux,$lugar_trabajo_aux,$fecha_ingreso_ieps_aux,$fecha_salida_ieps_aux,$perfil_aux,$estado_aux);
}

if ($accion=="elimina")
{
	eliminaUsuario($idpersona);
}
if ($accion=="update")
{
    //editarUsuario($dependencia_aux, $area_aux, $cod_usuario_aux, $nombre_usuario_aux, $user_name_aux, $cod_tipo_usuario_aux, $estado, $cod_provincia);
	editarUsuario($idpersona_aux,$iddepartamento_aux,$idpersonajefe_aux,$cedula_aux,$nombre_aux,$apellido_aux,$grupo_ocupacional_aux,$modalidad_contratacion_aux,$correo_aux,$lugar_trabajo_aux,$fecha_ingreso_ieps_aux,$fecha_salida_ieps_aux,$perfil_aux,$estado_aux);
}

if ($accion=="departamento")
{
	//echo "primera llamada".$iddepartamento."<br>";
    area_por_departamento($iddepartamento);
}


if ( $accion=="reseteo")
{
  // echo "CEDULA RESETEO". $idpersona_aux;
   // echo "ACCION RESETEO".$accion;
	reseteo($idpersona_aux);
}

if ( $accion=="ReseteoTablaUsuario")
{
//	echo "cedula update". $cedula_aux;
//	echo "accion update".$accion;
	ReseteoTablaUsuario($idpersona_aux);
}


function area_por_departamento($iddepartamento)
{
echo "<div id='DivJefeporDepartamento'>
		<select id='idpersonajefe' name='idpersonajefe'>";
		$consulta_jefe_inmediato="select idpersona as idpersonajefe,concat(nombre,' ',apellido,'(',case u.activo when 1 then 'A' else 'I' end ,')')
		
		 jefe from usuario u 
		inner join perfil_usuario pu on(u.idusuario = pu.idusuario)
		inner join persona p on(u.usuario = p.cedula) 
		where u.activo ='1' and p.activo ='1' and pu.idperfil = '3' and p.iddepartamento=".$iddepartamento;
		$result_jefe_inmediato=query($consulta_jefe_inmediato);
			while($lista_jefe_inmediato=mysql_fetch_object($result_jefe_inmediato))
				{
					if($idpersonajefe==$lista_jefe_inmediato->idpersonajefe)
						{
							echo "<option value='$lista_jefe_inmediato->idpersonajefe' selected>$lista_jefe_inmediato->jefe</option>";
						}
					else
						{
							echo "<option value='$lista_jefe_inmediato->idpersonajefe'>$lista_jefe_inmediato->jefe</option>";
						}
				}
echo "</select>
	</div>";

}






function daFormulario($cod_usuario_aux, $accion)
{

	if($accion=="edita")
		{
			//$busca_usuario="select * from persona where idpersona=$cod_usuario_aux";
			$busca_usuario="select  p.idpersona, p.iddepartamento, p.idpersonajefe, p.cedula, p.nombre, p.apellido, p.grupo_ocupacional, p.idpersona, 
			p.iddepartamento, p.idpersonajefe, p.cedula, p.nombre, p.apellido, p.grupo_ocupacional, p.modalidad_contratocion, 
			p.correo, p.activo, p.lugar_trabajo, p.fecha_ingreso_ieps, p.fecha_salida_ieps, p.modalidad_contratocion, 
			p.correo, p.activo, p.lugar_trabajo, p.fecha_ingreso_ieps, p.fecha_salida_ieps,pe.idperfil 
			from persona p 
				inner join usuario u on(u.usuario = p.cedula)
				inner join perfil_usuario pu on(u.idusuario = pu.idusuario)
				inner join perfil pe on(pe.idperfil= pu.idperfil)where p.cedula='$cod_usuario_aux'";
			
			//echo "busca_usuario=".$busca_usuario."<br>";
			$result_usuario=query($busca_usuario);
			while($edit_usuario=mysql_fetch_object($result_usuario))
			{
				$idpersona=$edit_usuario->idpersona;
				$iddepartamento=$edit_usuario->iddepartamento;
				$idpersonajefe=$edit_usuario->idpersonajefe;
				$cedula=$edit_usuario->cedula;
				$nombre=$edit_usuario->nombre;
				$apellido=$edit_usuario->apellido;
				$cargo=$edit_usuario->grupo_ocupacional;
				$modalidad=$edit_usuario->modalidad_contratocion;
				$correo=$edit_usuario->correo;
				$lugar_trabajo=$edit_usuario->lugar_trabajo;
				$fecha_ingreso_ieps=$edit_usuario->fecha_ingreso_ieps;
				$fecha_salida_ieps=$edit_usuario->fecha_salida_ieps;
				$idperfil=$edit_usuario->idperfil;
				$estado=$edit_usuario->activo;
				
				
			}
		}
	elseif($cod_usuario_aux==0)
		{
			$cod_usuario_aux="";
		}
//Sentenciasç
$consulta_departamento="select iddepartamento,nombre from departamento where activo = 1 order by nombre";
$consulta_tipo_usuario="select * from tipo_usuario";
$consulta_estado="select codigo,valor from catalogo where tipo ='estado'";
//Ejecuto sentencias y almaceno en una variable el resultado
$result_departamento=query($consulta_departamento);
$result_tipo=query($consulta_tipo_usuario);
$result_estado=query($consulta_estado);

//Imprimo el Formulario
echo "<div id='DivUsuario'>
		<form name='form1' method='post'>
		<table border='1' align='center'>";
		if($accion=="edita"){
			echo "<tr>
				<td colspan='2' align='center'><font color='#003399' size='2' face='Arial, Helvetica, sans-serif'><strong>EDITAR USUARIO</strong></font></td>
			</tr>
			<tr>
				<td><font color='#003399' size='2' face='Arial, Helvetica, sans-serif'><strong>Codigo :</strong></font></td>
				<td><input name='idpersona' type='text' size='30' maxlength='10' value='$idpersona' readonly></td>
			</tr>";
		}else
		{
			echo "<tr>
				<td colspan='2' align='center' class='tablacabecera'><font color='#003399' size='2' face='Arial, Helvetica, sans-serif'><strong>CREAR NUEVO USUARIO</strong></font></td>
			</tr>
			<tr>
				<td><font color='#003399' size='2' face='Arial, Helvetica, sans-serif'><strong>Codigo :</strong></font></td>
				<td><input name='idpersona' type='text' size='30' maxlength='10' value='$idpersona'></td>
			</tr>";
		}
		
	echo "<tr>
				<td><font color='#003399' size='2' face='Arial, Helvetica, sans-serif'><strong>Departamento :</strong></font></td>
				<td><select id='iddepartamento' name='iddepartamento' onChange='area_por_departamento(this.value);'><option>--Seleccione un Departamento--</option>";
while($lista_departamento=mysql_fetch_object($result_departamento))
		{
			if($iddepartamento==$lista_departamento->iddepartamento)
				{
					echo "<option value='$lista_departamento->iddepartamento' selected>$lista_departamento->nombre</option>";
				}
			else
				{
					echo "<option value='$lista_departamento->iddepartamento'>$lista_departamento->nombre</option>";
				}
		}

echo "</select></td>
			</tr>
			<!-- <tr id='divArea'>
				<td><font color='#003399' size='2' face='Arial, Helvetica, sans-serif'><strong>Area del Departamento:</strong></font></td>
				<td><select id='selectArea' name='selectArea'><option value='0'>---Seleccione un Area---</option></select></td>
			</tr>-->
			<tr>
				<td><font color='#003399' size='2' face='Arial, Helvetica, sans-serif'><strong>Jefe Inmediato :</strong></font></td>
				<td>				
					<div id='DivJefeporDepartamento'>
						<select id='idpersonajefe' name='idpersonajefe'><option>--Seleccione Jefe Inmediato--</option>";
						$consulta_jefe_inmediato="select idpersona as idpersonajefe,concat(nombre,' ',apellido,'(',case u.activo when 1 then 'A' else 'I' end ,')') jefe from usuario u 
						inner join perfil_usuario pu on(u.idusuario = pu.idusuario)
						inner join persona p on(u.usuario = p.cedula) 
						where  pu.idperfil = '3' and p.iddepartamento=".$iddepartamento;
						$result_jefe_inmediato=query($consulta_jefe_inmediato);
							while($lista_jefe_inmediato=mysql_fetch_object($result_jefe_inmediato))
								{
									if($idpersonajefe==$lista_jefe_inmediato->idpersonajefe)
										{
											echo "<option value='$lista_jefe_inmediato->idpersonajefe' selected>$lista_jefe_inmediato->jefe</option>";
										}
									else
										{
											echo "<option value='$lista_jefe_inmediato->idpersonajefe'>$lista_jefe_inmediato->jefe</option>";
										}
								}
				echo "</select>
					</div>
				</td>			
			</tr>
			
			<tr>
				<td><font color='#003399' size='2' face='Arial, Helvetica, sans-serif'><strong>CI :</strong></font></td>
				<td><input name='cedula' id='cedula' type='text' size='30' maxlength='10' value='$cedula' onKeyPress='numerico();' onBlur='check_cedula(document.form1.cod_usuario.value);'></td>
			</tr>
			
			<tr>
				<td><font color='#003399' size='2' face='Arial, Helvetica, sans-serif'><strong>Nombres de Usuario :</strong></font></td>
				<td><input name='nombre' type='text' size='50' value='$nombre' onKeyUp='this.value=this.value.toUpperCase();'></td>
			</tr>
			
			<tr>
				<td><font color='#003399' size='2' face='Arial, Helvetica, sans-serif'><strong>Apellidos de Usuario :</strong></font></td>
				<td><input name='apellido' type='text' size='50' value='$apellido' onKeyUp='this.value=this.value.toUpperCase();'></td>
			</tr>
			
			
			<tr>
				<td><font color='#003399' size='2' face='Arial, Helvetica, sans-serif'><strong>Grupo Ocupacional :</strong></font></td>
				<td>				
						<select name='grupo_ocupacional'><option>--Seleccione Grupo Ocupacional--</option>";
						$consulta_cargo="select codigo,valor from catalogos where tipo = 'cargo' order by valor";
						$result_cargo=query($consulta_cargo);
							while($lista_cargo=mysql_fetch_object($result_cargo))
								{
									if($cargo==$lista_cargo->codigo)
										{
											echo "<option value='$lista_cargo->codigo' selected>$lista_cargo->valor</option>";
										}
									else
										{
											echo "<option value='$lista_cargo->codigo'>$lista_cargo->valor</option>";
										}
								}
				echo "</select>
				</td>			
			</tr>
			<tr>
				<td><font color='#003399' size='2' face='Arial, Helvetica, sans-serif'><strong>Modalidad de Contratación :</strong></font></td>
				<td>				
						<select name='modalidad_contratacion'><option>--Seleccione Modalidad--</option>";
						$consulta_modalidad="select codigo,valor from catalogos where tipo = 'modalidad' order by valor";
						$result_modalidad=query($consulta_modalidad);
							while($lista_modalidad=mysql_fetch_object($result_modalidad))
								{
									if($modalidad==$lista_modalidad->codigo)
										{
											echo "<option value='$lista_modalidad->codigo' selected>$lista_modalidad->valor</option>";
										}
									else
										{
											echo "<option value='$lista_modalidad->codigo'>$lista_modalidad->valor</option>";
										}
								}
				echo "</select>
				</td>			
			</tr>
			<tr>
				<td><font color='#003399' size='2' face='Arial, Helvetica, sans-serif'><strong>Correo Institucional :</strong></font></td>
				<td><input name='correo' type='text' size='30' value='$correo' onKeyPress='numerico();' onBlur='check_cedula(document.form1.cod_usuario.value);'></td>
			</tr>
			<tr>
				<td><font color='#003399' size='2' face='Arial, Helvetica, sans-serif'><strong>Lugar Trabajo :</strong></font></td>
				<td><select name='lugar_trabajo'><option>--Seleccione Lugar de trabajo--</option>";
				$consulta_lugar_trabajo="select codigo,valor from catalogos where tipo = 'lugar_trabajo' order by valor";
				$result_lugar_trabajo=query($consulta_lugar_trabajo);
							while($lista_lugar_trabajo=mysql_fetch_object($result_lugar_trabajo))
								{
									if($lugar_trabajo==$lista_lugar_trabajo->codigo)
										{
											echo "<option value='$lista_lugar_trabajo->codigo' selected>$lista_lugar_trabajo->valor</option>";
										}
									else
										{
											echo "<option value='$lista_lugar_trabajo->codigo'>$lista_lugar_trabajo->valor</option>";
										}
								}
				echo "</select></div>
			</td>
			</tr>
			<tr>
				<td><font color='#003399' size='2' face='Arial, Helvetica, sans-serif'><strong>Fecha ingreso IEPS :</strong></font></td>
				<td><input name='fecha_ingreso_ieps' id='fecha_ingreso_ieps' type='text' size='30' value='$fecha_ingreso_ieps'></td>
			</tr>
			<tr>
				<td><font color='#003399' size='2' face='Arial, Helvetica, sans-serif'><strong>Fecha salida IEPS :</strong></font></td>
				<td><input name='fecha_salida_ieps' id='fecha_salida_ieps' type='text' size='30' value='$fecha_salida_ieps'></td>
			</tr>
			<tr>
				<td><font color='#003399' size='2' face='Arial, Helvetica, sans-serif'><strong>Perfil de Usuario :</strong></font></td>
				<td><select name='perfil' onChange='cargarNombres(this)'><option>--Seleccione Perfil--</option>";
				$consulta_perfil="select idperfil,nombre from perfil order by nombre";
				$result_perfil=query($consulta_perfil);
							while($lista_perfil=mysql_fetch_object($result_perfil))
								{
									if($idperfil==$lista_perfil->idperfil)
										{
											echo "<option value='$lista_perfil->idperfil' selected>$lista_perfil->nombre</option>";
										}
									else
										{
											echo "<option value='$lista_perfil->idperfil'>$lista_perfil->nombre</option>";
										}
								}
				echo "</select></div>
			</td>
			</tr>
			<tr>
				<td><font color='#003399' size='2' face='Arial, Helvetica, sans-serif'><strong>Estado :</strong></font></td>
				<td><select name='estado'><option>--Seleccione Estado--</option>";
				$consulta_estado="select codigo,valor from catalogos where tipo = 'estado' order by valor";
				$result_estado=query($consulta_estado);
							while($lista_estado=mysql_fetch_object($result_estado))
								{
									if($estado==$lista_estado->codigo)
										{
											echo "<option value='$lista_estado->codigo' selected>$lista_estado->valor</option>";
										}
									else
										{
											echo "<option value='$lista_estado->codigo'>$lista_estado->valor</option>";
										}
								}
				echo "</select></div>
			</td>
			</tr>
<tr><td colspan='2'><center>";

if ($accion=="formulario")
{	

	/*******************************
	input integrando areas por departamentos
	echo "<input type='button' name='ingresa' value='Crear' 
	  onClick=' CreaUsuario(document.form1.idpersona.value,document.form1.iddepartamento.value,document.form1.idpersonajefe.value,
 		document.form1.cedula.value,document.form1.nombre.value,document.form1.apellido.value,document.form1.grupo_ocupacional.value,
		document.form1.modalidad_contratacion.value,document.form1.correo.value,document.form1.lugar_trabajo.value,		
		document.form1.fecha_ingreso_ieps.value,document.form1.fecha_salida_ieps.value,document.form1.perfil.value,document.form1.estado.value, document.form1.selectArea.value);'>
	*******************************/			

	echo "<input type='button' name='ingresa' value='Crear' 
	  onClick=' CreaUsuario(document.form1.idpersona.value,document.form1.iddepartamento.value,document.form1.idpersonajefe.value,
 		document.form1.cedula.value,document.form1.nombre.value,document.form1.apellido.value,document.form1.grupo_ocupacional.value,
		document.form1.modalidad_contratacion.value,document.form1.correo.value,document.form1.lugar_trabajo.value,		
		document.form1.fecha_ingreso_ieps.value,document.form1.fecha_salida_ieps.value,document.form1.perfil.value,document.form1.estado.value);'>
	  <input type='button' name='regresar1' value='Regresar' onClick='regresar();'>";
	
	  
}
/*echo "<input type='button' name='edita' value='Editar' 
	  onClick='EditarUsuario(document.form1.idpersona.value,document.form1.iddepartamento.value,document.form1.idpersonajefe.value,
		document.form1.cedula.value,document.form1.nombre.value,document.form1.apellido.value,document.form1.grupo_ocupacional.value,
		document.form1.modalidad_contratacion.value,document.form1.correo.value,document.form1.lugar_trabajo.value,
		document.form1.fecha_ingreso_ieps.value,document.form1.fecha_salida_ieps.value,document.form1.perfil.value,document.form1.estado.value);'>
	  	 <input type='button' name='elimina' value='Eliminar' onClick='EliminaUsuario(document.form1.idpersona.value);'>
		 <input type='button' name='regresar1' value='Regresar' onClick='regresar();'>
 	     <input type='button' name='reseteo' value='Resetear Clave' onClick='ActualizarUsuarioyClave(document.form1.idpersona.value),aplicarReseteo(document.form1.cedula.value);'>
	     ";*/
elseif($accion=="edita")
{
	/******************
	Edicion 

	echo "<input type='button' name='edita' value='Editar' 
	  onClick='EditarUsuario(document.form1.idpersona.value,document.form1.iddepartamento.value,document.form1.idpersonajefe.value,
		document.form1.cedula.value,document.form1.nombre.value,document.form1.apellido.value,document.form1.grupo_ocupacional.value,
		document.form1.modalidad_contratacion.value,document.form1.correo.value,document.form1.lugar_trabajo.value,
		document.form1.fecha_ingreso_ieps.value,document.form1.fecha_salida_ieps.value,document.form1.perfil.value,document.form1.estado.value, document.form1.selectArea.value);'>
	  	 <input type='button' name='elimina' value='Eliminar' onClick='EliminaUsuario(document.form1.idpersona.value);'>
		 <input type='button' name='regresar1' value='Regresar' onClick='regresar();'>
 	     <input type='button' name='reseteo' value='Resetear Clave' onClick='ActualizarUsuarioyClave(document.form1.cedula.value),aplicarReseteo(document.form1.cedula.value);'>
	     ";

	*******************/				
	echo "<input type='button' name='edita' value='Editar' 
	  onClick='EditarUsuario(document.form1.idpersona.value,document.form1.iddepartamento.value,document.form1.idpersonajefe.value,
		document.form1.cedula.value,document.form1.nombre.value,document.form1.apellido.value,document.form1.grupo_ocupacional.value,
		document.form1.modalidad_contratacion.value,document.form1.correo.value,document.form1.lugar_trabajo.value,
		document.form1.fecha_ingreso_ieps.value,document.form1.fecha_salida_ieps.value,document.form1.perfil.value,document.form1.estado.value);'>
	  	 <input type='button' name='elimina' value='Eliminar' onClick='EliminaUsuario(document.form1.idpersona.value);'>
		 <input type='button' name='regresar1' value='Regresar' onClick='regresar();'>
 	     <input type='button' name='reseteo' value='Resetear Clave' onClick='ActualizarUsuarioyClave(document.form1.cedula.value),aplicarReseteo(document.form1.cedula.value);'>
	     ";
}
echo "</center></td>
			</tr>
		</table></form></div>";
}
//<input type='button' name='reseteo' value='Resetear Clave' onClick='aplicarReseteo(document.form1.idpersona.value);'>

/***************************************
//Insert usuarios con area
function insetUsuario($idpersona,$iddepartamento,$idpersonajefe,$cedula,$nombre,$apellido,$grupo_ocupacional,$modalidad_contratacion,$correo,$lugar_trabajo,$fecha_ingreso_ieps,$fecha_salida_ieps,$perfil,$estado,$idarea)
{
	$nombre = utf8_decode($nombre);
	$apellido= utf8_decode($apellido);
	$inserta="insert into persona (idpersona, iddepartamento, idpersonajefe, cedula, nombre, apellido, grupo_ocupacional, modalidad_contratocion, 
	correo, activo, lugar_trabajo, fecha_ingreso_ieps, fecha_salida_ieps,idarea)
	values('$idpersona', '$iddepartamento', '$idpersonajefe', '$cedula', '$nombre', '$apellido', '$grupo_ocupacional', '$modalidad_contratacion', 	'$correo', '$estado', '$lugar_trabajo', '$fecha_ingreso_ieps', '$fecha_salida_ieps', $idarea)";
	//echo "inserta=".$inserta."<br>";

	$insertausuario="insert into usuario (iddepartamento, usuario, contrasena, correo, activo, cedula)
	values('$iddepartamento', '$cedula', '$cedula', '$correo', '$estado', '$cedula')";
	//echo "insertausuario=".$insertausuario."<br>";

	if(query($inserta))
	{
		if(query($insertausuario))
		{
			insertPerfilUsuario($perfil,$estado,$cedula);
		}
	}
}
****************************************/
function insetUsuario($idpersona,$iddepartamento,$idpersonajefe,$cedula,$nombre,$apellido,$grupo_ocupacional,$modalidad_contratacion,$correo,$lugar_trabajo,$fecha_ingreso_ieps,$fecha_salida_ieps,$perfil,$estado)
{
	$nombre = utf8_decode($nombre);
	$apellido= utf8_decode($apellido);
	$inserta="insert into persona (idpersona, iddepartamento, idpersonajefe, cedula, nombre, apellido, grupo_ocupacional, modalidad_contratocion, 
	correo, activo, lugar_trabajo, fecha_ingreso_ieps, fecha_salida_ieps)
	values('$idpersona', '$iddepartamento', '$idpersonajefe', '$cedula', '$nombre', '$apellido', '$grupo_ocupacional', '$modalidad_contratacion', 	'$correo', '$estado', '$lugar_trabajo', '$fecha_ingreso_ieps', '$fecha_salida_ieps')";
	//echo "inserta=".$inserta."<br>";

	$insertausuario="insert into usuario (iddepartamento, usuario, contrasena, correo, activo, cedula)
	values('$iddepartamento', '$cedula', '$cedula', '$correo', '$estado', '$cedula')";
	//echo "insertausuario=".$insertausuario."<br>";

	if(query($inserta))
	{
		if(query($insertausuario))
		{
			insertPerfilUsuario($perfil,$estado,$cedula);
		}
	}
}

function insertPerfilUsuario($idperfil,$activo,$cedula)
 {
	 $consulta_usuario="select u.idusuario,u.correo, concat(p.nombre,' ',p.apellido) nombres from usuario u inner join persona p on(u.usuario = p.cedula)  where u.usuario = '$cedula'";
	$result_usuario=query($consulta_usuario);
	while($lista_usuario=mysql_fetch_object($result_usuario))
		{
			$idusuario=$lista_usuario->idusuario;
			$correo=$lista_usuario->correo;
			$nombres=$lista_usuario->nombres;
		}
		$insertaperfil_usuario="insert into perfil_usuario (idperfil, idusuario, activo)
		values('$idperfil', '$idusuario', '$activo')";
		//echo "insertPerfilUsuario=".$insertaperfil_usuario."<br>";
		if(query($insertaperfil_usuario))
		{
	  	//	echo "correo=$correo<br>";  
				$mensaje="";
	  			$body= "<html>
	  			<head>
				<title>Usuario del Sistema de Formularios en Linea de Talento Humano</title>
	  			</head>
	  			<body>
	  			<br><b>$nombres</b> el sistema de Formularios en Linea de Talento Humano le da la bienvenida.</br>
				<br>Su usuario ha sido creado satisfactoriamente, el nombre de usuario y clave es su número de cédula <b>$cedula</b>.</br>
				<br><b>No olvide cambiar la clave cuando ingresa por primera vez al sistema.</b></br> 
	  			</body>
	  			</html>";
	  			if(enviarMail($correo,$body,"Creación de usuario Sistema de Formularios Talento Humano."))
	  			{
					$mensaje=" LA CREACIÓN DEL USUARIO HA SIDO NOTIFICADO POR CORREO";
				}
					listaUsuarios("EL USUARIO HA SIDO CREADO EXITOSAMENTE...!".$mensaje);

		}
		else
			{
				//echo mysql_errno() . ": " .mysql_error();
				listaUsuarios("PROBLEMAS AL INGRESAR LA INFORMACIÓN... Error:".mysql_error());
				
			}
 }

 /*****************************
 Editar usuario integrando area

 function editarUsuario($idpersona,$iddepartamento,$idpersonajefe,$cedula,$nombre,$apellido,$grupo_ocupacional,$modalidad_contratacion,$correo,$lugar_trabajo,$fecha_ingreso_ieps,$fecha_salida_ieps,$perfil,$estado, $idarea)
{
	$nombre = utf8_decode($nombre);
	$apellido= utf8_decode($apellido);
	
	$consulta_usuario="select idusuario from usuario where usuario = '$cedula'";
	$result_usuario=query($consulta_usuario);
	while($lista_usuario=mysql_fetch_object($result_usuario))
		{
			$idusuario=$lista_usuario->idusuario;
		}
	
	$edita="update persona 
	set
	iddepartamento = $iddepartamento, 
	idpersonajefe = $idpersonajefe , 
	cedula = '$cedula' , 
	nombre = '$nombre' , 
	apellido = '$apellido' , 
	grupo_ocupacional = '$grupo_ocupacional' , 
	modalidad_contratocion = '$modalidad_contratacion' , 
	correo = '$correo' , 
	activo = '$estado' , 
	lugar_trabajo = $lugar_trabajo , 
	fecha_ingreso_ieps = '$fecha_ingreso_ieps' , 
	fecha_salida_ieps = '$fecha_salida_ieps',
	idarea = $idarea
	where
		idpersona = $idpersona";
	//echo $edita.'<br>';
	
	$editarusuario="update usuario 
	set
	iddepartamento = $iddepartamento,
	correo = '$correo', 
	activo = '$estado'
	where
		cedula = '$cedula'";
	//echo $editarusuario.'<br>';
	
	$editarperfil_usuario="update perfil_usuario 
	set 
	idperfil = '$perfil' , 
	activo = '$estado'	
	where
		idusuario = '$idusuario'";
	//echo $editarperfil_usuario."<br>";
	
	if(query($edita))
		{
		if(query($editarusuario))
			{
			if(query($editarperfil_usuario))
				{
					listaUsuarios("EL USUARIO HA SIDO ACTUALIZADO EXITOSAMENTE...!");
				}
			}
			
		}
}


 ******************************/

function editarUsuario($idpersona,$iddepartamento,$idpersonajefe,$cedula,$nombre,$apellido,$grupo_ocupacional,$modalidad_contratacion,$correo,$lugar_trabajo,$fecha_ingreso_ieps,$fecha_salida_ieps,$perfil,$estado)
{
	$nombre = utf8_decode($nombre);
	$apellido= utf8_decode($apellido);
	/*******************************************************************/
	$consulta_usuario="select idusuario from usuario where usuario = '$cedula'";
	$result_usuario=query($consulta_usuario);
	while($lista_usuario=mysql_fetch_object($result_usuario))
		{
			$idusuario=$lista_usuario->idusuario;
		}
	/*******************************************************************/
	$edita="update persona 
	set
	iddepartamento = $iddepartamento, 
	idpersonajefe = $idpersonajefe , 
	cedula = '$cedula' , 
	nombre = '$nombre' , 
	apellido = '$apellido' , 
	grupo_ocupacional = '$grupo_ocupacional' , 
	modalidad_contratocion = '$modalidad_contratacion' , 
	correo = '$correo' , 
	activo = '$estado' , 
	lugar_trabajo = $lugar_trabajo , 
	fecha_ingreso_ieps = '$fecha_ingreso_ieps' , 
	fecha_salida_ieps = '$fecha_salida_ieps'	
	where
		idpersona = $idpersona";
	//echo $edita.'<br>';
	/*******************************************************************/
	$editarusuario="update usuario 
	set
	iddepartamento = $iddepartamento,
	correo = '$correo', 
	activo = '$estado'
	where
		cedula = '$cedula'";
	//echo $editarusuario.'<br>';
	/*******************************************************************/
	$editarperfil_usuario="update perfil_usuario 
	set 
	idperfil = '$perfil' , 
	activo = '$estado'	
	where
		idusuario = '$idusuario'";
	//echo $editarperfil_usuario."<br>";
	/*******************************************************************/
	if(query($edita))
		{
		if(query($editarusuario))
			{
			if(query($editarperfil_usuario))
				{
					listaUsuarios("EL USUARIO HA SIDO ACTUALIZADO EXITOSAMENTE...!");
				}
			}
			
		}
}

function listaUsuarios($mensaje)
{
	echo "<div id='DivUsuario'>
		<table border='0' align='center'>
			<tr height='50'>
				<td align='center'><font size='2' face='Arial, Helvetica, sans-serif'><strong>".$mensaje."</strong></font></td>
			</tr>
			<tr>
				<td align='center'><input type='button' name='regresar' value='Regresar' onClick='regresar();'></td>
			</tr>
		</table>
	</div>";
}

function eliminaUsuario($idpersona)
{
	$elimina="delete from persona where idpersona=".$idpersona;
	if(query($elimina))
		{
			listaUsuarios("EL USUARIO HA SIDO ELIMINADO EXITOSAMENTE...!");
		}
}
/*function reseteo($idpersona)
{
	echo "cedula llego a funcion reseteo=".$idpersona;
}*/
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function reseteo($idpersona_aux)
{
//$ci_user= $_POST['ci_user'];

	$consulta=" select cedula, correo, concat(nombre,' ',apellido) nombres from persona where idpersona = '$idpersona_aux'";
	 
	$result_usuario=query($consulta);
	while($lista_usuario=mysql_fetch_object($result_usuario))
		{
			$cedula=$lista_usuario->cedula;
			$correo=$lista_usuario->correo;
			$nombres=$lista_usuario->nombres;
		}
		if(query($consulta))
		{
				$mensaje="";
	  			$body= "<html>
	  			<head>
				<title>Reseteo de Clave en Sistema Formularios de Talento Humano</title>
	  			</head>
	  			<body>
	  			<br><b>$nombres</b> El Sistema Formularios de Talento Humano ha reseteado su clave satisfactoriamente.</br>
				<br>El nombre de usuario y clave es su n&uacute;mero de c&eacute;dula <b>$cedula</b>.</br>
				<br><b>No olvide cambiar la clave cuando reingrese al sistema.</b></br> 
				</body>
	  			</html>";
//	  			if(enviarMail($mail_institucional,$body,"Creaci&oacute;n de usuario Sistema Administraci&oacute;n Parque Automotor."))
				if(enviarMail($correo,$body,"RESETEO DE CLAVE EN EL SISTEMA FORMULARIOS DE TALENTO HUMANO"))
	  			{
					$mensaje=" EL RESETEO DE CLAVE HA SIDO NOTIFICADA POR CORREO";
				}
					listaUsuarios("EL RESETEO DE CLAVE HA SIDO REALIZADA EXITOSAMENTE...!".$mensaje);

		}
		else
			{
				//echo mysql_errno() . ": " .mysql_error();
				listaUsuarios("PROBLEMAS AL INGRESAR LA INFORMACION... Error:".mysql_error());
				
			}
}


function ReseteoTablaUsuario($idpersona_aux)
{
	$editarusuario="update usuario 
	set
	contrasena = '$idpersona_aux', 
	ingreso = 0
	where
		cedula = '$idpersona_aux'";

		if(query($editarusuario))
			{
				listaUsuarios("USUARIO Y CONTRASEÑA RESETEADOS SATISFACTORIAMENTE...!");
			}
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////


?>
