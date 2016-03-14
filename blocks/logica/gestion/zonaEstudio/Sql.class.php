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
			
			// +++++++++++++++++++ Sentencias de mi Caso de Uso ++++++++++++++++++++++++++++++++
			
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
			
			case 'consultar_region' :
				$cadenaSql = "SELECT id_region, descripcion ";
				$cadenaSql .= "FROM parametros.region ";
				$cadenaSql .= "WHERE estado_registro='t';";
				break;
			
			case 'consultar_sector' :
				$cadenaSql = "SELECT id_sector id, descripcion valor ";
				$cadenaSql .= "FROM parametros.sector  ";
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
		}
		
		return $cadenaSql;
	}
}
?>
