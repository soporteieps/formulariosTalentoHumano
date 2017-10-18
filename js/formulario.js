	
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

function IngresaFormulario(idpersona,idpersonajefe,cedula,nombres,apellidos,unidadoperativa,fechainicio,fechafin,horainicio,horafin,motivo,archivo,observaciones)
{	
	//alert(cedula+","+nombres+","+apellidos+","+iddepartamento);
	if(validarObligatorio(fechainicio,fechafin,horainicio,horafin,motivo,archivo,observaciones))
	{
		var ajax=nuevoAjax();
		ajax.open("GET", "./clases/formulario.php?idpersona="+idpersona+"&idpersonajefe="+idpersonajefe+"&cedula="+cedula+"&nombres="+nombres+"&apellidos="+apellidos+"&unidadoperativa="+unidadoperativa+"&fechainicio="+fechainicio+"&fechafin="+fechafin+"&horainicio="+horainicio+"&horafin="+horafin+"&motivo="+motivo+"&archivo="+archivo+"&observaciones="+observaciones+"&accion=input",true);
		
		
		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
			document.getElementById("DivFormulario").innerHTML="cargando..";
			}
			if (ajax.readyState==4)
			{
				document.getElementById("DivFormulario").parentNode.innerHTML=ajax.responseText;
			
			} 
		}
		ajax.send(null);
	}
	
}

function ProcesarSolicitud(iddatopersonal,autorizacion,comentario)
{
	if(validarProcesar(autorizacion,comentario))
	{
	var ajax=nuevoAjax();
		ajax.open("GET", "./clases/formulario.php?iddatopersonal="+iddatopersonal+"&autorizacion="+autorizacion+"&comentario="+comentario+"&accion=procesar",true);
		
		
		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
			document.getElementById("DivFormulario").innerHTML="cargando..";
			}
			if (ajax.readyState==4)
			{
				document.getElementById("DivFormulario").parentNode.innerHTML=ajax.responseText;
			
			} 
		}
		ajax.send(null);
	}
}

function validarObligatorio(fechainicio,fechafin,horainicio,horafin,motivo,archivo,observaciones)
{
	//alert("validarObligatorio="+dependencia+","+area+","+cod_usuario+","+nombre_usuario+","+user_name+","+password+","+cod_tipo_usuario+","+tipo);
//	alert("validarObligatorio="+fechainicio+","+fechafin+","+horainicio+","+horafin+","+motivo+","+archivo+","+observaciones);
	boolExit = true;

	if(fechainicio=="")
	{
		alert("Fecha inicio es obligatorio.");
		boolExit = false;
		return;
	}
	if(fechafin=="")
	{
		alert("Fecha fin es obligatorio.");
		boolExit = false;
		return;
	}
	    //  alert("fecha inicio:"+fechainicio);
	     // alert("fecha fin:"+fechafin);		
		 fecha1=new Date(fechainicio);
		 fecha2=new Date(fechafin);
		 var resta=(fecha2-fecha1)/1000/3600/24;      
		// alert("Diferncia:"+resta);
	if(motivo==2 && resta > 3)
	{
//		alert("El Número de días"+"  "+ resta +"  "+ "excede los 3 permitidos!...");
		alert("El número máximo de días permitidos es 3\nUsted a elegido: " + resta + " días.");
		boolExit = false;
		return;
	}
	if(fechafin<fechainicio)
	{
		
		alert("Fecha fin es menor que Fecha inicio....");
		boolExit = false;
		return;
	}
	if(horainicio=="")
	{
		alert("Hora inicio es obligatorio.");
		boolExit = false;
		return;
	}
	if(horafin=="")
	{
		alert("Hora fin es obligatorio.");
		boolExit = false;
		return;
	}

	var hora2 = horafin.split(":");
	var hora1 = horainicio.split(":");
	var h2 = parseInt(hora2[0]);
	var m2 = parseInt(hora2[1]);
	var h1 = parseInt(hora1[0]);
	var m1 = parseInt(hora1[1]);
	var totalMinH1 = h1*60 + m1;
	var totalMinH2 = h2*60 + m2;
	var difMinutos = totalMinH2 - totalMinH1;
	var totalHoras = difMinutos / 60;

	if(motivo==6 && totalHoras > 2)
	{
		alert("El número máximo de horas permitidas es 2\nUsted a elegido: " +  parseFloat(totalHoras).toFixed(2) + " horas.");
		boolExit = false;
		return;
	}

	if(horafin<horainicio)
	{
		alert("Hora fin es menor que Hora Inicio");
		boolExit = false;
		return;
	}
	
	if(motivo=="" || motivo=="---Seleccione Motivo---" )
	{
		alert("Motivo es obligatorio.");
		boolExit = false;
		return;
	}
	
	if(motivo==2 && (fechafin>fechainicio))
	{
	   alert("La Fecha Fin no puede ser mayor a la Fecha Inicio en este tipo de permiso.");
	   boolExit = false;
	   return;
	}
	
 	//if(archivo=="" && ( motivo==1 || motivo==3 || motivo==4 || motivo==5 || motivo==6 || motivo==7|| motivo==8))
 	//alert("**************motivo="+motivo+"************"); 
	if(archivo=="" && ( motivo==1 || motivo==3 || motivo==4 || motivo==5 || motivo==6 || motivo==7|| motivo==8))
	{
		alert("Archivo es obligatorio.");
		boolExit = false;
		return;
	}
	
	if(observaciones=="")
	{
		alert("Observaciones es obligatorio.");
		boolExit = false;
		return;
	}
	
	return boolExit;
}

function validarProcesar(autorizacion,comentario)
{
	boolExit = true;

	if(autorizacion=="")
	{
		alert("Debe Autorizar o rechazar.");
		boolExit = false;
		return;
	}
	if(comentario=="")
	{
		alert("Comentario es obligatorio.");
		boolExit = false;
		return;
	}
	
	return boolExit;
}
