<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class registrarForm {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miSql;
	function __construct($lenguaje, $formulario, $sql) {
		$this->miConfigurador = \Configurador::singleton ();
		
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		
		$this->lenguaje = $lenguaje;
		
		$this->miFormulario = $formulario;
		
		$this->miSql = $sql;
	}
	function miForm() {
		
		/**
		 * IMPORTANTE: Este formulario está utilizando jquery.
		 * Por tanto en el archivo ready.php se delaran algunas funciones js
		 * que lo complementan.
		 */
		$conexion = "logica";
		
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
		// ---------------- SECCION: Parámetros Globales del Formulario ----------------------------------
		/**
		 * Atributos que deben ser aplicados a todos los controles de este formulario.
		 * Se utiliza un arreglo
		 * independiente debido a que los atributos individuales se reinician cada vez que se declara un campo.
		 *
		 * Si se utiliza esta técnica es necesario realizar un mezcla entre este arreglo y el específico en cada control:
		 * $atributos= array_merge($atributos,$atributosGlobales);
		 */
		$atributosGlobales ['campoSeguro'] = 'true';
		$_REQUEST ['tiempo'] = time ();
		
		{ /*
		   * Consultar Riesgos
		   */
			
			$cadenaSql = $this->miSql->getCadenaSql ( "consultar_riesgos", $_REQUEST ['id_zona'] );
			$riesgo = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
			
			foreach ( $riesgo as $valor ) {
				
				if ($valor ['control_ris'] == "Monitoreo") {
					
					$arreglo_riesgo [] = array (
							
							'Monitoreo,(1 - 2)Nivel de Riesgo Aceptable',
							"(1 - 2)Nivel de Riesgo Aceptable" 
					);
				}
				
				if ($valor ['control_ris'] == "Especificar la Acción") {
					
					$arreglo_riesgo [] = array (
							
							'Especificar la Acción,(3 - 4)Nivel de Riesgo Aceptable con Precaución',
							"(3 - 4)Nivel de Riesgo Aceptable con Precaución" 
					);
				}
				
				if ($valor ['control_ris'] == "Medidas de Emergencia") {
					
					$arreglo_riesgo [] = array (
							
							'Medidas de Emergencia,(1 - 2)Nivel de Riesgo Aceptable',
							"(6 - 9)Nivel de Riesgo Inaceptable" 
					);
				}
			}
		}
		
		// -------------------------------------------------------------------------------------------------
		// ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------
		$esteCampo = $esteBloque ['nombre'];
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;
		
		// Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
		$atributos ['tipoFormulario'] = 'multipart/form-data';
		
		// Si no se coloca, entonces toma el valor predeterminado 'POST'
		$atributos ['metodo'] = 'POST';
		
		// Si no se coloca, entonces toma el valor predeterminado 'index.php' (Recomendado)
		$atributos ['action'] = 'index.php';
		$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo );
		
		// Si no se coloca, entonces toma el valor predeterminado.
		$atributos ['estilo'] = '';
		$atributos ['marco'] = true;
		$tab = 1;
		// ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
		// ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
		$atributos ['tipoEtiqueta'] = 'inicio';
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->formulario ( $atributos );
		unset ( $atributos );
		
		// ------------------Division para los botones-------------------------
		$atributos ["id"] = "DivRegistro";
		$atributos ["estilo"] = " ";
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
		{
			$esteCampo = "marcoDatosBasicos";
			$atributos ['id'] = $esteCampo;
			$atributos ["estilo"] = "jqueryui";
			$atributos ['tipoEtiqueta'] = 'inicio';
			$atributos ["leyenda"] = "Registro Recomendaciones a la Navegación";
			echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
			unset ( $atributos );
			
			{
				
				// ---------------- CONTROL: Cuadro Lista ----------------------
				$esteCampo = 'riesgo';
				$atributos ['nombre'] = $esteCampo;
				$atributos ['id'] = $esteCampo;
				$atributos ['seleccion'] = - 1;
				$atributos ['evento'] = '';
				$atributos ['deshabilitado'] = false;
				$atributos ["etiquetaObligatorio"] = true;
				$atributos ['tab'] = $tab;
				$atributos ['tamanno'] = 1;
				$atributos ['columnas'] = 1;
				$atributos ['estilo'] = 'jqueryui';
				$atributos ['validar'] = 'required';
				$atributos ['limitar'] = false;
				$atributos ['anchoCaja'] = 70;
				$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ['anchoEtiqueta'] = 60;
				$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_region" );
				$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
				$atributos ['matrizItems'] = $arreglo_riesgo;
				
				// Utilizar lo siguiente cuando no se pase un arreglo:
				// $atributos ['baseDatos'] = 'geografico';
				// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
				$tab ++;
				$atributos = array_merge ( $atributos, $atributosGlobales );
				echo $this->miFormulario->campoCuadroLista ( $atributos );
				unset ( $atributos );
				
				// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
				$esteCampo = 'acciones'; // Acciones Preventivas
				$atributos ['id'] = $esteCampo;
				$atributos ['nombre'] = $esteCampo;
				$atributos ['tipo'] = 'text';
				$atributos ['estilo'] = 'jqueryui';
				$atributos ['marco'] = true;
				$atributos ['estiloMarco'] = '';
				$atributos ["etiquetaObligatorio"] = true;
				$atributos ['columnas'] = 92;
				$atributos ['filas'] = 5;
				$atributos ['dobleLinea'] = 0;
				$atributos ['tabIndex'] = $tab;
				$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ['validar'] = 'required,maxSize[10000]';
				$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
				$atributos ['deshabilitado'] = false;
				$atributos ['tamanno'] = 20;
				$atributos ['maximoTamanno'] = '';
				$atributos ['anchoEtiqueta'] = 220;
				$tab ++;
				
				// Aplica atributos globales al control
				$atributos = array_merge ( $atributos, $atributosGlobales );
				echo $this->miFormulario->campoTextArea ( $atributos );
				unset ( $atributos );
				
				// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
				$esteCampo = 'senalizacion'; // Señalización
				$atributos ['id'] = $esteCampo;
				$atributos ['nombre'] = $esteCampo;
				$atributos ['tipo'] = 'text';
				$atributos ['estilo'] = 'jqueryui';
				$atributos ['marco'] = true;
				$atributos ['estiloMarco'] = '';
				$atributos ["etiquetaObligatorio"] = true;
				$atributos ['columnas'] = 92;
				$atributos ['filas'] = 5;
				$atributos ['dobleLinea'] = 0;
				$atributos ['tabIndex'] = $tab;
				$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ['validar'] = 'maxSize[10000]';
				$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
				$atributos ['deshabilitado'] = false;
				$atributos ['tamanno'] = 20;
				$atributos ['maximoTamanno'] = '';
				$atributos ['anchoEtiqueta'] = 220;
				$tab ++;
				
				// Aplica atributos globales al control
				$atributos = array_merge ( $atributos, $atributosGlobales );
				echo $this->miFormulario->campoTextArea ( $atributos );
				unset ( $atributos );
				
				// ------------------Division para los botones-------------------------
				$atributos ["id"] = "MarcoBotones";
				$atributos ["estilo"] = "marcoBotones";
				echo $this->miFormulario->division ( "inicio", $atributos );
				{
					// -----------------CONTROL: Botón ----------------------------------------------------------------
					$esteCampo = 'botonGuardar';
					$atributos ["id"] = $esteCampo;
					$atributos ["tabIndex"] = $tab;
					$atributos ["tipo"] = 'boton';
					// submit: no se coloca si se desea un tipo button genérico
					$atributos ['submit'] = true;
					$atributos ["estiloMarco"] = '';
					$atributos ["estiloBoton"] = 'jqueryui';
					// verificar: true para verificar el formulario antes de pasarlo al servidor.
					$atributos ["verificar"] = '';
					$atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
					$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ['nombreFormulario'] = $esteBloque ['nombre'];
					$tab ++;
					
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoBoton ( $atributos );
					unset ( $atributos );
				}
				// ------------------Fin Division para los botones-------------------------
				echo $this->miFormulario->division ( "fin" );
				unset ( $atributos );
			}
			
			echo $this->miFormulario->marcoAgrupacion ( 'fin' );
			unset ( $atributos );
			
			// -----------------FIN CONTROL: Botón -----------------------------------------------------------
		}
		// ------------------Fin Division para los botones-------------------------
		echo $this->miFormulario->division ( "fin" );
		unset ( $atributos );
		
		// ------------------Division para los botones-------------------------
		$atributos ["id"] = "DivEstadistico";
		$atributos ["estilo"] = " ";
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
		{
			
			$esteCampo = "marcoDatosBasicos";
			$atributos ['id'] = $esteCampo;
			$atributos ["estilo"] = "jqueryui";
			$atributos ['tipoEtiqueta'] = 'inicio';
			$atributos ["leyenda"] = "Estadístico Ayudas a la Navegación en Relación a la Cantidad de las Mismas.";
			echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
			unset ( $atributos );
			
			{
				
				echo "<svg></svg>";
			}
			
			echo $this->miFormulario->marcoAgrupacion ( 'fin' );
			unset ( $atributos );
		}
		// ------------------Fin Division para los botones-------------------------
		echo $this->miFormulario->division ( "fin" );
		unset ( $atributos );
		
		// ------------------Division para los botones-------------------------
		$atributos ["id"] = "DivTabla";
		$atributos ["estilo"] = " ";
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
		{
			
			$esteCampo = "marcoDatosBasicos";
			$atributos ['id'] = $esteCampo;
			$atributos ["estilo"] = "jqueryui";
			$atributos ['tipoEtiqueta'] = 'inicio';
			// $atributos ["leyenda"] = "";
			echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
			unset ( $atributos );
			
			$atributos ['texto'] = "Recomendaciones a la Navegación";
			$atributos ['estilo'] = "textoResaltado";
			$tab ++;
			
			// Aplica atributos globales al control
			echo $this->miFormulario->campoTexto ( $atributos );
			unset ( $atributos );
			
			$cadenaSql = $this->miSql->getCadenaSql ( "consultar_recomedaciones", $_REQUEST ['id_zona'] );
			$recomendaciones = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
			
			if ($recomendaciones) {
				
				$mostrarHtml = "<table id='tablaRecomedaciones'>
									<thead>
						                <tr>
						              	    <th>Riesgo</th>
											<th>Acciones Preventivas</th>
											<th>Señalización</th>
											<th>Modificar<br>Recomendación</th>
											<th>Eliminar<br>Recomendación</th>
										</tr>
						            </thead>
							</table>
            ";
				echo $mostrarHtml;
			} else {
				
				$mensaje = "No Se Encontraron Recomendaciones a la Navegación<br> Para el Proyecto : " . $_REQUEST ['titulo_proyecto'] . ".";
				
				// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
				$esteCampo = 'mensajeRegistro';
				$atributos ['id'] = $esteCampo;
				$atributos ['tipo'] = 'error';
				$atributos ['estilo'] = 'textoCentrar';
				$atributos ['mensaje'] = $mensaje;
				
				$tab ++;
				
				// Aplica atributos globales al control
				$atributos = array_merge ( $atributos, $atributosGlobales );
				echo $this->miFormulario->cuadroMensaje ( $atributos );
				unset ( $atributos );
				// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
			}
			
			echo $this->miFormulario->marcoAgrupacion ( 'fin' );
			unset ( $atributos );
		}
		// ------------------Fin Division para los botones-------------------------
		echo $this->miFormulario->division ( "fin" );
		unset ( $atributos );
		
		// ------------------- SECCION: Paso de variables ------------------------------------------------
		
		/**
		 * En algunas ocasiones es útil pasar variables entre las diferentes páginas.
		 * SARA permite realizar esto a través de tres
		 * mecanismos:
		 * (a). Registrando las variables como variables de sesión. Estarán disponibles durante toda la sesión de usuario. Requiere acceso a
		 * la base de datos.
		 * (b). Incluirlas de manera codificada como campos de los formularios. Para ello se utiliza un campo especial denominado
		 * formsara, cuyo valor será una cadena codificada que contiene las variables.
		 * (c) a través de campos ocultos en los formularios. (deprecated)
		 */
		// En este formulario se utiliza el mecanismo (b) para pasar las siguientes variables:
		// Paso 1: crear el listado de variables
		
		$valorCodificado = "actionBloque=" . $esteBloque ["nombre"];
		$valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		$valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
		$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
		$valorCodificado .= "&usuario=" . $_REQUEST ["usuario"];
		$valorCodificado .= "&opcion=RegistrarRecomendaciones";
		$valorCodificado .= "&usuario=" . $_REQUEST ['usuario'];
		$valorCodificado .= "&id_zona=" . $_REQUEST ['id_zona'];
		$valorCodificado .= "&titulo_proyecto=" . $_REQUEST ['titulo_proyecto'];
		/*
		 * SARA permite que los nombres de los campos sean dinámicos.
		 * Para ello utiliza la hora en que es creado el formulario para
		 * codificar el nombre de cada campo.
		 */
		$valorCodificado .= "&campoSeguro=" . $_REQUEST ['tiempo'];
		/*
		 * Sara permite validar los campos en el formulario o funcion destino.
		 * Para ello se envía los datos atributos["validadar"] de los componentes del formulario
		 * Estos se pueden obtener en el atributo $this->miFormulario->validadorCampos del formulario
		 * La función $this->miFormulario->codificarCampos() codifica automáticamente el atributo validadorCampos
		 */
		$valorCodificado .= "&validadorCampos=" . $this->miFormulario->codificarCampos ();
		
		// Paso 2: codificar la cadena resultante
		$valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $valorCodificado );
		
		$atributos ["id"] = "formSaraData"; // No cambiar este nombre
		$atributos ["tipo"] = "hidden";
		$atributos ['estilo'] = '';
		$atributos ["obligatorio"] = false;
		$atributos ['marco'] = true;
		$atributos ["etiqueta"] = "";
		$atributos ["valor"] = $valorCodificado;
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		
		// ----------------FIN SECCION: Paso de variables -------------------------------------------------
		// ---------------- FIN SECCION: Controles del Formulario -------------------------------------------
		// ----------------FINALIZAR EL FORMULARIO ----------------------------------------------------------
		// Se debe declarar el mismo atributo de marco con que se inició el formulario.
		$atributos ['marco'] = true;
		$atributos ['tipoEtiqueta'] = 'fin';
		echo $this->miFormulario->formulario ( $atributos );
		
		return true;
	}
	function mensaje() {
		if (isset ( $_REQUEST ['mensaje'] )) {
			
			$tab = 1;
			
			// ------------------Division para los botones-------------------------
			$atributos ["id"] = "MensajeRespuesta";
			$atributos ["estilo"] = " ";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			{
				
				switch ($_REQUEST ['mensaje']) {
					
					
					case 'RegistroExito' :
						$atributos ['tipo'] = 'success';
						$atributos ['mensaje'] = 'Se Registro con Exito.<br>Recomendación a la Navegación.';
						break;
					
					case 'RegistroError' :
						$atributos ['tipo'] = 'error';
						$atributos ['mensaje'] = 'Error en el Registro.<br>Recomendación a la Navegación.<br>Verifique los Datos.';
						break;
					

					
					case 'ActualizoExito' :
						$atributos ['tipo'] = 'success';
						$atributos ['mensaje'] = 'Se Actualizado la Recomendación a la Navegación con Exito.';
						break;
					
					case 'ActualizacionError' :
						$atributos ['tipo'] = 'error';
						$atributos ['mensaje'] = 'Error en la Actualización de la Recomendación  a la Navegación.<br>Verifique los Datos.';
						break;
					

					case 'EliminoExito' :
						$atributos ['tipo'] = 'success';
						$atributos ['mensaje'] = 'Se Elimino con Exito Recomendación a la Navegación de la Zona de Estudio<br>Nombre Proyecto : <br>' . $_REQUEST ['titulo_proyecto'] . ".";
						break;
					
					case 'EliminoError' :
						$atributos ['tipo'] = 'error';
						$atributos ['mensaje'] = 'Error en la Eliminación de Recomendación a la Navegación de la Zona de Estudio.<br>Verifique los Datos.';
						break;
					
					case 'ErrorProcesamiento' :
						
						$atributos ['tipo'] = 'error';
						$atributos ['mensaje'] = 'Datos No Validos o Error al Procesar la Información.<br>Verifique los Datos.';
						
						break;
				}
				
				$esteCampo = 'mensajeGeneral';
				$atributos ['id'] = $esteCampo;
				$atributos ['estilo'] = 'textoCentrar';
				
				$tab ++;
				
				// Aplica atributos globales al control
				$atributos = array_merge ( $atributos );
				echo $this->miFormulario->cuadroMensaje ( $atributos );
				unset ( $atributos );
			}
			// ------------------Fin Division para los botones-------------------------
			echo $this->miFormulario->division ( "fin" );
			unset ( $atributos );
		}
	}
}
$miSeleccionador = new registrarForm ( $this->lenguaje, $this->miFormulario, $this->sql );
$miSeleccionador->mensaje ();
$miSeleccionador->miForm ();
?>		