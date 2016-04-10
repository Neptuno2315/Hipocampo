<?php

namespace logica\gestion\analisisRiesgos;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

/**
 * IMPORTANTE: Se recomienda que no se borren registros.
 * Utilizar mecanismos para - independiente del motor de bases de datos,
 * poder realizar rollbacks gestionados por el aplicativo.
 */
class Sql extends \Sql {
	var $miConfigurador;
	function getCadenaSql($tipo, $variable = '') {
		
		/**
		 * 1.
		 * Revisar las variables para evitar SQL Injection
		 */
		$prefijo = $this->miConfigurador->getVariableConfiguracion ( "prefijo" );
		$idSesion = $this->miConfigurador->getVariableConfiguracion ( "id_sesion" );
		
		switch ($tipo) {
			
			/**
			 * Clausulas específicas
			 */
			case 'insertarRegistro' :
				$cadenaSql = 'INSERT INTO ';
				$cadenaSql .= $prefijo . 'pagina ';
				$cadenaSql .= '( ';
				$cadenaSql .= 'nombre,';
				$cadenaSql .= 'descripcion,';
				$cadenaSql .= 'modulo,';
				$cadenaSql .= 'nivel,';
				$cadenaSql .= 'parametro';
				$cadenaSql .= ') ';
				$cadenaSql .= 'VALUES ';
				$cadenaSql .= '( ';
				$cadenaSql .= '\'' . $_REQUEST ['nombrePagina'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['descripcionPagina'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['moduloPagina'] . '\', ';
				$cadenaSql .= $_REQUEST ['nivelPagina'] . ', ';
				$cadenaSql .= '\'' . $_REQUEST ['parametroPagina'] . '\'';
				$cadenaSql .= ') ';
				break;
			
			case 'actualizarRegistro' :
				$cadenaSql = 'INSERT INTO ';
				$cadenaSql .= $prefijo . 'pagina ';
				$cadenaSql .= '( ';
				$cadenaSql .= 'nombre,';
				$cadenaSql .= 'descripcion,';
				$cadenaSql .= 'modulo,';
				$cadenaSql .= 'nivel,';
				$cadenaSql .= 'parametro';
				$cadenaSql .= ') ';
				$cadenaSql .= 'VALUES ';
				$cadenaSql .= '( ';
				$cadenaSql .= '\'' . $_REQUEST ['nombrePagina'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['descripcionPagina'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['moduloPagina'] . '\', ';
				$cadenaSql .= $_REQUEST ['nivelPagina'] . ', ';
				$cadenaSql .= '\'' . $_REQUEST ['parametroPagina'] . '\'';
				$cadenaSql .= ') ';
				break;
			
			case 'buscarRegistro' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'id_pagina as PAGINA, ';
				$cadenaSql .= 'nombre as NOMBRE, ';
				$cadenaSql .= 'descripcion as DESCRIPCION,';
				$cadenaSql .= 'modulo as MODULO,';
				$cadenaSql .= 'nivel as NIVEL,';
				$cadenaSql .= 'parametro as PARAMETRO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= $prefijo . 'pagina ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'nombre=\'' . $_REQUEST ['nombrePagina'] . '\' ';
				break;
			
			case 'borrarRegistro' :
				$cadenaSql = 'INSERT INTO ';
				$cadenaSql .= $prefijo . 'pagina ';
				$cadenaSql .= '( ';
				$cadenaSql .= 'nombre,';
				$cadenaSql .= 'descripcion,';
				$cadenaSql .= 'modulo,';
				$cadenaSql .= 'nivel,';
				$cadenaSql .= 'parametro';
				$cadenaSql .= ') ';
				$cadenaSql .= 'VALUES ';
				$cadenaSql .= '( ';
				$cadenaSql .= '\'' . $_REQUEST ['nombrePagina'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['descripcionPagina'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['moduloPagina'] . '\', ';
				$cadenaSql .= $_REQUEST ['nivelPagina'] . ', ';
				$cadenaSql .= '\'' . $_REQUEST ['parametroPagina'] . '\'';
				$cadenaSql .= ') ';
				break;
			
			/*
			 * Consultas para creacion Formulario
			 */
			case 'consultar_escala_douglas' :
				
				$cadenaSql = "SELECT pm.id_parametro id, pm.descripcion valor ";
				$cadenaSql .= "FROM parametros.parametro pm  ";
				$cadenaSql .= "JOIN  parametros.tema_parametros tp ON tp.id_tema_parametro=pm.parametro_tema ";
				$cadenaSql .= "WHERE pm.estado_registro='t'  ";
				$cadenaSql .= "AND  tp.estado_registro='t' ";
				$cadenaSql .= "AND  tp.descripcion='EscalaDouglas' ; ";
				
				break;
			
			case 'consultar_escala_beaufort' :
				
				$cadenaSql = "SELECT pm.id_parametro id, pm.descripcion valor ";
				$cadenaSql .= "FROM parametros.parametro pm  ";
				$cadenaSql .= "JOIN  parametros.tema_parametros tp ON tp.id_tema_parametro=pm.parametro_tema ";
				$cadenaSql .= "WHERE pm.estado_registro='t'  ";
				$cadenaSql .= "AND  tp.estado_registro='t' ";
				$cadenaSql .= "AND  tp.descripcion='EscalaBeaufort' ; ";
				
				break;
			
			case 'consultar_calidad' :
				
				$cadenaSql = "SELECT pm.descripcion id, pm.descripcion_detallada valor ";
				$cadenaSql .= "FROM parametros.parametro pm  ";
				$cadenaSql .= "JOIN  parametros.tema_parametros tp ON tp.id_tema_parametro=pm.parametro_tema ";
				$cadenaSql .= "WHERE pm.estado_registro='t'  ";
				$cadenaSql .= "AND  tp.estado_registro='t' ";
				$cadenaSql .= "AND  tp.descripcion='Calidad' ; ";
				
				break;
			
			case 'consultar_iluminacion_fondo' :
				
				$cadenaSql = "SELECT pm.id_parametro id, pm.descripcion valor ";
				$cadenaSql .= "FROM parametros.parametro pm  ";
				$cadenaSql .= "JOIN  parametros.tema_parametros tp ON tp.id_tema_parametro=pm.parametro_tema ";
				$cadenaSql .= "WHERE pm.estado_registro='t'  ";
				$cadenaSql .= "AND  tp.estado_registro='t' ";
				$cadenaSql .= "AND  tp.descripcion='IluminacionFondo' ; ";
				
				break;
			
			case 'consultar_tipo_fondo_marino' :
				
				$cadenaSql = "SELECT pm.id_parametro id, pm.descripcion valor ";
				$cadenaSql .= "FROM parametros.parametro pm  ";
				$cadenaSql .= "JOIN  parametros.tema_parametros tp ON tp.id_tema_parametro=pm.parametro_tema ";
				$cadenaSql .= "WHERE pm.estado_registro='t'  ";
				$cadenaSql .= "AND  tp.estado_registro='t' ";
				$cadenaSql .= "AND  tp.descripcion='FondosMarinos' ; ";
				
				break;
			
			case 'consultar_estabilidad_sedimentación' :
				
				$cadenaSql = "SELECT pm.id_parametro id, pm.descripcion valor ";
				$cadenaSql .= "FROM parametros.parametro pm  ";
				$cadenaSql .= "JOIN  parametros.tema_parametros tp ON tp.id_tema_parametro=pm.parametro_tema ";
				$cadenaSql .= "WHERE pm.estado_registro='t'  ";
				$cadenaSql .= "AND  tp.estado_registro='t' ";
				$cadenaSql .= "AND  tp.descripcion='TasaSedimentacion' ; ";
				
				break;
			
			case 'consultar_region' :
				$cadenaSql = "SELECT id_region, descripcion ";
				$cadenaSql .= "FROM region ";
				$cadenaSql .= "WHERE estado_registro='t';";
				break;
			
			case 'consultar_sector' :
				$cadenaSql = "SELECT id_sector id, descripcion valor ";
				$cadenaSql .= "FROM sector  ";
				$cadenaSql .= "WHERE estado_registro='t'  ";
				$cadenaSql .= "AND id_region ='" . $variable . "';";
				break;
			
			case 'consultar_periodo' :
				$cadenaSql = "SELECT pm.id_parametro id, pm.descripcion valor ";
				$cadenaSql .= "FROM parametros.parametro pm  ";
				$cadenaSql .= "JOIN  parametros.tema_parametros tp ON tp.id_tema_parametro=pm.parametro_tema ";
				$cadenaSql .= "WHERE pm.estado_registro='t'  ";
				$cadenaSql .= "AND  tp.estado_registro='t' ";
				$cadenaSql .= "AND  tp.descripcion='CaracterizacionPeriodoTiempo' ; ";
				
				break;
			
			case 'consultar_Operaciones_Noche_Dia' :
				$cadenaSql = "SELECT pm.id_parametro id, pm.descripcion valor ";
				$cadenaSql .= "FROM parametros.parametro pm  ";
				$cadenaSql .= "JOIN  parametros.tema_parametros tp ON tp.id_tema_parametro=pm.parametro_tema ";
				$cadenaSql .= "WHERE pm.estado_registro='t'  ";
				$cadenaSql .= "AND  tp.estado_registro='t' ";
				$cadenaSql .= "AND  tp.descripcion='OperacionesNocheDia' ; ";
				
				break;
			
			/*
			 * Sentenias de Registro de Informacion
			 */
			
			case 'registrar_zona_estudio' :
				$cadenaSql = " INSERT INTO zona_estudio(id_sector, titulo_proy, profundidad_qll, ancho_canl,  ";
				$cadenaSql .= "obtrucciones_vs, complejidad_hdr, tipo_fn, estabilidad_sed, ayudas_nv, ";
				$cadenaSql .= "calidad_dthd, operaciones_ddn, estado_mr, observaciones_vncr, ";
				$cadenaSql .= "restricciones_vs, condiciones_hl, iluminacion_fn, observaciones_scm, monitoreo_stm) ";
				$cadenaSql .= "VALUES (";
				$cadenaSql .= "'" . $variable ['id_sector'] . "',";
				$cadenaSql .= "'" . $variable ['titulo_proy'] . "',";
				$cadenaSql .= "'" . $variable ['profundidad_qll'] . "',";
				$cadenaSql .= "'" . $variable ['ancho_canl'] . "',";
				$cadenaSql .= "'" . $variable ['obtrucciones_vs'] . "',";
				$cadenaSql .= "'" . $variable ['complejidad_hdr'] . "',";
				$cadenaSql .= "'" . $variable ['tipo_fn'] . "',";
				$cadenaSql .= "'" . $variable ['estabilidad_sed'] . "',";
				$cadenaSql .= "'" . $variable ['ayudas_nv'] . "',";
				$cadenaSql .= "'" . $variable ['calidad_dthd'] . "',";
				$cadenaSql .= "'" . $variable ['operaciones_ddn'] . "',";
				$cadenaSql .= "'" . $variable ['estado_mr'] . "',";
				$cadenaSql .= ($variable ['observaciones_vncr'] != '') ? "'" . $variable ['observaciones_vncr'] . "'," : "NULL,";
				$cadenaSql .= "'" . $variable ['restricciones_vs'] . "',";
				$cadenaSql .= "'" . $variable ['condiciones_hl'] . "',";
				$cadenaSql .= "'" . $variable ['iluminacion_fn'] . "',";
				$cadenaSql .= ($variable ['observaciones_scm'] != '') ? "'" . $variable ['observaciones_scm'] . "'," : "NULL,";
				$cadenaSql .= ($variable ['monitoreo_stm'] != '') ? "'" . $variable ['monitoreo_stm'] . "');" : "NULL);";
				break;
			
			case "registrar_trafico_maritimo" :
				$cadenaSql = " INSERT INTO trafico(id_zona_estudio, variable_trf, numero_bq, periodo_trf) ";
				$cadenaSql .= "VALUES (";
				$cadenaSql .= "(SELECT MAX (id_zona_estudio) FROM zona_estudio),";
				$cadenaSql .= "'" . $variable ['variable'] . "',";
				$cadenaSql .= "'" . $variable ['numero_buques'] . "',";
				$cadenaSql .= "'" . $variable ['periodo'] . "');";
				
				break;
			
			case 'registrar_informacion_carta_nautica' :
				$cadenaSql = " INSERT INTO informacion_carta_nautica(id_zona_estudio, boyas_ais, boyas_nais, ";
				$cadenaSql .= " racon_num, linternas_num, otras_aton, proporciona_dgps, disponibilidad_stm,disponible_servpl, observaciones) ";
				$cadenaSql .= "VALUES (";
				$cadenaSql .= "(SELECT MAX (id_zona_estudio) FROM zona_estudio),";
				$cadenaSql .= "'" . $variable ['boyas_ais'] . "',";
				$cadenaSql .= "'" . $variable ['boyas_nais'] . "',";
				$cadenaSql .= "'" . $variable ['racon_num'] . "',";
				$cadenaSql .= "'" . $variable ['linternas_num'] . "',";
				$cadenaSql .= "'" . $variable ['otras_aton'] . "',";
				$cadenaSql .= "'" . $variable ['proporciona_dgps'] . "',";
				$cadenaSql .= "'" . $variable ['disponibilidad_stm'] . "',";
				$cadenaSql .= "'" . $variable ['disponible_servpl'] . "',";
				$cadenaSql .= ($variable ['observaciones'] != '') ? "'" . $variable ['observaciones'] . "');" : "NULL);";
				
				break;
			
			case 'registrar_peligros' :
				$cadenaSql = "  INSERT INTO peligros(id_zona_estudio,calado_mxbq, holgura_bjqll, maxima_olpr, ";
				$cadenaSql .= " sedimentacion_mxa, profundidad_minsg, anchura_cnl, tasa_mx, observaciones_flmr, ";
				$cadenaSql .= " prediccion_mxvntr, observaciones_vttr, prediccion_cbm, observaciones_efcb, ";
				$cadenaSql .= " distancia_pntcr, observaciones_pntcr, distancia_plgcr, observaciones_plgcr, ";
				$cadenaSql .= "  distancia_prmnvs, porcentaje_prmnvs, distancia_prmvs, porcentaje_prmvs, ";
				$cadenaSql .= " distancia_tmbsl, porcentaje_tmbsl, distancia_rpl, porcentaje_rpl, ";
				$cadenaSql .= " calidad_praton, calidad_plserv, calidad_grcmtr, calidad_pqcmtr) ";
				$cadenaSql .= "VALUES (";
				$cadenaSql .= "(SELECT MAX (id_zona_estudio) FROM zona_estudio),";
				$cadenaSql .= "'" . $variable ['calado_mxbq'] . "',";
				$cadenaSql .= "'" . $variable ['holgura_bjqll'] . "',";
				$cadenaSql .= "'" . $variable ['maxima_olpr'] . "',";
				$cadenaSql .= "'" . $variable ['sedimentacion_mxa'] . "',";
				$cadenaSql .= "'" . $variable ['profundidad_minsg'] . "',";
				$cadenaSql .= "'" . $variable ['anchura_cnl'] . "',";
				$cadenaSql .= "'" . $variable ['tasa_mx'] . "',";
				$cadenaSql .= ($variable ['observaciones_flmr'] != '') ? "'" . $variable ['observaciones_flmr'] . "'," : "NULL,";
				$cadenaSql .= "'" . $variable ['prediccion_mxvntr'] . "',";
				$cadenaSql .= ($variable ['observaciones_vttr'] != '') ? "'" . $variable ['observaciones_vttr'] . "'," : "NULL,";
				$cadenaSql .= "'" . $variable ['prediccion_cbm'] . "',";
				$cadenaSql .= ($variable ['observaciones_efcb'] != '') ? "'" . $variable ['observaciones_efcb'] . "'," : "NULL,";
				$cadenaSql .= "'" . $variable ['distancia_pntcr'] . "',";
				$cadenaSql .= ($variable ['observaciones_pntcr'] != '') ? "'" . $variable ['observaciones_pntcr'] . "'," : "NULL,";
				$cadenaSql .= "'" . $variable ['distancia_plgcr'] . "',";
				$cadenaSql .= ($variable ['observaciones_plgcr'] != '') ? "'" . $variable ['observaciones_plgcr'] . "'," : "NULL,";
				$cadenaSql .= "'" . $variable ['distancia_prmnvs'] . "',";
				$cadenaSql .= "'" . $variable ['porcentaje_prmnvs'] . "',";
				$cadenaSql .= "'" . $variable ['distancia_prmvs'] . "',";
				$cadenaSql .= "'" . $variable ['porcentaje_prmvs'] . "',"; //
				$cadenaSql .= "'" . $variable ['distancia_tmbsl'] . "',";
				$cadenaSql .= "'" . $variable ['porcentaje_tmbsl'] . "',";
				$cadenaSql .= "'" . $variable ['distancia_rpl'] . "',";
				$cadenaSql .= "'" . $variable ['porcentaje_rpl'] . "',";
				$cadenaSql .= "'" . $variable ['calidad_praton'] . "',";
				$cadenaSql .= "'" . $variable ['calidad_plserv'] . "',";
				$cadenaSql .= "'" . $variable ['calidad_grcmtr'] . "',";
				$cadenaSql .= "'" . $variable ['calidad_pqcmtr'] . "');";
				
				break;
			
			/*
			 * Sentencias Consulta Información
			 */
			
			case 'consultar_titulos_zonas' :
				$cadenaSql = "SELECT id_zona_estudio AS data , titulo_proy AS  value  ";
				$cadenaSql .= " FROM zona_estudio ";
				$cadenaSql .= "WHERE cast(titulo_proy as text) ILIKE '%" . $variable . "%' ";
				$cadenaSql .= "AND estado_registro=TRUE ";
				$cadenaSql .= "LIMIT 10; ";
				
				break;
			
			case 'consulta_zonas_estudio' :
				
				$cadenaSql = "SELECT zn.id_zona_estudio, sec.descripcion sector ,rgn.descripcion region, zn.titulo_proy,zn.fecha_registro ";
				$cadenaSql .= "FROM zona_estudio zn ";
				$cadenaSql .= "JOIN sector sec ON sec.id_sector=zn.id_sector AND sec.estado_registro=TRUE ";
				$cadenaSql .= "JOIN region rgn ON rgn.id_region= sec.id_region AND sec.estado_registro=TRUE ";
				$cadenaSql .= "WHERE zn.estado_registro=TRUE  ";
				if ($variable ['region'] != '') {
					$cadenaSql .= " AND rgn.id_region = '" . $variable ['region'] . "' ";
				}
				
				if ($variable ['sector'] != '') {
					$cadenaSql .= " AND sec.id_sector = '" . $variable ['sector'] . "' ";
				}
				
				if ($variable ['zona_estudio'] != '') {
					$cadenaSql .= " AND  zn.id_zona_estudio= '" . $variable ['zona_estudio'] . "' ";
				}
				
				if ($variable ['fecha_inicial'] != '') {
					$cadenaSql .= " AND zn.fecha_registro BETWEEN CAST ( '" . $variable ['fecha_inicial'] . "' AS DATE) ";
					$cadenaSql .= " AND  CAST ( '" . $variable ['fecha_final'] . "' AS DATE)  ";
				}
				
				break;
			
			/*
			 * Sentencias Modificación Información
			 */
			
			case 'consultar_general_por_zona' :
				
				$cadenaSql = "SELECT zn.*,id_peligros,  calado_mxbq, holgura_bjqll, maxima_olpr, 
						       sedimentacion_mxa, profundidad_minsg, anchura_cnl, tasa_mx, observaciones_flmr, 
						       prediccion_mxvntr, observaciones_vttr, prediccion_cbm, observaciones_efcb, 
						       distancia_pntcr, observaciones_pntcr, distancia_plgcr, observaciones_plgcr, 
						       distancia_prmnvs, porcentaje_prmnvs, distancia_prmvs, porcentaje_prmvs, 
						       distancia_tmbsl, porcentaje_tmbsl, distancia_rpl, porcentaje_rpl, 
						       calidad_praton, calidad_plserv, calidad_grcmtr, calidad_pqcmtr,id_inf_carta_nautica, boyas_ais, boyas_nais, 
						       racon_num, linternas_num, otras_aton, proporciona_dgps, disponibilidad_stm, 
						       disponible_servpl, observaciones,sec.id_sector sector, sec.id_region region ";
				$cadenaSql .= "FROM zona_estudio zn ";
				$cadenaSql .= "JOIN sector sec ON sec.id_sector=zn.id_sector ";
				$cadenaSql .= "JOIN peligros pl ON pl.id_zona_estudio=zn.id_zona_estudio ";
				$cadenaSql .= "JOIN informacion_carta_nautica ic ON ic.id_zona_estudio=zn.id_zona_estudio ";
				$cadenaSql .= "WHERE zn.id_zona_estudio='" . $variable . "' ;";
				break;
			
			case 'consultar_general_trafico_por_zona' :
				$cadenaSql = "SELECT id_trafico, id_zona_estudio, variable_trf, numero_bq, periodo_trf ";
				$cadenaSql .= "FROM trafico ";
				$cadenaSql .= "WHERE estado_registro='TRUE' ";
				$cadenaSql .= "AND id_zona_estudio='" . $variable . "' ;";
				
				break;
			
			case 'actualizar_zona_estudio' :
				$cadenaSql = " UPDATE zona_estudio";
				$cadenaSql .= " SET ";
				$cadenaSql .= " id_sector='" . $variable ['id_sector'] . "',";
				$cadenaSql .= " titulo_proy='" . $variable ['titulo_proy'] . "',";
				$cadenaSql .= " profundidad_qll='" . $variable ['profundidad_qll'] . "', ";
				$cadenaSql .= " ancho_canl='" . $variable ['ancho_canl'] . "',";
				$cadenaSql .= " obtrucciones_vs='" . $variable ['obtrucciones_vs'] . "', ";
				$cadenaSql .= " complejidad_hdr='" . $variable ['complejidad_hdr'] . "',";
				$cadenaSql .= " tipo_fn='" . $variable ['tipo_fn'] . "', ";
				$cadenaSql .= " estabilidad_sed='" . $variable ['estabilidad_sed'] . "', ";
				$cadenaSql .= " ayudas_nv='" . $variable ['ayudas_nv'] . "',";
				$cadenaSql .= " calidad_dthd='" . $variable ['calidad_dthd'] . "',";
				$cadenaSql .= " operaciones_ddn='" . $variable ['operaciones_ddn'] . "', ";
				$cadenaSql .= " estado_mr='" . $variable ['estado_mr'] . "', ";
				$cadenaSql .= " observaciones_vncr='" . $variable ['observaciones_vncr'] . "',";
				$cadenaSql .= " restricciones_vs='" . $variable ['restricciones_vs'] . "', ";
				$cadenaSql .= " condiciones_hl='" . $variable ['condiciones_hl'] . "', ";
				$cadenaSql .= " iluminacion_fn='" . $variable ['iluminacion_fn'] . "',";
				$cadenaSql .= " observaciones_scm='" . $variable ['observaciones_scm'] . "',";
				$cadenaSql .= " monitoreo_stm='" . $variable ['monitoreo_stm'] . "' ";
				$cadenaSql .= " WHERE id_zona_estudio='" . $variable ['id_zona_estudio'] . "';";
				
				break;
			
			case 'anular_trafico_maritimo' :
				
				$cadenaSql = " UPDATE trafico";
				$cadenaSql .= " SET estado_registro=FALSE ";
				$cadenaSql .= " WHERE id_zona_estudio='" . $variable . "';";
				break;
			
			case 'actualizar_informacion_carta_nautica' :
				
				$cadenaSql = " UPDATE informacion_carta_nautica";
				$cadenaSql .= " SET  ";
				$cadenaSql .= " boyas_ais='" . $variable ['boyas_ais'] . "',";
				$cadenaSql .= " boyas_nais='" . $variable ['boyas_nais'] . "', ";
				$cadenaSql .= " racon_num='" . $variable ['racon_num'] . "',";
				$cadenaSql .= " linternas_num='" . $variable ['linternas_num'] . "',";
				$cadenaSql .= " otras_aton='" . $variable ['otras_aton'] . "',";
				$cadenaSql .= " proporciona_dgps='" . $variable ['proporciona_dgps'] . "', ";
				$cadenaSql .= " disponibilidad_stm='" . $variable ['disponibilidad_stm'] . "',";
				$cadenaSql .= " disponible_servpl='" . $variable ['disponible_servpl'] . "',";
				$cadenaSql .= " observaciones='" . $variable ['observaciones'] . "' ";
				$cadenaSql .= " WHERE id_zona_estudio='" . $variable ['id_zona_estudio'] . "' ";
				$cadenaSql .= " AND estado_registro=TRUE ;";
				break;
			
			case 'actualizar_peligros' :
				$cadenaSql = " UPDATE peligros";
				$cadenaSql .= " SET ";
				$cadenaSql .= " calado_mxbq='" . $variable ['calado_mxbq'] . "',";
				$cadenaSql .= " holgura_bjqll='" . $variable ['holgura_bjqll'] . "', ";
				$cadenaSql .= " maxima_olpr='" . $variable ['maxima_olpr'] . "',";
				$cadenaSql .= " sedimentacion_mxa='" . $variable ['sedimentacion_mxa'] . "',";
				$cadenaSql .= " profundidad_minsg='" . $variable ['profundidad_minsg'] . "',";
				$cadenaSql .= " anchura_cnl='" . $variable ['anchura_cnl'] . "', ";
				$cadenaSql .= " tasa_mx='" . $variable ['tasa_mx'] . "',";
				$cadenaSql .= " observaciones_flmr='" . $variable ['observaciones_flmr'] . "',";
				$cadenaSql .= " prediccion_mxvntr='" . $variable ['prediccion_mxvntr'] . "',";
				$cadenaSql .= " observaciones_vttr='" . $variable ['observaciones_vttr'] . "', ";
				$cadenaSql .= " prediccion_cbm='" . $variable ['prediccion_cbm'] . "',";
				$cadenaSql .= " observaciones_efcb='" . $variable ['observaciones_efcb'] . "',";
				$cadenaSql .= " distancia_pntcr='" . $variable ['distancia_pntcr'] . "',";
				$cadenaSql .= " observaciones_pntcr='" . $variable ['observaciones_pntcr'] . "', ";
				$cadenaSql .= " distancia_plgcr='" . $variable ['distancia_plgcr'] . "',";
				$cadenaSql .= " observaciones_plgcr='" . $variable ['observaciones_plgcr'] . "',";
				$cadenaSql .= " distancia_prmnvs='" . $variable ['distancia_prmnvs'] . "', ";
				$cadenaSql .= " porcentaje_prmnvs='" . $variable ['porcentaje_prmnvs'] . "',";
				$cadenaSql .= " distancia_prmvs='" . $variable ['distancia_prmvs'] . "',";
				$cadenaSql .= " porcentaje_prmvs='" . $variable ['porcentaje_prmvs'] . "',";
				$cadenaSql .= " distancia_tmbsl='" . $variable ['distancia_tmbsl'] . "', ";
				$cadenaSql .= " porcentaje_tmbsl='" . $variable ['porcentaje_tmbsl'] . "', ";
				$cadenaSql .= " distancia_rpl='" . $variable ['distancia_rpl'] . "',";
				$cadenaSql .= " porcentaje_rpl='" . $variable ['porcentaje_rpl'] . "',";
				$cadenaSql .= " calidad_praton='" . $variable ['calidad_praton'] . "', ";
				$cadenaSql .= " calidad_plserv='" . $variable ['calidad_plserv'] . "', ";
				$cadenaSql .= " calidad_grcmtr='" . $variable ['calidad_grcmtr'] . "', ";
				$cadenaSql .= " calidad_pqcmtr='" . $variable ['calidad_pqcmtr'] . "' ";
				$cadenaSql .= " WHERE id_zona_estudio='" . $variable ['id_zona_estudio'] . "' ";
				$cadenaSql .= " AND estado_registro=TRUE ";
				
				break;
			
			/*
			 * Sentencias para deshabilitar Información Zona de Estudio
			 */
			
			case 'eliminar_zona_estudio' :
				$cadenaSql = " UPDATE zona_estudio ";
				$cadenaSql .= " SET estado_registro=FALSE ";
				$cadenaSql .= " WHERE id_zona_estudio='" . $variable . "';";
				
				break;
			
			case 'eliminar_peligros' :
				
				$cadenaSql = " UPDATE peligros ";
				$cadenaSql .= " SET estado_registro=FALSE ";
				$cadenaSql .= " WHERE id_zona_estudio='" . $variable . "';";
				
				break;
			
			case 'eliminar_info_carta_nautica' :
				
				$cadenaSql = " UPDATE informacion_carta_nautica ";
				$cadenaSql .= " SET estado_registro=FALSE ";
				$cadenaSql .= " WHERE id_zona_estudio='" . $variable . "';";
				
				break;
		}
		
		return $cadenaSql;
	}
}
?>
