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
				
				break;
			
			case "NoInserto" :
				
				$variable = 'pagina=zonaEstudio';
				
				break;
			
			default :
				$variable = '';
		}
		foreach ( $_REQUEST as $clave => $valor ) {
			unset ( $_REQUEST [$clave] );
		}
		
		$enlace = $miConfigurador->getVariableConfiguracion ( "enlace" );
		$variable = $miConfigurador->fabricaConexiones->crypto->codificar ( $variable );
		
		$_REQUEST [$enlace] = $variable;
		$_REQUEST ["recargar"] = true;
		
		return true;
	}
}
?>