<?php
use logica\gestion\zonaEstudio\funcion\Redireccionador;
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
		
		/* Arreglo Deshabilitar Información de Zona de Estudio */
		{
			$cadenaSql [] = $this->miSql->getCadenaSql ( 'eliminar_zona_estudio', $_REQUEST ['id_zona'] );
			$cadenaSql [] = $this->miSql->getCadenaSql ( 'anular_trafico_maritimo', $_REQUEST ['id_zona'] );
			$cadenaSql [] = $this->miSql->getCadenaSql ( 'eliminar_peligros', $_REQUEST ['id_zona'] );
			$cadenaSql [] = $this->miSql->getCadenaSql ( 'eliminar_info_carta_nautica', $_REQUEST ['id_zona'] );
		}
		
		// Conexion de Base de Datos
		$conexion = "logica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		// Ejecucción Transaccion
		$transaccion = $esteRecursoDB->transaccion ( $cadenaSql );
		
		if ($transaccion == true) {
			Redireccionador::redireccionar ( 'Elimino' );
		} else if ($transaccion == false) {
			Redireccionador::redireccionar ( 'NoElimino' );
		}
	}
}

$miProcesador = new FormProcessor ( $this->lenguaje, $this->sql );

$resultado = $miProcesador->procesarFormulario ();

?>