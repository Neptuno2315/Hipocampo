<?php

namespace logica\datosGeograficos\gestionInformacionBatimetrica\funcion;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
}
class Redireccionador {
	public static function redireccionar($opcion, $valor = "") {
		$miConfigurador = \Configurador::singleton ();
		
		switch ($opcion) {
			
			case 'ErrorModificacionFormulario' :
				$variable = 'pagina=gestionInformacionBatimetrica';
				$variable .= "&opcion=gestionBatimetriaZona";
				$variable .= "&mensaje=ErrorProcesamiento";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				$variable .= "&id_zona=" . $_REQUEST ['id_zona'];
				$variable .= "&titulo_proyecto=" . $_REQUEST ['titulo_proyecto'];
				$variable .= "&region=" . $_REQUEST ['region'];
				$variable .= "&sector=" . $_REQUEST ['sector'];
				
				break;
			
			case 'ErrorExtension' :
				$variable = 'pagina=gestionInformacionBatimetrica';
				$variable .= "&opcion=gestionBatimetriaZona";
				$variable .= "&mensaje=ErrorExtensionArchivos";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				$variable .= "&id_zona=" . $_REQUEST ['id_zona'];
				$variable .= "&titulo_proyecto=" . $_REQUEST ['titulo_proyecto'];
				$variable .= "&region=" . $_REQUEST ['region'];
				$variable .= "&sector=" . $_REQUEST ['sector'];
				
				break;
			
			case 'ErrorCargarFicheroDirectorio' :
				$variable = 'pagina=gestionInformacionBatimetrica';
				$variable .= "&opcion=gestionBatimetriaZona";
				$variable .= "&mensaje=ErrorCargarDirectorioProcesar";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				$variable .= "&id_zona=" . $_REQUEST ['id_zona'];
				$variable .= "&titulo_proyecto=" . $_REQUEST ['titulo_proyecto'];
				$variable .= "&region=" . $_REQUEST ['region'];
				$variable .= "&sector=" . $_REQUEST ['sector'];
				
				break;
			
			case "Inserto" :
				
				$variable = 'pagina=gestionInformacionBatimetrica';
				$variable .= "&opcion=gestionRecomendaciones";
				$variable .= "&mensaje=RegistroExito";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				$variable .= "&id_zona=" . $_REQUEST ['id_zona'];
				$variable .= "&titulo_proyecto=" . $_REQUEST ['titulo_proyecto'];
				
				break;
			
			case "NoInserto" :
				
				$variable = 'pagina=gestionInformacionBatimetrica';
				$variable .= "&opcion=gestionRecomendaciones";
				$variable .= "&mensaje=RegistroError";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				$variable .= "&id_zona=" . $_REQUEST ['id_zona'];
				$variable .= "&titulo_proyecto=" . $_REQUEST ['titulo_proyecto'];
				
				break;
			
			case "Actualizo" :
				
				$variable = 'pagina=gestionInformacionBatimetrica';
				$variable .= "&opcion=gestionRecomendaciones";
				$variable .= "&mensaje=ActualizoExito";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				$variable .= "&id_zona=" . $_REQUEST ['id_zona'];
				$variable .= "&titulo_proyecto=" . $_REQUEST ['titulo_proyecto'];
				
				break;
			
			case "NoActualizo" :
				
				$variable = 'pagina=gestionInformacionBatimetrica';
				$variable .= "&opcion=gestionRecomendaciones";
				$variable .= "&mensaje=ActualizacionError";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				$variable .= "&id_zona=" . $_REQUEST ['id_zona'];
				$variable .= "&titulo_proyecto=" . $_REQUEST ['titulo_proyecto'];
				
				break;
			
			case "Elimino" :
				$variable = 'pagina=gestionInformacionBatimetrica';
				$variable .= "&opcion=gestionRecomendaciones";
				$variable .= "&mensaje=EliminoExito";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				$variable .= "&id_zona=" . $_REQUEST ['id_zona'];
				$variable .= "&titulo_proyecto=" . $_REQUEST ['titulo_proyecto'];
				
				break;
			
			case "NoElimino" :
				$variable = 'pagina=gestionInformacionBatimetrica';
				$variable .= "&opcion=gestionRecomendaciones";
				$variable .= "&mensaje=EliminoError";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				$variable .= "&id_zona=" . $_REQUEST ['id_zona'];
				$variable .= "&titulo_proyecto=" . $_REQUEST ['titulo_proyecto'];
				break;
			
			case 'paginaPrincipal' :
				$variable = 'pagina=gestionInformacionBatimetrica';
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