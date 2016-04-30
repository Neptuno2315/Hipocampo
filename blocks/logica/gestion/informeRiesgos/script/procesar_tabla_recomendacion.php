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
	$cadenaACodificar .= "&funcion=consultarRecomendaciones";
	$cadenaACodificar .= "&tiempo=" . $_REQUEST ['tiempo'];
	$cadenaACodificar .= "&usuario=" . $_REQUEST ['usuario'];
	$cadenaACodificar .= "&id_zona=" . $_REQUEST ['id_zona'];
	
	// Codificar las variables
	$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
	$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar, $enlace );
	
	// URL definitiva
	$urlTabla = $url . $cadena;
	
}
?>
<script type='text/javascript' async='async'>




$(function() {
         	$('#tablaRecomedaciones').ready(function() {

             $('#tablaRecomedaciones').dataTable( {
            	 language: {
                     url: "<?php echo $urlDirectorio?>"
                 			},
				processing: true,
		        "aLengthMenu": [[10,25, 50,100,300,500,1000,-1], [10,25, 50,100,300,500,1000,'Todos']],
                  searching: true,
                  "scrollY":"200px",
                 "scrollCollapse": false,
                  info:true,
	   		    "pagingType": "simple",
	   		 "bLengthChange": false,
	   		"bPaginate": false,

                  ajax:{
                      url:"<?php echo $urlTabla?>",
                      dataSrc:"data"                                                                  
                  },
                  columns: [
                  { data :"riesgo" },
                  { data :"accion" },
                  { data :"senalizacion" },
                            ]
             });
                  
         		});

});




</script>
