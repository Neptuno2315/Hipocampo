<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class registrarForm {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miSql;
	function __construct($lenguaje, $formulario, $sql) {
		$this->miConfigurador = \Configurador::singleton ();
		
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		
		$this->lenguaje = $lenguaje;
		
		$this->miFormulario = $formulario;
		
		$this->miSql = $sql;
	}
	function miForm() {
		
		/**
		 * IMPORTANTE: Este formulario está utilizando jquery.
		 * Por tanto en el archivo ready.php se delaran algunas funciones js
		 * que lo complementan.
		 */
		// Rescatar los datos de este bloque
		$conexion = "logica";
		
		$esteRecursoDBLG = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$esteRecursoDBP = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
		/*
		 * Consultar Información Para Modificar Zona de Estudio
		 */
		{
			$cadenaSql = $this->miSql->getCadenaSql ( "consultar_general_por_zona", $_REQUEST ['id_zona'] );
			$informacion = $esteRecursoDBLG->ejecutarAcceso ( $cadenaSql, "busqueda" );
			$informacion = $informacion [0];
			
			$arreglo_zona = array (
					"region" => $informacion ['region'],
					"sector" => $informacion ['id_sector'],
					"nombre_pry" => $informacion ['titulo_proy'],
					"pr_co_ba" => $informacion ['profundidad_qll'],
					"ancho_canal" => $informacion ['ancho_canl'],
					"obtrucciones_visibilidad" => $informacion ['obtrucciones_vs'],
					"complejidad_hidrovia" => $informacion ['complejidad_hdr'],
					"tipo_fondo" => $informacion ['tipo_fn'],
					"estabilidad_sedimentos" => $informacion ['estabilidad_sed'],
					"ayudas_navegacion" => $informacion ['ayudas_nv'],
					"calidad_datos" => $informacion ['calidad_dthd'],
					"opera_nc_di" => $informacion ['operaciones_ddn'],
					"estado_mar" => $informacion ['estado_mr'],
					"obser_des__vi_mr" => $informacion ['observaciones_vncr'],
					"visibilidad" => $informacion ['restricciones_vs'],
					"con_hielo" => ($informacion ['condiciones_hl'] != 'f') ? 1 : 0,
					"ilum_fondo" => $informacion ['iluminacion_fn'],
					"obser_escom" => $informacion ['observaciones_scm'],
					"mn_stm" => $informacion ['monitoreo_stm'],
					"bo_mo_for_re" => $informacion ['boyas_ais'],
					"bo_si_ais_no_super" => $informacion ['boyas_nais'],
					"racon" => $informacion ['racon_num'],
					"linterna" => $informacion ['linternas_num'],
					"ort_aton" => $informacion ['otras_aton'],
					"g_gps" => ($informacion ['proporciona_dgps'] != 'f') ? 1 : 0,
					"ds_stm" => ($informacion ['disponibilidad_stm'] != 'f') ? 1 : 0,
					"ds_srv_pl" => ($informacion ['disponible_servpl'] != 'f') ? 1 : 0,
					"obser_des__sis_sn" => $informacion ['observaciones'], // ----
					"cal_max_buques" => $informacion ['calado_mxbq'],
					"hg_bj_quilla" => $informacion ['holgura_bjqll'],
					"mx_oleaje_pre" => $informacion ['maxima_olpr'],
					"sd_mx_anual" => $informacion ['sedimentacion_mxa'],
					"pr_mn_seguridad" => $informacion ['profundidad_minsg'],
					"ach_canal" => $informacion ['anchura_cnl'],
					"ts_maxima" => $informacion ['tasa_mx'],
					"ob_fluj_marea" => $informacion ['observaciones_flmr'],
					"pr_maxima" => $informacion ['prediccion_mxvntr'],
					"ob_temp_dirr" => $informacion ['observaciones_vttr'],
					"pr_maxima_dgl" => $informacion ['prediccion_cbm'],
					"ob_temp_dirr_com" => $informacion ['observaciones_efcb'],
					"pnt_cr_tr" => $informacion ['distancia_pntcr'],
					"ob_pt_ct_tr" => $informacion ['observaciones_pntcr'],
					"prl_max_cr" => $informacion ['distancia_plgcr'],
					"ob_prl_max_cr" => $informacion ['observaciones_plgcr'],
					"pr_mn_vs" => $informacion ['distancia_prmnvs'],
					"prc_mn_vs" => $informacion ['porcentaje_prmnvs'],
					"prd_pr_vs" => $informacion ['distancia_prmvs'],
					"pds_pr_vs" => $informacion ['porcentaje_prmvs'],
					"tm_bj_sl" => $informacion ['distancia_tmbsl'],
					"prc_tm_bj_sl" => $informacion ['porcentaje_tmbsl'],
					"prd_respl" => $informacion ['distancia_rpl'],
					"prc_prd_respl" => $informacion ['porcentaje_rpl'],
					"pr_aton" => $informacion ['calidad_praton'],
					"pl_tr_mr" => $informacion ['calidad_plserv'],
					"gr_cmp_trp" => $informacion ['calidad_grcmtr'],
					"pq_cmp_trp" => $informacion ['calidad_pqcmtr'] 
			);
			// ,
			
			$_REQUEST = array_merge ( $_REQUEST, $arreglo_zona );
			// var_dump ( $arreglo_zona );
			
			$cadenaSql = $this->miSql->getCadenaSql ( "consultar_general_trafico_por_zona", $_REQUEST ['id_zona'] );
			$trafico = $esteRecursoDBLG->ejecutarAcceso ( $cadenaSql, "busqueda" );
			
			if ($trafico != false) {
				
				$arregloPreTrafico = array (
						'rango1BC',
						'tiempo1BC',
						'rango2BC',
						'tiempo2BC',
						'rango3BC',
						'tiempo3BC',
						'rango1BE',
						'tiempo1BE',
						'rango2BE',
						'tiempo2BE',
						'rango1BP',
						'tiempo1BP',
						'rango2BP',
						'tiempo2BP',
						'rango3BP',
						'tiempo3BP',
						'rango1BG',
						'tiempo1BG',
						'rango2BG',
						'tiempo2BG',
						'rango1BPQ',
						'tiempo1BPQ',
						'rango1SM',
						'tiempo1SM',
						'rango2SM',
						'tiempo2SM',
						'rango3SM',
						'tiempo3SM',
						'rango4SM',
						'tiempo4SM',
						'rango5SM',
						'tiempo5SM',
						'rango1AA',
						'tiempo1AA',
						'rango2AA',
						'tiempo2AA',
						'rango3AA',
						'tiempo3AA',
						'rango4AA',
						'tiempo4AA',
						'num_bq_gr',
						'tiempo_bq_gr',
						'num_bq_pq',
						'tiempo_bq_pq' 
				);
				$conrador = 1;
				
				for($contador = 0; $contador <= (count ( $arregloPreTrafico ) - 1); $contador ++) {
					
					foreach ( $trafico as $valor ) {
						if ($valor ['variable_trf'] == $arregloPreTrafico [$contador]) {
							
							$_REQUEST [$valor ['variable_trf']] = $valor ['numero_bq'];
							$_REQUEST [$arregloPreTrafico [$contador + 1]] = $valor ['periodo_trf'];
						}
					}
				}
			}
		}
		
		// ---------------- SECCION: Parámetros Globales del Formulario ----------------------------------
		/**
		 * Atributos que deben ser aplicados a todos los controles de este formulario.
		 * Se utiliza un arreglo
		 * independiente debido a que los atributos individuales se reinician cada vez que se declara un campo.
		 *
		 * Si se utiliza esta técnica es necesario realizar un mezcla entre este arreglo y el específico en cada control:
		 * $atributos= array_merge($atributos,$atributosGlobales);
		 */
		$atributosGlobales ['campoSeguro'] = 'true';
		$_REQUEST ['tiempo'] = time ();
		
		// -------------------------------------------------------------------------------------------------
		// ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------
		$esteCampo = $esteBloque ['nombre'];
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;
		
		// Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
		$atributos ['tipoFormulario'] = 'multipart/form-data';
		
		// Si no se coloca, entonces toma el valor predeterminado 'POST'
		$atributos ['metodo'] = 'POST';
		
		// Si no se coloca, entonces toma el valor predeterminado 'index.php' (Recomendado)
		$atributos ['action'] = 'index.php';
		$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo );
		
		// Si no se coloca, entonces toma el valor predeterminado.
		$atributos ['estilo'] = '';
		$atributos ['marco'] = true;
		$tab = 1;
		// ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
		// ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
		$atributos ['tipoEtiqueta'] = 'inicio';
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->formulario ( $atributos );
		
		// $esteCampo = "marcoDatosBasicos";
		// $atributos ['id'] = $esteCampo;
		// $atributos ["estilo"] = "jqueryui";
		// $atributos ['tipoEtiqueta'] = 'inicio';
		// $atributos ["leyenda"] = "Modificar Proyecto de la Zona de Estudio : " . $_REQUEST ['titulo_proyecto'];
		// echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
		// unset ( $atributos );
		
		// {
		
		// }
		
		// echo $this->miFormulario->marcoAgrupacion ( 'fin' );
		// unset ( $atributos );
		
		// ------------------Division para los botones-------------------------
		$atributos ["id"] = "MarcoDatos";
		$atributos ["estilo"] = "marcoBotones";
		echo $this->miFormulario->division ( "inicio", $atributos );
		{
			
			$mostrarHtml = "<center>
								<table id='tabla_datos_riesgos'>
								</table>
						        <div id='barra_herramientas'>
					            </div>
							</center>";
			echo $mostrarHtml;
			
			// -----------------FIN CONTROL: Botón -----------------------------------------------------------
		}
		// ------------------Fin Division para los botones-------------------------
		echo $this->miFormulario->division ( "fin" );
		unset ( $atributos );
		
		// ------------------- SECCION: Paso de variables ------------------------------------------------
		
		/**
		 * En algunas ocasiones es útil pasar variables entre las diferentes páginas.
		 * SARA permite realizar esto a través de tres
		 * mecanismos:
		 * (a). Registrando las variables como variables de sesión. Estarán disponibles durante toda la sesión de usuario. Requiere acceso a
		 * la base de datos.
		 * (b). Incluirlas de manera codificada como campos de los formularios. Para ello se utiliza un campo especial denominado
		 * formsara, cuyo valor será una cadena codificada que contiene las variables.
		 * (c) a través de campos ocultos en los formularios. (deprecated)
		 */
		// En este formulario se utiliza el mecanismo (b) para pasar las siguientes variables:
		// Paso 1: crear el listado de variables
		
		$valorCodificado = "action=" . $esteBloque ["nombre"];
		$valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		$valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
		$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
		$valorCodificado .= "&usuario=" . $_REQUEST ["usuario"];
		$valorCodificado .= "&opcion=ModificarInformacionZona";
		$valorCodificado .= "&usuario=" . $_REQUEST ['usuario'];
		$valorCodificado .= "&id_zona=" . $_REQUEST ['id_zona'];
		/*
		 * SARA permite que los nombres de los campos sean dinámicos.
		 * Para ello utiliza la hora en que es creado el formulario para
		 * codificar el nombre de cada campo.
		 */
		$valorCodificado .= "&campoSeguro=" . $_REQUEST ['tiempo'];
		/*
		 * Sara permite validar los campos en el formulario o funcion destino.
		 * Para ello se envía los datos atributos["validadar"] de los componentes del formulario
		 * Estos se pueden obtener en el atributo $this->miFormulario->validadorCampos del formulario
		 * La función $this->miFormulario->codificarCampos() codifica automáticamente el atributo validadorCampos
		 */
		$valorCodificado .= "&validadorCampos=" . $this->miFormulario->codificarCampos ();
		
		// Paso 2: codificar la cadena resultante
		$valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $valorCodificado );
		
		$atributos ["id"] = "formSaraData"; // No cambiar este nombre
		$atributos ["tipo"] = "hidden";
		$atributos ['estilo'] = '';
		$atributos ["obligatorio"] = false;
		$atributos ['marco'] = true;
		$atributos ["etiqueta"] = "";
		$atributos ["valor"] = $valorCodificado;
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		
		// ----------------FIN SECCION: Paso de variables -------------------------------------------------
		// ---------------- FIN SECCION: Controles del Formulario -------------------------------------------
		// ----------------FINALIZAR EL FORMULARIO ----------------------------------------------------------
		// Se debe declarar el mismo atributo de marco con que se inició el formulario.
		$atributos ['marco'] = true;
		$atributos ['tipoEtiqueta'] = 'fin';
		echo $this->miFormulario->formulario ( $atributos );
		
		return true;
	}
}
$miSeleccionador = new registrarForm ( $this->lenguaje, $this->miFormulario, $this->sql );
$miSeleccionador->miForm ();
?>		