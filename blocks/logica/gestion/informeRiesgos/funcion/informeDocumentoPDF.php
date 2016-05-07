<?php
use html2PDF\HTML2PDF;

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
		var_dump ( $_REQUEST );
		exit ();
		

		
		/*
		 * Configurar Arreglo a Actualizar
		 */
		
		$arregloDatos = array (
				"id_recomendacion" => $_REQUEST ['id_recomendacion'],
				"riesgo" => $_REQUEST ['riesgo'],
				"acciones_prv" => $_REQUEST ['acciones'],
				"senalizacion_ext" => $_REQUEST ['senalizacion'] 
		);
		
		/*
		 * Registro de Recomendación
		 */
		
		$conexion = "logica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$cadenaSql = $this->miSql->getCadenaSql ( "actualizar_recomendacion", $arregloDatos );
		
		$actualizacion = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "accion", $arregloDatos, "actualizar_recomendacion" );
		

	}
}

$miProcesador = new FormProcessor ( $this->lenguaje, $this->sql );

$resultado = $miProcesador->procesarFormulario ();

?>