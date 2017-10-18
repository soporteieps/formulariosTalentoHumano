<?php
include("../lib/dbconfig.php");
include('mail.php');
error_reporting(0);
session_start(); 
$cedula = $_SESSION['cedula'];
$idperfil = $_SESSION['idperfil'];
$idpersona = $_SESSION['idpersona'];
$nombre=$_SESSION['nombre'];
$apellido=$_SESSION['apellido'];



if ($accion=="input")
{
	insertFormulario($idpersona, $idpersonajefe, $cedula, $nombres, $apellidos, $unidadoperativa, $fecha_inicio, $fecha_fin, $reemplazo);
}

	if($accion=="procesar")
	{
		updateFormulario($idsolicitud, $autorizacion,$comentario_jefe);
	}
	
	function updateFormulario($idsolicitud, $autorizacion,$comentario_jefe)
	{
		$comentario = utf8_decode($comentario);
		$mensaje="";
		
		if($autorizacion==1)
		{
			$update="update solicitud_vacaciones set autorizacion= '$autorizacion', comentario_jefe= '$comentario_jefe', fechaactualizacion=now() where idsolicitud = $idsolicitud";
			$mensaje="Autorizada";
		}else{
			$update="update solicitud_vacaciones set autorizacion= '$autorizacion', comentario1_jefe= '$comentario_jefe', fechaactualizacion=now() where idsolicitud = $idsolicitud";
			$mensaje="No Autorizada";
		}
		//echo $inserta.'<br>';
		if(query($update))
		{
		//$query = "select nombre,apellido, correo from persona where idpersona = '".$_SESSION['idpersona']."'";
		
		$query = "select sv.idsolicitud,p.idpersonajefe,p.idpersona,p. correo, sv.nombres,sv.apellidos, sv. fecha_inicio, sv. fecha_fin
		from persona p
		inner join solicitud_vacaciones sv on(p.idpersona = sv.idpersona) where sv.idsolicitud = '".$idsolicitud."'";
	  	//	echo "query =$query<br>";
			$result=query($query);
			
			while($row = mysql_fetch_array($result))
			{
				$idsolicitud = utf8_encode($row['idsolicitud']);
				$idpersonajefe = utf8_encode($row['idpersonajefe']);
				$idpersona = utf8_encode($row['idpersona']);
				$nombre = utf8_encode($row['nombres']);
				$apellido = utf8_encode($row['apellidos']);
				$fecha_inicio = utf8_encode($row['fecha_inicio']);
				$fecha_fin = utf8_encode($row['fecha_fin']);
				$correo = utf8_encode($row['correo']);
			}	
				
	  	 /* 	$row=null;
	  		$rows = array();
	  		while($row=mysql_fetch_array($result))
	  		{
	  			$rows[] = $row;
	  			
	  		}
	  		$row=$rows[0];
	  		$correo= $row['correo'];*/
	  	//	echo "correo=$correo<br>";  
	  			$body= "<html>
	  			<head>
	  			<title>Solicitud de Vacaciones</title>
	  			</head>
	  			<body>
	  			<br>La solicitud de vacaciones con Nro. de ID $idsolicitud de $nombre.$apellido desde $fecha_inicio hasta $fecha_fin ha sido $mensaje por su jefe inmediato</br> 
	  			</body>
	  			</html>";
	  			if(enviarMailDetalle($correo,$body,$autorizacion))
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

function insertFormulario($idpersona, $idpersonajefe, $cedula, $nombres, $apellidos, $unidadoperativa, $fecha_inicio, $fecha_fin, $reemplazo)
{
	$nombres = utf8_decode($nombres); 		
	$apellidos = utf8_decode($apellidos);
	//$motivo = utf8_decode($motivo);
	$reemplazo = utf8_decode($reemplazo);
	$comentario = utf8_decode($comentario_jefe);
			
	 $inserta="insert into solicitud_vacaciones (idpersona, idpersonajefe, cedula, nombres, apellidos, unidadoperativa, fecha_inicio, 
	fecha_fin, reemplazo)
	values
	('$idpersona', '$idpersonajefe', '$cedula', '$nombres', '$apellidos', '$unidadoperativa', '$fecha_inicio', '$fecha_fin', '$reemplazo')";
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
	  		$mensaje="Tiene pendientes solicitudes de vacaciones por aprobar, ingresa al sistema de Formularios en Linea de Talento Humano";
	  			$body= "<html>
	  			<head>
	  			<title>Solicitud de Vacaciones</title>
	  			</head>
	  			<body>
	  			<br>$mensaje</br> 
	  			</body>
	  			</html>";
	  			if(enviarMailDetalle($correo,$body,$autorizacion))
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
	echo "<div id='DivSolicitud_Vacaciones' align='center'>";
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