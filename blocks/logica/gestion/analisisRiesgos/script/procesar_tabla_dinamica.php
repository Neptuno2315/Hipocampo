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
	$cadenaACodificar .= "&funcion=consultarZonasEstudio";
	$cadenaACodificar .= "&tiempo=" . $_REQUEST ['tiempo'];
	$cadenaACodificar .= "&usuario=" . $_REQUEST ['usuario'];
	
	if (isset ( $_REQUEST ['region_consulta'] ) && $_REQUEST ['region_consulta'] != '') {
		$region = $_REQUEST ['region_consulta'];
	} else {
		$region = '';
	}
	
	if (isset ( $_REQUEST ['sector_consulta'] ) && $_REQUEST ['sector_consulta'] != '') {
		$sector = $_REQUEST ['sector_consulta'];
	} else {
		$sector = '';
	}
	
	if (isset ( $_REQUEST ['id_zona'] ) && $_REQUEST ['id_zona'] != '') {
		$zona = $_REQUEST ['id_zona'];
	} else {
		$zona = '';
	}
	
	if (isset ( $_REQUEST ['fecha_inicio_consulta'] ) && $_REQUEST ['fecha_inicio_consulta'] != '') {
		$fecha_inicio = $_REQUEST ['fecha_inicio_consulta'];
	} else {
		$fecha_inicio = '';
	}
	
	if (isset ( $_REQUEST ['fecha_final_consulta'] ) && $_REQUEST ['fecha_final_consulta'] != '') {
		$fecha_final = $_REQUEST ['fecha_final_consulta'];
	} else {
		$fecha_final = '';
	}
	/* Arreglo de Variables */
	$arreglo = array (
			'region' => $region,
			'sector' => $sector,
			'zona_estudio' => $zona,
			'fecha_inicial' => $fecha_inicio,
			'fecha_final' => $fecha_final 
	);
	
	$arreglo = base64_encode ( serialize ( $arreglo ) );
	
	$cadenaACodificar .= "&arreglo=" . $arreglo;
	
	// Codificar las variables
	$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
	$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar, $enlace );
	
	// URL definitiva
	$urlTabla = $url . $cadena;
}
?>
<script type='text/javascript' async='async'>




$(function() {
         	$('#tabla_datos_riesgos').ready(function() {

         		 $("#tabla_datos_riesgos").jqGrid({
                     url: 'data.json',
     				// we set the changes to be made at client side using predefined word clientArray
                     editurl: 'clientArray',
                     datatype: "json",
                     colModel: [
                         {
     						label: 'Tema',
                             name: 'tem',
                             width: 50,
     						key: true,
     						editable: true,
     						editrules : { required: true}
                         },
                         {
     						label: 'Variable',
                             name: 'var',
                             width: 140,
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
                              name: 'prb',
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
     				sortname: 'CustomerID',
     				sortorder : 'asc',
     				loadonce: true,
     				viewrecords: true,
                     width: 1042,
                     height: 390,
                     rowNum: 10,
                     pager: "#barra_herramientas"
                 });

         		$('#tabla_datos_riesgos').navGrid('#barra_herramientas',
                        // the buttons to appear on the toolbar of the grid
                        { edit: true, add: true, del: true, search: false, refresh: false, view: false, position: "left", cloneToTop: false },
                        // options for the Edit Dialog
                        {
                            editCaption: "The Edit Dialog",
        					template: template,
                            errorTextFormat: function (data) {
                                return 'Error: ' + data.responseText
                            }
                        },
                        // options for the Add Dialog
                        {
        					template: template,
                            errorTextFormat: function (data) {
                                return 'Error: ' + data.responseText
                            }
                        },
                        // options for the Delete Dailog
                        {
                            errorTextFormat: function (data) {
                                return 'Error: ' + data.responseText
                            }
                        });

                  
         		});

});




</script>
