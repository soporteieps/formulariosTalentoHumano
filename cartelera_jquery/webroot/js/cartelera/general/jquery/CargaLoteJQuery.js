<script type="text/javascript" language="javascript">

var CargaLoteJQuery= function() {
	
	this.registrarObjetosEventosJQuery=function() {
		
		jQuery.noConflict();
	
		jQuery(document).ready(function() {
			
			jQuery('#btnCargar').button();
			
			settings_upload=cargaLoteJQuery.getSettingsUpload('ARCHIVO','general','cargaLote','path_archivo','path_archivo');
			var uploadFilepath_archivo = jQuery("#div_path_archivo").uploadFile(settings_upload);

			
			jQuery("#btnCargar").click(function() {
				//alert("start");
				uploadFilepath_archivo.startUpload();
			});										
		});
		
	};
	
	this.getSettingsUpload=function(strTipo,strModulo,strTabla,strColumna,strNombreCampo) {
		//var strTipoArchivos='txt,doc,docx,xls,xlsx,ppt,pptx';
		var strTipoArchivos='txt';
		var id=jQuery("#id").val();
		
		var strController="http://localhost/Formularios_Talento_Humano_administrador/cartelera_jquery/UploadCargaLoteController.php";
		
		var settings_upload = {
			url: strController,
			dragDrop:false,
			showDelete:true,
			autoSubmit:false,
			fileName: "myfile",
			allowedTypes:strTipoArchivos,	
			returnType:"json",   
			formData: {"modulo":strModulo,"tabla":strTabla,"columna":strColumna,"id":id},
				
			dynamicFormData: function()
			{
			    var data ={ location:"ECUADOR"}
				
			    return data;
			},
			    
			onSuccess:function(files,data,xhr)
			{
				var strPath="";
				
				var strPath="webroot/uploads/"+strModulo+"/"+strTabla+"/"+strColumna+"/"+data;
				
				jQuery("#"+strNombreCampo).val(strPath);
				jQuery("#link_"+strNombreCampo).prop("href",strPath);
				
			    alert("Archivo Cargado");
												
				/*
				for(var i=0;i<data.length;i++) {
					alert("Archivo Cargado:"+data[i]);
				}
				*/
			},
						    
			deleteCallback: function(data,pd)
			{
				var strController="http://localhost/Formularios_Talento_Humano_administrador/cartelera_jquery/UploadDeleteCargaLoteController.php";
				
				for(var i=0;i<data.length;i++) {
					jQuery.post(strController,{op:"delete",name:data[i]},
					function(resp, textStatus, jqXHR)
					{
						//Show Message  
						jQuery("#status").append("<div>Archivo Eliminado</div>");      
					});
				}
					
				pd.statusbar.hide(); //You choice to hide/not.	
			}
		}
		
		return settings_upload;
	};
	
	this.onLoadWindowCargaLote=function() {		
		//REGISTRAR EVENTOS E INICIALIZAR OBJETOS JQUERY
		cargaLoteJQuery.registrarObjetosEventosJQuery();
		
		//cargaLoteJQuery.registrarTablaAccionesCargaLote();
		
		//cargaLoteJQuery.onLoadCargaLote();
	};
};

var cargaLoteJQuery=new CargaLoteJQuery();

window.onload = cargaLoteJQuery.onLoadWindowCargaLote; 

</script>