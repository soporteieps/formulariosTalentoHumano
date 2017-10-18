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
			       {filterUI:'t',width:100}]

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
	<font face="Arial, Helvetica, sans-serif"> <font color="#0000CC">Para Visualizar el documento localise el mismo utilizando la opcion de Filtro Archivo, Area, Documento, Titulo, A&ntildeo y de click sobre el Codigo del mismo.</font></font></div>  
    </td>
  </tr>
</table>
</form>
<?
$grid=new SimpleGrid();
$grid->AddHeadingRow(true);
$grid->AddCell("CODIGO");
$grid->AddCell("Tipo Archivo");
$grid->AddCell("Area");
$grid->AddCell("Tipo Documento");
$grid->AddCell("Titulo Documento");
$grid->AddCell("Carpeta");
$grid->AddCell("A&ntilde;o Documento");
$grid->AddCell("No. Documento");

if (OpenDB()) {

$sqltext="SELECT d.codigo_documento, h.des_archivo, a.area, t.tipo_documento, d.titulo, f.des_carpeta, year(d.fecha_creacion),  d.num_documento
          FROM documentos d 
          INNER JOIN tipo_archivo h ON (d.cod_archivo = h.cod_archivo)
          INNER JOIN tipo_documento t ON (d.cod_documento = t.cod_documento AND d.cod_documento <> 16)
          INNER JOIN area a ON (d.cod_area = a.cod_area)
          INNER JOIN folders f ON (d.codigo_carpeta = f.codigo_carpeta)
          INNER JOIN periodo p  ON (d.cod_anio = p.cod_anio)";

if($_SESSION["cod_tipo_usuario"]!=1 && $_SESSION["cod_tipo_usuario"]!=2)
		{
			$sqltext.=" where d.cod_area like '".$_SESSION['cod_area']."%'";
		}

  $sqltext.=" ORDER BY h.des_archivo ASC, a.area ASC, t.tipo_documento ASC";
  $rsMain=$oDB->RunQuery($sqltext);
  $colcnt = $oDB->db->NumFields($rsMain);
  while($oDB->db->FetchRow($rsMain,$row)) {
    $grid->AddDataRow();
    for ($i=0; $i < $colcnt; $i++) {
	  $v=utf8_encode($row[$i]);
	  $v=htmlspecialchars($v, ENT_COMPAT, 'UTF-8');
      if($i==0)
      {
         $v="<a href='../../../ver_documento.php?codigo_documento=".$v."'>".$v."</a>";		
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
