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
				"operaciones_ddn" => $_REQUEST ['opera_nc_di'],
				"estado_mr" => $_REQUEST ['estado_mar'],
				"observaciones_vncr" => $_REQUEST ['obser_des__vi_mr'],
				"restricciones_vs" => $_REQUEST ['visibilidad'],
				"condiciones_hl" => $_REQUEST ['con_hielo'],
				"iluminacion_fn" => $_REQUEST ['ilum_fondo'],
				"observaciones_scm" => $_REQUEST ['obser_escom'],
				"monitoreo_stm" => $_REQUEST ['mn_stm'] 
		);
		
		// INSERT INTO informacion_carta_nautica(
		// id_inf_carta_nautica, id_zona_estudio, boyas_ais, boyas_nais,
		// racon_num, linternas_num, otras_aton, proporciona_dgps, disponibilidad_stm,
		// disponible_servpl, observaciones, estado_registro, fecha_registro)
		// VALUES (?, ?, ?, ?,
		// ?, ?, ?, ?, ?,
		// ?, ?, ?, ?);
		$arregloCartaNautica = array (
				"id_zona_estudio" => $_REQUEST ['aa'],
				"boyas_ais" => $_REQUEST ['bo_mo_for_re'],
				"boyas_nais" => $_REQUEST ['bo_si_ais_no_super'],
				"racon_num" => $_REQUEST ['racon'],
				"linternas_num" => $_REQUEST ['linterna'],
				"otras_aton" => $_REQUEST ['ort_aton'],
				"proporciona_dgps" => $_REQUEST ['g_gps'],
				"disponibilidad_stm" => $_REQUEST ['ds_stm'],
				"disponible_servpl" => $_REQUEST ['ds_srv_pl'],
				"observaciones" => $_REQUEST ['obser_des__sis_sn'] 
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