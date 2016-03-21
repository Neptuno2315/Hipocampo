<?php

namespace logica\gestion\zonaEstudio;

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
			/*
			 * INSERT INTO zona_estudio(id_zona_estudio, id_sector, titulo_proy, profundidad_qll, ancho_canl,
			 * obtrucciones_vs, complejidad_hdr, tipo_fn, estabilidad_sed, ayudas_nv,
			 * calidad_dthd, operaciones_ddn, estado_mr, observaciones_vncr,
			 * restricciones_vs, condiciones_hl, iluminacion_fn, observaciones_scm,
			 * monitoreo_stm, estado_registro, fecha_registro)
			 * VALUES (?, ?, ?, ?, ?,
			 * ?, ?, ?, ?, ?,
			 * ?, ?, ?, ?,
			 * ?, ?, ?, ?,
			 * ?, ?, ?);
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
				$cadenaSql .= "'" . $variable ['monitoreo_stm'] . "'); ";
				break;
		}
		
		return $cadenaSql;
	}
}
?>
