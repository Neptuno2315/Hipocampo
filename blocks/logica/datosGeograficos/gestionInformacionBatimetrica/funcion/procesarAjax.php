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

$UrlDirectorioIconos = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" );
$UrlDirectorioIconos .= "css/iconos/";

$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "host" );
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/";
$rutaBloque .= $esteBloque ['grupo'] . '/' . $esteBloque ['nombre'];

$miPaginaActual = $this->miConfigurador->getVariableConfiguracion ( 'pagina' );

$url = $this->miConfigurador->getVariableConfiguracion ( "host" );
$url .= $this->miConfigurador->getVariableConfiguracion ( "site" );
$url .= "/index.php?";

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
			
			foreach ( $resultado as $valor ) {
				
				$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
				$cadenaACodificar .= "&opcion=gestionBatimetriaZona";
				$cadenaACodificar .= "&bloque=" . $esteBloque ['nombre'];
				$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque ["grupo"];
				$cadenaACodificar .= "&tiempo=" . $_REQUEST ['tiempo'];
				$cadenaACodificar .= "&usuario=" . $_REQUEST ['usuario'];
				$cadenaACodificar .= "&sector=" . $valor ['sector'];
				$cadenaACodificar .= "&region=" . $valor ['region'];
				$cadenaACodificar .= "&id_zona=" . $valor ['id_zona_estudio'];
				$cadenaACodificar .= "&titulo_proyecto=" . $valor ['titulo_proy'];
				// Codificar las variables
				$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
				$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar, $enlace );
				
				// URL definitiva
				$urlRegistroBatimetrico = $url . $cadena;
				
				$resultadoFinal [] = array (
						'region' => "<center>" . $valor ['region'] . "</center>",
						'sector' => "<center>" . $valor ['sector'] . "</center>",
						'titulo' => "<center>" . $valor ['titulo_proy'] . "</center>",
						'fecha' => "<center>" . $valor ['fecha_registro'] . "</center>",
						'opcionBatimetria' => "<center><a href='" . $urlRegistroBatimetrico . "'><img src='" . $UrlDirectorioIconos . "insertar.png 'width='20px'></a></center>" 
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
		
		case 'consultaInSrid' :
			
			$cadenaSql = $this->sql->getCadenaSql ( 'consultar_info_srid', $_REQUEST ['valor'] );
			$resultado = $esteRecursoGEO->ejecutarAcceso ( $cadenaSql, "busqueda" );
			
			$resultado = $resultado [0];
			
			// $cadena = (str_replace ( '",', '<br>', $resultado [0] ));
			
			$arreglo_extraer = array (
					"[",
					"]",
					"]," 
			);
			
			$ready = str_replace ( $arreglo_extraer, $arreglo_extraer [0], $resultado [0] );
			$cadena = explode ( $arreglo_extraer [0], $ready );
			
			foreach ( $cadena as $valor )
				($valor!='')?$descrp_sistema[]=$valor: "";
				
				
				$descrp_sistema[7]= str_replace (",","@", $descrp_sistema[7]);
				
				
				
				$descrp_sistema = implode ( "<br>", $descrp_sistema );
				
				$descrp_sistema = (str_replace ( '",', '"<br>', $descrp_sistema ));
// 			var_dump ( $descrp_sistema );
// 			exit ();
		
			
			// $cadena = (str_replace ( '",', '"<br>', $cadena ));
			// var_dump ( $launch );
			// exit ();
			echo json_encode ( $descrp_sistema );
			
			break;
	}
	
	exit ();
}

?>