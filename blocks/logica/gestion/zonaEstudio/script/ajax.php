<?php

/**
 *
 * Los datos del bloque se encuentran en el arreglo $esteBloque.
 */

// URL base
$url = $this->miConfigurador->getVariableConfiguracion ( "host" );
$url .= $this->miConfigurador->getVariableConfiguracion ( "site" );
$url .= "/index.php?";

{ // Url para Agregar Sectores de la Region
  // Variables
	$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
	$cadenaACodificar .= "&procesarAjax=true";
	$cadenaACodificar .= "&action=index.php";
	$cadenaACodificar .= "&bloqueNombre=" . $esteBloque ["nombre"];
	$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque ["grupo"];
	$cadenaACodificar .= "&funcion=SeleccionSector";
	$cadenaACodificar .= "&tiempo=" . $_REQUEST ['tiempo'];
	// Codificar las variables
	$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
	$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar, $enlace );
	// URL definitiva
	$urlSector = $url . $cadena;
}

?>
<script type='text/javascript'>

function consulta_sectores(elem, request, response){
	  $.ajax({
	    url: "<?php echo $urlSector?>",
	    dataType: "json",
	    data: { valor:$("#<?php echo $this->campoSeguro('region')?>").val()},
	    success: function(data){ 
	        if(data[0]!=" "){

	            $("#<?php echo $this->campoSeguro('sector')?>").html('');
	            $("<option value=''>Seleccione ....</option>").appendTo("#<?php echo $this->campoSeguro('sector')?>");
	            $.each(data , function(indice,valor){
				            	$("<option value='"+data[ indice ].id+"'>"+data[ indice ].valor+"</option>").appendTo("#<?php echo $this->campoSeguro('sector')?>");
	        			    });
	            $("#<?php echo $this->campoSeguro('sector')?>").removeAttr('disabled');
	            $('#<?php echo $this->campoSeguro('sector')?>').width(200);
	            $("#<?php echo $this->campoSeguro('sector')?>").select2();
	            }          
	   		}
	});

}
	$(function() {

	    $("#<?php echo $this->campoSeguro('region')?>").change(function() {
	    	
			if($("#<?php echo $this->campoSeguro('region')?>").val()!=''){
				consulta_sectores();

				}


	    	
		 });



		});
	</script>
