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
			$arreglo = unserialize ( $_REQUEST ['arreglo'] );
			
			$cadenaSql = $this->sql->getCadenaSql ( 'consulta_zonas_estudio', $arreglo );
			
			$resultado = $esteRecursoLG->ejecutarAcceso ( $cadenaSql, "busqueda" );
			
			var_dump($resultado);exit;
			
	
			for($i = 0; $i < count ( $resultado ); $i ++) {
				
				if (isset ( $_REQUEST ['accesoCondor'] ) && $_REQUEST ['accesoCondor'] == 'true') {
					$VariableDetalles = "pagina=elementoDetalle";
				} else {
					$VariableDetalles = "pagina=detalleElemento";
				}
				
				// pendiente la pagina para modificar parametro
				$VariableDetalles .= "&opcion=detalle";
				$VariableDetalles .= "&elemento=" . $resultado [$i] ['identificador_elemento_individual'];
				$VariableDetalles .= "&funcionario=" . $arreglo ['funcionario'];
				$VariableDetalles .= "&usuario=" . $_REQUEST ['usuario'];
				$VariableDetalles .= "&periodo=" . $resultado_periodo [0] [0];
				if (isset ( $_REQUEST ['accesoCondor'] ) && $_REQUEST ['accesoCondor'] == 'true') {
					$VariableDetalles .= "&accesoCondor=true";
				}
				
				$VariableDetalles = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $VariableDetalles, $directorio );
				
				$VariableObservaciones = "pagina=" . $miPaginaActual; // pendiente la pagina para modificar parametro
				$VariableObservaciones .= "&opcion=observaciones";
				$VariableObservaciones .= "&elemento_individual=" . $resultado [$i] ['identificador_elemento_individual'];
				$VariableObservaciones .= "&funcionario=" . $arreglo ['funcionario'];
				$VariableObservaciones .= "&placa=" . $resultado [$i] ['placa'];
				$VariableObservaciones .= "&usuario=" . $_REQUEST ['usuario'];
				$VariableObservaciones .= "&periodo=" . $resultado_periodo [0] [0];
				if (isset ( $_REQUEST ['accesoCondor'] ) && $_REQUEST ['accesoCondor'] == 'true') {
					$VariableObservaciones .= "&accesoCondor=true";
				}
				
				$VariableObservaciones = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $VariableObservaciones, $directorio );
				
				$identificaciones_elementos [] = $resultado [$i] ['identificador_elemento_individual'];
				
				$nombre = 'item_' . $i;
				$atributos ['id'] = $nombre;
				$atributos ['nombre'] = $nombre;
				$atributos ['marco'] = true;
				$atributos ['estiloMarco'] = true;
				$atributos ["etiquetaObligatorio"] = true;
				$atributos ['columnas'] = 1;
				$atributos ['dobleLinea'] = 1;
				$atributos ['tabIndex'] = $tab;
				$atributos ['etiqueta'] = '';
				$atributos ['seleccionado'] = ($resultado [$i] ['confirmada_existencia'] == 't') ? true : false;
				$atributos ['evento'] = 'onclick';
				$atributos ['eventoFuncion'] = ' verificarElementos(this.form)';
				$atributos ['valor'] = $resultado [$i] ['identificador_elemento_individual'];
				$atributos ['deshabilitado'] = false;
				$tab ++;
				
				// Aplica atributos globales al control
				$atributos = array_merge ( $atributos, $atributosGlobales );
				
				$item = ($resultado [$i] ['tipo_confirmada'] == 1) ? '&#8730 ' : $this->miFormulario->campoCuadroSeleccion ( $atributos );
				
				$resultadoFinal [] = array (
						'tipobien' => "<center>" . $resultado [$i] ['nombre_tipo_bienes'] . "</center>",
						'placa' => "<center>" . $resultado [$i] ['placa'] . "</center>",
						'descripcion' => "<center>" . $resultado [$i] ['descripcion_elemento'] . "</center>",
						'sede' => "<center>" . $resultado [$i] ['sede'] . "</center>",
						'dependencia' => "<center>" . $resultado [$i] ['dependencia'] . "</center>",
						'espaciofisico' => "<center>" . $resultado [$i] ['espaciofisico'] . "</center>",
						'estadoelemento' => "<center>" . $resultado [$i] ['estado_bien'] . "</center>",
						'contratista' => "<center>" . $resultado [$i] ['contratista'] . "</center>",
						'detalle' => "<center><a href='" . $VariableDetalles . "'><u>Ver Detalles</u></a></center>",
						'observaciones' => "<center><a href='" . $VariableObservaciones . "'>&#9658; &blk34;</a></center>",
						'verificacion' => "<center>" . $item . "</center>" 
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