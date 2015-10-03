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
		
		{
			
			// ---------------- CONTROL: Cuadro Lista ----------------------
			$esteCampo = 'region';
			$atributos ['nombre'] = $esteCampo;
			$atributos ['id'] = $esteCampo;
			$atributos ['seleccion'] = - 1;
			$atributos ['evento'] = '';
			$atributos ['deshabilitado'] = false;
			$atributos ["etiquetaObligatorio"] = true;
			$atributos ['tab'] = $tab;
			$atributos ['tamanno'] = 1;
			$atributos ['columnas'] = 2;
			$atributos ['estilo'] = 'jqueryui';
			$atributos ['validar'] = 'required';
			$atributos ['limitar'] = false;
			$atributos ['anchoCaja'] = 70;
			$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ['anchoEtiqueta'] = 170;
			
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_region" );
			
			$matrizItems = $esteRecursoDBP->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
			
			$atributos ['matrizItems'] = $matrizItems;
			
			// Utilizar lo siguiente cuando no se pase un arreglo:
			// $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
			// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
			$tab ++;
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroLista ( $atributos );
			unset ( $atributos );
			
			// ---------------- CONTROL: Cuadro Lista ----------------------
			$esteCampo = 'sector';
			$atributos ['nombre'] = $esteCampo;
			$atributos ['id'] = $esteCampo;
			$atributos ['seleccion'] = - 1;
			$atributos ['evento'] = '';
			$atributos ['deshabilitado'] = true;
			$atributos ["etiquetaObligatorio"] = true;
			$atributos ['tab'] = $tab;
			$atributos ['tamanno'] = 1;
			$atributos ['columnas'] = 2;
			$atributos ['estilo'] = 'jqueryui';
			$atributos ['validar'] = 'required';
			$atributos ['limitar'] = true;
			$atributos ['anchoCaja'] = 60;
			$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ['anchoEtiqueta'] = 150;
			
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
			
			$esteCampo = "AgrupacionContrato";
			$atributos ['id'] = $esteCampo;
			$atributos ['leyenda'] = "Volumen de Tráfico";
			echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
			unset ( $atributos );
			{
				
				$esteCampo = "AgrupacionBC";
				$atributos ['id'] = $esteCampo;
				$atributos ['leyenda'] = "Buques Comerciales";
				echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
				unset ( $atributos );
				{
					$esteCampo = 'rango1BC';
					$atributos ['id'] = $esteCampo;
					$atributos ['nombre'] = $esteCampo;
					$atributos ['tipo'] = 'text';
					$atributos ['estilo'] = 'jqueryui';
					$atributos ['marco'] = true;
					$atributos ['estiloMarco'] = '';
					$atributos ["etiquetaObligatorio"] = false;
					$atributos ['columnas'] = 2;
					$atributos ['dobleLinea'] = false;
					$atributos ['tabIndex'] = $tab;
					$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ['validar'] = 'custom[onlyNumberSp]';
					
					if (isset ( $_REQUEST [$esteCampo] )) {
						$atributos ['valor'] = $_REQUEST [$esteCampo];
					} else {
						$atributos ['valor'] = '';
					}
					$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
					$atributos ['deshabilitado'] = false;
					$atributos ['tamanno'] = 25;
					$atributos ['maximoTamanno'] = '';
					$atributos ['anchoEtiqueta'] = 295;
					$tab ++;
					
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'tiempo1BC';
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
					$atributos ['anchoEtiqueta'] = 80;
					
					$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_periodo" );
					
					$matrizItems = $esteRecursoDBP->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
					
					$atributos ['matrizItems'] = $matrizItems;
					
					// Utilizar lo siguiente cuando no se pase un arreglo:
					// $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
					// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
					$tab ++;
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroLista ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'rango2BC';
					$atributos ['id'] = $esteCampo;
					$atributos ['nombre'] = $esteCampo;
					$atributos ['tipo'] = 'text';
					$atributos ['estilo'] = 'jqueryui';
					$atributos ['marco'] = true;
					$atributos ['estiloMarco'] = '';
					$atributos ["etiquetaObligatorio"] = false;
					$atributos ['columnas'] = 2;
					$atributos ['dobleLinea'] = 0;
					$atributos ['tabIndex'] = $tab;
					$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ['validar'] = 'custom[onlyNumberSp]';
					
					if (isset ( $_REQUEST [$esteCampo] )) {
						$atributos ['valor'] = $_REQUEST [$esteCampo];
					} else {
						$atributos ['valor'] = '';
					}
					$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
					$atributos ['deshabilitado'] = false;
					$atributos ['tamanno'] = 25;
					$atributos ['maximoTamanno'] = '';
					$atributos ['anchoEtiqueta'] = 295;
					$tab ++;
					
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'tiempo2BC';
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
					$atributos ['anchoEtiqueta'] = 80;
					
					$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_periodo" );
					
					$matrizItems = $esteRecursoDBP->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
					
					$atributos ['matrizItems'] = $matrizItems;
					
					// Utilizar lo siguiente cuando no se pase un arreglo:
					// $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
					// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
					$tab ++;
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroLista ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'rango3BC';
					$atributos ['id'] = $esteCampo;
					$atributos ['nombre'] = $esteCampo;
					$atributos ['tipo'] = 'text';
					$atributos ['estilo'] = 'jqueryui';
					$atributos ['marco'] = true;
					$atributos ['estiloMarco'] = '';
					$atributos ["etiquetaObligatorio"] = false;
					$atributos ['columnas'] = 2;
					$atributos ['dobleLinea'] = 0;
					$atributos ['tabIndex'] = $tab;
					$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ['validar'] = 'custom[onlyNumberSp]';
					
					if (isset ( $_REQUEST [$esteCampo] )) {
						$atributos ['valor'] = $_REQUEST [$esteCampo];
					} else {
						$atributos ['valor'] = '';
					}
					$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
					$atributos ['deshabilitado'] = false;
					$atributos ['tamanno'] = 25;
					$atributos ['maximoTamanno'] = '';
					$atributos ['anchoEtiqueta'] = 295;
					$tab ++;
					
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'tiempo3BC';
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
					$atributos ['anchoEtiqueta'] = 80;
					
					$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_periodo" );
					
					$matrizItems = $esteRecursoDBP->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
					
					$atributos ['matrizItems'] = $matrizItems;
					
					// Utilizar lo siguiente cuando no se pase un arreglo:
					// $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
					// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
					$tab ++;
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroLista ( $atributos );
					unset ( $atributos );
				}
				
				echo $this->miFormulario->agrupacion ( 'fin' );
				
				$esteCampo = "AgrupacionBE";
				$atributos ['id'] = $esteCampo;
				$atributos ['leyenda'] = "Buques de Energía";
				echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
				unset ( $atributos );
				{
					
					$esteCampo = 'rango1BE';
					$atributos ['id'] = $esteCampo;
					$atributos ['nombre'] = $esteCampo;
					$atributos ['tipo'] = 'text';
					$atributos ['estilo'] = 'jqueryui';
					$atributos ['marco'] = true;
					$atributos ['estiloMarco'] = '';
					$atributos ["etiquetaObligatorio"] = false;
					$atributos ['columnas'] = 2;
					$atributos ['dobleLinea'] = false;
					$atributos ['tabIndex'] = $tab;
					$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ['validar'] = 'custom[onlyNumberSp]';
					
					if (isset ( $_REQUEST [$esteCampo] )) {
						$atributos ['valor'] = $_REQUEST [$esteCampo];
					} else {
						$atributos ['valor'] = '';
					}
					$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
					$atributos ['deshabilitado'] = false;
					$atributos ['tamanno'] = 25;
					$atributos ['maximoTamanno'] = '';
					$atributos ['anchoEtiqueta'] = 295;
					$tab ++;
					
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'tiempo1BE';
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
					$atributos ['anchoEtiqueta'] = 80;
					
					$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_periodo" );
					
					$matrizItems = $esteRecursoDBP->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
					
					$atributos ['matrizItems'] = $matrizItems;
					
					// Utilizar lo siguiente cuando no se pase un arreglo:
					// $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
					// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
					$tab ++;
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroLista ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'rango2BE';
					$atributos ['id'] = $esteCampo;
					$atributos ['nombre'] = $esteCampo;
					$atributos ['tipo'] = 'text';
					$atributos ['estilo'] = 'jqueryui';
					$atributos ['marco'] = true;
					$atributos ['estiloMarco'] = '';
					$atributos ["etiquetaObligatorio"] = false;
					$atributos ['columnas'] = 2;
					$atributos ['dobleLinea'] = 0;
					$atributos ['tabIndex'] = $tab;
					$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ['validar'] = 'custom[onlyNumberSp]';
					
					if (isset ( $_REQUEST [$esteCampo] )) {
						$atributos ['valor'] = $_REQUEST [$esteCampo];
					} else {
						$atributos ['valor'] = '';
					}
					$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
					$atributos ['deshabilitado'] = false;
					$atributos ['tamanno'] = 25;
					$atributos ['maximoTamanno'] = '';
					$atributos ['anchoEtiqueta'] = 295;
					$tab ++;
					
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'tiempo2BE';
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
					$atributos ['anchoEtiqueta'] = 80;
					
					$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_periodo" );
					
					$matrizItems = $esteRecursoDBP->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
					
					$atributos ['matrizItems'] = $matrizItems;
					
					// Utilizar lo siguiente cuando no se pase un arreglo:
					// $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
					// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
					$tab ++;
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroLista ( $atributos );
					unset ( $atributos );
				}
				echo $this->miFormulario->agrupacion ( 'fin' );
				unset ( $atributos );
				
				$esteCampo = "AgrupacionBP";
				$atributos ['id'] = $esteCampo;
				$atributos ['leyenda'] = "Buques de Pasajeros";
				echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
				unset ( $atributos );
				{
					
					$esteCampo = 'rango1BP';
					$atributos ['id'] = $esteCampo;
					$atributos ['nombre'] = $esteCampo;
					$atributos ['tipo'] = 'text';
					$atributos ['estilo'] = 'jqueryui';
					$atributos ['marco'] = true;
					$atributos ['estiloMarco'] = '';
					$atributos ["etiquetaObligatorio"] = false;
					$atributos ['columnas'] = 2;
					$atributos ['dobleLinea'] = false;
					$atributos ['tabIndex'] = $tab;
					$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ['validar'] = 'custom[onlyNumberSp]';
					
					if (isset ( $_REQUEST [$esteCampo] )) {
						$atributos ['valor'] = $_REQUEST [$esteCampo];
					} else {
						$atributos ['valor'] = '';
					}
					$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
					$atributos ['deshabilitado'] = false;
					$atributos ['tamanno'] = 25;
					$atributos ['maximoTamanno'] = '';
					$atributos ['anchoEtiqueta'] = 295;
					$tab ++;
					
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'tiempo1BP';
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
					$atributos ['anchoEtiqueta'] = 80;
					
					$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_periodo" );
					
					$matrizItems = $esteRecursoDBP->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
					
					$atributos ['matrizItems'] = $matrizItems;
					
					// Utilizar lo siguiente cuando no se pase un arreglo:
					// $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
					// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
					$tab ++;
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroLista ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'rango2BP';
					$atributos ['id'] = $esteCampo;
					$atributos ['nombre'] = $esteCampo;
					$atributos ['tipo'] = 'text';
					$atributos ['estilo'] = 'jqueryui';
					$atributos ['marco'] = true;
					$atributos ['estiloMarco'] = '';
					$atributos ["etiquetaObligatorio"] = false;
					$atributos ['columnas'] = 2;
					$atributos ['dobleLinea'] = 0;
					$atributos ['tabIndex'] = $tab;
					$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ['validar'] = 'custom[onlyNumberSp]';
					
					if (isset ( $_REQUEST [$esteCampo] )) {
						$atributos ['valor'] = $_REQUEST [$esteCampo];
					} else {
						$atributos ['valor'] = '';
					}
					$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
					$atributos ['deshabilitado'] = false;
					$atributos ['tamanno'] = 25;
					$atributos ['maximoTamanno'] = '';
					$atributos ['anchoEtiqueta'] = 295;
					$tab ++;
					
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'tiempo2BP';
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
					$atributos ['anchoEtiqueta'] = 80;
					
					$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_periodo" );
					
					$matrizItems = $esteRecursoDBP->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
					
					$atributos ['matrizItems'] = $matrizItems;
					
					// Utilizar lo siguiente cuando no se pase un arreglo:
					// $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
					// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
					$tab ++;
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroLista ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'rango3BP';
					$atributos ['id'] = $esteCampo;
					$atributos ['nombre'] = $esteCampo;
					$atributos ['tipo'] = 'text';
					$atributos ['estilo'] = 'jqueryui';
					$atributos ['marco'] = true;
					$atributos ['estiloMarco'] = '';
					$atributos ["etiquetaObligatorio"] = false;
					$atributos ['columnas'] = 2;
					$atributos ['dobleLinea'] = 0;
					$atributos ['tabIndex'] = $tab;
					$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ['validar'] = 'custom[onlyNumberSp]';
					
					if (isset ( $_REQUEST [$esteCampo] )) {
						$atributos ['valor'] = $_REQUEST [$esteCampo];
					} else {
						$atributos ['valor'] = '';
					}
					$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
					$atributos ['deshabilitado'] = false;
					$atributos ['tamanno'] = 25;
					$atributos ['maximoTamanno'] = '';
					$atributos ['anchoEtiqueta'] = 295;
					$tab ++;
					
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'tiempo3BP';
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
					$atributos ['anchoEtiqueta'] = 80;
					
					$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_periodo" );
					
					$matrizItems = $esteRecursoDBP->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
					
					$atributos ['matrizItems'] = $matrizItems;
					
					// Utilizar lo siguiente cuando no se pase un arreglo:
					// $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
					// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
					$tab ++;
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroLista ( $atributos );
					unset ( $atributos );
				}
				echo $this->miFormulario->agrupacion ( 'fin' );
				unset ( $atributos );
				
				$esteCampo = "AgrupacionBG";
				$atributos ['id'] = $esteCampo;
				$atributos ['leyenda'] = "Buques de Guerra";
				echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
				unset ( $atributos );
				{
					
					$esteCampo = 'rango1BG';
					$atributos ['id'] = $esteCampo;
					$atributos ['nombre'] = $esteCampo;
					$atributos ['tipo'] = 'text';
					$atributos ['estilo'] = 'jqueryui';
					$atributos ['marco'] = true;
					$atributos ['estiloMarco'] = '';
					$atributos ["etiquetaObligatorio"] = false;
					$atributos ['columnas'] = 2;
					$atributos ['dobleLinea'] = false;
					$atributos ['tabIndex'] = $tab;
					$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ['validar'] = 'custom[onlyNumberSp]';
					
					if (isset ( $_REQUEST [$esteCampo] )) {
						$atributos ['valor'] = $_REQUEST [$esteCampo];
					} else {
						$atributos ['valor'] = '';
					}
					$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
					$atributos ['deshabilitado'] = false;
					$atributos ['tamanno'] = 25;
					$atributos ['maximoTamanno'] = '';
					$atributos ['anchoEtiqueta'] = 295;
					$tab ++;
					
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'tiempo1BG';
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
					$atributos ['anchoEtiqueta'] = 80;
					
					$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_periodo" );
					
					$matrizItems = $esteRecursoDBP->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
					
					$atributos ['matrizItems'] = $matrizItems;
					
					// Utilizar lo siguiente cuando no se pase un arreglo:
					// $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
					// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
					$tab ++;
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroLista ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'rango2BG';
					$atributos ['id'] = $esteCampo;
					$atributos ['nombre'] = $esteCampo;
					$atributos ['tipo'] = 'text';
					$atributos ['estilo'] = 'jqueryui';
					$atributos ['marco'] = true;
					$atributos ['estiloMarco'] = '';
					$atributos ["etiquetaObligatorio"] = false;
					$atributos ['columnas'] = 2;
					$atributos ['dobleLinea'] = 0;
					$atributos ['tabIndex'] = $tab;
					$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ['validar'] = 'custom[onlyNumberSp]';
					
					if (isset ( $_REQUEST [$esteCampo] )) {
						$atributos ['valor'] = $_REQUEST [$esteCampo];
					} else {
						$atributos ['valor'] = '';
					}
					$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
					$atributos ['deshabilitado'] = false;
					$atributos ['tamanno'] = 25;
					$atributos ['maximoTamanno'] = '';
					$atributos ['anchoEtiqueta'] = 295;
					$tab ++;
					
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'tiempo2BG';
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
					$atributos ['anchoEtiqueta'] = 80;
					
					$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_periodo" );
					
					$matrizItems = $esteRecursoDBP->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
					
					$atributos ['matrizItems'] = $matrizItems;
					
					// Utilizar lo siguiente cuando no se pase un arreglo:
					// $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
					// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
					$tab ++;
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroLista ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'rango3BG';
					$atributos ['id'] = $esteCampo;
					$atributos ['nombre'] = $esteCampo;
					$atributos ['tipo'] = 'text';
					$atributos ['estilo'] = 'jqueryui';
					$atributos ['marco'] = true;
					$atributos ['estiloMarco'] = '';
					$atributos ["etiquetaObligatorio"] = false;
					$atributos ['columnas'] = 2;
					$atributos ['dobleLinea'] = 0;
					$atributos ['tabIndex'] = $tab;
					$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ['validar'] = 'custom[onlyNumberSp]';
					
					if (isset ( $_REQUEST [$esteCampo] )) {
						$atributos ['valor'] = $_REQUEST [$esteCampo];
					} else {
						$atributos ['valor'] = '';
					}
					$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
					$atributos ['deshabilitado'] = false;
					$atributos ['tamanno'] = 25;
					$atributos ['maximoTamanno'] = '';
					$atributos ['anchoEtiqueta'] = 295;
					$tab ++;
					
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					// echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'tiempo3BG';
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
					$atributos ['anchoEtiqueta'] = 80;
					
					$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_periodo" );
					
					$matrizItems = $esteRecursoDBP->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
					
					$atributos ['matrizItems'] = $matrizItems;
					
					// Utilizar lo siguiente cuando no se pase un arreglo:
					// $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
					// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
					$tab ++;
					$atributos = array_merge ( $atributos, $atributosGlobales );
					// echo $this->miFormulario->campoCuadroLista ( $atributos );
					unset ( $atributos );
				}
				echo $this->miFormulario->agrupacion ( 'fin' );
				unset ( $atributos );
				
				$esteCampo = "AgrupacionBG";
				$atributos ['id'] = $esteCampo;
				$atributos ['leyenda'] = "Buques Pesqueros";
				echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
				unset ( $atributos );
				{
					
					$esteCampo = 'rango1BPQ';
					$atributos ['id'] = $esteCampo;
					$atributos ['nombre'] = $esteCampo;
					$atributos ['tipo'] = 'text';
					$atributos ['estilo'] = 'jqueryui';
					$atributos ['marco'] = true;
					$atributos ['estiloMarco'] = '';
					$atributos ["etiquetaObligatorio"] = false;
					$atributos ['columnas'] = 2;
					$atributos ['dobleLinea'] = false;
					$atributos ['tabIndex'] = $tab;
					$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ['validar'] = 'custom[onlyNumberSp]';
					
					if (isset ( $_REQUEST [$esteCampo] )) {
						$atributos ['valor'] = $_REQUEST [$esteCampo];
					} else {
						$atributos ['valor'] = '';
					}
					$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
					$atributos ['deshabilitado'] = false;
					$atributos ['tamanno'] = 25;
					$atributos ['maximoTamanno'] = '';
					$atributos ['anchoEtiqueta'] = 295;
					$tab ++;
					
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'tiempo1BPQ';
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
					$atributos ['anchoEtiqueta'] = 80;
					
					$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_periodo" );
					
					$matrizItems = $esteRecursoDBP->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
					
					$atributos ['matrizItems'] = $matrizItems;
					
					// Utilizar lo siguiente cuando no se pase un arreglo:
					// $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
					// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
					$tab ++;
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroLista ( $atributos );
					unset ( $atributos );
				}
				echo $this->miFormulario->agrupacion ( 'fin' );
				unset ( $atributos );
				
				$esteCampo = "AgrupacionBG";
				$atributos ['id'] = $esteCampo;
				$atributos ['leyenda'] = "Servicios Marítimos";
				echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
				unset ( $atributos );
				{
					
					$esteCampo = 'rango1SM';
					$atributos ['id'] = $esteCampo;
					$atributos ['nombre'] = $esteCampo;
					$atributos ['tipo'] = 'text';
					$atributos ['estilo'] = 'jqueryui';
					$atributos ['marco'] = true;
					$atributos ['estiloMarco'] = '';
					$atributos ["etiquetaObligatorio"] = false;
					$atributos ['columnas'] = 2;
					$atributos ['dobleLinea'] = false;
					$atributos ['tabIndex'] = $tab;
					$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ['validar'] = 'custom[onlyNumberSp]';
					
					if (isset ( $_REQUEST [$esteCampo] )) {
						$atributos ['valor'] = $_REQUEST [$esteCampo];
					} else {
						$atributos ['valor'] = '';
					}
					$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
					$atributos ['deshabilitado'] = false;
					$atributos ['tamanno'] = 25;
					$atributos ['maximoTamanno'] = '';
					$atributos ['anchoEtiqueta'] = 295;
					$tab ++;
					
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'tiempo1SM';
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
					$atributos ['anchoEtiqueta'] = 80;
					
					$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_periodo" );
					
					$matrizItems = $esteRecursoDBP->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
					
					$atributos ['matrizItems'] = $matrizItems;
					
					// Utilizar lo siguiente cuando no se pase un arreglo:
					// $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
					// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
					$tab ++;
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroLista ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'rango2SM';
					$atributos ['id'] = $esteCampo;
					$atributos ['nombre'] = $esteCampo;
					$atributos ['tipo'] = 'text';
					$atributos ['estilo'] = 'jqueryui';
					$atributos ['marco'] = true;
					$atributos ['estiloMarco'] = '';
					$atributos ["etiquetaObligatorio"] = false;
					$atributos ['columnas'] = 2;
					$atributos ['dobleLinea'] = false;
					$atributos ['tabIndex'] = $tab;
					$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ['validar'] = 'custom[onlyNumberSp]';
					
					if (isset ( $_REQUEST [$esteCampo] )) {
						$atributos ['valor'] = $_REQUEST [$esteCampo];
					} else {
						$atributos ['valor'] = '';
					}
					$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
					$atributos ['deshabilitado'] = false;
					$atributos ['tamanno'] = 25;
					$atributos ['maximoTamanno'] = '';
					$atributos ['anchoEtiqueta'] = 295;
					$tab ++;
					
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'tiempo2SM';
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
					$atributos ['anchoEtiqueta'] = 80;
					
					$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_periodo" );
					
					$matrizItems = $esteRecursoDBP->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
					
					$atributos ['matrizItems'] = $matrizItems;
					
					// Utilizar lo siguiente cuando no se pase un arreglo:
					// $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
					// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
					$tab ++;
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroLista ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'rango3SM';
					$atributos ['id'] = $esteCampo;
					$atributos ['nombre'] = $esteCampo;
					$atributos ['tipo'] = 'text';
					$atributos ['estilo'] = 'jqueryui';
					$atributos ['marco'] = true;
					$atributos ['estiloMarco'] = '';
					$atributos ["etiquetaObligatorio"] = false;
					$atributos ['columnas'] = 2;
					$atributos ['dobleLinea'] = false;
					$atributos ['tabIndex'] = $tab;
					$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ['validar'] = 'custom[onlyNumberSp]';
					
					if (isset ( $_REQUEST [$esteCampo] )) {
						$atributos ['valor'] = $_REQUEST [$esteCampo];
					} else {
						$atributos ['valor'] = '';
					}
					$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
					$atributos ['deshabilitado'] = false;
					$atributos ['tamanno'] = 25;
					$atributos ['maximoTamanno'] = '';
					$atributos ['anchoEtiqueta'] = 295;
					$tab ++;
					
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'tiempo3SM';
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
					$atributos ['anchoEtiqueta'] = 80;
					
					$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_periodo" );
					
					$matrizItems = $esteRecursoDBP->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
					
					$atributos ['matrizItems'] = $matrizItems;
					
					// Utilizar lo siguiente cuando no se pase un arreglo:
					// $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
					// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
					$tab ++;
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroLista ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'rango4SM';
					$atributos ['id'] = $esteCampo;
					$atributos ['nombre'] = $esteCampo;
					$atributos ['tipo'] = 'text';
					$atributos ['estilo'] = 'jqueryui';
					$atributos ['marco'] = true;
					$atributos ['estiloMarco'] = '';
					$atributos ["etiquetaObligatorio"] = false;
					$atributos ['columnas'] = 2;
					$atributos ['dobleLinea'] = false;
					$atributos ['tabIndex'] = $tab;
					$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ['validar'] = 'custom[onlyNumberSp]';
					
					if (isset ( $_REQUEST [$esteCampo] )) {
						$atributos ['valor'] = $_REQUEST [$esteCampo];
					} else {
						$atributos ['valor'] = '';
					}
					$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
					$atributos ['deshabilitado'] = false;
					$atributos ['tamanno'] = 25;
					$atributos ['maximoTamanno'] = '';
					$atributos ['anchoEtiqueta'] = 295;
					$tab ++;
					
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'tiempo4SM';
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
					$atributos ['anchoEtiqueta'] = 80;
					
					$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_periodo" );
					
					$matrizItems = $esteRecursoDBP->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
					
					$atributos ['matrizItems'] = $matrizItems;
					
					// Utilizar lo siguiente cuando no se pase un arreglo:
					// $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
					// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
					$tab ++;
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroLista ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'rango5SM';
					$atributos ['id'] = $esteCampo;
					$atributos ['nombre'] = $esteCampo;
					$atributos ['tipo'] = 'text';
					$atributos ['estilo'] = 'jqueryui';
					$atributos ['marco'] = true;
					$atributos ['estiloMarco'] = '';
					$atributos ["etiquetaObligatorio"] = false;
					$atributos ['columnas'] = 2;
					$atributos ['dobleLinea'] = false;
					$atributos ['tabIndex'] = $tab;
					$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ['validar'] = 'custom[onlyNumberSp]';
					
					if (isset ( $_REQUEST [$esteCampo] )) {
						$atributos ['valor'] = $_REQUEST [$esteCampo];
					} else {
						$atributos ['valor'] = '';
					}
					$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
					$atributos ['deshabilitado'] = false;
					$atributos ['tamanno'] = 25;
					$atributos ['maximoTamanno'] = '';
					$atributos ['anchoEtiqueta'] = 295;
					$tab ++;
					
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'tiempo5SM';
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
					$atributos ['anchoEtiqueta'] = 80;
					
					$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_periodo" );
					
					$matrizItems = $esteRecursoDBP->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
					
					$atributos ['matrizItems'] = $matrizItems;
					
					// Utilizar lo siguiente cuando no se pase un arreglo:
					// $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
					// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
					$tab ++;
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroLista ( $atributos );
					unset ( $atributos );
				}
				echo $this->miFormulario->agrupacion ( 'fin' );
				unset ( $atributos );
				
				$esteCampo = "AgrupacionBG";
				$atributos ['id'] = $esteCampo;
				$atributos ['leyenda'] = "Acua-Aviónes Privados";
				echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
				unset ( $atributos );
				{
					
					$esteCampo = 'rango1AA';
					$atributos ['id'] = $esteCampo;
					$atributos ['nombre'] = $esteCampo;
					$atributos ['tipo'] = 'text';
					$atributos ['estilo'] = 'jqueryui';
					$atributos ['marco'] = true;
					$atributos ['estiloMarco'] = '';
					$atributos ["etiquetaObligatorio"] = false;
					$atributos ['columnas'] = 2;
					$atributos ['dobleLinea'] = false;
					$atributos ['tabIndex'] = $tab;
					$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ['validar'] = 'custom[onlyNumberSp]';
					
					if (isset ( $_REQUEST [$esteCampo] )) {
						$atributos ['valor'] = $_REQUEST [$esteCampo];
					} else {
						$atributos ['valor'] = '';
					}
					$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
					$atributos ['deshabilitado'] = false;
					$atributos ['tamanno'] = 25;
					$atributos ['maximoTamanno'] = '';
					$atributos ['anchoEtiqueta'] = 295;
					$tab ++;
					
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'tiempo1AA';
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
					$atributos ['anchoEtiqueta'] = 80;
					
					$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_periodo" );
					
					$matrizItems = $esteRecursoDBP->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
					
					$atributos ['matrizItems'] = $matrizItems;
					
					// Utilizar lo siguiente cuando no se pase un arreglo:
					// $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
					// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
					$tab ++;
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroLista ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'rango2AA';
					$atributos ['id'] = $esteCampo;
					$atributos ['nombre'] = $esteCampo;
					$atributos ['tipo'] = 'text';
					$atributos ['estilo'] = 'jqueryui';
					$atributos ['marco'] = true;
					$atributos ['estiloMarco'] = '';
					$atributos ["etiquetaObligatorio"] = false;
					$atributos ['columnas'] = 2;
					$atributos ['dobleLinea'] = false;
					$atributos ['tabIndex'] = $tab;
					$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ['validar'] = 'custom[onlyNumberSp]';
					
					if (isset ( $_REQUEST [$esteCampo] )) {
						$atributos ['valor'] = $_REQUEST [$esteCampo];
					} else {
						$atributos ['valor'] = '';
					}
					$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
					$atributos ['deshabilitado'] = false;
					$atributos ['tamanno'] = 25;
					$atributos ['maximoTamanno'] = '';
					$atributos ['anchoEtiqueta'] = 295;
					$tab ++;
					
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'tiempo2AA';
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
					$atributos ['anchoEtiqueta'] = 80;
					
					$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_periodo" );
					
					$matrizItems = $esteRecursoDBP->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
					
					$atributos ['matrizItems'] = $matrizItems;
					
					// Utilizar lo siguiente cuando no se pase un arreglo:
					// $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
					// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
					$tab ++;
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroLista ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'rango3AA';
					$atributos ['id'] = $esteCampo;
					$atributos ['nombre'] = $esteCampo;
					$atributos ['tipo'] = 'text';
					$atributos ['estilo'] = 'jqueryui';
					$atributos ['marco'] = true;
					$atributos ['estiloMarco'] = '';
					$atributos ["etiquetaObligatorio"] = false;
					$atributos ['columnas'] = 2;
					$atributos ['dobleLinea'] = false;
					$atributos ['tabIndex'] = $tab;
					$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ['validar'] = 'custom[onlyNumberSp]';
					
					if (isset ( $_REQUEST [$esteCampo] )) {
						$atributos ['valor'] = $_REQUEST [$esteCampo];
					} else {
						$atributos ['valor'] = '';
					}
					$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
					$atributos ['deshabilitado'] = false;
					$atributos ['tamanno'] = 25;
					$atributos ['maximoTamanno'] = '';
					$atributos ['anchoEtiqueta'] = 295;
					$tab ++;
					
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'tiempo3AA';
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
					$atributos ['anchoEtiqueta'] = 80;
					
					$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_periodo" );
					
					$matrizItems = $esteRecursoDBP->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
					
					$atributos ['matrizItems'] = $matrizItems;
					
					// Utilizar lo siguiente cuando no se pase un arreglo:
					// $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
					// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
					$tab ++;
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroLista ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'rango4AA';
					$atributos ['id'] = $esteCampo;
					$atributos ['nombre'] = $esteCampo;
					$atributos ['tipo'] = 'text';
					$atributos ['estilo'] = 'jqueryui';
					$atributos ['marco'] = true;
					$atributos ['estiloMarco'] = '';
					$atributos ["etiquetaObligatorio"] = false;
					$atributos ['columnas'] = 2;
					$atributos ['dobleLinea'] = false;
					$atributos ['tabIndex'] = $tab;
					$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ['validar'] = 'custom[onlyNumberSp]';
					
					if (isset ( $_REQUEST [$esteCampo] )) {
						$atributos ['valor'] = $_REQUEST [$esteCampo];
					} else {
						$atributos ['valor'] = '';
					}
					$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
					$atributos ['deshabilitado'] = false;
					$atributos ['tamanno'] = 25;
					$atributos ['maximoTamanno'] = '';
					$atributos ['anchoEtiqueta'] = 295;
					$tab ++;
					
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					
					$esteCampo = 'tiempo4AA';
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
					$atributos ['anchoEtiqueta'] = 80;
					
					$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_periodo" );
					
					$matrizItems = $esteRecursoDBP->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
					
					$atributos ['matrizItems'] = $matrizItems;
					
					// Utilizar lo siguiente cuando no se pase un arreglo:
					// $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
					// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
					$tab ++;
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroLista ( $atributos );
					unset ( $atributos );
				}
				echo $this->miFormulario->agrupacion ( 'fin' );
				unset ( $atributos );
				
				$esteCampo = 'num_bq_gr'; // Número de Buques Grandes
				$atributos ['id'] = $esteCampo;
				$atributos ['nombre'] = $esteCampo;
				$atributos ['tipo'] = 'text';
				$atributos ['estilo'] = 'jqueryui';
				$atributos ['marco'] = true;
				$atributos ['estiloMarco'] = '';
				$atributos ["etiquetaObligatorio"] = false;
				$atributos ['columnas'] = 2;
				$atributos ['dobleLinea'] = false;
				$atributos ['tabIndex'] = $tab;
				$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ['validar'] = 'custom[onlyNumberSp]';
				
				if (isset ( $_REQUEST [$esteCampo] )) {
					$atributos ['valor'] = $_REQUEST [$esteCampo];
				} else {
					$atributos ['valor'] = '';
				}
				$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
				$atributos ['deshabilitado'] = false;
				$atributos ['tamanno'] = 25;
				$atributos ['maximoTamanno'] = '';
				$atributos ['anchoEtiqueta'] = 295;
				$tab ++;
				
				// Aplica atributos globales al control
				$atributos = array_merge ( $atributos, $atributosGlobales );
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				$esteCampo = 'tiempo_bq_gr'; // Periodo de Buques Pequeños
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
				$atributos ['anchoEtiqueta'] = 80;
				
				$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_periodo" );
				
				$matrizItems = $esteRecursoDBP->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
				
				$atributos ['matrizItems'] = $matrizItems;
				
				// Utilizar lo siguiente cuando no se pase un arreglo:
				// $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
				// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
				$tab ++;
				$atributos = array_merge ( $atributos, $atributosGlobales );
				echo $this->miFormulario->campoCuadroLista ( $atributos );
				unset ( $atributos );
				
				$esteCampo = 'num_bq_pq'; // Número de Buques Grandes
				$atributos ['id'] = $esteCampo;
				$atributos ['nombre'] = $esteCampo;
				$atributos ['tipo'] = 'text';
				$atributos ['estilo'] = 'jqueryui';
				$atributos ['marco'] = true;
				$atributos ['estiloMarco'] = '';
				$atributos ["etiquetaObligatorio"] = false;
				$atributos ['columnas'] = 2;
				$atributos ['dobleLinea'] = false;
				$atributos ['tabIndex'] = $tab;
				$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ['validar'] = 'custom[onlyNumberSp]';
				
				if (isset ( $_REQUEST [$esteCampo] )) {
					$atributos ['valor'] = $_REQUEST [$esteCampo];
				} else {
					$atributos ['valor'] = '';
				}
				$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
				$atributos ['deshabilitado'] = false;
				$atributos ['tamanno'] = 25;
				$atributos ['maximoTamanno'] = '';
				$atributos ['anchoEtiqueta'] = 295;
				$tab ++;
				
				// Aplica atributos globales al control
				$atributos = array_merge ( $atributos, $atributosGlobales );
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				$esteCampo = 'tiempo_bq_pq'; // Periodo de Buques Grandes
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
				$atributos ['anchoEtiqueta'] = 80;
				
				$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_periodo" );
				
				$matrizItems = $esteRecursoDBP->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
				
				$atributos ['matrizItems'] = $matrizItems;
				
				// Utilizar lo siguiente cuando no se pase un arreglo:
				// $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
				// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
				$tab ++;
				$atributos = array_merge ( $atributos, $atributosGlobales );
				echo $this->miFormulario->campoCuadroLista ( $atributos );
				unset ( $atributos );
			}
			echo $this->miFormulario->agrupacion ( 'fin' );
			unset ( $atributos );
			
			$esteCampo = "AgrupacionBG";
			$atributos ['id'] = $esteCampo;
			$atributos ['leyenda'] = "Configuración de la Hidrovía";
			echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
			unset ( $atributos );
			{
				
				$esteCampo = 'pr_co_ba'; // Profundidad / Corriente de aire / Bajo la Quilla
				$atributos ['id'] = $esteCampo;
				$atributos ['nombre'] = $esteCampo;
				$atributos ['tipo'] = 'text';
				$atributos ['estilo'] = 'jqueryui';
				$atributos ['marco'] = true;
				$atributos ['estiloMarco'] = '';
				$atributos ["etiquetaObligatorio"] = true;
				$atributos ['columnas'] = 2;
				$atributos ['dobleLinea'] = false;
				$atributos ['tabIndex'] = $tab;
				$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ['validar'] = 'required,custom[onlyNumberSp]';
				
				if (isset ( $_REQUEST [$esteCampo] )) {
					$atributos ['valor'] = $_REQUEST [$esteCampo];
				} else {
					$atributos ['valor'] = ' ';
				}
				$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
				$atributos ['deshabilitado'] = false;
				$atributos ['tamanno'] = 25;
				$atributos ['maximoTamanno'] = '';
				$atributos ['anchoEtiqueta'] = 300;
				$tab ++;
				
				// Aplica atributos globales al control
				$atributos = array_merge ( $atributos, $atributosGlobales );
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				$esteCampo = 'ancho_canal'; // Profundidad / Corriente de aire / Bajo la Quilla
				$atributos ['id'] = $esteCampo;
				$atributos ['nombre'] = $esteCampo;
				$atributos ['tipo'] = 'text';
				$atributos ['estilo'] = 'jqueryui';
				$atributos ['marco'] = true;
				$atributos ['estiloMarco'] = '';
				$atributos ["etiquetaObligatorio"] = true;
				$atributos ['columnas'] = 2;
				$atributos ['dobleLinea'] = false;
				$atributos ['tabIndex'] = $tab;
				$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ['validar'] = 'required,custom[onlyNumberSp]';
				
				if (isset ( $_REQUEST [$esteCampo] )) {
					$atributos ['valor'] = $_REQUEST [$esteCampo];
				} else {
					$atributos ['valor'] = ' ';
				}
				$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
				$atributos ['deshabilitado'] = false;
				$atributos ['tamanno'] = 25;
				$atributos ['maximoTamanno'] = '';
				$atributos ['anchoEtiqueta'] = 200;
				$tab ++;
				
				// Aplica atributos globales al control
				$atributos = array_merge ( $atributos, $atributosGlobales );
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				$esteCampo = 'obtrucciones_visibilidad';
				$atributos ['id'] = $esteCampo;
				$atributos ['nombre'] = $esteCampo;
				$atributos ['tipo'] = 'text';
				$atributos ['estilo'] = 'jqueryui';
				$atributos ['marco'] = true;
				$atributos ['estiloMarco'] = '';
				$atributos ["etiquetaObligatorio"] = true;
				$atributos ['columnas'] = 2;
				$atributos ['dobleLinea'] = false;
				$atributos ['tabIndex'] = $tab;
				$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ['validar'] = 'required';
				
				if (isset ( $_REQUEST [$esteCampo] )) {
					$atributos ['valor'] = $_REQUEST [$esteCampo];
				} else {
					$atributos ['valor'] = ' ';
				}
				$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
				$atributos ['deshabilitado'] = false;
				$atributos ['tamanno'] = 25;
				$atributos ['maximoTamanno'] = '';
				$atributos ['anchoEtiqueta'] = 300;
				$tab ++;
				
				// Aplica atributos globales al control
				$atributos = array_merge ( $atributos, $atributosGlobales );
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				$esteCampo = 'complejidad_hidrovia';
				$atributos ['id'] = $esteCampo;
				$atributos ['nombre'] = $esteCampo;
				$atributos ['tipo'] = 'text';
				$atributos ['estilo'] = 'jqueryui';
				$atributos ['marco'] = true;
				$atributos ['estiloMarco'] = '';
				$atributos ["etiquetaObligatorio"] = true;
				$atributos ['columnas'] = 2;
				$atributos ['dobleLinea'] = false;
				$atributos ['tabIndex'] = $tab;
				$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ['validar'] = 'required';
				
				if (isset ( $_REQUEST [$esteCampo] )) {
					$atributos ['valor'] = $_REQUEST [$esteCampo];
				} else {
					$atributos ['valor'] = ' ';
				}
				$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
				$atributos ['deshabilitado'] = false;
				$atributos ['tamanno'] = 25;
				$atributos ['maximoTamanno'] = '';
				$atributos ['anchoEtiqueta'] = 200;
				$tab ++;
				
				// Aplica atributos globales al control
				$atributos = array_merge ( $atributos, $atributosGlobales );
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				$esteCampo = 'tipo_fondo';
				$atributos ['id'] = $esteCampo;
				$atributos ['nombre'] = $esteCampo;
				$atributos ['tipo'] = 'text';
				$atributos ['estilo'] = 'jqueryui';
				$atributos ['marco'] = true;
				$atributos ['estiloMarco'] = '';
				$atributos ["etiquetaObligatorio"] = true;
				$atributos ['columnas'] = 2;
				$atributos ['dobleLinea'] = false;
				$atributos ['tabIndex'] = $tab;
				$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ['validar'] = 'required';
				
				if (isset ( $_REQUEST [$esteCampo] )) {
					$atributos ['valor'] = $_REQUEST [$esteCampo];
				} else {
					$atributos ['valor'] = ' ';
				}
				$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
				$atributos ['deshabilitado'] = false;
				$atributos ['tamanno'] = 25;
				$atributos ['maximoTamanno'] = '';
				$atributos ['anchoEtiqueta'] = 300;
				$tab ++;
				
				// Aplica atributos globales al control
				$atributos = array_merge ( $atributos, $atributosGlobales );
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				$esteCampo = 'estabilidad_sedimentos';
				$atributos ['id'] = $esteCampo;
				$atributos ['nombre'] = $esteCampo;
				$atributos ['tipo'] = 'text';
				$atributos ['estilo'] = 'jqueryui';
				$atributos ['marco'] = true;
				$atributos ['estiloMarco'] = '';
				$atributos ["etiquetaObligatorio"] = true;
				$atributos ['columnas'] = 2;
				$atributos ['dobleLinea'] = false;
				$atributos ['tabIndex'] = $tab;
				$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ['validar'] = 'required,custom[onlyNumberSp]';
				
				if (isset ( $_REQUEST [$esteCampo] )) {
					$atributos ['valor'] = $_REQUEST [$esteCampo];
				} else {
					$atributos ['valor'] = ' ';
				}
				$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
				$atributos ['deshabilitado'] = false;
				$atributos ['tamanno'] = 25;
				$atributos ['maximoTamanno'] = '';
				$atributos ['anchoEtiqueta'] = 200;
				$tab ++;
				
				// Aplica atributos globales al control
				$atributos = array_merge ( $atributos, $atributosGlobales );
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				
				$esteCampo = 'ayudas_navegacion';
				$atributos ['id'] = $esteCampo;
				$atributos ['nombre'] = $esteCampo;
				$atributos ['tipo'] = 'text';
				$atributos ['estilo'] = 'jqueryui';
				$atributos ['marco'] = true;
				$atributos ['estiloMarco'] = '';
				$atributos ["etiquetaObligatorio"] = true;
				$atributos ['columnas'] = 2;
				$atributos ['dobleLinea'] = false;
				$atributos ['tabIndex'] = $tab;
				$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ['validar'] = 'required';
				
				if (isset ( $_REQUEST [$esteCampo] )) {
					$atributos ['valor'] = $_REQUEST [$esteCampo];
				} else {
					$atributos ['valor'] = ' ';
				}
				$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
				$atributos ['deshabilitado'] = false;
				$atributos ['tamanno'] = 25;
				$atributos ['maximoTamanno'] = '';
				$atributos ['anchoEtiqueta'] = 300;
				$tab ++;
				
				// Aplica atributos globales al control
				$atributos = array_merge ( $atributos, $atributosGlobales );
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				
				$esteCampo ='calidad_datos';
				$atributos ['id'] = $esteCampo;
				$atributos ['nombre'] = $esteCampo;
				$atributos ['tipo'] = 'text';
				$atributos ['estilo'] = 'jqueryui';
				$atributos ['marco'] = true;
				$atributos ['estiloMarco'] = '';
				$atributos ["etiquetaObligatorio"] = true;
				$atributos ['columnas'] = 2;
				$atributos ['dobleLinea'] = false;
				$atributos ['tabIndex'] = $tab;
				$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ['validar'] = 'required,custom[onlyNumberSp]';
				
				if (isset ( $_REQUEST [$esteCampo] )) {
					$atributos ['valor'] = $_REQUEST [$esteCampo];
				} else {
					$atributos ['valor'] = ' ';
				}
				$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
				$atributos ['deshabilitado'] = false;
				$atributos ['tamanno'] = 25;
				$atributos ['maximoTamanno'] = '';
				$atributos ['anchoEtiqueta'] = 200;
				$tab ++;
				
				// Aplica atributos globales al control
				$atributos = array_merge ( $atributos, $atributosGlobales );
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
			}
			echo $this->miFormulario->agrupacion ( 'fin' );
			unset ( $atributos );
		}
		
		$esteCampo = 'num_contrato';
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;
		$atributos ['tipo'] = 'text';
		$atributos ['estilo'] = 'jqueryui';
		$atributos ['marco'] = true;
		$atributos ['estiloMarco'] = '';
		$atributos ["etiquetaObligatorio"] = true;
		$atributos ['columnas'] = 2;
		$atributos ['dobleLinea'] = 0;
		$atributos ['tabIndex'] = $tab;
		$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ['validar'] = 'required, minSize[1],maxSize[15],custom[onlyNumberSp]';
		
		if (isset ( $_REQUEST [$esteCampo] )) {
			$atributos ['valor'] = $_REQUEST [$esteCampo];
		} else {
			$atributos ['valor'] = '';
		}
		$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
		$atributos ['deshabilitado'] = false;
		$atributos ['tamanno'] = 25;
		$atributos ['maximoTamanno'] = '';
		$atributos ['anchoEtiqueta'] = 214;
		$tab ++;
		
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		
		// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
		$esteCampo = 'fecha_contrato';
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;
		$atributos ['tipo'] = 'fecha';
		$atributos ['estilo'] = 'jqueryui';
		$atributos ['marco'] = true;
		$atributos ['estiloMarco'] = '';
		$atributos ["etiquetaObligatorio"] = true;
		$atributos ['columnas'] = 2;
		$atributos ['dobleLinea'] = 0;
		$atributos ['tabIndex'] = $tab;
		$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ['validar'] = 'required,custom[date]';
		
		if (isset ( $_REQUEST [$esteCampo] )) {
			$atributos ['valor'] = $_REQUEST [$esteCampo];
		} else {
			$atributos ['valor'] = '';
		}
		$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
		$atributos ['deshabilitado'] = false;
		$atributos ['tamanno'] = 8;
		$atributos ['maximoTamanno'] = '';
		$atributos ['anchoEtiqueta'] = 214;
		$tab ++;
		
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		
		// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
		$esteCampo = 'nombre_contratista';
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;
		$atributos ['tipo'] = 'text';
		$atributos ['estilo'] = 'jqueryui';
		$atributos ['marco'] = true;
		$atributos ['estiloMarco'] = '';
		$atributos ["etiquetaObligatorio"] = true;
		$atributos ['columnas'] = 1;
		$atributos ['dobleLinea'] = 0;
		$atributos ['tabIndex'] = $tab;
		$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ['validar'] = 'required';
		$atributos ['textoFondo'] = 'Ingrese Mínimo 3 Caracteres de Búsqueda';
		
		if (isset ( $_REQUEST [$esteCampo] )) {
			$atributos ['valor'] = $_REQUEST [$esteCampo];
		} else {
			$atributos ['valor'] = '';
		}
		$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
		$atributos ['deshabilitado'] = false;
		$atributos ['tamanno'] = 64;
		$atributos ['maximoTamanno'] = '';
		$atributos ['anchoEtiqueta'] = 214;
		$tab ++;
		
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		
		$esteCampo = 'id_contratista';
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
		
		// -----------------CONTROL: Botón ----------------------------------------------------------------
		$esteCampo = "DocumentoSoporte";
		$atributos ["id"] = $esteCampo; // No cambiar este nombre
		$atributos ["nombre"] = $esteCampo;
		$atributos ["tipo"] = "file";
		// $atributos ["obligatorio"] = true;
		$atributos ["etiquetaObligatorio"] = true;
		$atributos ["tabIndex"] = $tab ++;
		$atributos ["columnas"] = 2;
		$atributos ["estilo"] = "textoIzquierda";
		$atributos ["anchoEtiqueta"] = 220;
		$atributos ["tamanno"] = 500000;
		$atributos ["validar"] = "required";
		$atributos ["etiqueta"] = $this->lenguaje->getCadena ( $esteCampo );
		// $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
		// $atributos ["valor"] = $valorCodificado;
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		
		// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
		
		/*
		 *
		 */
		
		echo "<br><br><br>";
		
		// ------------------Division para los botones-------------------------
		$atributos ["id"] = "botones";
		$atributos ["estilo"] = "marcoBotones";
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
		{
			// -----------------CONTROL: Botón ----------------------------------------------------------------
			$esteCampo = 'botonAceptar';
			$atributos ["id"] = $esteCampo;
			$atributos ["tabIndex"] = $tab;
			$atributos ["tipo"] = 'boton';
			// submit: no se coloca si se desea un tipo button genérico
			$atributos ['submit'] = 'true';
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
		
		$valorCodificado = "action=" . $esteBloque ["nombre"];
		$valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		$valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
		$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
		$valorCodificado .= "&opcion=documento";
		/**
		 * SARA permite que los nombres de los campos sean dinámicos.
		 * Para ello utiliza la hora en que es creado el formulario para
		 * codificar el nombre de cada campo.
		 */
		$valorCodificado .= "&campoSeguro=" . $_REQUEST ['tiempo'];
		
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
$miSeleccionador = new registrarForm ( $this->lenguaje, $this->miFormulario, $this->sql );
$miSeleccionador->miForm ();
?>		