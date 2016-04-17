<?php
use logica\gestion\analisisRiesgos\funcion\Redireccionador;
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
		var_dump ( $_REQUEST );
		
		// Conexion de Base de Datos
		$conexion = "logica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		/*
		 * Consulta de Variables Procesadas
		 */
		{
			$arregloConsulta = array (
					"token" => $_REQUEST ['token'],
					"id_zona" => $_REQUEST ['id_zona'] 
			);
			
			$cadenaSql = $this->miSql->getCadenaSql ( 'consultar_variables_temporales_procesadas', $arregloConsulta );
			
			$variables_procesadas = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
		} // Fin Consulta Variables
		
		/*
		 * Configurar y Validar Arreglo a Registrar
		 */
		
		foreach ( $variables_procesadas as $valor ) {
			
			$arregloDatos [] = array (
					"id_zona_estudio" => $valor ['id_zona_estudio'],
					"tema" => $valor ['tema'],
					"variable" => $valor ['variable'],
					"valor" => $valor ['valor'],
					"nota" => $valor ['nota'],
					"probabilidad" => (is_null ( $valor ['probabilidad'] ) == true) ? $this->ErrorDatosVaciosObligatorios () : $valor ['probabilidad'],
					"impacto" => (is_null ( $valor ['impacto'] ) == true) ? $this->ErrorDatosVaciosObligatorios () : $valor ['impacto'],
					"riesgo" => (is_null ( $valor ['riesgo'] ) == true) ? $this->ErrorDatosVaciosObligatorios () : $valor ['riesgo'],
					"observacion" => (is_null ( $valor ['control_ris'] ) == true) ? $this->ErrorDatosVaciosObligatorios () : $valor ['control_ris'] 
			);
		}
		
		var_dump ( $arregloDatos );
		
		exit ();
		// Se guarda en un array para crear una trasaccion
		
		foreach ($arregloDatos as $valor){
			
			
			
			
		}
		
		
		$cadenaSql [] = $this->miSql->getCadenaSql ( 'registrar_variables_riesgo', $arregloPeligros );
		
		// Ejecucción Transaccion
		
		$transaccion = $esteRecursoDB->transaccion ( $cadenaSql );
		
		if ($transaccion == true) {
			Redireccionador::redireccionar ( 'Inserto' );
		} else if ($transaccion == false) {
			Redireccionador::redireccionar ( 'NoInserto' );
		}
	}
	function ErrorDatosVaciosObligatorios() {
		Redireccionador::redireccionar ( "ErrorVariablesVacias" );
		exit ();
	}
}

$miProcesador = new FormProcessor ( $this->lenguaje, $this->sql );

$resultado = $miProcesador->procesarFormulario ();

?>