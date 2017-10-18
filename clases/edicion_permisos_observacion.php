<?php
include("../lib/dbconfig.php");
session_start(); 
//$accion=$_GET['accion'];

/*echo $accion."<br>";*/

if($accion=="edita_observacion")
{
	editaObservacion($id, $observaciones);
}


function editaObservacion($id, $observaciones)
{
//echo "llega id:". $id;
//echo"llega observacion: ".$observaciones;	
	
	
  $update="update dato_personal 
	       set
	       observaciones = '$observaciones'
		   where
	       iddatopersonal = '$id'";


/*echo"update: ".$update."<br>";	*/
  if(query($update))
  {
	        echo "<div id='DivListaHorario' align='center'>";
	  				echo "<table border='1'>
				 <tr>
					<td bgcolor='#6B79A5' colspan='4'><font size='2' face='Arial, Helvetica, sans-serif' color='#ffffff'>
						<center>
							<strong>Registro Editado Exitosamente...!</strong></font>
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
   }
   /*else
   {
      echo "No se ha podido actualizar"  . $update;
   }*/

	
	
	
	
 //query($update);
 //$resultado = mysql_query($update);
	
		   
}



function EliminaHorarioEvento($cod_evento, $cod_horario)
{ 
   $elimina="delete from horario_evento where cod_horario = '$cod_horario'";
   $result=query($elimina);
   if(isset($result))
   {
	   $horas_evento = "SELECT SEC_TO_TIME( SUM( TIME_TO_SEC( total_horas ) ) ) as horas FROM horario_evento
                          where cod_evento = '$cod_evento'";
       $result_horas=query($horas_evento);
       while($horas=mysql_fetch_object($result_horas))
       {
          $total_horas=$horas->horas; 
       }
       // separo el valor de horas   
       $total_horas = "select hour('$total_horas') as horas";
       $result_horas=query($total_horas);
       while($lista_horas=mysql_fetch_object($result_horas))
       {
          $horas_evento=$lista_horas->horas; 
       }
       // actualizo horas evento
	   $update="update evento 
							set
							horas_evento = $horas_evento 
							where
							cod_evento = '$cod_evento'";
	  if(query($update))
      //daHorasEvento($cod_evento);
      listaHorario($cod_evento);
   }
   else
   {
      echo "No se ha podido eliminar el Horario seleccionada<br>";
	  listaHorario($cod_evento);
   }
}

function restaHoras($horaIni, $horaFin)
{
    return (date("H:i:s", strtotime("00:00:00") + strtotime($horaFin) - strtotime($horaIni) ));
}

function parteHora( $hora ){
    $horaSplit = explode(":", $hora);
        if( count($horaSplit) < 3 ){
            $horaSplit[2] = 0;
        }
    return $horaSplit;
}

function SumaHoras( $time1, $time2 ){
    list($hour1, $min1, $sec1) = parteHora($time1);
    list($hour2, $min2, $sec2) = parteHora($time2);
    return date('H:i:s', mktime( $hour1 - $hour2, $min1 - $min2, $sec1 - $sec2));
}

function daHorasEvento($cod_evento)
{		
	$consulta="select horas_evento from evento where cod_evento = '$cod_evento'";
	$result=query($consulta);
	while($h_evento=mysql_fetch_object($result))
	{
		$horas=$h_evento->horas_evento;
	}
	echo "<div id='IdHoras'>
			<table border='0'>
                <tr>
                    <td>
						<input name='horas' type='text' size='10' id='horas' value='$horas' readonly>
					 </td>
                </tr>
            </table>
		</div>";
}

function formularioHorario($cod_horario, $cod_evento)
{
   $consulta="select * from horario_evento where cod_horario = $cod_horario and cod_evento = $cod_evento";
   $result_horario=query($consulta);

   $tiempo_lunch="select * from tiempo_lunch order by cod_lunch";
   $tiempo=query($tiempo_lunch);

   while($horario=mysql_fetch_object($result_horario))
   {
	  $cod_horario=$horario->cod_horario;
	  $fecha_horario=$horario->fecha_horario;
	  $hora_desde=$horario->hora_desde;
	  $hora_hasta=$horario->hora_hasta;
	  $tiempo_lunch=$horario->tiempo_lunch;
   }
   echo "<div id='DivIngresaHorario'>";
   echo "<table border='1'>
   <tr>
   		<td bgcolor='#6B79A5' colspan='4'><font size='1' face='Arial, Helvetica, sans-serif' color='#ffffff'>
		<center><strong>INGRESO DE INFORMACIÓN HORARIO CURSO</center></strong></font>
	   </td>
   </tr>
   <tr>
   		<td colspan='2'><input type='hidden' name='cod_horario' id='cod_horario' value='$cod_horario'></td> 
   </tr>

   <tr>
    <td><strong><font size='1' face='Arial, Helvetica, sans-serif'>*FECHA HORARIO (YYYY-MM-DD) :</font></strong></td>
    <td><font size='1' face='Arial, Helvetica, sans-serif'>
	<input type='text' name='fecha_horario' id='fecha_horario' style='width: 80px; font-size:12px;' readonly='true' value='$fecha_horario'>
    </font></td>
   </tr>

   <tr>
    <td><strong><font size='1' face='Arial, Helvetica, sans-serif'>*HORARIO DESDE (hh:mm:ss) :</font></strong></td>
    <td><font size='1' face='Arial, Helvetica, sans-serif'>
    <input name='horai' type='text' size='10' onBlur='CheckTime(this);' value='$hora_desde'>
    </font></td>
  </tr>

   <tr>
    <td><strong><font size='1' face='Arial, Helvetica, sans-serif'>*HORARIO HASTA (hh:mm:ss) :</font></strong></td>
    <td><font size='1' face='Arial, Helvetica, sans-serif'>
    <input name='horaf' type='text' size='10' onBlur='CheckTimef(this);' value='$hora_hasta'>
    </font></td>
   </tr>


   <tr>
    <td><strong><font size='1' face='Arial, Helvetica, sans-serif'>*TIEMPO RECESO (MINUTOS) :</font></strong></td>
    <td><font size='1' face='Arial, Helvetica, sans-serif'>
     <select name='lunch' onChange='Horas_Diarias(document.form1.horai.value, document.form1.horaf.value, document.form1.lunch.value);'>
      <option value=-1>---Seleccione Tiempo Receso---</option>";
      while($lista_tiempo=mysql_fetch_object($tiempo))
      {	
         echo "<option value='". $lista_tiempo->minutos ."'>".$lista_tiempo->des_lunch."</option>";
      }  
      echo "</select></font></td>
      </tr>
      <tr>
      <td colspan='3'><center><font size='1' face='Arial, Helvetica, sans-serif'>
      <input name='ingresar' type='button' value='Ingresar' onClick='if(valida_horario()){
		  Ingresa_Horario(document.form1.cod_evento.value, document.form1.fecha_horario.value, document.form1.desde.value, document.form1.hasta.value, document.form1.horai.value, document.form1.horaf.value, document.form1.lunch.value);}'>
    <center></td>
    </tr></table></div>";
}
?>