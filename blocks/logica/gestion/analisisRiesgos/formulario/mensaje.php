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
		
		// Rescatar los datos de este bloque
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
		// $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo );
		// Si no se coloca, entonces toma el valor predeterminado.
		$atributos ['estilo'] = '';
		$atributos ['marco'] = true;
		$tab = 1;
		// ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
		
		// ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
		$atributos ['tipoEtiqueta'] = 'inicio';
		echo $this->miFormulario->formulario ( $atributos );
		{
			
			switch ($_REQUEST ['mensaje']) {
				
				case 'ErrorVariablesVacias' :
					
					$atributos ['tipo'] = 'error';
					$atributos ['mensaje'] = 'Error al Procesar los Datos de las Variables .<br>Verifique que las Variables tengan Probabilidad y Impacto.';
					
					break;
				
				case 'RegistroExito' :
					$atributos ['tipo'] = 'success';
					$atributos ['mensaje'] = 'Se Registro con Exito Zona de Estudio<br>Nombre Proyecto : <br>' . $_REQUEST ['TituloProyecto'] . ".";
					break;
				
				case 'RegistroError' :
					$atributos ['tipo'] = 'error';
					$atributos ['mensaje'] = 'Error en el Registro de la Informacion de la Zona de Estudio.<br>Verifique los Datos.';
					break;
				
				case 'ActualizoExito' :
					$atributos ['tipo'] = 'success';
					$atributos ['mensaje'] = 'Se Actualizo con Exito Zona de Estudio<br>Nombre Proyecto : <br>' . $_REQUEST ['TituloProyecto'] . ".";
					break;
				
				case 'ActualizacionError' :
					$atributos ['tipo'] = 'error';
					$atributos ['mensaje'] = 'Error en la Actualización de la Informacion de la Zona de Estudio.<br>Verifique los Datos.';
					break;
				
				case 'EliminoExito' :
					$atributos ['tipo'] = 'success';
					$atributos ['mensaje'] = 'Se Elimino con Exito Zona de Estudio<br>Nombre Proyecto : <br>' . $_REQUEST ['TituloProyecto'] . ".";
					break;
				
				case 'EliminoError' :
					$atributos ['tipo'] = 'error';
					$atributos ['mensaje'] = 'Error en la Eliminación de la Informacion de la Zona de Estudio.<br>Verifique los Datos.';
					break;
				
				case 'ErrorProcesamiento' :
					
					$atributos ['tipo'] = 'error';
					$atributos ['mensaje'] = 'Datos No Validos o Error al Procesar la Información.<br>Verifique los Datos.';
					
					break;
			}
			echo "<br><br>";
			$esteCampo = 'mensajeGeneral';
			$atributos ['id'] = $esteCampo;
			$atributos ['estilo'] = 'textoCentrar';
			
			$tab ++;
			
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->cuadroMensaje ( $atributos );
		}
		
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
		$valorCodificado .= "&opcion=redireccionar";
		$valorCodificado .= "&usuario=" . $_REQUEST ['usuario'];
		/**
		 * SARA permite que los nombres de los campos sean dinámicos.
		 * Para ello utiliza la hora en que es creado el formulario para
		 * codificar el nombre de cada campo. Si se utiliza esta técnica es necesario pasar dicho tiempo como una variable:
		 * (a) invocando a la variable $_REQUEST ['tiempo'] que se ha declarado en ready.php o
		 * (b) asociando el tiempo en que se está creando el formulario
		 */
		$valorCodificado .= "&campoSeguro=" . $_REQUEST ['tiempo'];
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
		
		$atributos ['marco'] = true;
		$atributos ['tipoEtiqueta'] = 'fin';
		echo $this->miFormulario->formulario ( $atributos );
	}
}
$miSeleccionador = new registrarForm ( $this->lenguaje, $this->miFormulario, $this->sql );

$miSeleccionador->miForm ();
?>
