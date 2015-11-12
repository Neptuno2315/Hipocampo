<?php

use logica\canales\gestionRiesgo\Sql;

// Conección a Base de Datos
$conexion = "parametros";
$esteRecursoDBP = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
//

if (isset ( $_REQUEST ['funcion'] )) {
	
	switch ($_REQUEST ['funcion']) {
		
		case 'SeleccionSector' :
			
			$cadenaSql = $this->sql->getCadenaSql ( 'consultar_sector', $_REQUEST ['valor'] );
			$resultado = $esteRecursoDBP->ejecutarAcceso ( $cadenaSql, "busqueda" );
			echo json_encode ( $resultado );
			exit();
			break;
	}
}

?>