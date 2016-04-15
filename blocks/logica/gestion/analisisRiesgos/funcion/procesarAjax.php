<?php
// Conección a Base de Datos
$conexion = "geografico";
$esteRecursoGEO = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
$conexion = "logica";
$esteRecursoLG = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );

$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );

$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "host" );
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/";
$rutaBloque .= $esteBloque ['grupo'] . '/' . $esteBloque ['nombre'];

$miPaginaActual = $this->miConfigurador->getVariableConfiguracion ( 'pagina' );

if (isset ( $_REQUEST ['funcion'] )) {
	
	switch ($_REQUEST ['funcion']) {
		
		case 'SeleccionSector' :
			
			$cadenaSql = $this->sql->getCadenaSql ( 'consultar_sector', $_REQUEST ['valor'] );
			$resultado = $esteRecursoGEO->ejecutarAcceso ( $cadenaSql, "busqueda" );
			echo json_encode ( $resultado );
			break;
		
		case 'busquedaTituloZona' :
			
			$cadenaSql = $this->sql->getCadenaSql ( 'consultar_titulos_zonas', $_GET ['query'] );
			$resultadoItems = $esteRecursoLG->ejecutarAcceso ( $cadenaSql, "busqueda" );
			foreach ( $resultadoItems as $key => $values ) {
				$keys = array (
						'value',
						'data' 
				);
				$resultado [$key] = array_intersect_key ( $resultadoItems [$key], array_flip ( $keys ) );
			}
			echo '{"suggestions":' . json_encode ( $resultado ) . '}';
			break;
		
		case 'consultarZonasEstudio' :
			$arreglo = unserialize ( base64_decode ( $_REQUEST ['arreglo'] ) );
			
			$cadenaSql = $this->sql->getCadenaSql ( 'consulta_zonas_estudio', $arreglo );
			
			$resultado = $esteRecursoLG->ejecutarAcceso ( $cadenaSql, "busqueda" );
			
			// var_dump ( $resultado );
			// exit ();
			
			// URL base
			$url = $this->miConfigurador->getVariableConfiguracion ( "host" );
			$url .= $this->miConfigurador->getVariableConfiguracion ( "site" );
			$url .= "/index.php?";
			
			foreach ( $resultado as $valor ) {
				
				$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
				$cadenaACodificar .= "&actionBloque=analizarRiesgo";
				$cadenaACodificar .= "&opcion=analizarRiesgo";
				$cadenaACodificar .= "&bloque=" . $esteBloque ['nombre'];
				$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque ["grupo"];
				$cadenaACodificar .= "&tiempo=" . $_REQUEST ['tiempo'];
				$cadenaACodificar .= "&usuario=" . $_REQUEST ['usuario'];
				$cadenaACodificar .= "&id_zona=" . $valor ['id_zona_estudio'];
				$cadenaACodificar .= "&titulo_proyecto=" . $valor ['titulo_proy'];
				// Codificar las variables
				$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
				$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar, $enlace );
				
				// URL definitiva
				$urlAnalizar = $url . $cadena;
				
				$resultadoFinal [] = array (
						'region' => "<center>" . $valor ['region'] . "</center>",
						'sector' => "<center>" . $valor ['sector'] . "</center>",
						'titulo' => "<center>" . $valor ['titulo_proy'] . "</center>",
						'fecha' => "<center>" . $valor ['fecha_registro'] . "</center>",
						'analizar' => "<center><a href='" . $urlAnalizar . "'><B>↺</B></a></center>" 
				);
			}
			
			$total = count ( $resultadoFinal );
			
			$resultado = json_encode ( $resultadoFinal );
			
			$resultado = '{
                "recordsTotal":' . $total . ',
                "recordsFiltered":' . $total . ',
				"data":' . $resultado . '}';
			
			echo $resultado;
			
			break;
		
		case 'consultaVariables' :
			
			$tabla = new stdClass ();
			
			$page = $_GET ['page'];
			
			$limit = $_GET ['rows'];
			
			$sidx = $_GET ['sidx'];
			
			$sord = $_GET ['sord'];
			
			if (! $sidx)
				$sidx = 1;
				
				// ------------------
			
			$cadenaSql = $this->sql->getCadenaSql ( 'consultar_variables_registradas_temporales', $_REQUEST ['tiempo'] );
			
			$resultadoItems = $esteRecursoLG->ejecutarAcceso ( $cadenaSql, "busqueda" );
			
			// ---------------------
			$filas = count ( $resultadoItems );
			
			if ($filas > 0 && $limit > 0) {
				$total_pages = ceil ( $filas / $limit );
			} else {
				$total_pages = 0;
			}
			
			if ($page > $total_pages)
				$page = $total_pages;
			
			$start = $limit * $page - $limit;
			if ($resultadoItems != false) {
				$tabla->page = $page;
				$tabla->total = $total_pages;
				$tabla->records = $filas;
				
				$i = 0;
				
				foreach ( $resultadoItems as $row ) {
					$tabla->rows [$i] ['tem'] = $row ['id_riesgo_temp'];
					$tabla->rows [$i] ['cell'] = array (
							$row ['tema'],
							$row ['variable'],
							$row ['valor'],
							$row ['nota'],
							$row ['probabilidad'],
							$row ['impacto'],
							$row ['riesgo'],
							$row ['control_ris']
					);
					$i ++;
				}
				
				$tabla = json_encode ( $tabla );
				
				echo $tabla;
			}
			
			break;
	}
	exit ();
}

?>