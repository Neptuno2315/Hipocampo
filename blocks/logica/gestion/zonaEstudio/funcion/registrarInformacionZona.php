<?php
include_once ('Redireccionador.php');
class FormProcessor {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miSql;
	var $conexion;
	function __construct($lenguaje, $sql) {
		$this->miConfigurador = \Configurador::singleton ();
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		$this->lenguaje = $lenguaje;
		$this->miSql = $sql;
	}
	function procesarFormulario() {
		var_dump ( $_REQUEST );
		exit ();
		$conexion = "logica";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		// INSERT INTO zona_estudio(
		// id_zona_estudio, id_sector, titulo_proy, profundidad_qll, ancho_canl,
		// obtrucciones_vs, complejidad_hdr, tipo_fn, estabilidad_sed, ayudas_nv,
		// calidad_dthd, operaciones_ddn, estado_mr, observaciones_vncr,
		// restricciones_vs, condiciones_hl, iluminacion_fn, observaciones_scm,
		// monitoreo_stm, estado_registro, fecha_registro)
		// VALUES (?, ?, ?, ?, ?,
		// ?, ?, ?, ?, ?,
		// ?, ?, ?, ?,
		// ?, ?, ?, ?,
		// ?, ?, ?);
		
		$arregloZonaEstudio = array (
				"id_sector" => $_REQUEST ['sector'],
				"titulo_proy" => $_REQUEST ['nombre_pry'],
				"profundidad_qll" => $_REQUEST ['pr_co_ba'],
				"ancho_canl" => $_REQUEST ['pr_co_ba'],
				"obtrucciones_vs" => $_REQUEST ['obtrucciones_visibilidad'],
				"complejidad_hdr" => $_REQUEST ['complejidad_hidrovia'],
				"tipo_fn" => $_REQUEST ['tipo_fondo'],
				"estabilidad_sed" => $_REQUEST ['estabilidad_sedimentos'],
				"ayudas_nv" => $_REQUEST ['ayudas_nv'],
				"calidad_dthd" => $_REQUEST ['calidad_datos'],
				"operaciones_ddn" => $_REQUEST ['calidad_datos'],
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'guardar_usuario', $_REQUEST ['usuario'] );
		echo $cadenaSql;
		$miresultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "acceso" );
		var_dump ( $esteRecursoDB );
		exit ();
		// Aquí va la lógica de procesamiento
		
		// Al final se ejecuta la redirección la cual pasará el control a otra página
		$variable = 'cualquierDato';
		Redireccionador::redireccionar ( 'opcion1', $variable );
	}
	function resetForm() {
		foreach ( $_REQUEST as $clave => $valor ) {
			
			if ($clave != 'pagina' && $clave != 'development' && $clave != 'jquery' && $clave != 'tiempo') {
				unset ( $_REQUEST [$clave] );
			}
		}
	}
}

$miProcesador = new FormProcessor ( $this->lenguaje, $this->sql );

$resultado = $miProcesador->procesarFormulario ();

?>