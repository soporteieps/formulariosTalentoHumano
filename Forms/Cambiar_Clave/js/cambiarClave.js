function nuevoAjax()
{ 
	/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
	var xmlhttp=false;
	try
	{
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch(e)
	{
		try
		{
			// Creacion del objet AJAX para IE
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(E)
		{
			if (!xmlhttp && typeof XMLHttpRequest!='undefined') xmlhttp=new XMLHttpRequest();
		}
	}
	return xmlhttp; 
}


function cambiarClave2(old_passwd, new_passwd, new_passwd_confirm, type_user)
{
	//alert('cambiarClave2 ='+old_passwd+','+new_passwd+','+new_passwd_confirm+','+type_user) ;
	if(validar(old_passwd,new_passwd,new_passwd_confirm))
	{
		// Creo el nuevo objeto AJAX y envio al servidor el ID del select a cargar y la opcion seleccionada del select origen
		var ajax=nuevoAjax();
		ajax.open("GET", "./clases/cambiarClave.php?old_passwd="+old_passwd+"&new_passwd="+new_passwd+"&new_passwd_confirm="+new_passwd_confirm+"&type_user="+type_user+"&accion=cambiarClave",true);
						
		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{ 
			document.getElementById("DivTablaFormulario").innerHTML="cargando..";
			}
			if (ajax.readyState==4)
			{ 
				document.getElementById("DivTablaFormulario").parentNode.innerHTML=ajax.responseText;
				vu=true;
			} 
		}
		ajax.send(null);
	}
}

function cambiarClave(old_passwd, new_passwd, new_passwd_confirm, type_user)
{
	//alert('cambiarClave ='+old_passwd+','+new_passwd+','+new_passwd_confirm+','+type_user) ;
	if(validar(old_passwd,new_passwd,new_passwd_confirm))
	{
		// Creo el nuevo objeto AJAX y envio al servidor el ID del select a cargar y la opcion seleccionada del select origen
		var ajax=nuevoAjax();
		ajax.open("GET", "./clases/cambiarClave.php?old_passwd="+old_passwd+"&new_passwd="+new_passwd+"&new_passwd_confirm="+new_passwd_confirm+"&type_user="+type_user+"&accion=cambiarClave",true);
						
		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{ 
			document.getElementById("DivTablaFormulario").innerHTML="cargando..";
			}
			if (ajax.readyState==4)
			{ 
				document.getElementById("DivTablaFormulario").parentNode.innerHTML=ajax.responseText;
				vu=true;
			} 
		}
		ajax.send(null);
	}
}

function validar(old_passwd,new_passwd,new_passwd_confirm)
{
	if(old_passwd== "" || /^\s+$/.test(old_passwd)){
		alert("CLAVE ANTERIOR es obligatorio.");
		return false; 
	}

	if(new_passwd== "" || /^\s+$/.test(new_passwd)){
		alert("NUEVA CLAVE es obligatorio.");
		return false; 
	}
	
	if(new_passwd.length < 4){
		alert("NUEVA CLAVE tiene que tener minimo 5 caracteres.");
		return false;
	}

	if(new_passwd_confirm== "" || /^\s+$/.test(new_passwd_confirm)){
		alert("CONFIRME LA NUEVA CLAVE es obligatorio.");
		return false; 
	}

	if(new_passwd != new_passwd_confirm)
	{
		alert("NUEVA CLAVE no coincide");
		return false; 
	}
return true;  
}

//function regresar(type_user){
function regresar(){
	window.location.href="../../../index.php";
}

//function regresar(type_user){
function salir(){
	window.top.location.href="../../index.php";
}