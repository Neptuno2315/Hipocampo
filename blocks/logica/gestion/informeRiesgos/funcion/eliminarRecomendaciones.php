<?php
use logica\gestion\informeRiesgos\funcion\Redireccionador;
include_once ('Redireccionador.php');
include_once ("core/builder/InspectorHTML.class.php");
class FormProcessor {
	var $miConfigurador;
	var $miInspectorHTML;
	var $lenguaje;
	var $miFormulario;
	var $miSql;
	var $conexion;
	function __construct($lenguaje, $sql) {
		$this->miInspectorHTML = \InspectorHTML::singleton ();
		$this->miConfigurador = \Configurador::singleton ();
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		$this->lenguaje = $lenguaje;
		$this->miSql = $sql;
	}
	function procesarFormulario() {
		
		/*
		 * Eliminar de Recomendación
		 */
		$conexion = "logica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$cadenaSql = $this->miSql->getCadenaSql ( "eliminar_recomendacion",  $_REQUEST ['id_recomendacion']);
		
		$eliminar = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "accion", $_REQUEST ['id_recomendacion'], "eliminar_recomendacion" );
		
		if ($eliminar == true) {
			Redireccionador::redireccionar ( "Elimino" );
		} else if ($eliminar == false) {
			Redireccionador::redireccionar ( "NoElimino" );
		}
	}
}

$miProcesador = new FormProcessor ( $this->lenguaje, $this->sql );

$resultado = $miProcesador->procesarFormulario ();

?>