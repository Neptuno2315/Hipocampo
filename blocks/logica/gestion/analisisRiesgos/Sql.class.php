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
			
			/*
			 * Consultas para creacion Formulario
			 */
			
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
			
			/*
			 * Sentenias de Registro de Informacion
			 */
			
			case 'registrar_variables_temporales' :
				$cadenaSql = " INSERT INTO riesgo_temporal(id_zona_estudio, tema, variable,token)  ";
				$cadenaSql .= "VALUES (";
				$cadenaSql .= "'" . $variable ['zona'] . "',";
				$cadenaSql .= "'" . $variable ['abreviatura'] . "',";
				$cadenaSql .= "'" . $variable ['variable'] . "',";
				$cadenaSql .= "'" . $variable ['token'] . "');";
				
				break;
			
			/*
			 * Limpiar Tabla Temporal
			 */
			
			case 'limpiar_variables_temporales' :
				$cadenaSql = " DELETE FROM riesgo_temporal  ";
				$cadenaSql .= "WHERE id_zona_estudio='" . $variable . "'; ";
				
				break;
			
			/*
			 * Sentencias Consulta Información
			 */
			
			case 'consultar_parametros_utilizar' :
				
				$cadenaSql = "SELECT tp.abreviatura,pm.descripcion variable ";
				$cadenaSql .= "FROM  parametro pm  ";
				$cadenaSql .= "JOIN  tema_parametros tp ON tp.id_tema_parametro=pm.parametro_tema AND  tp.estado_registro='t' ";
				$cadenaSql .= "WHERE pm.estado_registro='t'  ";
				$cadenaSql .= "AND  tp.id_tema_parametro >= 9 ";
				$cadenaSql .= "AND  tp.id_tema_parametro <= 12; ";
				
				break;
			
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
