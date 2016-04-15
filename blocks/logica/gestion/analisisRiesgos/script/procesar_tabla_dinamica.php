<?php
/**
 *
 * Los datos del bloque se encuentran en el arreglo $esteBloque.
 */

// URL base
$url = $this->miConfigurador->getVariableConfiguracion ( "host" );
$url .= $this->miConfigurador->getVariableConfiguracion ( "site" );

$urlDirectorio = $url;
$urlDirectorio = $urlDirectorio . "/plugin/scripts/javascript/dataTable/Spanish.json";

$url .= "/index.php?";

// Variables
{
	$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
	$cadenaACodificar .= "&procesarAjax=true";
	$cadenaACodificar .= "&action=index.php";
	$cadenaACodificar .= "&bloqueNombre=" . $esteBloque ["nombre"];
	$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque ["grupo"];
	$cadenaACodificar .= "&funcion=consultaVariables";
	$cadenaACodificar .= "&tiempo=" . $_REQUEST ['tiempo'];
	$cadenaACodificar .= "&usuario=" . $_REQUEST ['usuario'];
	// Codificar las variables
	$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
	$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar, $enlace );
	
	// URL definitiva
	$urlTablaDinamica = $url . $cadena;
}
?>
<script type='text/javascript' async='async'>




$(function() {
         	$('#tabla_datos_riesgos').ready(function() {

         		 $("#tabla_datos_riesgos").jqGrid({
                     url:	"<?php echo $urlTablaDinamica?>",
                     datatype: "json",
                     mtype: "GET",
                     colModel: [
                         {
     						label: 'Tema',
                             name: 'tem',
                             width: 40,
     						key: true,
     						editable: true,
     						editrules : { required: true}
                         },
                         {
     						label: 'Variable',
                             name: 'var',
                             width: 150,
                             editable: true // must set editable to true if you want to make the field editable
                         },
                         {
     						label : 'Valor',
                             name: 'val',
                             width: 36,
                             editable: true
                         },
                         {
     						label: 'Nota',
                             name: 'not',
                             width: 120,
                             editable: true
                         },
                         {
     						label: 'Probabilidad',
                             name: 'prb',
                             width: 69,
                             editable: true
                         },
                         {
      						label: 'Impacto',
                              name: 'imp',
                              width: 65,
                              editable: true
                          },
                          {
        						label: 'Riesgo',
                                name: 'risk',
                                width: 65,
                                editable: true
                          },
                          {
      						label: 'Observación Controlar Riesgo',
                              name: 'ob_risk',
                              width: 145,
                              editable: true
                           }
                     ],
     				sortname: 'tem',
     				sortorder : 'asc',
     				loadonce: true,
     				viewrecords: false,
     				rownumbers: true,
     				 rowNum: 100,
                     width: 1042,
                     height: 365,
                     pager: "#barra_herramientas",
                     caption: "Variables para Gestión Riesgo"
                 }).navGrid('#barra_herramientas',
                 	    {	
             	    add:false,
             	    addtext:'Añadir Item',
             		edit:true,
             		edittext:'Editar Item',	    		
             		del:true ,
             		deltext:'Eliminar Item',
             		alertcap:"Alerta",
                    alerttext:"Seleccione Item",
             		search:false ,
             		refresh:true,
             		refreshstate: 'current',
             		refreshtext:'Refrescar Items',
             		},

                 {      caption:"Editar Item",
                        addCaption: "Adicionar Item",
                        width: 425, 
                        height: 310,
                        mtype:'GET',
                        url:'<?php echo $urlTablaDinamica?>',
                        bSubmit: "Agregar",
                        bCancel: "Cancelar",
                        bClose: "Close",
                        saveData: "Data has been changed! Save changes?",
                        bYes : "Yes",
                        bNo : "No",
                        bExit : "Cancel",
                        closeOnEscape:true,
                        closeAfterAdd:true,
                        onclickSubmit:function(params, postdata){
                            //save add
                            var p=params;
                            var pt=postdata;
                        },
                        beforeSubmit : function(postdata, formid) { 
                            var p = postdata;
                            var id=id;
                            var success=true;
                            var message="continue";
                            return[success,message]; 
                        },    
                        afterSubmit : function(response, postdata) 
                        { 
                            var r=response; 
                            var p=postdata;
                            var responseText=jQuery.jgrid.parse(response.responseText);
                            var success=true;
                            var message="continue";
                            return [success,message] 
                        },
                        afterComplete : function (response, postdata, formid) {        
                            var responseText=jQuery.jgrid.parse(response.responseText);
                            var r=response;
                            var p=postdata;
                            var f=formid;
                        } },//edit
                 { },//add
                  {
             			
                          
                         url:'<?php echo $urlTablaDinamica?>',
                         caption: "Eliminar Item",
                         width: 425, 
                         height: 150,
                         mtype:'GET',
                         bSubmit: "Eliminar",
                         bCancel: "Cancelar",
                         bClose: "Close",
                         msg:"Desea Eliminar Item ?",
                         bYes : "Yes",
                         bNo : "No",
                         bExit : "Cancel",
                         closeOnEscape:true,
                         closeAfterAdd:true,
                         refresh:true,
                         onclickSubmit:function(params, postdata,id_items){
                             //save add
                             var p=params;
                             var pt=postdata;
                             
                             
                         },
                         beforeSubmit : function(postdata, formid) { 
                             var p = postdata;
                             var id=formid;
                             var success=true;
                             var message="continue";
                             return[success,message]; 
                         }, 
                         afterSubmit : function(response, postdata) 
                         { 
                             var r=response; 
                             var p=postdata;
                             var responseText=jQuery.jgrid.parse(response.responseText);
                             var success=true;
                             var message="continue";
                             return [success,message] 
                         },
                         afterComplete : function (response, postdata, formid) {        
                             var responseText=jQuery.jgrid.parse(response.responseText);
                             var r=response;
                             var p=postdata;
                             var f=formid;
                         } 

                         },//del
                  {},
                  {}
                	);

                  
         		});

});




</script>
