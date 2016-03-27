<?php

/**
 *
 * Los datos del bloque se encuentran en el arreglo $esteBloque.
 */

// URL base
$url = $this->miConfigurador->getVariableConfiguracion ( "host" );
$url .= $this->miConfigurador->getVariableConfiguracion ( "site" );
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
	
	$arreglo =base64_encode ( serialize ( $arreglo ));
	
	$cadenaACodificar .= "&arreglo=" . $arreglo;
	
	// Codificar las variables
	$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
	$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar, $enlace );
	
	// URL definitiva
	$urlTabla = $url . $cadena;
}
?>
<script type='text/javascript'>




$(function() {
         	$('#tablaInfoZonas').ready(function() {

             $('#tablaInfoZonas').dataTable( {
//              	 serverSide: true,
				processing: true,
		        "aLengthMenu": [[10,25, 50,100,300,500,1000,-1], [10,25, 50,100,300,500,1000,'Todos']],
//                   ordering: true,
                  searching: true,
//                deferRender: true,
      //             sScrollY: 500	,
        //          bScrollCollapse: true,
                  info:true,
//                   lengthChange:true,
   		    "pagingType": "full_numbers",
//                   stateSave: true,
         //          renderer: "bootstrap",
         //          retrieve: true,
                  ajax:{
                      url:"<?php echo $urlTabla?>",
                      dataSrc:"data"                                                                  
                  },
                  columns: [
                  { data :"region" },
                  { data :"sector" },
                  { data :"titulo" },
                  { data :"fecha" },
                  { data :"modificar" },
                  { data :"eliminar" },
                            ]
             });
                  
         		});

});




</script>
