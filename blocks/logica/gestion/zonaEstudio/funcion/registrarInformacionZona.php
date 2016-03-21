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
		
		// INSERT INTO peligros(
		// id_peligros, id_zona_estudio, calado_mxbq, holgura_bjqll, maxima_olpr,
		// sedimentacion_mxa, profundidad_minsg, anchura_cnl, tasa_mx, observaciones_flmr,
		// prediccion_mxvntr, observaciones_vttr, prediccion_cbm, observaciones_efcb,
		// distancia_pntcr, observaciones_pntcr, distancia_plgcr, observaciones_plgcr,
		// distancia_prmnvs, porcentaje_prmnvs, distancia_prmvs, porcentaje_prmvs,
		// distancia_tmbsl, porcentaje_tmbsl, distancia_rpl, porcentaje_rpl,
		// calidad_praton, calidad_plserv, calidad_grcmtr, calidad_pqcmtr,
		// estado_registro, fecha_registro)
		
		$arregloPeligros = array (
				"id_zona_estudio" => $_REQUEST ['aa'],
				"calado_mxbq" => $_REQUEST ['cal_max_buques'],
				"holgura_bjqll" => $_REQUEST ['hg_bj_quilla'],
				"maxima_olpr" => $_REQUEST ['mx_oleaje_pre'],
				"sedimentacion_mxa" => $_REQUEST ['sd_mx_anual'],
				"profundidad_minsg" => $_REQUEST ['pr_mn_seguridad'],
				"anchura_cnl" => $_REQUEST ['ach_canal'],
				"tasa_mx" => $_REQUEST ['ts_maxima'],
				"observaciones_flmr" => $_REQUEST ['ob_fluj_marea'],
				"prediccion_mxvntr" => $_REQUEST ['pr_maxima'],
				"observaciones_vttr" => $_REQUEST ['ob_temp_dirr'],
				"prediccion_cbm" => $_REQUEST ['pr_maxima_dgl'],
				"observaciones_efcb" => $_REQUEST ['ob_temp_dirr_com'],
				"distancia_pntcr" => $_REQUEST ['pnt_cr_tr'],
				"observaciones_pntcr" => $_REQUEST ['ob_pt_ct_tr'],
				"distancia_plgcr" => $_REQUEST ['prl_max_cr'],
				"observaciones_plgcr" => $_REQUEST ['ob_prl_max_cr'],
				"distancia_prmnvs" => $_REQUEST ['pr_mn_vs'],
				"porcentaje_prmnvs" => $_REQUEST ['prc_mn_vs'],
				"distancia_prmvs" => $_REQUEST ['prd_pr_vs'],
				"porcentaje_prmvs" => $_REQUEST ['pds_pr_vs'],
				"distancia_tmbsl" => $_REQUEST ['tm_bj_sl'],
				"porcentaje_tmbsl" => $_REQUEST ['prc_tm_bj_sl'],
				"distancia_rpl" => $_REQUEST ['prd_respl'],
				"porcentaje_rpl" => $_REQUEST ['prc_prd_respl'],
				"calidad_praton" => $_REQUEST ['pr_aton'],
				"calidad_plserv" => $_REQUEST ['pl_tr_mr'],
				"calidad_grcmtr" => $_REQUEST ['gr_cmp_trp'],
				"calidad_pqcmtr" => $_REQUEST ['pq_cmp_trp'] 
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