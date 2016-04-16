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
	
	
	
	$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
	$cadenaACodificar .= "&procesarAjax=true";
	$cadenaACodificar .= "&action=index.php";
	$cadenaACodificar .= "&bloqueNombre=" . $esteBloque ["nombre"];
	$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque ["grupo"];
	$cadenaACodificar .= "&funcion=editarVariables";
	$cadenaACodificar .= "&tiempo=" . $_REQUEST ['tiempo'];
	$cadenaACodificar .= "&usuario=" . $_REQUEST ['usuario'];
	// Codificar las variables
	$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
	$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar, $enlace );
	
	// URL definitiva
	$urlEditaVariables = $url . $cadena;
	
	$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
	$cadenaACodificar .= "&procesarAjax=true";
	$cadenaACodificar .= "&action=index.php";
	$cadenaACodificar .= "&bloqueNombre=" . $esteBloque ["nombre"];
	$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque ["grupo"];
	$cadenaACodificar .= "&funcion=limpiarVariables";
	$cadenaACodificar .= "&tiempo=" . $_REQUEST ['tiempo'];
	$cadenaACodificar .= "&usuario=" . $_REQUEST ['usuario'];
	// Codificar las variables
	$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
	$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar, $enlace );
	
	// URL definitiva
	$urlLimpiaVariables = $url . $cadena;
	
	
	
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
                             editable: true, 
                         },
                         {
     						label : 'Valor',
                             name: 'val',
                             width: 36,
                             editable: true,
                             editrules:{number:true},
                             sorttype:'number',
                              
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
                             editable: true,
                             edittype: "select",
                             editoptions: {
                                 value: "0: 0 - SIN EVALUAR;1: 1 - BAJO;2:2 - MEDIO;3:3 - ALTO",
                                 dataInit: function (element) {
                                	 window.setTimeout(function () {
                                         $(element).select2();
                                         });
                                     }
                             }
                         },
                         {
      						label: 'Impacto',
                              name: 'imp',
                              width: 65,
                              editable: true,
                              edittype: "select",
                              editoptions: {
                                  value: "0: 0 - SIN EVALUAR;1: 1 - MENOR;2:2 - MODERADO;3:3 - SEVERO",
                                  dataInit: function (element) {
                                 	 window.setTimeout(function () {
                                          $(element).select2();
                                          });
                                      }
                              
                              }
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
     				viewrecords: true,
     				rownumbers: true,
     				 rowNum: 100, 
                     width: 1042,
                     height: 365,
                     pager: "#barra_herramientas",
                     caption: "Variables para Gestión Riesgo"
                 });


         		$("#tabla_datos_riesgos").navGrid('#barra_herramientas',
                   {	
             	    add:false,
             	    addtext:'Añadir Item',
             		edit:true,
             		edittext:'Editar Variable',	    		
             		del:true ,
             		deltext:'Limpiar Variable',
             		alertcap:"Alerta",
                    alerttext:"Seleccione Variable",
             		search:false ,
             		refresh:true,
             		refreshstate: 'current',
             		refreshtext:'Refrescar Variables',
             		},

                 {      caption:"Editar Variable",
                        addCaption: "Editar Variable",
                        width: 425, 
                        height: 310,
                        mtype:'GET',
                        url:'<?php echo $urlEditaVariables?>',
                        bSubmit: "Guardar",
                        bCancel: "Cancelar",
                        bClose: "Close",
                        saveData: "Data has been changed! Save changes?",
                        bYes : "Yes",
                        bNo : "No",
                        bExit : "Cancel",
                        closeOnEscape:true,
                        closeAfterEdit:true,
                        refresh:false,
                        reloadAfterSubmit:false,
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
                        }
                         },//edit
                 { },//add
                  {
             			 url:'<?php echo $urlLimpiaVariables?>',
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
