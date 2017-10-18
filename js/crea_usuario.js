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

//se añadio idarea
/**************
function CreaUsuario(idpersona,iddepartamento,idpersonajefe,cedula,nombre,apellido,grupo_ocupacional,modalidad_contratacion,correo,lugar_trabajo,fecha_ingreso_ieps,fecha_salida_ieps,perfil,estado,idarea)
{
	//alert("CreaUsuario="+idpersona+","+iddepartamento+","+idpersonajefe+","+cedula+","+nombre+","+apellido+","+grupo_ocupacional+","+modalidad_contratacion+","+correo+","+lugar_trabajo+","+fecha_ingreso_ieps+","+fecha_salida_ieps+","+perfil+","+estado);
	if(validarObligatorio(iddepartamento,idpersonajefe,cedula,nombre,apellido,grupo_ocupacional,modalidad_contratacion,correo,lugar_trabajo,fecha_ingreso_ieps,fecha_salida_ieps,perfil,estado))
	{
		var ajax=nuevoAjax();
		ajax.open("GET", "crea_usuario.php?idpersona_aux="+idpersona+"&iddepartamento_aux="+iddepartamento+"&idpersonajefe_aux="+idpersonajefe+"&cedula_aux="+cedula+"&nombre_aux="+nombre+"&apellido_aux="+apellido+"&grupo_ocupacional_aux="+grupo_ocupacional+"&modalidad_contratacion_aux="+modalidad_contratacion+"&correo_aux="+correo+"&lugar_trabajo_aux="+lugar_trabajo+"&fecha_ingreso_ieps_aux="+fecha_ingreso_ieps+"&fecha_salida_ieps_aux="+fecha_salida_ieps+"&perfil_aux="+perfil+"&estado_aux="+estado+"&idarea="+idarea+"&accion=crea",true);
		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
			document.getElementById("DivUsuario").innerHTML="cargando..";
			}
			if (ajax.readyState==4)
			{
				document.getElementById("DivUsuario").parentNode.innerHTML=ajax.responseText;
				vu=true;
			} 
		}
		ajax.send(null);
	}
}


***************/
function CreaUsuario(idpersona,iddepartamento,idpersonajefe,cedula,nombre,apellido,grupo_ocupacional,modalidad_contratacion,correo,lugar_trabajo,fecha_ingreso_ieps,fecha_salida_ieps,perfil,estado)
{
	//alert("CreaUsuario="+idpersona+","+iddepartamento+","+idpersonajefe+","+cedula+","+nombre+","+apellido+","+grupo_ocupacional+","+modalidad_contratacion+","+correo+","+lugar_trabajo+","+fecha_ingreso_ieps+","+fecha_salida_ieps+","+perfil+","+estado);
	if(validarObligatorio(iddepartamento,idpersonajefe,cedula,nombre,apellido,grupo_ocupacional,modalidad_contratacion,correo,lugar_trabajo,fecha_ingreso_ieps,fecha_salida_ieps,perfil,estado))
	{
		var ajax=nuevoAjax();
		ajax.open("GET", "crea_usuario.php?idpersona_aux="+idpersona+"&iddepartamento_aux="+iddepartamento+"&idpersonajefe_aux="+idpersonajefe+"&cedula_aux="+cedula+"&nombre_aux="+nombre+"&apellido_aux="+apellido+"&grupo_ocupacional_aux="+grupo_ocupacional+"&modalidad_contratacion_aux="+modalidad_contratacion+"&correo_aux="+correo+"&lugar_trabajo_aux="+lugar_trabajo+"&fecha_ingreso_ieps_aux="+fecha_ingreso_ieps+"&fecha_salida_ieps_aux="+fecha_salida_ieps+"&perfil_aux="+perfil+"&estado_aux="+estado+"&accion=crea",true);
		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
			document.getElementById("DivUsuario").innerHTML="cargando..";
			}
			if (ajax.readyState==4)
			{
				document.getElementById("DivUsuario").parentNode.innerHTML=ajax.responseText;
				vu=true;
			} 
		}
		ajax.send(null);
	}
}

/************************
Editar usuario con integracion de area

function EditarUsuario(idpersona,iddepartamento,idpersonajefe,cedula,nombre,apellido,grupo_ocupacional,modalidad_contratacion,correo,lugar_trabajo,fecha_ingreso_ieps,fecha_salida_ieps,perfil,estado,idarea)
{
if(validarObligatorio(iddepartamento,idpersonajefe,cedula,nombre,apellido,grupo_ocupacional,modalidad_contratacion,correo,lugar_trabajo,fecha_ingreso_ieps,fecha_salida_ieps,perfil,estado))
	{
		var ajax=nuevoAjax();
		
		ajax.open("GET","crea_usuario.php?idpersona_aux="+idpersona+"&iddepartamento_aux="+iddepartamento+"&idpersonajefe_aux="+idpersonajefe+"&cedula_aux="+cedula+"&nombre_aux="+nombre+"&apellido_aux="+apellido+"&grupo_ocupacional_aux="+grupo_ocupacional+"&modalidad_contratacion_aux="+modalidad_contratacion+"&correo_aux="+correo+"&lugar_trabajo_aux="+lugar_trabajo+"&fecha_ingreso_ieps_aux="+fecha_ingreso_ieps+"&fecha_salida_ieps_aux="+fecha_salida_ieps+"&perfil_aux="+perfil+"&estado_aux="+estado+"&idarea="+idarea+"&accion=update",true);
		
		
		
		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
			document.getElementById("DivUsuario").innerHTML="cargando..";
			}
			if (ajax.readyState==4)
			{
				document.getElementById("DivUsuario").parentNode.innerHTML=ajax.responseText;
				vu=true;
			} 
		}
		ajax.send(null);
	}
}

*************************/


function EditarUsuario(idpersona,iddepartamento,idpersonajefe,cedula,nombre,apellido,grupo_ocupacional,modalidad_contratacion,correo,lugar_trabajo,fecha_ingreso_ieps,fecha_salida_ieps,perfil,estado)
{
if(validarObligatorio(iddepartamento,idpersonajefe,cedula,nombre,apellido,grupo_ocupacional,modalidad_contratacion,correo,lugar_trabajo,fecha_ingreso_ieps,fecha_salida_ieps,perfil,estado))
	{
		var ajax=nuevoAjax();
		
		ajax.open("GET","crea_usuario.php?idpersona_aux="+idpersona+"&iddepartamento_aux="+iddepartamento+"&idpersonajefe_aux="+idpersonajefe+"&cedula_aux="+cedula+"&nombre_aux="+nombre+"&apellido_aux="+apellido+"&grupo_ocupacional_aux="+grupo_ocupacional+"&modalidad_contratacion_aux="+modalidad_contratacion+"&correo_aux="+correo+"&lugar_trabajo_aux="+lugar_trabajo+"&fecha_ingreso_ieps_aux="+fecha_ingreso_ieps+"&fecha_salida_ieps_aux="+fecha_salida_ieps+"&perfil_aux="+perfil+"&estado_aux="+estado+"&accion=update",true);
		
		
		
		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
			document.getElementById("DivUsuario").innerHTML="cargando..";
			}
			if (ajax.readyState==4)
			{
				document.getElementById("DivUsuario").parentNode.innerHTML=ajax.responseText;
				vu=true;
			} 
		}
		ajax.send(null);
	}
}

function EliminaUsuario(idpersona)
{
	//alert("EliminaUsuario="+idpersona);
	var txt;
	var r = confirm("Esta seguro de eliminar el usuario con CI "+idpersona+"..!");
	if (r == true) {
			var ajax=nuevoAjax();
			ajax.open("GET", "crea_usuario.php?idpersona="+idpersona+"&accion=elimina",true);
			ajax.onreadystatechange=function() 
			{ 
				if (ajax.readyState==1)
				{
				document.getElementById("DivUsuario").innerHTML="cargando..";
				}
				if (ajax.readyState==4)
				{
					document.getElementById("DivUsuario").parentNode.innerHTML=ajax.responseText;
					vu=true;
				} 
			}
			ajax.send(null);
	} 	
}

function area_por_departamento(iddepartamento)
{
	//alert("area_por_departamento="+iddepartamento);
	var ajax=nuevoAjax();
		ajax.open("GET", "crea_usuario.php?iddepartamento="+iddepartamento+"&accion=departamento",true);
        ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
			document.getElementById("DivJefeporDepartamento").innerHTML="cargando..";
			}
			if (ajax.readyState==4)
			{
				document.getElementById("DivJefeporDepartamento").parentNode.innerHTML=ajax.responseText;
				vu=true;
				//integracion de area
				//buscarArea(iddepartamento);
			} 
		}
		ajax.send(null);

		
}
//function reseteo(idpersona)
function aplicarReseteo(idpersona)
{
		var ajax=nuevoAjax();
		//alert("cedula en ajax= "+idpersona);
		ajax.open("GET","crea_usuario.php?idpersona_aux="+idpersona+"&accion=reseteo",true);
		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
			document.getElementById("DivUsuario").innerHTML="cargando..";
			}
			if (ajax.readyState==4)
			{
				document.getElementById("DivUsuario").parentNode.innerHTML=ajax.responseText;
				vu=true;
			} 
		}
		ajax.send(null);
	//	alert("hola");
	
}

function ActualizarUsuarioyClave(idpersona)
{
		var ajax=nuevoAjax();
		//alert("cedula en ajax= "+idpersona);
		ajax.open("GET","crea_usuario.php?idpersona_aux="+idpersona+"&accion=ReseteoTablaUsuario",true);
		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
			document.getElementById("DivUsuario").innerHTML="cargando..";
			}
			if (ajax.readyState==4)
			{
				document.getElementById("DivUsuario").parentNode.innerHTML=ajax.responseText;
				vu=true;
			} 
		}
		ajax.send(null);
	//	alert("hola");
	
}


function regresar()
		{
 	        window.location.href="../Forms/usuarios/index.php";
		
		}

function validarObligatorio(iddepartamento,idpersonajefe,cedula,nombre,apellido,grupo_ocupacional,modalidad_contratacion,correo,lugar_trabajo,fecha_ingreso_ieps,fecha_salida_ieps,perfil,estado)
{
	//alert("validarObligatorio="+dependencia+","+area+","+cod_usuario+","+nombre_usuario+","+user_name+","+password+","+cod_tipo_usuario+","+tipo);
	//alert("validarObligatorio="+idpersonajefe);
	boolExit = true;
	if(iddepartamento=="--Seleccione un Departamento--")
	{
		alert("Departamento es Obligatorio.");
		boolExit = false;
		return;
	}
	if(idpersonajefe=="--Seleccione Jefe Inmediato--")
	{
		alert("Jefe Inmediato es Obligatorio.");
		boolExit = false;
		return;
	}
	if(cedula=="")
	{
		alert("CI es Obligatorio.");
		boolExit = false;
		return;
	}
	if(nombre=="")
	{
		alert("Nombres del Usuario es Obligatorio.");
		boolExit = false;
		return;
	}
	if(apellido=="")
	{
		alert("Apellidos del Usuario es Obligatorio.");
		boolExit = false;
		return;
	}
	if(grupo_ocupacional=="--Seleccione Grupo Ocupacional--")
	{
		alert("Grupo Ocupacional es Obligatorio.");
		boolExit = false;
		return;
	}
	if(modalidad_contratacion=="--Seleccione Modalidad--")
	{
		alert("Modalidad de Contratación es Obligatorio.");
		boolExit = false;
		return;
	}
	
	if(correo=="correo")
	{
		alert("Correo Institucional es Obligatorio.");
		boolExit = false;
		return;
	}
	
	if(lugar_trabajo=="--Seleccione Lugar de trabajo--")
	{
		alert("Lugar Trabajo es Obligatorio.");
		boolExit = false;
		return;
	}
	
	if(fecha_ingreso_ieps=="")
	{
		alert("Fecha de Ingreso es Obligatorio.");
		boolExit = false;
		return;
	}
	
	if(fecha_salida_ieps=="")
	{
		alert("Fecha de Salida es Obligatorio.");
		boolExit = false;
		return;
	}
	
	if(perfil=="--Seleccione Perfil--")
	{
		alert("Perfil de Usuario es Obligatorio.");
		boolExit = false;
		return;
	}
	
	if(estado=="--Seleccione Estado--")
	{
		alert("Estado es Obligatorio.");
		boolExit = false;
		return;
	}
	
	
	return boolExit;
}

//funcion cargarNombres para un jefe-inmediato
function cargarNombres(changeValue)
{
	if(changeValue.value == 3)
	{
		console.log(changeValue.value);
		var ajax = nuevoAjax();
		var fData = new FormData();

		//valor del departamento
		var idDepartamento = $("#iddepartamento").val();

		//añadimos los valores al FormData
		fData.append('idperfil', changeValue.value);
		fData.append('iddepartamento', idDepartamento);

		//removemos los jefes cargados
		$("#idpersonajefe option").remove();

		//abrimos la conexion al archivo php
		ajax.open("POST", "modificarJefes.php", true);

		//enviamos los parametros
		ajax.onload = function(e)
		{
			if(ajax.status == 200)
			{
				$('#idpersonajefe').html(ajax.responseText);
			}
		};

		ajax.send(fData);

	}

}

//buscar areas por departamento
function buscarArea(iddepartamento)
{
	var ajax = nuevoAjax();
	var fData = new FormData();

	var idDepartamento = iddepartamento;

	fData.append('iddepartamento', idDepartamento);

	ajax.open("POST", "buscarAreas.php", true);

	ajax.onload = function(e)
	{
		if(ajax.status == 200)
		{
			var respuesta = ajax.responseText;			
			if(respuesta != "0f")
			{
				//aplicamos sentencias css 
				$("#divArea").show();
				$('#selectArea').append(respuesta);

			}
			else
			{
				//ocultamos el div si esta en pantalla
				$("#divArea").css("display", "none");				
				$("#selectArea").html("<option value='0' selected>--- Seleccione un Area ---</option>");
			}
		}
	};

	ajax.send(fData);

}

