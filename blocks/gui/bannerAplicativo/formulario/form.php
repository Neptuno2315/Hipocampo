<?php

namespace blocks\gui\bannerUsuario\formulario;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class Formulario {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	function __construct($lenguaje, $formulario) {
		$this->miConfigurador = \Configurador::singleton ();
		
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		
		$this->lenguaje = $lenguaje;
		
		$this->miFormulario = $formulario;
	}
	function formulario() {
		$this->estructura ();
		$this->formPasoVariables ();
	}
	function estructura() {
		// ------------------- Inicio División -------------------------------
		$esteCampo = 'fondo_texto';
		$atributos ['id'] = $esteCampo;
		$atributos ['estilo'] = 'divGeneral2';
		$atributos ['estiloEnLinea'] = '';
		$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
		echo $this->miFormulario->division ( "inicio", $atributos );
		{
			
			$esteCampo = 'texto';
			$atributos ['id'] = $esteCampo;
			$atributos ['estilo'] = '';
			$atributos ['estiloEnLinea'] = '';
			$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
			echo $this->miFormulario->division ( "inicio", $atributos );
			{
				?>


<h3>SISTEMA DE GESTIÓN RIESGO A LA NAVEGACIÓN</h3>
<h3>DE DISEÑO DE CANALES</h3>
<h2>HIPOCAMPO</h2>

<?php
			}
			echo $this->miFormulario->division ( "fin" );
			// ------------------- Inicio División -------------------------------
		}
		
		// ---------------------Fin Division -----------------------------------
		echo $this->miFormulario->division ( "fin" );
	}
	function formPasoVariables() {
		
		// Rescatar los datos de este bloque
		$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
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
		
		$valorCodificado = "idUsario=" . $esteBloque ["grupo"];
		/**
		 * SARA permite que los nombres de los campos sean dinámicos.
		 * Para ello utiliza la hora en que es creado el formulario para
		 * codificar el nombre de cada campo. Si se utiliza esta técnica es necesario pasar dicho tiempo como una variable:
		 * (a) invocando a la variable $_REQUEST ['tiempo'] que se ha declarado en ready.php o
		 * (b) asociando el tiempo en que se está creando el formulario
		 */
		$valorCodificado .= "&tiempo=" . time ();
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
	}
}

$miFormulario = new Formulario ( $this->lenguaje, $this->miFormulario );

$miFormulario->formulario ();
?>