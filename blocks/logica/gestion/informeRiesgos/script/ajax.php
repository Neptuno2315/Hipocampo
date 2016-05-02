<?php

/**
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

{ // Url para autocompletar los Titulos o Nombres de lo Proyectos
  // Variables
	$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
	$cadenaACodificar .= "&procesarAjax=true";
	$cadenaACodificar .= "&action=index.php";
	$cadenaACodificar .= "&bloqueNombre=" . $esteBloque ["nombre"];
	$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque ["grupo"];
	$cadenaACodificar .= "&funcion=busquedaTituloZona";
	$cadenaACodificar .= "&tiempo=" . $_REQUEST ['tiempo'];
	// Codificar las variables
	$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
	$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar, $enlace );
	// URL definitiva
	$urlTituloZona = $url . $cadena;
}

{ // Url para Estadistica Racon.
  // Variables
	
	$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
	$cadenaACodificar .= "&procesarAjax=true";
	$cadenaACodificar .= "&action=index.php";
	$cadenaACodificar .= "&bloqueNombre=" . $esteBloque ["nombre"];
	$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque ["grupo"];
	$cadenaACodificar .= "&funcion=consultaAtoN";
	$cadenaACodificar .= "&tiempo=" . $_REQUEST ['tiempo'];
	if (isset ( $_REQUEST ['id_zona'] )) {
		$cadenaACodificar .= "&id_zona=" . $_REQUEST ['id_zona'];
	}
	// Codificar las variables
	$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
	$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar, $enlace );
	// URL definitiva
	$urlAton = $url . $cadena;
}

?>
<script type='text/javascript' async='async'>




function consulta_estadistico(elem, request, response){
	  $.ajax({
	    url: "<?php echo $urlAton?>",
	    dataType: "json",
	    success: function(data){ 

	    	nv.addGraph(function() {
	    		  var chart = nv.models.pieChart()
	    		      .x(function(d) { return d.label })
	    		      .y(function(d) { return d.value })
	    		      .showLabels(true);

	    		    d3.select("#DivEstadistico svg")
	    		        .datum(data)
	    		        .transition().duration(350)
	    		        .call(chart);

	    		  return chart;

	        	});


	    }
	  });


}
function consultas_sector(elem, request, response){
	  $.ajax({
	    url: "<?php echo $urlSector?>",
	    dataType: "json",
	    data: { valor:$("#<?php echo $this->campoSeguro('region_consulta')?>").val()},
	    success: function(data){ 
	        if(data[0]!=" "){

	            $("#<?php echo $this->campoSeguro('sector_consulta')?>").html('');
	            $("<option value=''>Seleccione ....</option>").appendTo("#<?php echo $this->campoSeguro('sector_consulta')?>");
	            $.each(data , function(indice,valor){
				            	$("<option value='"+data[ indice ].id+"'>"+data[ indice ].valor+"</option>").appendTo("#<?php echo $this->campoSeguro('sector_consulta')?>");
	        			    });
	            $("#<?php echo $this->campoSeguro('sector_consulta')?>").removeAttr('disabled');
	            $('#<?php echo $this->campoSeguro('sector_consulta')?>').width(200);
	            $("#<?php echo $this->campoSeguro('sector_consulta')?>").select2();
	            }          
	   		}
	});

}


	$(function() {




	    $("#DivEstadistico").ready(function() {
	    	consulta_estadistico();
	 	 });

	    $("#<?php echo $this->campoSeguro('region_consulta')?>").change(function() {
	    	
		if($("#<?php echo $this->campoSeguro('region_consulta')?>").val()!=''){
			consultas_sector();

			}
	 	 });



        $("#<?php echo $this->campoSeguro('nombre_pry_consulta') ?>").autocomplete({
        	minChars: 3,
        	serviceUrl: '<?php echo $urlTituloZona; ?>',
        	onSelect: function (suggestion) {
            	    $("#<?php echo $this->campoSeguro('id_zona') ?>").val(suggestion.data);
        	    }
                    
        });

	    
	    $("#<?php echo $this->campoSeguro('nombre_pry_consulta')?>").blur(function() {

	    	if($("#<?php echo $this->campoSeguro('id_zona') ?>")!=''){

	    		$("#<?php echo $this->campoSeguro('nombre_pry_consulta')?>").val('');
		    	
		    	}
	 	 });

		});
	</script>
