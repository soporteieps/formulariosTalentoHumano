<?php
include("../lib/dbconfig.php");
include('mail.php');

error_reporting(0);
session_start(); 
$cedula = $_SESSION['cedula'];
$idperfil = $_SESSION['idperfil'];
$idpersona = $_SESSION['idpersona'];


/*$placa= utf8_decode($_POST['placa']);
$fecha_mantenimiento= utf8_decode($_POST['fecha_mantenimiento']);
$ultimo_kilometraje= utf8_decode($_POST['ultimo_kilometraje']);
$observaciones= utf8_decode($_POST['observaciones']);
$cantidad = ($_POST['cantidad']);
$valor = ($_POST['valor']);
$trabajo_solicitado = utf8_decode($_POST['trabajo_solicitado']);
$encargado_transportes = utf8_decode($_POST['encargado_transportes']);
*/

if ($accion=="input")
{
	insertFormulario($idpersona, $idpersonajefe, $cedula,$nombres,$apellidos,$unidadoperativa,$fechainicio,$fechafin,$horainicio,$horafin,$motivo,$archivo,$observaciones);
}
if($accion=="procesar")
{
	updateFormulario($iddatopersonal, $autorizacion,$comentario);
}

function updateFormulario($iddatopersonal, $autorizacion,$comentario)
{
	$comentario = utf8_decode($comentario);
	$mensaje="";
	if($autorizacion==1)
	{
		$update="update dato_personal set autorizacion= '$autorizacion', comentario= '$comentario', fechaactualizacion=now() where iddatopersonal = $iddatopersonal";
		$mensaje="Autorizada";
	}else{
		$update="update dato_personal set autorizacion= '$autorizacion', comentario_1= '$comentario', fechaactualizacion=now() where iddatopersonal = $iddatopersonal";
		$mensaje="No Autorizada";
	}
	
//	echo "update=$update<br>";
	  if(query($update))
	  {


  		/*if(enviar_mail($correo))
	  	{*/	  		
	  		$query = "select nombre,apellido, correo from persona where idpersona = '".$_SESSION['idpersona']."'";
	  	//	echo "query =$query<br>";
	  		$result=query($query);
	  		$row=null;
	  		$rows = array();
	  		while($row=mysql_fetch_array($result))
	  		{
	  			$rows[] = $row;
	  			
	  		}
	  		$row=$rows[0];
	  		$correo= $row['correo'];
	  	//	echo "correo=$correo<br>";  
	  			$body= "<html>
	  			<head>
	  			<title>Solicitud de Permisos</title>
	  			</head>
	  			<body>
	  			<br>Su solicitud ha sido $mensaje</br> 
	  			</body>
	  			</html>";
	  			if(enviarMailDetalle1($correo,$body))
	  			{
	  				
	  				echo "<div id='DivFormulario' align='center'>";
	  				echo "<table border='1'>
				 <tr>
					<td bgcolor='#6B79A5' colspan='4'><font size='2' face='Arial, Helvetica, sans-serif' color='#ffffff'>
						<center>
							<strong>PROCESO FUE FINALIZADO...!</strong></font>
						</center>
					</td>
				  </tr>
				  <tr height='30'>
				 	<td>
						<center>
							<input name='cancelar' type='button' value='Regresar' onClick='regresar1();'>
						</center>
					</td>
				 </tr>
			</table>
		   </div>";
	  				
	  				
/*	  				echo "<div id='DivFormulario' align='center' style='background-image:url(../../images/productos.jpg); background-repeat:no-repeat; background-position:center; opacity:80);'>
									<table width='280' height='194' border='1'>
									<div
										<tr>
											<td bgcolor='#084164' height='20'>
												<font size='2' face='Arial, Helvetica, sans-serif' color='#ffffff'>
													<center><strong>SOLICITUD ENVIADA SATISFACTORIAMENTE</center></strong></font>
											</td>
										</tr>
										<tr>
											<td align='center' valign='bottom'>
												<input name='btnRegresar' id='btnRegresar' style='background-image:url(../../images/nuevo.gif);background-repeat:no-repeat;height:50px;width:50px;background-position:center; cursor: pointer;'
											 type='button' value='Regresar' onclick='regresar()' title='Ingresar nueva solicitud'>
											</td>
										</tr>
									</table>
								</div>";
*/	  					
	  					
	  			}
	  			else
	  			{
	  				echo ('<span style="color:#ffffff">ERROR: El correo electr&oacute;nico ingresado no existe o esta mal ingresado, porfavor comuniquese con el departamento de Tecnolog&iacute;a del IEPS, para poder corregir su correo electr&oacute;nico y pueda recibir informaci&oacute;n por esta v&iacute;a.</span><br>');
	  			//}
	  			//}
	  			}
	  	}
}
	  	
	  	
function insertFormulario($idpersona, $idpersonajefe, $cedula,$nombres,$apellidos,$unidadoperativa,$fechainicio,$fechafin,$horainicio,$horafin,$motivo,$archivo,$observaciones)
{
	$nombres = utf8_decode($nombres); 		
	$apellidos = utf8_decode($apellidos);
	$motivo = utf8_decode($motivo);
	$observaciones = $observaciones; //SIN UTF8 ME PERMITE INGRESAR Ñ Y TILDES A LA BASE DE DATOS
	$comentario = utf8_decode($comentario);
	
	//echo "OBSERVACIONES:" . $observaciones;
	
			
	 $inserta="insert into dato_personal (idpersona, idpersonajefe, cedula, nombres, apellidos, unidadoperativa, fechainicio, 
	fechafin, horainicio, horafin, motivo, archivo, observaciones)
	values
	('$idpersona', '$idpersonajefe', '$cedula', '$nombres', '$apellidos', '$unidadoperativa', '$fechainicio', '$fechafin', '$horainicio', '$horafin', '$motivo', '$archivo', '$observaciones')";
	//echo $inserta.'<br>';
	  if(query($inserta))
	  {
	  $query = "select correo from persona where idpersona=$idpersonajefe";
	  	//	echo "query =$query<br>";
	  		$result=query($query);
	  		$row=null;
	  		$rows = array();
	  		while($row=mysql_fetch_array($result))
	  		{
	  			$rows[] = $row;
	  			
	  		}
	  		$row=$rows[0];
	  		$correo= $row['correo'];
	  		//echo "correo=$correo<br>";  
	  		$mensaje="Tiene pendientes solicitudes de permisos por aprobar, ingresa al sistema de Formularios en Linea de Talento Humano";
	  			$body= "<html>
	  			<head>
	  			<title>Solicitud de Permisos</title>
	  			</head>
	  			<body>
	  			<br>$mensaje</br> 
	  			</body>
	  			</html>";
	  			if(enviarMailDetalle1($correo,$body))
	  			{
	  				
	  				echo "<div id='DivFormulario' align='center'>";
	  				echo "<table border='1'>
				 <tr>
					<td bgcolor='#6B79A5' colspan='4'><font size='2' face='Arial, Helvetica, sans-serif' color='#ffffff'>
						<center>
							<strong>SOLICITUD ENVIADA SATISFACTORIAMENTE</strong></font>
						</center>
					</td>
				  </tr>
				  <tr height='30'>
				 	<td>
						<center>
							<input name='cancelar' type='button' value='Regresar' onClick='regresar();'>
						</center>
					</td>
				 </tr>
			</table>
		   </div>";
	  				
	  				/*echo "<div id='DivFormulario' align='center' style='background-image:url(../../images/productos.jpg); background-repeat:no-repeat; background-position:center; opacity:80);'>
									<table width='280' height='194' border='1'>
									<div
										<tr>
											<td bgcolor='#084164' height='20'>
												<font size='2' face='Arial, Helvetica, sans-serif' color='#ffffff'>
													<center><strong>SOLICITUD ENVIADA SATISFACTORIAMENTE</center></strong></font>
											</td>
										</tr>
										<tr>
											<td align='center' valign='bottom'>
												<input name='btnRegresar' id='btnRegresar' style='background-image:url(../../images/nuevo.gif);background-repeat:no-repeat;height:50px;width:50px;background-position:center; cursor: pointer;'
											 type='button' value='Regresar' onclick='regresar()' title='Ingresar nueva solicitud'>
											</td>
										</tr>
									</table>
								</div>";
	  					*/
	  					
	  			}
	  			else
	  			{
	  				echo ('<span style="color:#ffffff">ERROR: El correo electr&oacute;nico ingresado no existe o esta mal ingresado, porfavor comuniquese con el departamento de Tecnolog&iacute;a del IEPS, para poder corregir su correo electr&oacute;nico y pueda recibir informaci&oacute;n por esta v&iacute;a.</span><br>');
	  			//}
	  			//}
	  			}
	  	}
}
	  	

function mensaje($mensaje)
{
	echo "<div id='DivFormulario' align='center'>";
				echo "<table border='1'>
				 <tr>
					<td bgcolor='#6B79A5' colspan='4'><font size='2' face='Arial, Helvetica, sans-serif' color='#ffffff'>
						<center>
							<strong>".$mensaje."</strong></font>
						</center>
					</td>
				  </tr>
				  <tr height='30'>
				 	<td>
						<center>
							<input name='cancelar' type='button' value='Regresar' onClick='regresar1();'>
						</center>
					</td>	
				 </tr>
			</table>
		   </div>";
}
?>