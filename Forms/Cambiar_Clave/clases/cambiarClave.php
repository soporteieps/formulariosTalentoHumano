<?php
session_start();
include '../../../lib/dbconfig.php';
//include("../../../clases/cerrar_sesion.php");
$s=session_name();



if ($accion=="cambiarClave")
{
//echo $accion.' , '.$old_passwd.' , '.$new_passwd.' , '.$new_passwd_confirm.' , '.$_SESSION["password"].'<br>';
	if($_SESSION["contrasena"] == 'clave01')
	{
		if($old_passwd == $_SESSION["contrasena"])
		{
			if($new_passwd==$new_passwd_confirm)
			{
				$actualiza="update usuario set contrasena = '".$new_passwd."', ingreso = 1 where	usuario = '".$_SESSION["usuario"]."'";
				if(query($actualiza))
				{	
					session_destroy(); // destruyo la sesión
					cambioClaveCorrecto("La clave ha sido cambiada satisfactoriamente.",$type_user);
				}
			}
			else
			{
				daFormulario("La nueva clave no coincide.",$type_user);
			}
		}
		else
		{
			daFormulario("La clave anterior es incorrecta.",$type_user);
		}
	}
	else
	{
		//echo $accion.' , '.md5($old_passwd).' , '.$new_passwd.' , '.$new_passwd_confirm.' , '.$_SESSION["password"].'<br>';
		if($old_passwd == $_SESSION["contrasena"])
		{
			if($new_passwd==$new_passwd_confirm)
			{
				$actualiza="update usuario set contrasena = '".$new_passwd."', ingreso = 1 where	usuario = '".$_SESSION["usuario"]."'";
				if(query($actualiza))
				{	
					session_destroy(); // destruyo la sesión
					cambioClaveCorrecto("La clave ha sido cambiada satisfactoriamente.",$type_user);
				}
			}
			else
			{
				daFormulario("La nueva clave no coincide.",$type_user);
			}
		}
		else
		{
			daFormulario("La clave anterior es incorrecta.",$type_user);
		}
	}
}

function cambioClaveCorrecto($mensaje,$type_user)
{
	//echo 'cambioClaveCorrecto='.$mensaje.' , '.$type_user;
	
echo'<div id="DivTablaFormulario" align="center" style="background-image:url(../../images/cambio_clave.jpg); background-repeat:no-repeat; background-position:center;>
	<form method="post" name="form1" >
	 	<table border="1" height="100">
	 		<tr>
				<td align="center"><strong><font face="Arial, Helvetica, sans-serif">CAMBIO DE CLAVE</font></strong></td>
			</tr>
			<tr height="30">
				<td></td>
			</tr>
			<tr height="30">
				<td></td>
			</tr>
			<tr height="30">
				<td></td>
			</tr>
			<tr>
				<td><center><input name="salir" type="button" value="Salir" onClick="salir();"></center></td>
			</tr>
			<tr>
				
				<td align="center"><input name="type_user" type="hidden" value="'.$type_user.'"
				<strong><font color="#0000FF" face="Arial, Helvetica, sans-serif"><b>'.$mensaje.'</b></font></strong></td>
			</tr>
		</table>
	</form>
</div>';
}


function daFormulario($mensaje,$type_user)
{
	//echo 'daFormulario='.$mensaje.' , '.$type_user;
	
	echo '<div id="DivTablaFormulario" align="center" style="background-image:url(../../images/Icono_usuario.jpg); background-repeat:no-repeat; background-position:center; >
	<form name="form1" method="post" >
	<table border="1">
	<tr>
		<td colspan="2" align="center"><strong><font color="#FF0000" size="+2" face="Arial, Helvetica, sans-serif">CAMBIO DE CLAVE</font></strong></td>
	</tr>
	<tr>
		<td><strong><font color="#0000FF" face="Arial, Helvetica, sans-serif">Ingrese su clave anterior:</font></strong></td>
		<td><input name="old_passwd" type="password" size="20" maxlength="20"></td>
	</tr>
	<tr>
		<td><strong><font color="#0000FF" face="Arial, Helvetica, sans-serif">Ingrese la nueva clave:</font></strong></td>
		<td><input name="new_passwd" type="password"  size="20" maxlength="20"></td>
	</tr>
	<tr>
		<td><strong><font color="#0000FF" face="Arial, Helvetica, sans-serif">Confirme la nueva clave:</font></strong></td>
		<td><input name="new_passwd_confirm" type="password" size="20" maxlength="20"></td>
	</tr>
	<tr>
		<td><center><input name="clave" type="button" value="Cambiar Clave" onClick="cambiarClave2(document.form1.old_passwd.value, document.form1.new_passwd.value, document.form1.new_passwd_confirm.value, document.form1.type_user.value)"></center></td>
		<td><center><input name="regresar" type="button" value="Regresar" onClick="history.go(-1);"></center></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input name="type_user" type="hidden" value="'.$type_user.'">
		<strong><font color="red" face="Arial, Helvetica, sans-serif">'.$mensaje.'</font></strong></td>
	</tr>
	
	</table>
	</form></div>';
}

?>