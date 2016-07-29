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

{ // Url para Consultar Información de SRID.
  // Variables
	
	$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
	$cadenaACodificar .= "&procesarAjax=true";
	$cadenaACodificar .= "&action=index.php";
	$cadenaACodificar .= "&bloqueNombre=" . $esteBloque ["nombre"];
	$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque ["grupo"];
	$cadenaACodificar .= "&funcion=consultaInSrid";
	$cadenaACodificar .= "&tiempo=" . $_REQUEST ['tiempo'];
	// Codificar las variables
	$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
	$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar, $enlace );
	// URL definitiva
	$urlSRID = $url . $cadena;
}

?>
<script type='text/javascript' async='async'>





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


function consultas_srid(elem, request, response){
	  $.ajax({
	    url: "<?php echo $urlSRID?>",
	    dataType: "json",
	    data: { valor:$("#<?php echo $this->campoSeguro('srid')?>").val()},
	    success: function(data){ 
	 
	        if(data!=" "){



	        	document.getElementById("informacion_srid").innerHTML = data;
	        	
	            
	            }          
	   		}
	});

}



	$(function() {


	    $("#<?php echo $this->campoSeguro('srid')?>").change(function() {
	    	
			if($("#<?php echo $this->campoSeguro('srid')?>").val()!=''){
				consultas_srid();

				}
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
