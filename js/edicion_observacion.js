function nuevoAjax()
{ 
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

function edicion_observacion(id,observaciones)
{
	var datos = observaciones;
	if(datos.trim() != "")
	{	
		var ajax=nuevoAjax();
	    
		ajax.open("GET", "./clases/edicion_permisos_observacion.php?id="+id+"&observaciones="+observaciones+"&accion=edita_observacion",true);

		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
			document.getElementById("DivListaHorario").innerHTML="cargando..";
			}
			if (ajax.readyState==4)
			{
				document.getElementById("DivListaHorario").parentNode.innerHTML=ajax.responseText;
				vu=true;
			} 
		}
		ajax.send(null);
	}
	else
	{
		alert("Ingrese Observación!...");
		document.getElementById("observaciones").focus();
		
		}
} 
