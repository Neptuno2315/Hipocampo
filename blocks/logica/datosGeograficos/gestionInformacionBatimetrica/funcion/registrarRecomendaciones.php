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
		 * Validar que los Campos no fuesen manipulados para saltarse la validaciones del plugin Validation Engine
		 */
		{
			if (isset ( $_REQUEST ['validadorCampos'] )) {
				$validadorCampos = $this->miInspectorHTML->decodificarCampos ( $_REQUEST ['validadorCampos'] );
				$respuesta = $this->miInspectorHTML->validacionCampos ( $_REQUEST, $validadorCampos, false );
				
				if ($respuesta != false) {
					
					$_REQUEST = $respuesta;
				} else {
					Redireccionador::redireccionar ( "ErrorModificacionFormulario" );
				}
			}
		}
		
		/*
		 * Configurar Arreglo a Registrar
		 */
		
		$arregloDatos = array (
				"id_zona_estudio" => $_REQUEST ['id_zona'],
				"riesgo" => $_REQUEST ['riesgo'],
				"acciones_prv" => $_REQUEST ['acciones'],
				"senalizacion_ext" => $_REQUEST ['senalizacion'] 
		);
		
		/*
		 * Registro de Recomendación
		 */
		
		$conexion = "logica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$cadenaSql = $this->miSql->getCadenaSql ( "registrar_recomendacion", $arregloDatos );
		
		$registro = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "accion", $_REQUEST ['id_zona'], "registrar_recomendacion" );
		
		
		if ($registro == true) {
			Redireccionador::redireccionar ( "Inserto" );
		} else if ($registro == false) {
			Redireccionador::redireccionar ( "NoInserto" );
		}
	}
}

$miProcesador = new FormProcessor ( $this->lenguaje, $this->sql );

$resultado = $miProcesador->procesarFormulario ();

?>