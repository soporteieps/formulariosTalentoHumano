<?php
include("../lib/dbconfig.php");
session_start(); 

if($accion=="jefeinmediato")
{
	getJefeInmediato($idDepartamento, $action);
}

if($accion=="nombresubrrogante")
{
	getNombreSubrrogante($cedula_subrrogante);
}

if($accion=="input")
{
	cambiarJefe($iddepartamento, $jefeinmediato, $cedula_subrrogante, $fecha_inicio);
}

if($accion=="edit")
{
	editFormulario($id_subrrogacion, $iddepartamento, $jefeinmediato, $cedula_subrrogante, $fecha_inicio, $fecha_fin, $comentario_jefe);
}


function getJefeInmediato($idDepartamento, $action)
{	
	echo '<div id="Div_JefeInmediato">';
		if($action=="edita")
			{
				$consulta="select cedula,concat(nombre,' ',apellido,'(',case activo when 1 then 'A' else 'I' end ,')') nombres from persona where cedula in (select u.cedula from usuario u inner join perfil_usuario pu on(u.idusuario = pu.idusuario) where  pu.idperfil = 3 and u.iddepartamento = ".$idDepartamento.")";
			}else
			{
				$consulta="select cedula,concat(nombre,' ',apellido,'(',case activo when 1 then 'A' else 'I' end ,')') nombres from persona where activo = 1 and cedula in (select u.cedula from usuario u inner join perfil_usuario pu on(u.idusuario = pu.idusuario) where  pu.idperfil = 3 and u.activo = 1 and u.iddepartamento = ".$idDepartamento.")";
				
			}
				//$consulta="select cedula,concat(nombre,' ',apellido) nombres from persona where activo = 1 and cedula in (select u.cedula from usuario u inner join perfil_usuario pu on(u.idusuario = pu.idusuario) where  pu.idperfil = 3 and u.activo = 1 and u.iddepartamento = ".$idDepartamento.")";
			//echo "getJefeInmediato=".$consulta."<br>";
			
			$result=query($consulta);
			echo '<select name="jefeinmediato" id="jefeinmediato" style="width:300px" >';
			while($area=mysql_fetch_object($result))
				{
					$descripcion = utf8_encode($area->usuario);	
					echo '<option value="'.$area->cedula.'">'.$area->nombres.'</option>';			
				}
			echo '</select>
		</div>';
}

function getNombreSubrrogante($cedula_subrrogante)
{
		echo '<div id="Div_NombreSubrrogante">';	
			$consulta="select concat(nombre,' ',apellido) nombres from persona where cedula in (select u.cedula from usuario u inner join perfil_usuario pu on(u.idusuario = pu.idusuario) where cedula = ".$cedula_subrrogante.")";
			$result=query($consulta);
			while($area=mysql_fetch_object($result))
				{
					//$nombres = utf8_encode($area->nombres);
					$nombres_aux = $area->nombres;
				}
			echo '<input name="nombre_subrrogante" type="text" id="nombre_subrrogante" value="'.$nombres_aux.'" style="width: 200px; font-size:12px"; disabled>';
		echo '</div>';
}


function editFormulario($id_subrrogacion, $id_departamento, $id_jefesubrrogado, $id_jefesubrrogante, $fecha_inicio, $fecha_fin, $observacion)
{
	 $update="update subrrogacion set activo = '0' where id_subrrogacion = '$id_subrrogacion'";
			
	//echo $update.'<br>';
	  if(query($update))
	  {
		  if(
		  (usuario($id_jefesubrrogado,'1')) and
		  (perfiles($id_jefesubrrogado,$id_jefesubrrogante,'1')) and
		  (dato_personal($id_jefesubrrogado,$id_jefesubrrogante, $fecha_inicio, $fecha_fin,'1')) and
		  (persona($id_jefesubrrogado,$id_jefesubrrogante,'1'))
		  )
		  {
			  mensaje("LA SUBRROGACION A SIDO TERMINADA SATISFACTORIAMENTE");
		  }
	  }
}


function cambiarJefe($id_departamento, $id_jefesubrrogado, $id_jefesubrrogante, $fecha_inicio)
{

	$queryTotalSubordinados = "SELECT COUNT(*) as subordinados FROM persona WHERE idpersonajefe = $id_jefesubrrogado AND activo = 1";

	$resSubordinados = query($queryTotalSubordinados);
	$numSubordinados = 0;
	while($respuesta = mysql_fetch_object($resSubordinados))
	{
		$numSubordinados = $respuesta->subordinados;
	}

	//se tiene que buscar los usuarios que tengan el cliente jefe equivocado

	$consultaUsuarios = "SELECT idpersonajefe, cedula as Cedula, nombre as Nombre, apellido as Apellido, activo as Activo FROM persona WHERE idpersonajefe = $id_jefesubrrogado and activo = 1";

	//echo $consultaUsuarios . "<br>";

	$resultado = query($consultaUsuarios);
	$idjefeAntiguo = 0;
	$cont = 0;
	while($empleado = mysql_fetch_object($resultado))
	{
		$cont++;
		if($cont == 1)
			$idjefeAntiguo = $empleado->idpersonajefe;

		$cedula = $empleado->Cedula;
		//echo $cedula . "<br />";
		$actualizarDatos = "UPDATE persona SET idpersonajefe = $id_jefesubrrogante WHERE cedula = '$cedula'";

		//echo $actualizarDatos . "<br>";
		query($actualizarDatos);			

		//actualizar los permisos desde la fecha en q se realiza esta operacion
		//$today = date("Y-m-d");
		//echo $today . "<br>";

		$actualizarPermisos = "UPDATE dato_personal SET idpersonajefe = $id_jefesubrrogante WHERE cedula = '$cedula' AND fechainicio >= '$fecha_inicio'";
		//echo $actualizarPermisos . "<br>";

		query($actualizarPermisos);	

	}
	//dejar inactivo al antiguo jefe
	$consultaDesactivarJefe = "UPDATE persona SET activo = 0 WHERE cedula = '$idjefeAntiguo'";
	$consultaDescactivarUsuarioJefe = "UPDATE usuario SET activo = 0 WHERE cedula = '$idjefeAntiguo'";
	//echo $consultaDesactivarJefe . "-------" . $consultaDescactivarUsuarioJefe;

	query($consultaDesactivarJefe);
	query($consultaDescactivarUsuarioJefe);

	if($cont == $numSubordinados)
		mensaje("EL JEFE INMEDIATO HA SIDO REEMPLAZADO SATISFACOTRIAMENTE");		
	else
	{
		$faltantes = $numSubordinados - $cont;
		mensaje("FALTAN " . $faltantes . " REGISTROS POR CAMBIAR DE ID JEFE");
	}


	
}

function mensaje($mensaje)
{
	echo "<div id='DivSubrrogaciones' align='center'>";
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

function usuario($id_jefesubrrogado, $activo){
/*CAMBIAR EL CAMPO activo a 0*/
$retorno=false;
$actulizar="update usuario set activo = $activo where cedula = '$id_jefesubrrogado'";
//echo "usuario=".$actulizar."<br>";

$actulizar_activo="update persona set activo = $activo where idpersona = '$id_jefesubrrogado'";
	//echo "actulizar_activo=".$actulizar_activo."<br>";
	if(query($actulizar) and query($actulizar_activo))
	  {
	  $retorno=true;
	  }
      return $retorno;
}

function perfiles($id_jefesubrrogado, $id_jefesubrrogante,$activo){
//function perfiles($cedula){
/*CAMBIAR EL idperfil POR PERFIL DE JEFE INMEDIATO(3)*/
$retorno=false;
//SI INGRESA UNA NUEVA SUBRROGACION
if($activo == '0'){
	$actulizar="update perfil_usuario set idperfil = 3 where idusuario = (select idusuario from usuario where cedula = '$id_jefesubrrogante')";
	//echo "perfiles=".$actulizar."<br>";
}else//SI REVIERTE LA SUBRROGACION
{
	//$actulizar="select * from perfil_usuario where idperfil_usuario in (select idusuario from usuario where usuario in('$id_jefesubrrogado', '$id_jefesubrrogante')) and jefe_posesionado = 0";
	$actulizar="update perfil_usuario set idperfil = 2 where idperfil_usuario in (select idusuario from usuario where usuario in('$id_jefesubrrogado', '$id_jefesubrrogante'))
and jefe_posesionado = 0";
}

if(query($actulizar))
  {
	  $retorno=true;
  }
    return $retorno;
}

/*CAMBIAR TODOS LOS REGISTROS QUE SE ENCUENTREN EN EL RANGO TIEMPO DE LA DURACION DE LA SUBRROGACION EL idpersonajefe*/
function dato_personal($id_jefesubrrogado, $id_jefesubrrogante, $fecha_inicio, $fecha_fin, $activo){
$retorno=false;

//SI INGRESA UNA NUEVA SUBRROGACION
if($activo == '0'){
	$actulizar="update dato_personal set idpersonajefe  = '$id_jefesubrrogante' where idpersonajefe = '$id_jefesubrrogado' and fechainicio >= '$fecha_inicio' and fechafin <= '$fecha_fin' and idpersona <> '$id_jefesubrrogante'";
	//echo "dato_personal=".$actulizar."<br>";
	
	$actulizar_permisos_nuevo_jefe="update dato_personal set idpersonajefe  = (select idpersonajefe from persona where idpersona = '$id_jefesubrrogado') where idpersona = '$id_jefesubrrogante' and fechainicio >= '$fecha_inicio' and fechafin <= '$fecha_fin'";
	//echo "dato_personal=".$actulizar_permisos_nuevo_jefe."<br>";
}else//SI REVIERTE LA SUBRROGACION
{
	$actulizar="update dato_personal set idpersonajefe  = '$id_jefesubrrogado' where idpersonajefe = '$id_jefesubrrogante' and fechainicio > '$fecha_fin' and idpersona <> '$id_jefesubrrogante'";
	//echo "dato_personal=".$actulizar."<br>";
	
	$actulizar_permisos_nuevo_jefe="update dato_personal set idpersonajefe  = '$id_jefesubrrogado' where idpersona = '$id_jefesubrrogante' and fechainicio >'$fecha_fin'";
	//echo "actulizar_permisos_nuevo_jefe=".$actulizar_permisos_nuevo_jefe."<br>";
}



if(query($actulizar) and query($actulizar_permisos_nuevo_jefe))
  {
	  $retorno=true;
  }
    return $retorno;
}

/*CAMBIAR TODOS LOS QUE ESTAN A CARGO DEL JEFE SALIENTE POR EL JEFE ENTRANTE Y QUE EL CAMPO ACTIVO DEL SALIENTE EN CERO*/
function persona($id_jefesubrrogado, $id_jefesubrrogante,$activo){
	echo "persona=".$id_jefesubrrogado.",".$id_jefesubrrogante.",".$activo."<br>";
	
//SI INGRESA UNA NUEVA SUBRROGACION
if($activo == '0'){
$retorno=false;
$set_nuevo_jefe_subordinados="";
$where_nuevo_jefe_subordinados="";

$getJefeInmediato ="select iddepartamento, idpersonajefe from persona where idpersona = '$id_jefesubrrogado'";
$result=query($getJefeInmediato);
	while($data=mysql_fetch_object($result))
	{
		$idpersonajefe = $data->idpersonajefe;	
		$iddepartamento = $data->iddepartamento;
	}
	//JEFES
	$set_nuevo_jefe="update persona set idpersonajefe = '$idpersonajefe' where idpersona =  '$id_jefesubrrogante'";
	//SUBORDINADOS
	$set_nuevo_jefe_subordinados="set idpersonajefe = '$id_jefesubrrogante' where idpersonajefe =  '$id_jefesubrrogado'";
	$where_nuevo_jefe_subordinados="";
	
}
else//SI REVIERTE LA SUBRROGACION
{
	//DEPARTAMENTO JEFE SUBRROGANTE
	$getJefeInmediato ="select iddepartamento from persona where idpersona = '$id_jefesubrrogante'";
	$result=query($getJefeInmediato);
	while($data=mysql_fetch_object($result))
	{
		$iddepartamento = $data->iddepartamento;
	}
	
	//DEPARTAMENTO JEFE SUBRROGADO
	$getJefeInmediato ="select iddepartamento from persona where idpersona = '$id_jefesubrrogado'";
	$result=query($getJefeInmediato);
	while($data=mysql_fetch_object($result))
	{
		$iddepartamento_subrrogado = $data->iddepartamento;
	}
	
	
	$getIdJefeInmediato ="select * from persona p where p.cedula=( 
select cedula from usuario where idusuario =(
select idusuario from perfil_usuario 
where idusuario in (select idusuario from usuario where iddepartamento = 1) and jefe_posesionado = $iddepartamento))";
	$result=query($getIdJefeInmediato);
	while($data=mysql_fetch_object($result))
	{
		$idpersona = $data->idpersona;
	}
	

	$idpersonajefe = $id_jefesubrrogado;
	//JEFES
	$set_nuevo_jefe="update persona set idpersonajefe = '$idpersona' where idpersona =  '$id_jefesubrrogante'";
	//SUBORDINADOS
	$set_nuevo_jefe_subordinados="set idpersonajefe = '$id_jefesubrrogado' where idpersonajefe =  '$id_jefesubrrogante'";
	//SI EL JEFE SUBRROGANTE PERTENECE AL MISMO DEPARTAMENTO DEL JEFE SUBRROGADO
	if($iddepartamento == $iddepartamento_subrrogado) 
	{
		$where_nuevo_jefe_subordinados="and idpersona <> '$id_jefesubrrogante'";
	}else
	{
		$where_nuevo_jefe_subordinados="and iddepartamento <> $iddepartamento and idpersona <> '$id_jefesubrrogante'";	
	}
}

	//JEFES
	$actulizar_nuevo_jefe ="$set_nuevo_jefe";
	//SUBORDINADOS
	$actulizar_nuevo_jefe_subordinados ="update persona $set_nuevo_jefe_subordinados $where_nuevo_jefe_subordinados";
	
	
	
	echo "actulizar_nuevo_jefe=".$actulizar_nuevo_jefe ."<br>";
	echo "actulizar_nuevo_jefe_subordinados=".$actulizar_nuevo_jefe_subordinados."<br>";
	
	if(query($actulizar_nuevo_jefe) and query($actulizar_nuevo_jefe_subordinados))
	  {
	  	$retorno=true;
	  }
      return $retorno;
}

?>