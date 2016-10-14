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
	         	$('#tabla_gestion_usuario').ready(function() {
	         		 $("#tabla_gestion_usuario").jqGrid({
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
	                    pager: "#barra_herramientas_usuarios",
	                    caption: "Gestión Usuarios",

	                 });




	          		$("#tabla_gestion_usuario").navGrid('#barra_herramientas_usuarios',
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
