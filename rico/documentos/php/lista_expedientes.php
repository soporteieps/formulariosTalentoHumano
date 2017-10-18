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
<title>Lista de Expedientes</title>
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
   columnSpecs:  [{filterUI:'t',width:150},{filterUI:'f',width:200}, {filterUI:'f',width:200},
                   {filterUI:'t',width:200}, {filterUI:'t',width:200} , {filterUI:'t',width:200}]
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

<body>
<table width="71%" height="44" border="0" cellpadding="10">
  <tr>
  </tr>
  <tr>
   <td colspan="1"><div align="left"><font color="#FF0000" face="Arial, Helvetica, sans-serif"><strong>Aviso:</strong></font>
	<font face="Arial, Helvetica, sans-serif"> <font color="#0000CC">Para Visualizar el documento localise el mismo utilizando la opcion de Filtro Archivo, Descripcion, A&ntildeo y de click sobre el Codigo del mismo.</font></font></div>  
    </td>
  </tr>
</table>
</form>
<?
$grid=new SimpleGrid();
$grid->AddHeadingRow(true);
$grid->AddCell("CODIGO");
$grid->AddCell("Area");
$grid->AddCell("Documento");
$grid->AddCell("Archivo");
$grid->AddCell("Periodo");
$grid->AddCell("Descripcion Carpeta");

if (OpenDB()) {
$sqltext="SELECT f.codigo_carpeta, a.area, d.tipo_documento, t.des_archivo, p.des_informe, f.des_carpeta
   FROM folders f
   INNER JOIN area a ON (f.cod_area = a.cod_area)
   INNER JOIN tipo_documento d ON (f.cod_documento = d.cod_documento and d.cod_documento = 16)
   INNER JOIN tipo_archivo t ON (f.cod_archivo = t.cod_archivo)
   INNER JOIN periodo p ON (f.cod_periodo = p.cod_anio)";
   
if($_SESSION["cod_tipo_usuario"]!=1 && $_SESSION["cod_tipo_usuario"]!=2)
		{
			$sqltext.=" where f.cod_area like '".$_SESSION['cod_area']."%'";
		}

  $sqltext.=" ORDER BY f.codigo_carpeta ASC";
  $rsMain=$oDB->RunQuery($sqltext);
  $colcnt = $oDB->db->NumFields($rsMain);
  while($oDB->db->FetchRow($rsMain,$row)) {
    $grid->AddDataRow();
    for ($i=0; $i < $colcnt; $i++) {
	  $v=utf8_encode($row[$i]);
	  $v=htmlspecialchars($v, ENT_COMPAT, 'UTF-8');
      if($i==0)
      {
         $v="<a href='../../../ver_expediente.php?codigo_carpeta=".$v."'>".$v."</a>";		
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
