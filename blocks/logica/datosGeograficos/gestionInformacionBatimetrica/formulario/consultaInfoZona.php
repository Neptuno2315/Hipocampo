<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class consultarForm {
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
	function miFormulario() {
		
		/**
		 * IMPORTANTE: Este formulario está utilizando jquery.
		 * Por tanto en el archivo ready.php se delaran algunas funciones js
		 * que lo complementan.
		 */
		// Rescatar los datos de este bloque
		$conexion = "parametros";
		
		$esteRecursoDBP = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
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
		
		// -------------------------------------------------------------------------------------------------
		// ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------
		$esteCampo = $esteBloque['nombre'];
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
		
		$esteCampo = "marcoDatosBasicos";
		$atributos ['id'] = $esteCampo;
		$atributos ["estilo"] = "jqueryui";
		$atributos ['tipoEtiqueta'] = 'inicio';
		$atributos ["leyenda"] = "Consulta Proyecto de la Zona de Estudio : Gestión Batimetría";
		echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
		unset ( $atributos );
		
		{
			
			// ---------------- CONTROL: Cuadro Lista ----------------------
			$esteCampo = 'region_consulta';
			$atributos ['nombre'] = $esteCampo;
			$atributos ['id'] = $esteCampo;
			$atributos ['seleccion'] = - 1;
			$atributos ['evento'] = '';
			$atributos ['deshabilitado'] = false;
			$atributos ["etiquetaObligatorio"] = false;
			$atributos ['tab'] = $tab;
			$atributos ['tamanno'] = 1;
			$atributos ['columnas'] = 2;
			$atributos ['estilo'] = 'jqueryui';
			$atributos ['validar'] = '';
			$atributos ['limitar'] = false;
			$atributos ['anchoCaja'] = 70;
			$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ['anchoEtiqueta'] = 120;
			
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_region" );
			
			$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
			// $atributos ['matrizItems'] = $matrizItems;
			
			// Utilizar lo siguiente cuando no se pase un arreglo:
			$atributos ['baseDatos'] = 'geografico';
			// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
			$tab ++;
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroLista ( $atributos );
			unset ( $atributos );
			
			// ---------------- CONTROL: Cuadro Lista ----------------------
			$esteCampo = 'sector_consulta';
			$atributos ['nombre'] = $esteCampo;
			$atributos ['id'] = $esteCampo;
			$atributos ['seleccion'] = - 1;
			$atributos ['evento'] = '';
			$atributos ['deshabilitado'] = true;
			$atributos ["etiquetaObligatorio"] = false;
			$atributos ['tab'] = $tab;
			$atributos ['tamanno'] = 1;
			$atributos ['columnas'] = 2;
			$atributos ['estilo'] = 'jqueryui';
			$atributos ['validar'] = '';
			$atributos ['limitar'] = true;
			$atributos ['anchoCaja'] = 60;
			$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ['anchoEtiqueta'] = 150;
			$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
			$matrizItems = array (
					array (
							'',
							'Sin Sectores' 
					) 
			);
			$atributos ['matrizItems'] = $matrizItems;
			
			// Utilizar lo siguiente cuando no se pase un arreglo:
			// $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
			// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
			$tab ++;
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroLista ( $atributos );
			unset ( $atributos );
			
			$esteCampo = 'nombre_pry_consulta'; // Nombre o Titulo Proyecto
			$atributos ['id'] = $esteCampo;
			$atributos ['nombre'] = $esteCampo;
			$atributos ['tipo'] = 'text';
			$atributos ['estilo'] = 'jqueryui';
			$atributos ['marco'] = true;
			$atributos ['estiloMarco'] = '';
			$atributos ["etiquetaObligatorio"] = false;
			$atributos ['columnas'] = 1;
			$atributos ['dobleLinea'] = false;
			$atributos ['tabIndex'] = $tab;
			$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ['validar'] = 'maxSize[4000]';
			
			if (isset ( $_REQUEST [$esteCampo] )) {
				$atributos ['valor'] = $_REQUEST [$esteCampo];
			} else {
				$atributos ['valor'] = '';
			}
			$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
			$atributos ['deshabilitado'] = false;
			$atributos ['tamanno'] = 65;
			$atributos ['maximoTamanno'] = '4000';
			$atributos ['anchoEtiqueta'] = 120;
			$atributos ['textoFondo'] = "Ingrese Mínimo 3 Caracteres de Búsqueda";
			$tab ++;
			
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroTexto ( $atributos );
			unset ( $atributos );
			
			$esteCampo = 'id_zona';
			$atributos ["id"] = $esteCampo; // No cambiar este nombre
			$atributos ["tipo"] = "hidden";
			$atributos ['estilo'] = '';
			$atributos ["obligatorio"] = false;
			$atributos ['marco'] = true;
			$atributos ["etiqueta"] = "";
			if (isset ( $_REQUEST [$esteCampo] )) {
				$atributos ['valor'] = $_REQUEST [$esteCampo];
			} else {
				$atributos ['valor'] = '';
			}
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroTexto ( $atributos );
			unset ( $atributos );
			
			// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
			$esteCampo = 'fecha_inicio_consulta';
			$atributos ['id'] = $esteCampo;
			$atributos ['nombre'] = $esteCampo;
			$atributos ['tipo'] = 'text';
			$atributos ['estilo'] = 'jqueryui';
			$atributos ['marco'] = true;
			$atributos ['estiloMarco'] = '';
			// $atributos ["etiquetaObligatorio"] = true;
			$atributos ['columnas'] = 2;
			$atributos ['dobleLinea'] = 0;
			$atributos ['tabIndex'] = $tab;
			$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ['validar'] = '';
			
			if (isset ( $_REQUEST [$esteCampo] )) {
				$atributos ['valor'] = $_REQUEST [$esteCampo];
			} else {
				$atributos ['valor'] = '';
			}
			$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
			$atributos ['deshabilitado'] = true;
			$atributos ['tamanno'] = 8;
			$atributos ['maximoTamanno'] = '';
			$atributos ['anchoEtiqueta'] = 120;
			$tab ++;
			
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroTexto ( $atributos );
			
			// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
			$esteCampo = 'fecha_final_consulta';
			$atributos ['id'] = $esteCampo;
			$atributos ['nombre'] = $esteCampo;
			$atributos ['tipo'] = 'text';
			$atributos ['estilo'] = 'jqueryui';
			$atributos ['marco'] = true;
			$atributos ['estiloMarco'] = '';
			// $atributos ["etiquetaObligatorio"] = true;
			$atributos ['columnas'] = 2;
			$atributos ['dobleLinea'] = 0;
			$atributos ['tabIndex'] = $tab;
			$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ['validar'] = '';
			
			if (isset ( $_REQUEST [$esteCampo] )) {
				$atributos ['valor'] = $_REQUEST [$esteCampo];
			} else {
				$atributos ['valor'] = '';
			}
			$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
			$atributos ['deshabilitado'] = true;
			$atributos ['tamanno'] = 8;
			$atributos ['maximoTamanno'] = '';
			$atributos ['anchoEtiqueta'] = 150;
			$tab ++;
			
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroTexto ( $atributos );
			
			unset ( $atributos );
			
			// ------------------Division para los botones-------------------------
			$atributos ["id"] = "botones";
			$atributos ["estilo"] = "marcoBotones";
			echo $this->miFormulario->division ( "inicio", $atributos );
			{
				// -----------------CONTROL: Botón ----------------------------------------------------------------
				$esteCampo = 'botonConsultar';
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
				
				// -----------------FIN CONTROL: Botón -----------------------------------------------------------
			}
			// ------------------Fin Division para los botones-------------------------
			echo $this->miFormulario->division ( "fin" );
			unset ( $atributos );
		}
		
		echo $this->miFormulario->marcoAgrupacion ( 'fin' );
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
		
		$valorCodificado = "actionBloque=consultaZonaEstudio";
		$valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		$valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
		$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
		$valorCodificado .= "&usuario=" . $_REQUEST ["usuario"];
		$valorCodificado .= "&opcion=consultarInformacionZona";
		/**
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
}
$miSeleccionador = new consultarForm ( $this->lenguaje, $this->miFormulario, $this->sql );
$miSeleccionador->miFormulario ();
?>		