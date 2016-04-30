<?php

namespace logica\gestion\informeRiesgos\funcion;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
}
class Redireccionador {
	public static function redireccionar($opcion, $valor = "") {
		$miConfigurador = \Configurador::singleton ();
		
		switch ($opcion) {
			
			case 'ErrorModificacionFormulario' :
				$variable = 'pagina=informeRiesgos';
				$variable .= "&opcion=gestionRecomendaciones";
				$variable .= "&mensaje=ErrorProcesamiento";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				$variable .= "&id_zona=" . $_REQUEST ['id_zona'];
				$variable .= "&titulo_proyecto=" . $_REQUEST ['titulo_proyecto'];
				
				break;
			
			case "Inserto" :
				
				$variable = 'pagina=analisisRiesgos';
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=RegistroExito";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				$variable .= "&TituloProyecto=" . $_REQUEST ['titulo_proyecto'];
				
				break;
			
			case "NoInserto" :
				
				$variable = 'pagina=analisisRiesgos';
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=RegistroError";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				break;
			
			case "Actualizo" :
				
				$variable = 'pagina=analisisRiesgos';
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=ActualizoExito";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				$variable .= "&TituloProyecto=" . $_REQUEST ['nombre_pry'];
				
				break;
			
			case "NoActualizo" :
				
				$variable = 'pagina=analisisRiesgos';
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=ActualizacionError";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				
				break;
			
			case "Elimino" :
				
				$variable = 'pagina=analisisRiesgos';
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=EliminoExito";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				$variable .= "&TituloProyecto=" . $_REQUEST ['nombre_pry'];
				
				break;
			
			case "NoElimino" :
				
				$variable = 'pagina=analisisRiesgos';
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=EliminoError";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				break;
			
			case 'paginaPrincipal' :
				$variable = 'pagina=analisisRiesgos';
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				break;
		}
		foreach ( $_REQUEST as $clave => $valor ) {
			unset ( $_REQUEST [$clave] );
		}
		$url = $miConfigurador->configuracion ["host"] . $miConfigurador->configuracion ["site"] . "/index.php?";
		$enlace = $miConfigurador->configuracion ['enlace'];
		$variable = $miConfigurador->fabricaConexiones->crypto->codificar ( $variable );
		$_REQUEST [$enlace] = $enlace . '=' . $variable;
		$redireccion = $url . $_REQUEST [$enlace];
		
		echo "<script>location.replace('" . $redireccion . "')</script>";
		exit ();
	}
}
?>