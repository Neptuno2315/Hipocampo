<?php

namespace logica\gestion\zonaEstudio\funcion;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
}
class Redireccionador {
	public static function redireccionar($opcion, $valor = "") {
		$miConfigurador = \Configurador::singleton ();
		
		switch ($opcion) {
			
			case "Inserto" :
				
				$variable = 'pagina=zonaEstudio';
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=RegistroExito";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				$variable .= "&TituloProyecto=" . $_REQUEST ['nombre_pry'];
				
				break;
			
			case "NoInserto" :
				
				$variable = 'pagina=zonaEstudio';
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=RegistroError";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				break;
			
			case "Actualizo" :
				
				$variable = 'pagina=zonaEstudio';
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=ActualizoExito";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				$variable .= "&TituloProyecto=" . $_REQUEST ['nombre_pry'];
				
				break;
			
			case "NoActualizo" :
				
				$variable = 'pagina=zonaEstudio';
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=ActualizacionError";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				break;
			
			case 'ErrorModificacionFormulario' :
				$variable = 'pagina=zonaEstudio';
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=ErrorProcesamiento";
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