<?php
// Conección a Base de Datos
$conexion = "geografico";
$esteRecursoGEO = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
$conexion = "logica";
$esteRecursoLG = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );

//

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
			$arreglo =  unserialize ( base64_decode ($_REQUEST ['arreglo'] ) );
			
			$cadenaSql = $this->sql->getCadenaSql ( 'consulta_zonas_estudio', $arreglo );
			
			$resultado = $esteRecursoLG->ejecutarAcceso ( $cadenaSql, "busqueda" );
			
// 			var_dump ( $resultado );
// 			exit ();
			
			// URL base
			$url = $this->miConfigurador->getVariableConfiguracion ( "host" );
			$url .= $this->miConfigurador->getVariableConfiguracion ( "site" );
			$url .= "/index.php?";
			
			
			foreach ( $resultado as $valor ) {
				
				$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
				$cadenaACodificar .= "&procesarAjax=true";
				$cadenaACodificar .= "&actionBloque=index.php";
				$cadenaACodificar .= "&bloqueNombre=" . $esteBloque ["nombre"];
				$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque ["grupo"];
				$cadenaACodificar .= "&funcion=modifcarInformacionZona";
				$cadenaACodificar .= "&tiempo=" . $_REQUEST ['tiempo'];
				$cadenaACodificar .= "&usuario=" . $_REQUEST ['usuario'];
				$cadenaACodificar .= "&id_zona=" . $valor ['id_zona_estudio'];
				// Codificar las variables
				$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
				$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar, $enlace );
				
				// URL definitiva
				$urlModificar = $url . $cadena;
				
				
				
				$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
				$cadenaACodificar .= "&procesarAjax=true";
				$cadenaACodificar .= "&action=index.php";
				$cadenaACodificar .= "&bloqueNombre=" . $esteBloque ["nombre"];
				$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque ["grupo"];
				$cadenaACodificar .= "&funcion=eliminarInformacionZona";
				$cadenaACodificar .= "&tiempo=" . $_REQUEST ['tiempo'];
				$cadenaACodificar .= "&usuario=" . $_REQUEST ['usuario'];
				$cadenaACodificar .= "&id_zona=" . $valor ['id_zona_estudio'];
				// Codificar las variables
				$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
				$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar, $enlace );
				
				// URL definitiva
				$urlEliminar = $url . $cadena;
				
				
				
				$resultadoFinal [] = array (
						'region' => "<center>" . $resultado [$i] ['region'] . "</center>",
						'sector' => "<center>" . $resultado [$i] ['sector'] . "</center>",
						'titulo' => "<center>" . $resultado [$i] ['titulo_proy'] . "</center>",
						'fecha' => "<center>" . $resultado [$i] ['fecha_registro'] . "</center>",
						'modificar' => "<center><a href='" . $urlModificar . "'><u>&#9658; &blk34;</u></a></center>",
						'eliminar' => "<center><a href='" . $urlEliminar . "'><u>X</u></a></center>", 
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