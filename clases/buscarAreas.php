<?php

include "../lib/dbconfig.php";

//datos enviados desde el archivo js (crea_usuario.js)
$iddepartamento = $_POST['iddepartamento'];

$consultaArea = "SELECT COUNT(*) as numAreas FROM DepartamentoArea WHERE iddepartamento = $iddepartamento";

$resultadoConsulta = query($consultaArea);
$cont = 0;
$mensaje = ""; //se guardara la respuesta

while($auxiliar = mysql_fetch_object($resultadoConsulta))
{
	$cont = $auxiliar->numAreas;
}

// Si encuentra resultados se tiene que devolver los datos y mostrar el combobox
if($cont > 0)
{
	//realizamos la consulta de las areas
	$consulta = "SELECT idarea as IdArea, iddepartamento as Departamento, nombrearea as Area FROM DepartamentoArea WHERE iddepartamento = $iddepartamento";

	$resultado = query($consulta);
	$contAux = 0;
	while($lista = mysql_fetch_object($resultado))
	{
		//cargamos las opciones que deben aparecer
		$mensaje .= "<option value='$lista->IdArea'>" . strtoupper($lista->Area) . "</option>";
	}

}
else
{
	$mensaje = "0f";
}

echo $mensaje;

?>