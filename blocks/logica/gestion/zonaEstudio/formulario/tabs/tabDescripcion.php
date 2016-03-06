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
			$atributos ['anchoEtiqueta'] = 120;
			
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_region" );
			
			$matrizItems = $esteRecursoDBP->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
			$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
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
			
			$atributos ["id"] = "ventanaA";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			{
				
				echo "<h3>Datos Preliminares</h3>
							<section>";
				
				{
					
					$esteCampo = "AgrupacionTrafico";
					$atributos ['id'] = $esteCampo;
					$atributos ['leyenda'] = "Volumen de Tráfico";
					echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
					unset ( $atributos );
					{
						
						$atributos ["id"] = "vol_traf";
						$atributos ["estilo"] = " ";
						$atributos ["estiloEnLinea"] = "display:none";
						echo $this->miFormulario->division ( "inicio", $atributos );
						unset ( $atributos );
						{
							
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
								$atributos ['tamanno'] = 15;
								$atributos ['maximoTamanno'] = '';
								$atributos ['anchoEtiqueta'] = 270;
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
								$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
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
								$atributos ['tamanno'] = 15;
								$atributos ['maximoTamanno'] = '';
								$atributos ['anchoEtiqueta'] = 270;
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
								$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
								
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
								$atributos ['tamanno'] = 15;
								$atributos ['maximoTamanno'] = '';
								$atributos ['anchoEtiqueta'] = 270;
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
								$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
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
								$atributos ['tamanno'] = 15;
								$atributos ['maximoTamanno'] = '';
								$atributos ['anchoEtiqueta'] = 270;
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
								$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
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
								$atributos ['tamanno'] = 15;
								$atributos ['maximoTamanno'] = '';
								$atributos ['anchoEtiqueta'] = 270;
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
								$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
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
								$atributos ['tamanno'] = 15;
								$atributos ['maximoTamanno'] = '';
								$atributos ['anchoEtiqueta'] = 270;
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
								$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
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
								$atributos ['tamanno'] = 15;
								$atributos ['maximoTamanno'] = '';
								$atributos ['anchoEtiqueta'] = 270;
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
								$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
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
								$atributos ['tamanno'] = 15;
								$atributos ['maximoTamanno'] = '';
								$atributos ['anchoEtiqueta'] = 270;
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
								$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
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
								$atributos ['tamanno'] = 15;
								$atributos ['maximoTamanno'] = '';
								$atributos ['anchoEtiqueta'] = 270;
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
								$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
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
								$atributos ['tamanno'] = 15;
								$atributos ['maximoTamanno'] = '';
								$atributos ['anchoEtiqueta'] = 270;
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
								$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
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
								$atributos ['tamanno'] = 15;
								$atributos ['maximoTamanno'] = '';
								$atributos ['anchoEtiqueta'] = 270;
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
								$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
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
							
							$esteCampo = "AgrupacionBPES";
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
								$atributos ['tamanno'] = 15;
								$atributos ['maximoTamanno'] = '';
								$atributos ['anchoEtiqueta'] = 270;
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
								$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
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
							
							$esteCampo = "AgrupacionSM";
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
								$atributos ['tamanno'] = 15;
								$atributos ['maximoTamanno'] = '';
								$atributos ['anchoEtiqueta'] = 270;
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
								$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
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
								$atributos ['tamanno'] = 15;
								$atributos ['maximoTamanno'] = '';
								$atributos ['anchoEtiqueta'] = 270;
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
								$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
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
								$atributos ['tamanno'] = 15;
								$atributos ['maximoTamanno'] = '';
								$atributos ['anchoEtiqueta'] = 270;
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
								$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
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
								$atributos ['tamanno'] = 15;
								$atributos ['maximoTamanno'] = '';
								$atributos ['anchoEtiqueta'] = 270;
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
								$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
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
								$atributos ['tamanno'] = 15;
								$atributos ['maximoTamanno'] = '';
								$atributos ['anchoEtiqueta'] = 270;
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
								$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
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
							
							$esteCampo = "AgrupacionAP";
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
								$atributos ['tamanno'] = 15;
								$atributos ['maximoTamanno'] = '';
								$atributos ['anchoEtiqueta'] = 270;
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
								$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
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
								$atributos ['tamanno'] = 15;
								$atributos ['maximoTamanno'] = '';
								$atributos ['anchoEtiqueta'] = 270;
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
								$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
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
								$atributos ['tamanno'] = 15;
								$atributos ['maximoTamanno'] = '';
								$atributos ['anchoEtiqueta'] = 270;
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
								$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
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
								$atributos ['tamanno'] = 15;
								$atributos ['maximoTamanno'] = '';
								$atributos ['anchoEtiqueta'] = 270;
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
								$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
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
							$atributos ['tamanno'] = 15;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 270;
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
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
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
							$atributos ['tamanno'] = 15;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 270;
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
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
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
						echo $this->miFormulario->division ( "fin" );
					}
					echo $this->miFormulario->agrupacion ( 'fin' );
					unset ( $atributos );
					
					$esteCampo = "AgrupacionCH";
					$atributos ['id'] = $esteCampo;
					$atributos ['leyenda'] = "Configuración de la Hidrovía";
					echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
					unset ( $atributos );
					{
						
						$atributos ["id"] = "conf_hidro";
						$atributos ["estilo"] = " ";
						$atributos ["estiloEnLinea"] = "display:none";
						echo $this->miFormulario->division ( "inicio", $atributos );
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
							$atributos ['tamanno'] = 15;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 290;
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
							$atributos ['tamanno'] = 15;
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
							$atributos ['tamanno'] = 15;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 290;
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
							$atributos ['tamanno'] = 15;
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
							$atributos ['tamanno'] = 15;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 290;
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
							$atributos ['tamanno'] = 15;
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
							$atributos ['tamanno'] = 15;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 290;
							$tab ++;
							
							// Aplica atributos globales al control
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroTexto ( $atributos );
							unset ( $atributos );
							
							$esteCampo = 'calidad_datos';
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
							$atributos ['tamanno'] = 15;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 200;
							$tab ++;
							
							// Aplica atributos globales al control
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroTexto ( $atributos );
							unset ( $atributos );
						}
						echo $this->miFormulario->division ( "fin" );
					}
					
					echo $this->miFormulario->agrupacion ( 'fin' );
					unset ( $atributos );
				}
				
				$esteCampo = "AgrupacionSnS";
				$atributos ['id'] = $esteCampo;
				$atributos ['leyenda'] = "Descripción del Sistema de Señalización Graficado Sobre Carta Náutica";
				echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
				unset ( $atributos );
				{
					
					$atributos ["id"] = "se_gr_ca";
					$atributos ["estilo"] = " ";
					$atributos ["estiloEnLinea"] = "display:none";
					echo $this->miFormulario->division ( "inicio", $atributos );
					unset ( $atributos );
					{
						
						$esteCampo = 'bo_mo_for_re'; // Boyas monitorizados de forma remota con AIS
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
						$atributos ['tamanno'] = 15;
						$atributos ['maximoTamanno'] = '';
						$atributos ['anchoEtiqueta'] = 290;
						$tab ++;
						
						// Aplica atributos globales al control
						$atributos = array_merge ( $atributos, $atributosGlobales );
						echo $this->miFormulario->campoCuadroTexto ( $atributos );
						unset ( $atributos );
						
						$esteCampo = 'bo_si_ais_no_super'; // Boyas sin AIS o no supervisados
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
						$atributos ['tamanno'] = 15;
						$atributos ['maximoTamanno'] = '';
						$atributos ['anchoEtiqueta'] = 200;
						$tab ++;
						
						// Aplica atributos globales al control
						$atributos = array_merge ( $atributos, $atributosGlobales );
						echo $this->miFormulario->campoCuadroTexto ( $atributos );
						unset ( $atributos );
						
						$esteCampo = 'racon'; // Racon
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
						$atributos ['tamanno'] = 15;
						$atributos ['maximoTamanno'] = '';
						$atributos ['anchoEtiqueta'] = 290;
						$tab ++;
						
						// Aplica atributos globales al control
						$atributos = array_merge ( $atributos, $atributosGlobales );
						echo $this->miFormulario->campoCuadroTexto ( $atributos );
						unset ( $atributos );
						
						$esteCampo = 'linterna'; // Linternas
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
						$atributos ['tamanno'] = 15;
						$atributos ['maximoTamanno'] = '';
						$atributos ['anchoEtiqueta'] = 200;
						$tab ++;
						
						// Aplica atributos globales al control
						$atributos = array_merge ( $atributos, $atributosGlobales );
						echo $this->miFormulario->campoCuadroTexto ( $atributos );
						unset ( $atributos );
						
						$esteCampo = 'ort_aton'; // Otras AtoN
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
						$atributos ['tamanno'] = 15;
						$atributos ['maximoTamanno'] = '';
						$atributos ['anchoEtiqueta'] = 290;
						$tab ++;
						
						// Aplica atributos globales al control
						$atributos = array_merge ( $atributos, $atributosGlobales );
						echo $this->miFormulario->campoCuadroTexto ( $atributos );
						unset ( $atributos );
						
						$esteCampo = 'g_gps'; // GPS diferencial
						$atributos ['nombre'] = $esteCampo;
						$atributos ['id'] = $esteCampo;
						$atributos ['seleccion'] = 0;
						$atributos ['evento'] = '';
						$atributos ['deshabilitado'] = false;
						$atributos ["etiquetaObligatorio"] = false;
						$atributos ['tab'] = $tab;
						$atributos ['tamanno'] = 1;
						$atributos ['columnas'] = 2;
						$atributos ['estilo'] = 'jqueryui';
						$atributos ['validar'] = 'required';
						$atributos ['limitar'] = false;
						$atributos ['anchoCaja'] = 70;
						$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
						$atributos ['anchoEtiqueta'] = 200;
						$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
						
						$matrizItems = array (
								array (
										0,
										"NO" 
								),
								array (
										1,
										"SI" 
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
						
						$esteCampo = 'ds_stm'; // Servicion de Trafico Maritimo
						$atributos ['nombre'] = $esteCampo;
						$atributos ['id'] = $esteCampo;
						$atributos ['seleccion'] = 0;
						$atributos ['evento'] = '';
						$atributos ['deshabilitado'] = false;
						$atributos ["etiquetaObligatorio"] = false;
						$atributos ['tab'] = $tab;
						$atributos ['tamanno'] = 1;
						$atributos ['columnas'] = 2;
						$atributos ['estilo'] = 'jqueryui';
						$atributos ['validar'] = 'required';
						$atributos ['limitar'] = false;
						$atributos ['anchoCaja'] = 10;
						$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
						$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
						$atributos ['anchoEtiqueta'] = 290;
						
						$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_periodo" );
						
						$matrizItems = array (
								array (
										0,
										"NO" 
								),
								array (
										1,
										"SI" 
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
						
						$esteCampo = 'ds_srv_pl'; // Disponible al Servicio de Pilotos
						$atributos ['nombre'] = $esteCampo;
						$atributos ['id'] = $esteCampo;
						$atributos ['seleccion'] = 0;
						$atributos ['evento'] = '';
						$atributos ['deshabilitado'] = false;
						$atributos ["etiquetaObligatorio"] = false;
						$atributos ['tab'] = $tab;
						$atributos ['tamanno'] = 1;
						$atributos ['columnas'] = 2;
						$atributos ['estilo'] = 'jqueryui';
						$atributos ['validar'] = 'required';
						$atributos ['limitar'] = false;
						$atributos ['anchoCaja'] = 70;
						$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
						$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
						$atributos ['anchoEtiqueta'] = 200;
						
						$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_periodo" );
						
						$matrizItems = array (
								array (
										0,
										"NO" 
								),
								array (
										1,
										"SI" 
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
						// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
						$esteCampo = 'obser_des__sis_sn'; // Observaciones Sistema de Señalización
						$atributos ['id'] = $esteCampo;
						$atributos ['nombre'] = $esteCampo;
						$atributos ['tipo'] = 'text';
						$atributos ['estilo'] = 'jqueryui';
						$atributos ['marco'] = true;
						$atributos ['estiloMarco'] = '';
						$atributos ["etiquetaObligatorio"] = true;
						$atributos ['columnas'] = 80;
						$atributos ['filas'] = 5;
						$atributos ['dobleLinea'] = 0;
						$atributos ['tabIndex'] = $tab;
						$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
						$atributos ['validar'] = 'maxSize[4000]';
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
					}
					echo $this->miFormulario->division ( "fin" );
				}
				echo $this->miFormulario->agrupacion ( 'fin' );
				unset ( $atributos );
				
				$esteCampo = "AgrupacionCNC";
				$atributos ['id'] = $esteCampo;
				$atributos ['leyenda'] = "Condiciones de Navegación";
				echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
				unset ( $atributos );
				{
					
					$atributos ["id"] = "cond_nave";
					$atributos ["estilo"] = " ";
					$atributos ["estiloEnLinea"] = "display:none";
					echo $this->miFormulario->division ( "inicio", $atributos );
					unset ( $atributos );
					{
						
						$esteCampo = 'opera_nc_di'; // Operaciones Noche / Dia
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
						$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
						$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
						$atributos ['anchoEtiqueta'] = 290;
						
						$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_periodo" );
						
						$matrizItems = array (
								array (
										0,
										"Noche" 
								),
								array (
										1,
										"Día" 
								),
								array (
										2,
										"Noche-Día" 
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
						
						$esteCampo = 'estado_mar'; // Estado Mar
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
						$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
						$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
						$atributos ['anchoEtiqueta'] = 200;
						
						$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_estado_mar" );
						$matrizItems = $esteRecursoDBP->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
						
						$atributos ['matrizItems'] = $matrizItems;
						
						// Utilizar lo siguiente cuando no se pase un arreglo:
						// $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
						// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
						$tab ++;
						$atributos = array_merge ( $atributos, $atributosGlobales );
						echo $this->miFormulario->campoCuadroLista ( $atributos );
						unset ( $atributos );
						
						// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
						$esteCampo = 'obser_des__vi_mr'; // Observaciones Sistema de Señalización
						$atributos ['id'] = $esteCampo;
						$atributos ['nombre'] = $esteCampo;
						$atributos ['tipo'] = 'text';
						$atributos ['estilo'] = 'jqueryui';
						$atributos ['marco'] = true;
						$atributos ['estiloMarco'] = '';
						$atributos ["etiquetaObligatorio"] = true;
						$atributos ['columnas'] = 80;
						$atributos ['filas'] = 5;
						$atributos ['dobleLinea'] = 0;
						$atributos ['tabIndex'] = $tab;
						$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
						$atributos ['validar'] = 'maxSize[4000]';
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
						
						$esteCampo = 'visibilidad'; // visibilidad
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
						$atributos ['tamanno'] = 15;
						$atributos ['maximoTamanno'] = '';
						$atributos ['anchoEtiqueta'] = 290;
						$tab ++;
						
						// Aplica atributos globales al control
						$atributos = array_merge ( $atributos, $atributosGlobales );
						echo $this->miFormulario->campoCuadroTexto ( $atributos );
						unset ( $atributos );
						
						$esteCampo = 'con_hielo'; // Condiciones Hielo
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
						$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
						$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
						$atributos ['anchoEtiqueta'] = 200;
						
						$matrizItems = array (
								array (
										0,
										"No Existe" 
								),
								array (
										1,
										"Existe" 
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
						
						$esteCampo = 'ilum_fondo'; // Iluminación de Fondo
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
						$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
						$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
						$atributos ['anchoEtiqueta'] = 290;
						
						$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_periodo" );
						
						$matrizItems = array (
								array (
										0,
										"Buena" 
								),
								array (
										1,
										"Regular" 
								),
								array (
										2,
										"Mala" 
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
						
						// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
						$esteCampo = 'obser_escom'; // Observaciones Escombros
						$atributos ['id'] = $esteCampo;
						$atributos ['nombre'] = $esteCampo;
						$atributos ['tipo'] = 'text';
						$atributos ['estilo'] = 'jqueryui';
						$atributos ['marco'] = true;
						$atributos ['estiloMarco'] = '';
						$atributos ["etiquetaObligatorio"] = true;
						$atributos ['columnas'] = 80;
						$atributos ['filas'] = 5;
						$atributos ['dobleLinea'] = 0;
						$atributos ['tabIndex'] = $tab;
						$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
						$atributos ['validar'] = 'maxSize[4000]';
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
					}
					echo $this->miFormulario->division ( "fin" );
				}
				echo $this->miFormulario->agrupacion ( 'fin' );
				unset ( $atributos );
				
				$esteCampo = "AgrupacionNS";
				$atributos ['id'] = $esteCampo;
				$atributos ['leyenda'] = "Nivel Servicio";
				echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
				unset ( $atributos );
				{
					
					$atributos ["id"] = "niv_serv";
					$atributos ["estilo"] = " ";
					$atributos ["estiloEnLinea"] = "display:none";
					echo $this->miFormulario->division ( "inicio", $atributos );
					unset ( $atributos );
					{
						
						// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
						$esteCampo = 'mn_stm'; // Observaciones Escombros
						$atributos ['id'] = $esteCampo;
						$atributos ['nombre'] = $esteCampo;
						$atributos ['tipo'] = 'text';
						$atributos ['estilo'] = 'jqueryui';
						$atributos ['marco'] = true;
						$atributos ['estiloMarco'] = '';
						$atributos ["etiquetaObligatorio"] = true;
						$atributos ['columnas'] = 80;
						$atributos ['filas'] = 5;
						$atributos ['dobleLinea'] = 0;
						$atributos ['tabIndex'] = $tab;
						$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
						$atributos ['validar'] = 'maxSize[4000]';
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
					}
					echo $this->miFormulario->division ( "fin" );
				}
				echo $this->miFormulario->agrupacion ( 'fin' );
				unset ( $atributos );
			}
			
			echo "</section>
							<h3>Evaluación Peligros</h3>
							<section>";
			{
				
				$esteCampo = "AgrupacionPNaturales";
				$atributos ['id'] = $esteCampo;
				$atributos ['leyenda'] = "Naturales";
				echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
				unset ( $atributos );
				{
					$esteCampo = "AgrupacionPRO";
					$atributos ['id'] = $esteCampo;
					$atributos ['leyenda'] = "Profundidad y Olas";
					echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
					unset ( $atributos );
					{
						
						$atributos ["id"] = "Prd_olas";
						$atributos ["estilo"] = " ";
						$atributos ["estiloEnLinea"] = "display:none";
						echo $this->miFormulario->division ( "inicio", $atributos );
						unset ( $atributos );
						{
							
							$esteCampo = 'cal_max_buques'; // Calado Máximo de los Buques
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
							$atributos ['validar'] = 'required,custom[onlyNumberSp]';
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['valor'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['valor'] = '';
							}
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
							$atributos ['deshabilitado'] = false;
							$atributos ['tamanno'] = 15;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 270;
							$tab ++;
							
							// Aplica atributos globales al control
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroTexto ( $atributos );
							unset ( $atributos );
							
							$esteCampo = 'hg_bj_quilla'; // Holgura Bajo la Quilla
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
							$atributos ['validar'] = 'required,custom[onlyNumberSp]';
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['valor'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['valor'] = '';
							}
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
							$atributos ['deshabilitado'] = false;
							$atributos ['tamanno'] = 15;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 270;
							$tab ++;
							
							// Aplica atributos globales al control
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroTexto ( $atributos );
							unset ( $atributos );
							
							$esteCampo = 'mx_oleaje_pre'; // Máxima Oleaje Predicho
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
							$atributos ['validar'] = 'required,custom[onlyNumberSp]';
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['valor'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['valor'] = '';
							}
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
							$atributos ['deshabilitado'] = false;
							$atributos ['tamanno'] = 15;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 270;
							$tab ++;
							
							// Aplica atributos globales al control
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroTexto ( $atributos );
							unset ( $atributos );
							
							$esteCampo = 'sd_mx_anual'; // Sedimentación Maxima Anual
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
							$atributos ['validar'] = 'required,custom[onlyNumberSp]';
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['valor'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['valor'] = '';
							}
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
							$atributos ['deshabilitado'] = false;
							$atributos ['tamanno'] = 15;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 270;
							$tab ++;
							
							// Aplica atributos globales al control
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroTexto ( $atributos );
							unset ( $atributos );
							
							$esteCampo = 'pr_mn_seguridad'; // Profundidad Mínima Seguridad
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
							$atributos ['validar'] = 'required,custom[onlyNumberSp]';
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['valor'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['valor'] = '';
							}
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
							$atributos ['deshabilitado'] = false;
							$atributos ['tamanno'] = 15;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 270;
							$tab ++;
							
							// Aplica atributos globales al control
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroTexto ( $atributos );
							unset ( $atributos );
							
							$esteCampo = 'ach_canal'; // Anchura del Canal
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
							$atributos ['validar'] = 'required,custom[onlyNumberSp]';
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['valor'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['valor'] = '';
							}
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
							$atributos ['deshabilitado'] = false;
							$atributos ['tamanno'] = 15;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 270;
							$tab ++;
							
							// Aplica atributos globales al control
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroTexto ( $atributos );
							unset ( $atributos );
						}
						echo $this->miFormulario->division ( "fin" );
						unset ( $atributos );
					}
					
					echo $this->miFormulario->agrupacion ( 'fin' );
					unset ( $atributos );
					
					$esteCampo = "AgrupacionFM";
					$atributos ['id'] = $esteCampo;
					$atributos ['leyenda'] = "Flujo de la Marea";
					echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
					unset ( $atributos );
					{
						
						$atributos ["id"] = "fluj_marea";
						$atributos ["estilo"] = " ";
						$atributos ["estiloEnLinea"] = "display:none";
						echo $this->miFormulario->division ( "inicio", $atributos );
						unset ( $atributos );
						{
							
							$esteCampo = 'ts_maxima'; // Tasa Máxima
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
							$atributos ['validar'] = 'required,custom[number],min[0],max[1]';
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['valor'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['valor'] = '';
							}
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
							$atributos ['deshabilitado'] = false;
							$atributos ['tamanno'] = 15;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 270;
							$tab ++;
							
							// Aplica atributos globales al control
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroTexto ( $atributos );
							unset ( $atributos );
							
							// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
							$esteCampo = 'ob_fluj_marea'; // Observaciones
							$atributos ['id'] = $esteCampo;
							$atributos ['nombre'] = $esteCampo;
							$atributos ['tipo'] = 'text';
							$atributos ['estilo'] = 'jqueryui';
							$atributos ['marco'] = true;
							$atributos ['estiloMarco'] = '';
							$atributos ["etiquetaObligatorio"] = true;
							$atributos ['columnas'] = 90;
							$atributos ['filas'] = 5;
							$atributos ['dobleLinea'] = 0;
							$atributos ['tabIndex'] = $tab;
							$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
							$atributos ['validar'] = 'maxSize[4000]';
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
						}
						echo $this->miFormulario->division ( "fin" );
						unset ( $atributos );
					}
					echo $this->miFormulario->agrupacion ( 'fin' );
					unset ( $atributos );
					
					$esteCampo = "AgrupacionVT";
					$atributos ['id'] = $esteCampo;
					$atributos ['leyenda'] = "Viento y Tormentas";
					echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
					unset ( $atributos );
					{
						
						$atributos ["id"] = "vnt_torm";
						$atributos ["estilo"] = " ";
						$atributos ["estiloEnLinea"] = "display:none";
						echo $this->miFormulario->division ( "inicio", $atributos );
						unset ( $atributos );
						{
							
							$esteCampo = 'pr_maxima'; // Predicción Máxima Escala Beaufort
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
							$atributos ['anchoEtiqueta'] = 180;
							
							$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_escala_beaufort" );
							
							$matrizItems = $esteRecursoDBP->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
							$atributos ['matrizItems'] = $matrizItems;
							
							// Utilizar lo siguiente cuando no se pase un arreglo:
							// $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
							// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
							$tab ++;
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroLista ( $atributos );
							unset ( $atributos );
							// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
							$esteCampo = 'ob_temp_dirr'; // Observaciones Temporada y Dirección
							$atributos ['id'] = $esteCampo;
							$atributos ['nombre'] = $esteCampo;
							$atributos ['tipo'] = 'text';
							$atributos ['estilo'] = 'jqueryui';
							$atributos ['marco'] = true;
							$atributos ['estiloMarco'] = '';
							$atributos ["etiquetaObligatorio"] = true;
							$atributos ['columnas'] = 90;
							$atributos ['filas'] = 5;
							$atributos ['dobleLinea'] = 0;
							$atributos ['tabIndex'] = $tab;
							$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
							$atributos ['validar'] = 'maxSize[4000]';
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
						}
						echo $this->miFormulario->division ( "fin" );
						unset ( $atributos );
					}
					echo $this->miFormulario->agrupacion ( 'fin' );
					unset ( $atributos );
					
					$esteCampo = "AgrupacionEC";
					$atributos ['id'] = $esteCampo;
					$atributos ['leyenda'] = "Efecto Combinado";
					echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
					unset ( $atributos );
					{
						
						$atributos ["id"] = "efect_comb";
						$atributos ["estilo"] = " ";
						$atributos ["estiloEnLinea"] = "display:none";
						echo $this->miFormulario->division ( "inicio", $atributos );
						unset ( $atributos );
						{
							
							$esteCampo = 'pr_maxima_dgl'; // Predicción Máxima Escala Douglas
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
							$atributos ['anchoEtiqueta'] = 180;
							
							$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_escala_beaufort" );
							
							$matrizItems = $esteRecursoDBP->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
							$atributos ['matrizItems'] = $matrizItems;
							
							// Utilizar lo siguiente cuando no se pase un arreglo:
							// $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
							// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
							$tab ++;
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroLista ( $atributos );
							unset ( $atributos );
							
							// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
							$esteCampo = 'ob_temp_dirr_com'; // Observaciones Temporada y Dirección Combinados
							$atributos ['id'] = $esteCampo;
							$atributos ['nombre'] = $esteCampo;
							$atributos ['tipo'] = 'text';
							$atributos ['estilo'] = 'jqueryui';
							$atributos ['marco'] = true;
							$atributos ['estiloMarco'] = '';
							$atributos ["etiquetaObligatorio"] = true;
							$atributos ['columnas'] = 90;
							$atributos ['filas'] = 5;
							$atributos ['dobleLinea'] = 0;
							$atributos ['tabIndex'] = $tab;
							$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
							$atributos ['validar'] = 'maxSize[4000]';
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
						}
						echo $this->miFormulario->division ( "fin" );
						unset ( $atributos );
					}
					echo $this->miFormulario->agrupacion ( 'fin' );
					unset ( $atributos );
					
					$esteCampo = "AgrupacionTP";
					$atributos ['id'] = $esteCampo;
					$atributos ['leyenda'] = "Terreno y Peligros";
					echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
					unset ( $atributos );
					{
						
						$atributos ["id"] = "terr_pelgr";
						$atributos ["estilo"] = " ";
						$atributos ["estiloEnLinea"] = "display:none";
						echo $this->miFormulario->division ( "inicio", $atributos );
						unset ( $atributos );
						{
							
							$esteCampo = 'pnt_cr_tr'; // Distancia Punto de la Tierra Mas Cercana
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
							$atributos ['validar'] = 'required,custom[number], min[0.01]';
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['valor'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['valor'] = '';
							}
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
							$atributos ['deshabilitado'] = false;
							$atributos ['tamanno'] = 15;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 150;
							$tab ++;
							
							// Aplica atributos globales al control
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroTexto ( $atributos );
							unset ( $atributos );
							
							$esteCampo = 'ob_pt_ct_tr'; // Observaciones Puntos de la Tierra Mas Cercana
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
							$atributos ['validar'] = '';
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['valor'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['valor'] = '';
							}
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
							$atributos ['deshabilitado'] = false;
							$atributos ['tamanno'] = 30;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 90;
							$tab ++;
							
							// Aplica atributos globales al control
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroTexto ( $atributos );
							unset ( $atributos );
							
							// ------------------Division para los botones-------------------------
							$atributos ["id"] = "Salto Linea";
							$atributos ["estiloEnLinea"] = "clear:both;";
							echo $this->miFormulario->division ( "inicio", $atributos );
							unset ( $atributos );
							
							{
								$esteCampo = 'prl_max_cr'; // Distancia Punto de peligro Mas Cercano
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
								$atributos ['validar'] = 'required,custom[number], min[0.01]';
								
								if (isset ( $_REQUEST [$esteCampo] )) {
									$atributos ['valor'] = $_REQUEST [$esteCampo];
								} else {
									$atributos ['valor'] = '';
								}
								$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
								$atributos ['deshabilitado'] = false;
								$atributos ['tamanno'] = 15;
								$atributos ['maximoTamanno'] = '';
								$atributos ['anchoEtiqueta'] = 150;
								$tab ++;
								
								// Aplica atributos globales al control
								$atributos = array_merge ( $atributos, $atributosGlobales );
								echo $this->miFormulario->campoCuadroTexto ( $atributos );
								unset ( $atributos );
								
								$esteCampo = 'ob_prl_max_cr'; // Observaciones Puntos de la Tierra Mas Cercana
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
								$atributos ['validar'] = '';
								
								if (isset ( $_REQUEST [$esteCampo] )) {
									$atributos ['valor'] = $_REQUEST [$esteCampo];
								} else {
									$atributos ['valor'] = '';
								}
								$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
								$atributos ['deshabilitado'] = false;
								$atributos ['tamanno'] = 30;
								$atributos ['maximoTamanno'] = '';
								$atributos ['anchoEtiqueta'] = 90;
								$tab ++;
								
								// Aplica atributos globales al control
								$atributos = array_merge ( $atributos, $atributosGlobales );
								echo $this->miFormulario->campoCuadroTexto ( $atributos );
								unset ( $atributos );
							}
							
							// ------------------Fin Division para los botones-------------------------
							echo $this->miFormulario->division ( "fin" );
							unset ( $atributos );
						}
						echo $this->miFormulario->division ( "fin" );
						unset ( $atributos );
					}
					echo $this->miFormulario->agrupacion ( 'fin' );
					unset ( $atributos );
					
					$esteCampo = "AgrupacionVS";
					$atributos ['id'] = $esteCampo;
					$atributos ['leyenda'] = "Visibilidad";
					echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
					unset ( $atributos );
					{
						
						$atributos ["id"] = "visib";
						$atributos ["estilo"] = " ";
						$atributos ["estiloEnLinea"] = "display:none";
						echo $this->miFormulario->division ( "inicio", $atributos );
						unset ( $atributos );
						{
							
							$esteCampo = 'pr_mn_vs'; // Prediccion Minima de Visibilidad
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
							$atributos ['validar'] = 'required,custom[number], min[0.01]';
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['valor'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['valor'] = '';
							}
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
							$atributos ['deshabilitado'] = false;
							$atributos ['tamanno'] = 15;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 150;
							$tab ++;
							
							// Aplica atributos globales al control
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroTexto ( $atributos );
							unset ( $atributos );
							
							$esteCampo = 'prc_mn_vs'; // Porcentaje de Visilidad Mínima
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
							$atributos ['validar'] = 'required,custom[number], min[0],max[100]';
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['valor'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['valor'] = '';
							}
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
							$atributos ['deshabilitado'] = false;
							$atributos ['tamanno'] = 15;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 90;
							$tab ++;
							
							// Aplica atributos globales al control
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroTexto ( $atributos );
							unset ( $atributos );
							
							// ------------------Division para los botones-------------------------
							$atributos ["id"] = "Salto Linea";
							$atributos ["estiloEnLinea"] = "clear:both;";
							echo $this->miFormulario->division ( "inicio", $atributos );
							unset ( $atributos );
							
							{
								
								$esteCampo = 'prd_pr_vs'; // Distancia Promedio Predicho
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
								$atributos ['validar'] = 'required,custom[number], min[0.01]';
								
								if (isset ( $_REQUEST [$esteCampo] )) {
									$atributos ['valor'] = $_REQUEST [$esteCampo];
								} else {
									$atributos ['valor'] = '';
								}
								$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
								$atributos ['deshabilitado'] = false;
								$atributos ['tamanno'] = 15;
								$atributos ['maximoTamanno'] = '';
								$atributos ['anchoEtiqueta'] = 150;
								$tab ++;
								
								// Aplica atributos globales al control
								$atributos = array_merge ( $atributos, $atributosGlobales );
								echo $this->miFormulario->campoCuadroTexto ( $atributos );
								unset ( $atributos );
								
								$esteCampo = 'pds_pr_vs'; // Porcentaje de Distancia Promedio Predicho Visibilidad
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
								$atributos ['validar'] = 'required,custom[number], min[0],max[100]';
								
								if (isset ( $_REQUEST [$esteCampo] )) {
									$atributos ['valor'] = $_REQUEST [$esteCampo];
								} else {
									$atributos ['valor'] = '';
								}
								$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
								$atributos ['deshabilitado'] = false;
								$atributos ['tamanno'] = 15;
								$atributos ['maximoTamanno'] = '';
								$atributos ['anchoEtiqueta'] = 90;
								$tab ++;
								
								// Aplica atributos globales al control
								$atributos = array_merge ( $atributos, $atributosGlobales );
								echo $this->miFormulario->campoCuadroTexto ( $atributos );
								unset ( $atributos );
							}
							
							// ------------------Fin Division para los botones-------------------------
							echo $this->miFormulario->division ( "fin" );
							unset ( $atributos );
						}
						echo $this->miFormulario->division ( "fin" );
						unset ( $atributos );
					}
					echo $this->miFormulario->agrupacion ( 'fin' );
					unset ( $atributos );
					
					$esteCampo = "AgrupacionLF";
					$atributos ['id'] = $esteCampo;
					$atributos ['leyenda'] = "Luz de Fondo";
					echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
					unset ( $atributos );
					{
						
						$atributos ["id"] = "luz_fnd";
						$atributos ["estilo"] = " ";
						$atributos ["estiloEnLinea"] = "display:none";
						echo $this->miFormulario->division ( "inicio", $atributos );
						unset ( $atributos );
						{
							
							$esteCampo = 'tm_bj_sl'; // Distancia Temas Bajo Sol Luz de Fondo
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
							$atributos ['validar'] = 'required,custom[number], min[0.01]';
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['valor'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['valor'] = '';
							}
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
							$atributos ['deshabilitado'] = false;
							$atributos ['tamanno'] = 15;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 150;
							$tab ++;
							
							// Aplica atributos globales al control
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroTexto ( $atributos );
							unset ( $atributos );
							
							$esteCampo = 'prc_tm_bj_sl'; // Porcentaje de Temas Bajo Sol
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
							$atributos ['validar'] = 'required,custom[number], min[0],max[100]';
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['valor'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['valor'] = '';
							}
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
							$atributos ['deshabilitado'] = false;
							$atributos ['tamanno'] = 15;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 90;
							$tab ++;
							
							// Aplica atributos globales al control
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroTexto ( $atributos );
							unset ( $atributos );
							
							// ------------------Division para los botones-------------------------
							$atributos ["id"] = "Salto Linea";
							$atributos ["estiloEnLinea"] = "clear:both;";
							echo $this->miFormulario->division ( "inicio", $atributos );
							unset ( $atributos );
							
							{
								
								$esteCampo = 'prd_respl'; // Distancia Respandor Luz de Fondo
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
								$atributos ['validar'] = 'required,custom[number], min[0.01]';
								
								if (isset ( $_REQUEST [$esteCampo] )) {
									$atributos ['valor'] = $_REQUEST [$esteCampo];
								} else {
									$atributos ['valor'] = '';
								}
								$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
								$atributos ['deshabilitado'] = false;
								$atributos ['tamanno'] = 15;
								$atributos ['maximoTamanno'] = '';
								$atributos ['anchoEtiqueta'] = 150;
								$tab ++;
								
								// Aplica atributos globales al control
								$atributos = array_merge ( $atributos, $atributosGlobales );
								echo $this->miFormulario->campoCuadroTexto ( $atributos );
								unset ( $atributos );
								
								$esteCampo = 'prc_prd_respl'; // Porcentaje de Respandor Luz de Fondo
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
								$atributos ['validar'] = 'required,custom[number], min[0],max[100]';
								
								if (isset ( $_REQUEST [$esteCampo] )) {
									$atributos ['valor'] = $_REQUEST [$esteCampo];
								} else {
									$atributos ['valor'] = '';
								}
								$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
								$atributos ['deshabilitado'] = false;
								$atributos ['tamanno'] = 15;
								$atributos ['maximoTamanno'] = '';
								$atributos ['anchoEtiqueta'] = 90;
								$tab ++;
								
								// Aplica atributos globales al control
								$atributos = array_merge ( $atributos, $atributosGlobales );
								echo $this->miFormulario->campoCuadroTexto ( $atributos );
								unset ( $atributos );
							}
							
							// ------------------Fin Division para los botones-------------------------
							echo $this->miFormulario->division ( "fin" );
							unset ( $atributos );
						}
						echo $this->miFormulario->division ( "fin" );
						unset ( $atributos );
					}
					echo $this->miFormulario->agrupacion ( 'fin' );
					unset ( $atributos );
				}
				echo $this->miFormulario->agrupacion ( 'fin' );
				unset ( $atributos );
				
				$esteCampo = "AgrupacionPHumano";
				$atributos ['id'] = $esteCampo;
				$atributos ['leyenda'] = "Factor Humano";
				echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
				unset ( $atributos );
				{
					
					$esteCampo = "AgrupacionCLD";
					$atributos ['id'] = $esteCampo;
					$atributos ['leyenda'] = "Calidad de: ";
					echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
					unset ( $atributos );
					{
						$atributos ["id"] = "cald";
						$atributos ["estilo"] = " ";
						$atributos ["estiloEnLinea"] = "display:none";
						echo $this->miFormulario->division ( "inicio", $atributos );
						unset ( $atributos );
						{
							$esteCampo = 'pr_aton'; // Provision de Las AtoN
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
							$atributos ['anchoEtiqueta'] = 148;
							
							$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_region" );
							
							$matrizItems = $esteRecursoDBP->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
							$atributos ['matrizItems'] = $matrizItems;
							
							// Utilizar lo siguiente cuando no se pase un arreglo:
							// $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
							// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
							$tab ++;
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroLista ( $atributos );
							unset ( $atributos );
							
							$esteCampo = 'pl_tr_mr'; // Pilotaje /Trafico Marítimo
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
							$atributos ['anchoEtiqueta'] = 148;
							
							$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_region" );
							
							$matrizItems = $esteRecursoDBP->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
							$atributos ['matrizItems'] = $matrizItems;
							
							// Utilizar lo siguiente cuando no se pase un arreglo:
							// $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
							// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
							$tab ++;
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroLista ( $atributos );
							unset ( $atributos );
							// ------------------Division para los botones-------------------------
							$atributos ["id"] = "Salto Linea";
							$atributos ["estiloEnLinea"] = "clear:both;";
							echo $this->miFormulario->division ( "inicio", $atributos );
							unset ( $atributos );
							
							{
								
								$esteCampo = 'gr_cmp_trp'; // Grandes Compentencias de los Tripulantes de lo Buques
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
								$atributos ['anchoEtiqueta'] = 148;
								
								$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_region" );
								
								$matrizItems = $esteRecursoDBP->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
								$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
								$atributos ['matrizItems'] = $matrizItems;
								
								// Utilizar lo siguiente cuando no se pase un arreglo:
								// $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
								// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
								$tab ++;
								$atributos = array_merge ( $atributos, $atributosGlobales );
								echo $this->miFormulario->campoCuadroLista ( $atributos );
								unset ( $atributos );
								
								$esteCampo = 'pq_cmp_trp'; // Pequeña Competencia de tripulantes de Los buques $atributos ['id'] = $esteCampo;
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
								$atributos ['anchoEtiqueta'] = 148;
								
								$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultar_region" );
								
								$matrizItems = $esteRecursoDBP->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
								$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
								$atributos ['matrizItems'] = $matrizItems;
								
								// Utilizar lo siguiente cuando no se pase un arreglo:
								// $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
								// $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
								$tab ++;
								$atributos = array_merge ( $atributos, $atributosGlobales );
								echo $this->miFormulario->campoCuadroLista ( $atributos );
								unset ( $atributos );
							}
							
							// ------------------Fin Division para los botones-------------------------
							echo $this->miFormulario->division ( "fin" );
							unset ( $atributos );
						}
						echo $this->miFormulario->division ( "fin" );
						unset ( $atributos );
					}
					echo $this->miFormulario->agrupacion ( 'fin' );
					unset ( $atributos );
				}
				echo $this->miFormulario->agrupacion ( 'fin' );
				unset ( $atributos );
			}
		}
		
		// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
		
		/*
		 *
		 */
		
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