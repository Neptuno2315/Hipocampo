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

$url = $this->miConfigurador->getVariableConfiguracion ( "host" );
$url .= $this->miConfigurador->getVariableConfiguracion ( "site" );
$url .= "/index.php?";

if (isset ( $_REQUEST ['funcion'] )) {
	
	switch ($_REQUEST ['funcion']) {
		
		case 'consultaAtoN' :
			
			$cadenaSql = $this->sql->getCadenaSql ( 'consultar_aton_zona', $_REQUEST ['id_zona'] );
			$resultado = $esteRecursoLG->ejecutarAcceso ( $cadenaSql, "busqueda" );
			$resultado = $resultado [0];
			
			$array_aton = array (
					
					array (
							"label" => "Boyas AIS",
							"value" => $resultado ['boyas_ais'] 
					),
					array (
							"label" => "Boyas sin AIS",
							"value" => $resultado ['boyas_nais'] 
					),
					array (
							"label" => "Racon",
							"value" => $resultado ['racon_num'] 
					),
					array (
							"label" => "Linternas",
							"value" => $resultado ['linternas_num'] 
					),
					array (
							"label" => "Otras AtoN",
							"value" => $resultado ['otras_aton'] 
					) 
			);
			
			echo json_encode ( $array_aton );
			
			break;
		
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
			
			// URL base
			
			foreach ( $resultado as $valor ) {
				
				$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
				$cadenaACodificar .= "&opcion=gestionRecomendaciones";
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
				$urlRecomendaciones = $url . $cadena;
				
				$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
				$cadenaACodificar .= "&opcion=documento";
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
				$urlDocumento = $url . $cadena;
				
				$resultadoFinal [] = array (
						'region' => "<center>" . $valor ['region'] . "</center>",
						'sector' => "<center>" . $valor ['sector'] . "</center>",
						'titulo' => "<center>" . $valor ['titulo_proy'] . "</center>",
						'fecha' => "<center>" . $valor ['fecha_registro'] . "</center>",
						'validar' => "<center><a href='" . $urlRecomendaciones . "'><img src='" . $rutaBloque . "/css/iconos/busqueda.png 'width='20px'></a></center>",
						'documento' => "<center><a href='" . $urlDocumento . "'><img src='" . $rutaBloque . "/css/iconos/descargar.png 'width='20px'></a></center>" 
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
		
		case 'consultarRecomendaciones' :
			
			$cadenaSql = $this->sql->getCadenaSql ( "consultar_recomedaciones", $_REQUEST ['id_zona'] );
			$recomendaciones = $esteRecursoLG->ejecutarAcceso ( $cadenaSql, "busqueda" );
			
			foreach ( $recomendaciones as $valor ) {
				
				
				$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
				$cadenaACodificar .= "&opcion=modificarRecomendaciones";
				$cadenaACodificar .= "&bloque=" . $esteBloque ['nombre'];
				$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque ["grupo"];
				$cadenaACodificar .= "&tiempo=" . $_REQUEST ['tiempo'];
				$cadenaACodificar .= "&usuario=" . $_REQUEST ['usuario'];
				$cadenaACodificar .= "&id_recomendacion=" . $valor ['id_recomendacion'];
				
				// Codificar las variables
				$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
				$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar, $enlace );
				
				// URL definitiva
				$urlModificar = $url . $cadena;
				
				$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
				$cadenaACodificar .= "&opcion=eliminarRecomendaciones";
				$cadenaACodificar .= "&bloque=" . $esteBloque ['nombre'];
				$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque ["grupo"];
				$cadenaACodificar .= "&tiempo=" . $_REQUEST ['tiempo'];
				$cadenaACodificar .= "&usuario=" . $_REQUEST ['usuario'];
				$cadenaACodificar .= "&id_recomendacion=" . $valor ['id_recomendacion'];
				
				// Codificar las variables
				$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
				$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar, $enlace );
				
				// URL definitiva
				$urlELiminar = $url . $cadena;
				
				
				$especificar_riesgo = explode ( ",", $valor ['riesgo'] );
				
				$resultadoFinal [] = array (
						'riesgo' => "<center>" . $especificar_riesgo [1] . "</center>",
						'accion' => "<center>" . $valor ['acciones_prv'] . "</center>",
						'senalizacion' => "<center>" . $valor ['senalizacion_ext'] . "</center>",
						'modificar' => "<center><a href='" . $urlModificar . "'><img src='" . $rutaBloque . "/css/iconos/edit.png 'width='20px'></a></center>",
						'eliminar' => "<center><a href='" . $urlELiminar . "'><img src='" . $rutaBloque . "/css/iconos/eliminate.png 'width='20px'></a></center>" 
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
	}
	exit ();
}

?>