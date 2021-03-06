<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
<title>Rico</title>

<script src="../../src/rico.js" type="text/javascript"></script>
<script src="objetos_iti.js" type="text/javascript"></script>

<script type='text/javascript'>
Rico.loadModule('Corner','DragAndDrop');

<? $AltoFila = 180; 
$AltoCabeza = 40; 
	$AltoCont=$AltoCabeza+($AltoFila*2)+20;
	$AnchoColumna=140;
$ndias=19;
?>
</script>

<style type="text/css">
body, p {
	font-family : Trebuchet MS, Arial, Helvetica, sans-serif;
}
h1 { font-size: 16pt; }

div.title {
   font-family      : Verdana;
   font-size        : 10px;
  
   text-shadow:#FF0;
   background-color : #003;;
   color            :#ffffff;
width:<? echo $AnchoColumna-7; ?>px;
   margin           : 1px;
}
div.box {
   font-family   : Verdana;
   font-size     : 9px;
width:<? echo $AnchoColumna-4; ?>px;
height        : 58px;
   text-align    : center;
   border-bottom : 2px solid #6b6b6b;
   border-right  : 2px solid #6b6b6b;
   position:relative;
 
   z-index:1000;
}


div.panel {
   width    : 400px;
   height   : 80px;
   padding  : 2px;
   border   : 1px solid #5b5b5b;
   float:left;
   position:relative;
}

div.simpleDropPanel {
   width    : 200px;
   height   : 80px;
   padding  : 2px;
   border   : 1px solid #5b5b5b;
   margin-top: 3px;
   position:absolute;
   z-index:100;
}
<style type="text/css">
html{
	margin:0px;
	padding:0px;
	height:100%;
	width:100%;
}
body{
	margin:0px;
	padding:0px;
	font-family:arial;
	font-size:0.8em;	
	height:100%;
	width:100%;
}

p,h2{
	margin:2px;
}

h1{
	font-size:1.4em;
	margin:2px;
}
h2{
	font-size:1.3em;
}
  
 
.div_Horario{	
	height:<? echo $AltoFila; ?>px;
	
	border-bottom:1px solid #F6DBA2;	
		width:<? echo $AnchoColumna; ?>px;
		background:#ffffee;
	float:left;
	font-size:0.8em;
	line-height:20px;
	border-right:1px solid #ACA899;
	padding-top:2px;
	
}

.div_HorarioCont{	
	height:<? echo $AltoCont-160; ?>px; 
	border-bottom:1px solid #F6DBA2;	
		width:<? echo $AnchoColumna; ?>px;
		background:#FBE6BF;
	float:left;
	font-size:0.8em;
	line-height:20px;
	border-right:1px solid #ACA899;	
}
#planner_Dias{
	width:1000px;
	}
#div_contendorGral{
	float:left;
height:<? echo $AltoCont+3 ?>px;
	border:1px solid #000;
	width:<? echo ($AnchoColumna*7)+7; ?>px;
	overflow:auto;
	left:40px;
}

#planner_top{
	background-color:buttonface;
	height:40px;
	border-bottom:1px solid #ACA899;
	
	

}
.div_AMPM,.div_espaciador{
	text-align:center;
	font-family:arial;
	font-size:20px;
	line-height:<? echo $AltoFila; ?>px;
	height:<? echo $AltoFila; ?>px;	/* Height of hour rows */
	
	border-right:1px solid #ACA899;
	width:40px;
		background-color: buttonface;
		

}


.div_espaciador{
	height:<? echo $AltoCont; ?>px;
	float:left;
	background-color:#309;// buttonface;

}	
#div_espacio{
	height:34px;
	
}
.div_AMPM,#div_espacio{
	border-bottom:1px solid #ACA899;
}

.div_AMPM {
	font-size:10px;
	text-decoration:superscript;	
	line-height:<? echo $AltoFila; ?>px;
	position:relative;
	top:37px;
}
	
.div_dia {
	width:<? echo $AnchoColumna; ?>px;
	float:left;
	background-color:buttonface;
	text-align:center;
	font-family:arial;
	height:34px;
	font-size:0.8em;
	line-height:20px;
	border-right:1px solid #ACA899;

}
#divG {
	border:1px solid #000;
	position:relative;
	top:60px;
	float:left;
	left:20px;
	
}
#divSitios {
	position:relative;
	overflow:visible;
	border:1px solid #000;
	top:60px;
	left:5px;
	float:left;
	width:200px;
	height:200px;
   font-family      : Verdana;
   font-size        : 10px;
  	
   text-shadow:#FF0;
}
</style>
</head>
<script language="javascript">
Sitio=new _Sitio(123,'Payoral 123',null,1,"div");
Sitio2=new _Sitio(125,'Punta Gil 125',null,0,"div");
Sitio3=new _Sitio(125,'Punta Gil 125',null,1,"div");
Sitio4=new _Sitio(127,'Media Luna/Cerro Crocker/Puntudo [9/10] [PK,SK,BS,KY,FP]',null,0,"div");
Sitio5=new _Sitio(128,'Punta Gil 128',null,0,"div");

Dia1=new _Dia(1,"Dia 1","div");
Dia2=new _Dia(2,"Dia 2","div");
Dia3=new _Dia(3,"Dia 3","div");
Dia4=new _Dia(4,"Dia 4","div");
Dia5=new _Dia(5,"Dia 5","div");
Dia6=new _Dia(6,"Dia 6","div");
Dia7=new _Dia(7,"Dia 7","div");
Dia8=new _Dia(8,"Dia 8","div");
Dia9=new _Dia(9,"Dia 9","div");
Dia10=new _Dia(10,"Dia 10","div");

Dia1.NuevoSitioO(Sitio);
Dia1.NuevoSitioO(Sitio2);
Dia1.NuevoSitioO(Sitio3);
Dia3.NuevoSitioO(Sitio4);
Dia3.NuevoSitioO(Sitio5);

Iti=new _Itinerario(null,1,"12-01-2008","12-01-2008",7,"divG");
Iti.AnchoColumna =<? echo $AnchoColumna; ?>;
Iti.NuevoDiaO(Dia1);
Iti.NuevoDiaO(Dia2);
Iti.NuevoDiaO(Dia3);
Iti.NuevoDiaO(Dia4);
Iti.NuevoDiaO(Dia5);
Iti.NuevoDiaO(Dia6);
Iti.NuevoDiaO(Dia7);
Iti.NuevoDiaO(Dia8);
Iti.NuevoDiaO(Dia9);
Iti.NuevoDiaO(Dia10);
</script>
<body>


<div id="divSitios">
Media Luna/Cerro Crocker/Puntudo
<br>
Galapaguera Cerro Colorado
<br>
Centro Crianza Fausto Llerena
</div>
<div id="divListados" style=" position:absolute; top:280px;"></div>

<div id="divG"></div>
 
<script language="javascript">
function listaT()
{
	Iti.Listado("divListados");
}
			Iti.Grafica();
			//Iti.Listado("divListados");

			
			</script> 
 



<div id="divDebug" style=" position:relative;"></div>







<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

<p>&nbsp;</p>
<p>&nbsp;</p>
<input name="BListado" type="button" value="Listado" onClick="listaT();">
</body>
</html>