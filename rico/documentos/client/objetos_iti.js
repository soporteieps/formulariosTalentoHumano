Rico.onLoad( function() {
  Rico.setDebugArea('logger');
  CustomDraggable = Class.create();
  CustomDraggable.prototype = Object.extend(new Rico.Draggable(), CustomDraggableMethods);
  writeNameSpans();
  createDraggables();
});

var names = [ "Arrecife Macgowen (M) [3/8] [PK, SK, MN, KJ]", "Centro Crianza Arnaldo Tupiza [3/8] [PK, SK, PS, TR MN, KJ]", "Dampier, Joan", "Alvarez, Randy",
              "Neil, William", "Hardoway, Kimber", "Story, Leslie", "Lott, Charlie",
              "Patton, Sabrina", "Lopez, Juan" ];

function writeNameSpans() {
  var s='';
  for ( var i = 0 ; i < names.length ; i++ )
    s+="<div id='NS" + i + "_'>" + names[i] + "<\/div>";
  $('divSitios').innerHTML=s;
}

function createDraggables() {
   for ( var i = 0 ; i < names.length ; i++ )
      dndMgr.registerDraggable( new CustomDraggable($('NS'+i+'_'), names[i]) );
}


var CustomDraggableMethods = {

   initialize: function( htmlElement, name ) {
      this.type        = 'Custom';
      this.htmlElement = $(htmlElement);
      this.name        = name;
   },


   select: function() {
      this.selected = true;
      var el = this.htmlElement;

      // show the item selected.....
      el.style.color           = "#ffffff";
      el.style.backgroundColor = "#08246b";
	  
   },

   deselect: function() {
      this.selected = false;
      var el = this.htmlElement;
      el.style.color           = "#2b2b2b";
      el.style.backgroundColor = "transparent";
   }

   

}


/*********************************/
/** funciones para reflejar la parte grafica en los objetos
***/
/*********************************/
function elimina_sitio(origen)
{
		var idO=origen.split('_');
		var idDiaO=idO[1].substr(3,idO[1].length-3)
		var amAnterior=idO[2]=='AM';
		var DiaOrigen=Iti.Devuelve_Dia(idDiaO);		
		var idSitio=idO[0].substr(2,idO[0].length-2);		
		DiaOrigen.EliminaSitio(idSitio,amAnterior);
		
	
	}
function ingresa_Sitio(origen,destino,div)
{
	//alert(origen);
	var divAnt=document.getElementById(origen);
	var html=divAnt.innerHTML;
	divAnt.parentNode.removeChild(divAnt);
			
		var idO=origen.split('_');
		var idDiaO=idO[1].substr(3,idO[1].length-3)
		var idD=destino.split('_');
		var idDiaD=idD[0].substr(3,idD[0].length-3)
		var amNuevo=idD[1]=='AM';
		var amAnterior=idO[2]=='AM';
		
		//var am=0;
		var idSitio=idO[0].substr(2,idO[0].length-2);

		var DiaOrigen=Iti.Devuelve_Dia(idDiaO);
		var DiaDestino=Iti.Devuelve_Dia(idDiaD);
		S=new _Sitio(idSitio,html,null,amNuevo,div);
		DiaDestino.NuevoSitioO(S);
		S.Grafica();			
		return true;
	}
function cambia_dia(origen,destino,div)
{
			
		var idO=origen.split('_');
		var idDiaO=idO[1].substr(3,idO[1].length-3)
		var idD=destino.split('_');
		var idDiaD=idD[0].substr(3,idD[0].length-3)
		var amNuevo=idD[1]=='AM';
		var amAnterior=idO[2]=='AM';
		
		//var am=0;
		var idSitio=idO[0].substr(2,idO[0].length-2);

		var DiaOrigen=Iti.Devuelve_Dia(idDiaO);
		var DiaDestino=Iti.Devuelve_Dia(idDiaD);
		
		
		//alert("origen="+DiaOrigen.nro+" desti="+DiaDestino.nro+" Sitio="+idSitio+" AM="+am);
		
DiaOrigen.CambiaSitioDia(idSitio,amAnterior,DiaDestino,amNuevo,div)	
		return true;
	}	
	
function CreaPanelSitio(msitio) {
	//alert(msitio.idPadre);
	if(msitio.am)
	 divPadre="dia"+msitio.idPadre+"_AM";
	else
	 divPadre="dia"+msitio.idPadre+"_PM";
	 
	var id="PS"+msitio.id+"_"+divPadre;
	
	var divP=document.getElementById(divPadre);	


  var div = document.createElement('div');
  var title = document.createElement('div');
  div.className='box';
  title.className='title';
 // dropCnt++;
  div.innerHTML=msitio.nombre;
 // div.appendChild(title);
  //var id='grag'+dropCnt
  div.id=id;
  Element.setStyle(div, {backgroundColor:'#ffffff'});
  divP.appendChild(div);
  dndMgr.registerDraggable( new Rico.Draggable('test-rico-dnd',id) );	  
  msitio.div=div.id;
	
}


function CreaPanel(divPadre)
{
	var divP=document.getElementById(divPadre);	
	var divEsp=document.createElement('div');
	divEsp.className='div_espaciador';
	var divEspacio=document.createElement('div');
	divEsp.id='div_espacio';
	var divam=document.createElement('div');
	var divpm=document.createElement('div');	
    divam.className='div_AMPM';
	divam.innerHTML="AM";
    divpm.className='div_AMPM';
	divpm.innerHTML="PM";
	divEsp.appendChild(divam);
	divEsp.appendChild(divpm);
	divEsp.appendChild(divEspacio);
	
	divP.appendChild(divEsp);
	
	
	
	
	
	var divCont = document.createElement('div');
    divCont.id="div_contendorGral";
var divPDias = document.createElement('div');

    divPDias.id="planner_Dias";
    divPDias.name="planner_Dias";

Element.setStyle(divPDias, {
				 backgroundColor:'#06C'});
divCont.appendChild(divPDias);
divP.appendChild(divCont);

	
    	
	
	}


function CreaDia(divPadre,nro,texto)
{
	//alert(divPadre);
	var divP=document.getElementById(divPadre);	
	var div = document.createElement('div');
    div.className='div_HorarioCont';
    div.id="dia"+nro;
	divP.appendChild(div);
	CreaCabezaDia(div.id,div.id+"CAB",texto);
	CreaZonaDia(div.id,div.id+"_AM");
	CreaZonaDia(div.id,div.id+"_PM");	
	
    	
	
	}
function CreaCabezaDia(divPadre,id,texto)
{
	var divP=document.getElementById(divPadre);	
	var div = document.createElement('div');
    div.className='div_dia';
	div.innerHTML=texto+"<br><span></span>";
    div.id=id;
    divP.appendChild(div);
}
function CreaZonaDia(divPadre,id)
{
	var divP=document.getElementById(divPadre);	
	var div = document.createElement('div');
    div.className='div_Horario';
    div.id=id;
    Element.setStyle(div, {backgroundColor:'#ffffee'});
    divP.appendChild(div);
	dndMgr.registerDropZone( new Rico.Dropzone(id) );
}

/*********************************/
/** objeto Sitio
***/
/*********************************/

function GraficaSitio()
{
	CreaPanelSitio(this);
}	

function _Sitio(id,nombre,idPadre,am,div)
{ 	this.id=id;
	this.am=am;
	this.nombre=nombre;
	this.div=div;
	this.idPadre=idPadre;
	this.Grafica=GraficaSitio;
	}
	


function CambiaSitioDia(idSitio,amAnterior,Dia,amNuevo,div)
{
	if(Dia.nro!=this.nro)
	{
		
		for (var m=0;m<this.Sitios.length;m++)
		{
			if(this.Sitios[m].id==idSitio)
				if(this.Sitios[m].am==amAnterior)
				{
			 		var S=this.Sitios[m];
					this.EliminaSitio(idSitio,amAnterior);					
					S.am=amNuevo;
					S.div=div;
					Dia.NuevoSitioO(S);
				}
		}
	
	
	}
	else
	{
		//alert("mismo dia");
		for (var i=0;i<this.Sitios.length;i++)
		{
			if(this.Sitios[i].id==idSitio)
			{
				this.Sitios[i].am=amNuevo;
				this.Sitios[i].div=div;				
			}
		}
	}
}

/*********************************/
/** objeto DIa
***/
/*********************************/
function EliminaSitio(idSitio,am)
{
	var tmp=new Array();
	var c=0;
	for (var i=0;i<this.Sitios.length;i++)
	{
		if(this.Sitios[i].id==idSitio)
		{
			if(this.Sitios[i].am!=am)
			{
				tmp[c++]=this.Sitios[i];
			}
			//else
			//				alert("Borra="+this.Sitios[i].id);
		}
		else
		{
			tmp[c++]=this.Sitios[i];
		//	alert(this.Sitios[i].id)
		}
	
	}

	this.nSitios=0;
	this.Sitios.splice(0);
	for (var k=0;k<tmp.length;k++)
		this.Sitios[this.nSitios++]=tmp[k];
}

function NuevoSitio(id,am,div)
{
		this.Sitios[this.nSitios++]=new _Sitio(id,am,div);
}
function NuevoSitioO(sitio)
{		sitio.idPadre=this.nro;
		this.Sitios[this.nSitios++]=sitio;
}




function GraficaDia(div)
{
	CreaDia(div,this.nro,this.titulo);
	if(this.nSitios>0)
	{

	 for(var j=0;j<this.nSitios;j++)
	 {		

	  this.Sitios[j].Grafica(this.div);
	 }
	 	 
	}
	//alert("nro="+this.nro);
}


function _Dia(nro,titulo,div)
{
	this.nro=nro;
	this.nSitios=0;
	this.titulo=titulo;
	this.Sitios=new Array();//new Sitio();
	this.div=div;
	this.CambiaSitioDia=CambiaSitioDia;
	this.NuevoSitio=NuevoSitio;
	this.NuevoSitioO=NuevoSitioO;
	this.EliminaSitio=EliminaSitio;
	this.Grafica=GraficaDia;
	}
/*********************************/
/* objeto Itinerario	**************/
function NuevoDia(nro,div)
{
	this.Dias[this.nDias++]=new _Dia(nro,div);

}
function NuevoDiaO(dia)
{
	this.Dias[this.nDias++]=dia;
//	alert(this.Dias[this.nDias-1].titulo);
//this.nDias++;
}
function EliminaDia(Dia)
{
	var tmp=new Array();
	var c=0;
	for (i=0;i<this.nDias;i++)
	{
		if(this.Dias[i].nro!=Dia)
		tmp[c++]=this.Dias[i];
	}
	this.Dias=tmp;
	this.nDias=c-1;
	}
	
function GraficaI()
{
	//elimina todo el contenido del div
//	div.innerHTML="";
	this.Da_ancho();
	CreaPanel(this.div);
	
	for(var k=0;k<this.nDias;k++)
	 	{
	 	//alert(this.Dias[k].nro);
			this.Dias[k].Grafica(this.divCuerpo);
		}
			

	 	document.getElementById("planner_Dias").style.width=this.ancho+"px";
}

function Listado(ldiv)
{
	
	var mdiv=document.getElementById(ldiv);
	mdiv.innerHTML="";
	for(var k=0;k<this.nDias;k++)
 	{		
			mdiv.innerHTML=mdiv.innerHTML+this.Dias[k].nro+"="+this.Dias[k].div+"<br>";
			var sit="";
			 for(var j=0;j<this.Dias[k].nSitios;j++)
			 {		
				 sit=sit+"&nbsp;&nbsp;&nbsp;&nbsp;|--> "+this.Dias[k].Sitios[j].id+" am="+this.Dias[k].Sitios[j].am+"="+this.Dias[k].Sitios[j].div+"<br>";
	 		}
			mdiv.innerHTML=mdiv.innerHTML+sit;
	}
			

	 	//document.getElementById("planner_Dias").style.width=this.ancho+"px";
}

function Devuelve_Dia(nro)
{
	 
	for(var k=0;k<this.nDias;k++)
 	{	
		if(this.Dias[k].nro==nro)
			return this.Dias[k];
	}
}

function Da_ancho()
{ 
	this.ancho=(this.nDias*this.AnchoColumna)+this.nDias;
}
function _Itinerario(id,dia_inicio,tFechaVigencia,tFechaCaducidad,Canti_dias,div)
{
	this.id=id;
	this.dia_inicio=dia_inicio;
	this.nDias=0;
	this.div=div;
	this.divCuerpo="planner_Dias";
	this.tFechaVigencia=tFechaVigencia;
	this.tFechaCaducidad=tFechaCaducidad;
	this.Canti_dias;
	this.Dias=new Array();
	this.AnchoColumna=170;
	
	this.NuevoDia=NuevoDia;
	this.EliminaDia=EliminaDia;
	this.NuevoDiaO=NuevoDiaO;
	this.Grafica=GraficaI;
	this.Ancho=170;
	this.Da_ancho=Da_ancho;
	this.Listado=Listado;
	this.Devuelve_Dia=Devuelve_Dia;
	}


