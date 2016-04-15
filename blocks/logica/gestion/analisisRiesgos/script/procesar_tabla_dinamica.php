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
     				viewrecords: true,
                     width: 1042,
                     height: 390,
                     rowNum: 10,
                     pager: "#barra_herramientas"
                 });

                  
         		});

});




</script>
