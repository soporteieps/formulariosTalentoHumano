<?php
include("../lib/dbconfig.php");
session_start(); 

if ($accion=="input")
{
	insertFormulario($idpersona, $idpersonajefe, $cedula, $nombres, $apellidos, $unidadoperativa, $fecha_1_salida, $fecha_1_retorno, $fecha_2_salida, $fecha_2_retorno, $fecha_3_salida, $fecha_3_retorno, $fecha_4_salida, $fecha_4_retorno, $fecha_5_salida, $fecha_5_retorno, $fecha_6_salida, $fecha_6_retorno, $reemplazo);
}
if($accion=="procesar")
{
	updateFormulario($idplan_vacaciones, $autorizacion,$comentario);
}

function updateFormulario($idplan_vacaciones, $autorizacion,$comentario)
{
	$comentario = utf8_decode($comentario);
	
	if($autorizacion==1)
	{
		$update="update plan_vacaciones set autorizacion= '$autorizacion', comentario= '$comentario' where idplan_vacaciones = $idplan_vacaciones";	
	}else
		$update="update plan_vacaciones set autorizacion= '$autorizacion', comentario_1= '$comentario' where idplan_vacaciones = $idplan_vacaciones";	
	
	//echo $inserta.'<br>';
	  if(query($update))
	  {
		  mensaje("PROCESO FUE FINALIZADO...!");
	  }
}


function insertFormulario($idpersona, $idpersonajefe, $cedula, $nombres, $apellidos, $unidadoperativa, $fecha_1_salida, $fecha_1_retorno, $fecha_2_salida, $fecha_2_retorno, $fecha_3_salida, $fecha_3_retorno, $fecha_4_salida, $fecha_4_retorno, $fecha_5_salida, $fecha_5_retorno, $fecha_6_salida, $fecha_6_retorno, $reemplazo)
{
	$nombres = utf8_decode($nombres); 		
	$apellidos = utf8_decode($apellidos);
	//$motivo = utf8_decode($motivo);
	$reemplazo = utf8_decode($reemplazo);
	$comentario = utf8_decode($comentario);
			
	 $inserta="insert into plan_vacaciones (idpersona, idpersonajefe, cedula, nombres, apellidos, unidadoperativa, fecha_1_salida, 
	fecha_1_retorno,fecha_2_salida,fecha_2_retorno,fecha_3_salida,fecha_3_retorno,fecha_4_salida,fecha_4_retorno,fecha_5_salida,fecha_5_retorno,
	fecha_6_salida,fecha_6_retorno,reemplazo)
	values
	('$idpersona', '$idpersonajefe', '$cedula', '$nombres', '$apellidos', '$unidadoperativa', '$fecha_1_salida', '$fecha_1_retorno', '$fecha_2_salida', '$fecha_2_retorno', '$fecha_3_salida', '$fecha_3_retorno', '$fecha_4_salida', '$fecha_4_retorno', '$fecha_5_salida', '$fecha_5_retorno', '$fecha_6_salida', '$fecha_6_retorno', '$reemplazo')";
	//echo $inserta.'<br>';
	  if(query($inserta))
	  {
		  mensaje("INGRESO FUE SATISFACTORIO");
	  }
}

function mensaje($mensaje)
{
	echo "<div id='DivPlanificacion_Vacaciones' align='center'>";
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