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
$cadenaACodificar .= "&funcion=consultarRoles";

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar, $enlace);

// URL definitiva
$urlConsultarRoles = $url . $cadena;

// Variables
$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar .= "&procesarAjax=true";
$cadenaACodificar .= "&action=index.php";
$cadenaACodificar .= "&bloqueNombre=" . $esteBloque["nombre"];
$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque["grupo"];
$cadenaACodificar .= "&funcion=consultarUsuarios";

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar, $enlace);

// URL definitiva
$urlConsultarUsuarios = $url . $cadena;

// Variables
$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar .= "&procesarAjax=true";
$cadenaACodificar .= "&action=index.php";
$cadenaACodificar .= "&bloqueNombre=" . $esteBloque["nombre"];
$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque["grupo"];
$cadenaACodificar .= "&funcion=crearUsuario";

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar, $enlace);

// URL definitiva
$urlCrearUsuario = $url . $cadena;

// Variables
$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar .= "&procesarAjax=true";
$cadenaACodificar .= "&action=index.php";
$cadenaACodificar .= "&bloqueNombre=" . $esteBloque["nombre"];
$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque["grupo"];
$cadenaACodificar .= "&funcion=editarUsuario";

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar, $enlace);

// URL definitiva
$urlEditarUsuario = $url . $cadena;

// Variables
$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar .= "&procesarAjax=true";
$cadenaACodificar .= "&action=index.php";
$cadenaACodificar .= "&bloqueNombre=" . $esteBloque["nombre"];
$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque["grupo"];
$cadenaACodificar .= "&funcion=eliminarUsuario";

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar, $enlace);

// URL definitiva
$urlEliminarUsuario = $url . $cadena;

/**
 * Fin
 **/

?>
<script type='text/javascript'>


$(document).ready(function() {


	$(function() {
	         	$('#tabla_gestion_usuario').ready(function() {
	         		 $("#tabla_gestion_usuario").jqGrid({
	                     url:	"<?php echo $urlConsultarUsuarios;?>",
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
								editoptions: {size:25, maxlength: 20},
						 },
						 {
								label: 'Número Identificación :',
						        name: 'num_ident',
						        width: 40,
								editable: true,
								sorttype:'number',
								align:'center',
								formatter: 'integer',
								editrules : {required: true,integer: true},
								editoptions: {size:25, maxlength: 20},
						 },
						 {
								label: 'Tipo Identificación :',
						        name: 'tipo_id',
						        width: 40,
								align:'center',
								editable: true,
		                	    edittype: 'select',
		                		editoptions: {
		                                     value: "CC: Cedula Ciudadanía;CE: Cedula Extranjería",
		                					},
								editrules : {required: true}
						 },

	                         {
	     						label: 'Nombres :',
	                            name: 'nombres',
	                            width: 40,
	     						editable: true,
	     						sorttype:'text',
	     						align:'center',
	     						editrules : {required: true},
	     						itoptions: {size:25, maxlength: 30},

	                         },


	                         {
	     						label: 'Apellidos :',
	                            name: 'apellidos',
	                            width: 40,
	     						editable: true,
	     						sorttype:'text',
	     						align:'center',
	     						editrules : {required: true},
	     						 editoptions: {size:25, maxlength: 30},

	                         },

	                         {
	     						label: 'Correo Electrónico :',
	                            name: 'email',
	                            width: 40,
	     						editable: true,
	     						sorttype:'text',
	     						align:'center',
	     						formatter: 'email',
	     						editrules : {required: true,email: true},
	     						editoptions: {size:25, maxlength: 40},

	                         },
	                          {
   	                			label: 'Rol :',
                				name:"rol",
                				width:30,
                				editable: true,
                				align:'center',
                				edittype: 'select',
                				editrules: {required: true},
                				editoptions: {
                					dataInit: function (element) {
                                 			window.setTimeout(function () {
											$(element).width(160);
                                     		$(element).select2({
                   								 placeholder: "Seleccione Roles",
                    							 allowClear: true,
                								});
                                     });
                             		},
                             		 dataUrl:'<?php echo $urlConsultarRoles;?>',
                             		 defaultValue: ''
                             	}
		                	 },
    						{
   	                			label: 'Actualizar Contraseña :',
                				name:"upd_pass",
                				width: 40,
								align:'center',
								editable: true,
		                	    edittype: 'select',
		                		editoptions: {
		                                     value: "0: NO;1: SI",
		                					},
								editrules : {required: true}
		                	 },

                            {
	     						label: 'Contraseña :',
	                            name: 'contrasena',
	                            width: 70,
	     						editable: true,
	     						align:'center',
	     						edittype: 'password',
	     						formatter:"password",
	     						editrules : {required: true},
								editoptions: {size:25, maxlength: 20, minlength: 10},
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
	              	    addtext:'Crear Usuario',
	              		edit:true,
	              		edittext:'Actualizar Usuario',
	              		del:true ,
	              		deltext:'Eliminar Usuario',
	              		alertcap:"Alerta",
	                    alerttext:"Seleccione Usuario",
	              		search:false ,
	              		refresh:true,
	              		refreshstate: 'current',
	              		refreshtext:'Recargar Usuarios',
	              		},
	                  {      caption:"Actualizar Usuario",
	                         addCaption: "Actualizar Usuario",
	                         width: 350,
	                         height: 365,
	                         mtype:'GET',
	                         url:'<?php echo $urlEditarUsuario;?>',
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
	                        	 caption:"Crear Usuario",
	 	                         addCaption: "Crear Usuario",
	 	                         width: 350,
	 	                         height: 365,
	 	                         mtype:'GET',
	 	                         url:'<?php echo $urlCrearUsuario;?>',
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
	              			  url:'<?php echo $urlEliminarUsuario;?>',
	                          caption: "Eliminar Usuario",
	                          width: 350,
	                          height:125,
	                          mtype:'GET',
	                          bSubmit: "Eliminar",
	                          bCancel: "Cancelar",
	                          bClose: "Close",
	                          msg:" <b>¿Desea Eliminar Usuario?</b><br>¡ Recordar <b>NO</b> se Podran Reversar los Cambios !",
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
