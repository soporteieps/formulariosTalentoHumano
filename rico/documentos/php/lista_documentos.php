<?
session_start();
if(empty($_SESSION['username']) && empty($_SESSION["password"]))
		{ 
			header('Location: ../../../index.html');
		}
	
require "applib.php";
require "../../plugins/php/SimpleGrid.php";
include("../../../lib/dbconfig.php");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Lista Documentos</title>
<script src="../../../src/rico.js" type="text/javascript"></script>
<link href="../client/css/demo.css" type="text/css" rel="stylesheet" />
<? 
require "chklang2.php";
?>
<script type='text/javascript'>
Rico.loadModule('SimpleGrid','greenHdg.css');

var ex3;
Rico.onLoad( function() {
  // filterUI='t' --> text box
  // filterUI='s' --> select list
  var grid_options = {
    useUnformattedColWidth: false,
    FilterLocation:   -1,     // put filter on a new header row
   columnSpecs:  [,{filterUI:'t',width:300}, {filterUI:'t',width:200}, {filterUI:'t',width:200},
                   {filterUI:'t',width:200}, {filterUI:'t',width:200}, {filterUI:'t',width:100},
				   {filterUI:'t',width:100}, {filterUI:'t',width:100}]
  };
  var documentos=new Rico.SimpleGrid ('documentos', grid_options);
 
  });
</script>


<style type="text/css">
input, select { font-weight:normal;font-size:8pt;}
tr.ex3_hdg2 div.ricoLG_cell { 
  height:     1.4em;   /* the text boxes require a little more height than normal */
  text-align: left;
  background-color: #6B79A5;
}
.ricoLG_cell {
  white-space: nowrap;
}
</style>
</head>

<script type="text/javascript">alert("Para modificar la información de un Documento debe hacer click sobre el CODIGO del mismo.");</script>

<body>
<?
if($_SESSION["cod_tipo_usuario"]==3)
		{
			echo "<form name='form1' method='post' action='../../../documento.php'>";
		}
elseif($_SESSION["cod_tipo_usuario"]==1)
		{
			echo "<form name='form1' method='post' action='../../../ingreso_documento_administrador.php'>";
		}
?>
<table width="71%" height="44" border="0" cellpadding="10">
  <tr>
<?
		if($_SESSION["cod_tipo_usuario"]==3)
				{
					echo "<td colspan='1'><center><input name='reporte' type='submit' value='Crear Documento'></center></td>";
				}
		elseif($_SESSION["cod_tipo_usuario"]==1)
				{
					echo "<td colspan='1'><center><input name='reporte' type='submit' value='Crear/Eliminar Documento'></center></td>";
				}
?>
  </tr>
  <tr>
    <td colspan="1"><div align="left"><font color="#FF0000" face="Arial, Helvetica, sans-serif"><strong>Aviso:</strong></font>
	<font face="Arial, Helvetica, sans-serif"> <font color="#0000CC">Para modificar la información de un Documento debe hacer click sobre el CODIGO del mismo.</font></font></div>
    </td>
  </tr>
</table>
</form>
<?
$grid=new SimpleGrid();
$grid->AddHeadingRow(true);
$grid->AddCell("CODIGO");
$grid->AddCell("Titulo Documento");
$grid->AddCell("Tipo Archivo");
$grid->AddCell("Area");
$grid->AddCell("Tipo Documento");
$grid->AddCell("Carpeta");
$grid->AddCell("A&ntilde;o Documento");
$grid->AddCell("No. Documento");
$grid->AddCell("Observacion");

if (OpenDB()) {
$sqltext="SELECT d.codigo_documento, d.titulo, h.des_archivo, a.area, t.tipo_documento, f.des_carpeta, year(d.fecha_creacion), d.num_documento, d.observacion FROM documentos d
             INNER JOIN tipo_documento t ON (d.cod_documento = t.cod_documento) 
             INNER JOIN area a ON (d.cod_area = a.cod_area)
             INNER JOIN tipo_archivo h ON (d.cod_archivo = h.cod_archivo)
             INNER JOIN folders f ON (d.codigo_carpeta = f.codigo_carpeta)
             ";

if($_SESSION["cod_tipo_usuario"]!=1 && $_SESSION["cod_tipo_usuario"]!=2)
		{
			$sqltext.=" where d.cod_area like '".$_SESSION['cod_area']."%'";
		}

  $sqltext.=" ORDER BY a.area ASC";
  $rsMain=$oDB->RunQuery($sqltext);
  $colcnt = $oDB->db->NumFields($rsMain);
  while($oDB->db->FetchRow($rsMain,$row)) {
    $grid->AddDataRow();
    for ($i=0; $i < $colcnt; $i++) {
	  $v=utf8_encode($row[$i]);
      $v=htmlspecialchars($v, ENT_COMPAT, 'UTF-8');
      if($i==0)
	  {
	  	//Si el usuario es administrador o técnico el vínculo debe apuntar a la modificación de información de caracter técnico	
		if(($_SESSION["cod_tipo_usuario"]==1 || $_SESSION["cod_tipo_usuario"]==3))
		{
	  	    $v="<a href='../../../documento.php?codigo_documento=".$v."&action=update'>".$v."</a>";
		}
		if(($_SESSION["cod_tipo_usuario"]==2 ))
		{
	  	    $v="<a href='../../../consultar_documento.php?codigo_documento=".$v."&action=update'>".$v."</a>";
		}
	  }
	  $grid->AddCell($v);
    }
  }
  $oDB->rsClose($rsMain);
}
$grid->Render("documentos", 1);   // output html
?>
</body>
</html>
