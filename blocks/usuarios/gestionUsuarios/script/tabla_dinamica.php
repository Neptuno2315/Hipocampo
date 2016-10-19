<?php

if (!isset($GLOBALS["autorizado"])) {
    include "../index.php";
    exit();
}

/**
 *
 * Los datos del bloque se encuentran en el arreglo $esteBloque.
 */
// URL base
$url = $this->miConfigurador->getVariableConfiguracion("host");
$url .= $this->miConfigurador->getVariableConfiguracion("site");
$url .= "/index.php?";

// Variables
$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar .= "&procesarAjax=true";
$cadenaACodificar .= "&action=index.php";
$cadenaACodificar .= "&bloqueNombre=" . $esteBloque["nombre"];
$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque["grupo"];
$cadenaACodificar .= "&funcion=consultarRol";

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar, $enlace);

// URL definitiva
$urlTablaDinamica = $url . $cadena;

// Variables
$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar .= "&procesarAjax=true";
$cadenaACodificar .= "&action=index.php";
$cadenaACodificar .= "&bloqueNombre=" . $esteBloque["nombre"];
$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque["grupo"];
$cadenaACodificar .= "&funcion=crearRol";

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar, $enlace);

// URL definitiva
$urlCrearRol = $url . $cadena;

// Variables
$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar .= "&procesarAjax=true";
$cadenaACodificar .= "&action=index.php";
$cadenaACodificar .= "&bloqueNombre=" . $esteBloque["nombre"];
$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque["grupo"];
$cadenaACodificar .= "&funcion=editarRol";

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar, $enlace);

// URL definitiva
$urlEditarRol = $url . $cadena;

// Variables
$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar .= "&procesarAjax=true";
$cadenaACodificar .= "&action=index.php";
$cadenaACodificar .= "&bloqueNombre=" . $esteBloque["nombre"];
$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque["grupo"];
$cadenaACodificar .= "&funcion=eliminarRol";

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar, $enlace);

// URL definitiva
$urlEliminarRol = $url . $cadena;

// Variables
$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar .= "&procesarAjax=true";
$cadenaACodificar .= "&action=index.php";
$cadenaACodificar .= "&bloqueNombre=" . $esteBloque["nombre"];
$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque["grupo"];
$cadenaACodificar .= "&funcion=consultarRelaciones";

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar, $enlace);

// URL definitiva
$urlConsultarRelaciones = $url . $cadena;

// Variables
$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar .= "&procesarAjax=true";
$cadenaACodificar .= "&action=index.php";
$cadenaACodificar .= "&bloqueNombre=" . $esteBloque["nombre"];
$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque["grupo"];
$cadenaACodificar .= "&funcion=consultarPaginas";

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar, $enlace);

// URL definitiva
$urlConsultarPaginas = $url . $cadena;

// Variables
$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar .= "&procesarAjax=true";
$cadenaACodificar .= "&action=index.php";
$cadenaACodificar .= "&bloqueNombre=" . $esteBloque["nombre"];
$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque["grupo"];
$cadenaACodificar .= "&funcion=adicionFuncionalidad";

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar, $enlace);

// URL definitiva
$urlAdicionFuncionalidad = $url . $cadena;

// Variables
$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar .= "&procesarAjax=true";
$cadenaACodificar .= "&action=index.php";
$cadenaACodificar .= "&bloqueNombre=" . $esteBloque["nombre"];
$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque["grupo"];
$cadenaACodificar .= "&funcion=eliminarFuncionalidad";

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar, $enlace);

// URL definitiva
$urlEliminarFuncionalidad = $url . $cadena;

?>
<script type='text/javascript'>


$(document).ready(function() {


	$(function() {
	         	$('#tabla_general').ready(function() {
	         		 $("#tabla_general").jqGrid({
	                     url:	"<?php echo $urlTablaDinamica;?>",
	                     datatype: "json",
	                     mtype: "GET",
	                     colModel: [
						{
								label: 'Identificador',
						        name: 'id',
						        width: 40,
								key: true,
								editable: false,
								sorttype:'number',
								align:'center',
								editrules : {required: true}
						 },
	                         {
	     						label: 'Nombre : ',
	                             name: 'nombre',
	                             width: 40,
	     						editable: true,
	     						sorttype:'text',
	     						align:'center',
	     						editrules : {required: true},
	     						 editoptions: {size:25, maxlength: 20},

	                         },
	                         {
	     						label: 'Descripción : ',
	                             name: 'descripcion',
	                             width: 150,
	                             editable: true,
	                             edittype:'textarea',
	                             editrules : {required: true},
	                             editoptions: {rows:"5",cols:"25"},
	                         }
	                         ],
	                   	sortname: 'id',
	     				sortorder : 'asc',
	     				viewrecords: true,
	     				rownumbers: false,
	     				loadonce : false,
                        rowNum: 100,
                        width: $("#seccionCentralAmpliada").width()-65,
	                    height: 300,
	                    pager: "#barra_herramientas_general",
	                    caption: "Gestión Roles",
	                 	subGrid: true,
	                     subGridOptions: {
	                         "plusicon"  : "ui-icon-triangle-1-e",
	                         "minusicon" : "ui-icon-triangle-1-s",
	                         "openicon"  : "ui-icon-arrowreturn-1-e",
	                 		// load the subgrid data only once
	                 		// and the just show/hide
	                 		"reloadOnExpand" : true,
	                 		// select the row when the expand column is clicked
	                 		"selectOnExpand" : true
	                 	},
	                	subGridRowExpanded: function(subgrid_id, row_id) {

		                	var ident= row_id;
	                		var subgrid_table_id, pager_id;
	                		subgrid_table_id = subgrid_id+"_t";
	                		pager_id = "p_"+subgrid_table_id;
	                		$("#"+subgrid_id).html("<table id='"+subgrid_table_id+"' class='scroll'></table><div id='"+pager_id+"' class='scroll'></div>");
	                		jQuery("#"+subgrid_table_id).jqGrid({
	                			url:'<?php echo $urlConsultarRelaciones;?>&id_gestion='+row_id,
	                			datatype: "json",
	    	                     mtype: "GET",
	                			colModel: [
	                				{
										label: 'Identificador',
								        name: 'id',
								        width: 40,
										key: true,
										editable: false,
										sorttype:'number',
										align:'center',
										editrules : {required: true}
						 			},
	       	                		{
	       	                			label: 'Funcionalidad :',
		                				name:"funcionalidad",
		                				width:100,
		                				editable: true,
		                				edittype: 'select',
		                				editrules: {required: true},
		                				editoptions: {
		                					dataInit: function (element) {
	                                     			window.setTimeout(function () {
													$(element).width(350);
	                                         		$(element).select2({
                           								 placeholder: "Seleccione Funcionalidad",
                            							 allowClear: true,
                        								});
	                                         });
                                     		},
                                     		 dataUrl:'<?php echo $urlConsultarPaginas;?>',
                                     		 defaultValue: ''
                                     	}
		                			}
	                			],
	                			sortname: 'id',
	                		   	rowNum:20,
	                		   	pager: pager_id,
	                		   	viewrecords: false,
	                		   	sortname: 'num',
	                		    sortorder: "asc",
	                		    height: '100%',
	                		    width: $("#seccionCentralAmpliada").width()-120,
	                		    caption: "Gestión Funcionalidades",

	                		}).navGrid("#"+pager_id,
	    	                		{
    	                		       edit:false,
    	                		       add:true,
    	                		       del:true,
    	                		       search:false,
    	                		       alertcap:"Alerta",
    	       	                       alerttext:"Seleccione Relacion Funcionalidad",
    	                		    },

    	                		    {  },//edit
    	   	                        {
    	   	                        	 caption:"Relacionar Funcionalidad",
    	   	 	                         addCaption: "Relacionar Funcionalidad",
    	   	 	                         width: 500,
    	   	 	                         height: 125,
    	   	 	                         mtype:'GET',
    	   	 	                         url:'<?php echo $urlAdicionFuncionalidad;?>&identificador='+ident,
    	   	 	                         bSubmit: "Guardar",
    	   	 	                         bCancel: "Cancelar",
    	   	 	                         bClose: "Close",
    	   	 	                         saveData: "Data has been changed! Save changes?",
    	   	 	                         bYes : "Yes",
    	   	 	                         bNo : "No",
    	   	 	                         bExit : "Cancel",
    	   	 	                         closeOnEscape:true,
    	   		                         closeAfterAdd:true,
    	   		                         refresh:true,
    	   		                         reloadAfterSubmit:true,
    	   		                         recreateForm: true,
    	   	 	                         onclickSubmit:function(params, postdata){
    	   	 	                             //save add
    	   	 	                             var p=params;
    	   	 	                             var pt=postdata;
    	   	 	                         },
     										afterSubmit : function(response, postdata){
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


    	   	        	                  },//add
    	   	                   {
    	   	              			  url:'<?php echo $urlEliminarFuncionalidad;?>',
    	   	                          caption: "Eliminar Funcionalidad",
    	   	                          width: 350,
    	   	                          height:125,
    	   	                          mtype:'GET',
    	   	                          bSubmit: "Eliminar",
    	   	                          bCancel: "Cancelar",
    	   	                          bClose: "Close",
    	   	                          msg:" <b>¿Desea Eliminar Funcionalidad?</b><br>¡ Recordar <b>NO</b> se podran reversar los Cambios!",
    	   	                          bYes : "Yes",
    	   	                          bNo : "No",
    	   	                          bExit : "Cancel",
    	   	                          closeOnEscape:true,
    	   	                          closeAfterDel:true,
    	   	                          refresh:true,
    	   	                          reloadAfterSubmit:true,
    	   	                          recreateForm: true,
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
    	   	                          }//Del





    	                		    );
	                	}
	                 });




	          		$("#tabla_general").navGrid('#barra_herramientas_general',
	                    {
	              	    add:true,
	              	    addtext:'Crear Rol',
	              		edit:true,
	              		edittext:'Actualizar Rol',
	              		del:true ,
	              		deltext:'Eliminar Rol',
	              		alertcap:"Alerta",
	                    alerttext:"Seleccione Rol",
	              		search:false ,
	              		refresh:true,
	              		refreshstate: 'current',
	              		refreshtext:'Recargar Roles',
	              		},
	                  {      caption:"Actualizar Rol",
	                         addCaption: "Actualizar Rol",
	                         width: 350,
	                         height: 193,
	                         mtype:'GET',
	                         url:'<?php echo $urlEditarRol;?>',
	                         bSubmit: "Actualizar",
	                         bCancel: "Cancelar",
	                         bClose: "Close",
	                         saveData: "Data has been changed! Save changes?",
	                         bYes : "Yes",
	                         bNo : "No",
	                         bExit : "Cancel",
	                         closeOnEscape:true,
	                         closeAfterEdit:true,
	                         refresh:true,
	                         reloadAfterSubmit:true,
	                         recreateForm: true,
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
	                  {
	                        	 caption:"Crear Rol",
	 	                         addCaption: "Crear Rol",
	 	                         width: 350,
	 	                         height: 190,
	 	                         mtype:'GET',
	 	                         url:'<?php echo $urlCrearRol;?>',
	 	                         bSubmit: "Crear",
	 	                         bCancel: "Cancelar",
	 	                         bClose: "Close",
	 	                         saveData: "Data has been changed! Save changes?",
	 	                         bYes : "Yes",
	 	                         bNo : "No",
	 	                         bExit : "Cancel",
	 	                         closeOnEscape:true,
		                         closeAfterAdd:true,
		                         refresh:true,
		                         reloadAfterSubmit:true,
		                         recreateForm: true,
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


	        	                  },//add
	                   {
	              			  url:'<?php echo $urlEliminarRol;?>',
	                          caption: "Eliminar Rol",
	                          width: 350,
	                          height:125,
	                          mtype:'GET',
	                          bSubmit: "Eliminar",
	                          bCancel: "Cancelar",
	                          bClose: "Close",
	                          msg:" <b>¿Desea Eliminar Rol?</b><br>¡ Recordar <b>NO</b> se Podran Reversar los Cambios !",
	                          bYes : "Yes",
	                          bNo : "No",
	                          bExit : "Cancel",
	                          closeOnEscape:true,
	                          closeAfterDell:true,
	                          refresh:true,
	                          reloadAfterSubmit:true,
	                          recreateForm: true,
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
});

</script>
