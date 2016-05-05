<?php

namespace logica\gestion\informeRiesgos;

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
			
			case 'consultar_aton_zona' :
				$cadenaSql = "	SELECT  boyas_ais, boyas_nais,racon_num, linternas_num, otras_aton ";
				$cadenaSql .= "FROM informacion_carta_nautica  ";
				$cadenaSql .= "WHERE estado_registro=TRUE  ";
				$cadenaSql .= "AND id_zona_estudio ='" . $variable . "';";
				break;
			
			/*
			 * Sentenias de Registro de Informacion
			 */
			
			case 'registrar_recomendacion' :
				
				$cadenaSql = " INSERT INTO recomendacion(id_zona_estudio, riesgo, acciones_prv, senalizacion_ext)  ";
				$cadenaSql .= "VALUES (";
				$cadenaSql .= "'" . $variable ['id_zona_estudio'] . "',";
				$cadenaSql .= "'" . $variable ['riesgo'] . "',";
				$cadenaSql .= "'" . $variable ['acciones_prv'] . "',";
				$cadenaSql .= ($variable ['senalizacion_ext'] != '') ? "'" . $variable ['senalizacion_ext'] . "');" : "NULL);";
				
				break;
			
			/*
			 * Sentencias Consulta Información
			 */
			
			case "consultar_recomendacion_particular" :
				$cadenaSql = "SELECT id_recomendacion,riesgo , acciones_prv, senalizacion_ext, rm.id_zona_estudio, zn.titulo_proy ";
				$cadenaSql .= "FROM  recomendacion rm ";
				$cadenaSql .= "JOIN  zona_estudio zn ON zn.id_zona_estudio= rm.id_zona_estudio ";
				$cadenaSql .= "WHERE rm.estado_registro=TRUE  ";
				$cadenaSql .= "AND  rm.id_recomendacion='" . $variable . "'; ";
				
				break;
			
			case "consultar_recomedaciones" :
				$cadenaSql = "SELECT id_recomendacion,riesgo , acciones_prv, senalizacion_ext, rm.id_zona_estudio, zn.titulo_proy ";
				$cadenaSql .= "FROM  recomendacion rm ";
				$cadenaSql .= "JOIN  zona_estudio zn ON zn.id_zona_estudio= rm.id_zona_estudio ";
				$cadenaSql .= "WHERE rm.estado_registro=TRUE  ";
				$cadenaSql .= "AND  rm.id_zona_estudio='" . $variable . "'; ";
				
				break;
			
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
				
				$cadenaSql = "SELECT DISTINCT zn.id_zona_estudio, sec.descripcion sector ,rgn.descripcion region, zn.titulo_proy,zn.fecha_registro ";
				$cadenaSql .= "FROM zona_estudio zn ";
				$cadenaSql .= "JOIN sector sec ON sec.id_sector=zn.id_sector AND sec.estado_registro=TRUE ";
				$cadenaSql .= "JOIN region rgn ON rgn.id_region= sec.id_region AND sec.estado_registro=TRUE ";
				$cadenaSql .= "JOIN riesgo ris ON ris.id_zona_estudio= zn.id_zona_estudio AND ris.estado_registro=TRUE ";
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
			
			case 'consultar_riesgos' :
				$cadenaSql = "SELECT DISTINCT  control_ris  ";
				$cadenaSql .= "FROM riesgo  ";
				$cadenaSql .= "WHERE  id_zona_estudio= '" . $variable . "'";
				$cadenaSql .= "AND estado_registro = TRUE ";
				$cadenaSql .= "AND riesgo <> 0 ;";
				
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
			
			case 'actualizar_variable_temporal' :
				$cadenaSql = " UPDATE riesgo_temporal";
				$cadenaSql .= " SET ";
				$cadenaSql .= " valor='" . $variable ['valor'] . "',";
				$cadenaSql .= " nota='" . $variable ['nota'] . "',";
				$cadenaSql .= " probabilidad='" . $variable ['probabilidad'] . "', ";
				$cadenaSql .= " impacto='" . $variable ['impacto'] . "',";
				$cadenaSql .= " riesgo='" . $variable ['riesgo'] . "', ";
				$cadenaSql .= " control_ris='" . $variable ['observacion'] . "' ";
				$cadenaSql .= " WHERE id_riesgo_temp= '" . $variable ['id'] . "' ";
				$cadenaSql .= " AND token='" . $variable ['token'] . "' ;";
				
				break;
			
			case 'limpiar_valores_variable' :
				$cadenaSql = " UPDATE riesgo_temporal";
				$cadenaSql .= " SET ";
				$cadenaSql .= " valor=NULL,";
				$cadenaSql .= " nota=NULL,";
				$cadenaSql .= " probabilidad=NULL, ";
				$cadenaSql .= " impacto=NULL,";
				$cadenaSql .= " riesgo=NULL, ";
				$cadenaSql .= " control_ris=NULL  ";
				$cadenaSql .= " WHERE id_riesgo_temp= '" . $variable ['id'] . "' ";
				$cadenaSql .= " AND token='" . $variable ['token'] . "' ;";
				
				break;
		}
		
		return $cadenaSql;
	}
}
?>
