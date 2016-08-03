<?php
use logica\datosGeograficos\gestionInformacionBatimetrica\funcion\Redireccionador;
include_once ('Redireccionador.php');
include_once ("core/builder/InspectorHTML.class.php");
class FormProcessor {
	var $miConfigurador;
	var $miInspectorHTML;
	var $lenguaje;
	var $miFormulario;
	var $miSql;
	var $conexion;
	var $var_dbf;
	var $var_prj;
	var $var_shx;
	var $var_shp;
	var $prefijo;
	var $archivoSql;
	function __construct($lenguaje, $sql) {
		$this->miInspectorHTML = \InspectorHTML::singleton ();
		$this->miConfigurador = \Configurador::singleton ();
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		$this->lenguaje = $lenguaje;
		$this->miSql = $sql;
	}
	function procesarFormulario() {
		
		/*
		 * Validar que los Campos no fuesen manipulados para saltarse la validaciones del plugin Validation Engine
		 */
		{
			if (isset ( $_REQUEST ['validadorCampos'] )) {
				$validadorCampos = $this->miInspectorHTML->decodificarCampos ( $_REQUEST ['validadorCampos'] );
				$respuesta = $this->miInspectorHTML->validacionCampos ( $_REQUEST, $validadorCampos, false );
				
				if ($respuesta != false) {
					
					$_REQUEST = $respuesta;
				} else {
					Redireccionador::redireccionar ( "ErrorModificacionFormulario" );
				}
			}
		}
		
		/*
		 * Verificar Extensión Ficheros
		 */
		
		$this->verificarExtencionFicheros ();
		
		/*
		 * Cargar Ficheros en el Directorio
		 */
		
		$this->cargarFicherosDirectorio ();
		
		/*
		 * Cargar Estructura a la Tabla Espacial
		 */
		
		$this->cargarEstruturaEspacial ();
		
		exit ();
		
		// $arregloDatos = array (
		// "id_zona_estudio" => $_REQUEST ['id_zona'],
		// "riesgo" => $_REQUEST ['riesgo'],
		// "acciones_prv" => $_REQUEST ['acciones'],
		// "senalizacion_ext" => $_REQUEST ['senalizacion']
		// );
		
		// /*
		// * Registro de Recomendación
		// */
		
		// $conexion = "logica";
		// $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		// $cadenaSql = $this->miSql->getCadenaSql ( "registrar_recomendacion", $arregloDatos );
		
		// $registro = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "accion", $_REQUEST ['id_zona'], "registrar_recomendacion" );
		
		if ($registro == true) {
			Redireccionador::redireccionar ( "Inserto" );
		} else if ($registro == false) {
			Redireccionador::redireccionar ( "NoInserto" );
		}
	}
	function cargarEstruturaEspacial() {
		$this->archivoSql = $this->prefijo . reset ( explode ( ".", $this->var_shp ['nombreActualArchivo'] ) );
		
		$rutaStatica = $this->miConfigurador->configuracion ['rutaBloque'] . "/funcion/procesarShapes/";
		
		$this->var_shp ['ruta_sql'] = $rutaStatica . $this->archivoSql . ".slq";
		
		echo "shp2pgsql -W LATIN1 -I -s " . $_REQUEST ['srid'] . " " . $this->var_shp ['rutaDirectorio'] . " >  " . $rutaStatica . $this->archivoSql . ".slq";
		
		$queries = exec ( "shp2pgsql -W LATIN1 -I -s " . $_REQUEST ['srid'] . " " . $this->var_shp ['rutaDirectorio'] . " >  " . $rutaStatica . $this->archivoSql . ".slq" );
		
		var_dump ( $this->var_shp );
	}
	function cargarFicherosDirectorio() {
		
		/**
		 *
		 * @var unknown $this->prefijo Cadena Aleatoria para evitar que los shapes se dupliquen al subir.
		 */
		$this->prefijo = substr ( md5 ( uniqid ( time () ) ), 0, 6 );
		
		/*
		 * fichero dbf
		 */
		{
			/*
			 * obtenemos los datos del Fichero
			 */
			$tamano = $this->var_dbf ['size'];
			$tipo = $this->var_dbf ['type'];
			$archivo = $this->var_dbf ['name'];
			
			/*
			 * guardamos el fichero en el Directorio
			 */
			$ruta_absoluta = $this->miConfigurador->configuracion ['rutaBloque'] . "/funcion/procesarShapes/" . $this->prefijo . "_" . $archivo;
			
			if (! copy ( $this->var_dbf ['tmp_name'], $ruta_absoluta )) {
				
				Redireccionador::redireccionar ( "ErrorCargarFicheroDirectorio" );
			}
		}
		/*
		 * fichero prj
		 */
		
		{
			/*
			 * obtenemos los datos del Fichero
			 */
			$tamano = $this->var_prj ['size'];
			$tipo = $this->var_prj ['type'];
			$archivo = $this->var_prj ['name'];
			
			/*
			 * guardamos el fichero en el Directorio
			 */
			$ruta_absoluta = $this->miConfigurador->configuracion ['rutaBloque'] . "/funcion/procesarShapes/" . $this->prefijo . "_" . $archivo;
			
			if (! copy ( $this->var_prj ['tmp_name'], $ruta_absoluta )) {
				
				Redireccionador::redireccionar ( "ErrorCargarFicheroDirectorio" );
			}
		}
		
		/*
		 * fichero shx
		 */
		
		{
			/*
			 * obtenemos los datos del Fichero
			 */
			$tamano = $this->var_shx ['size'];
			$tipo = $this->var_shx ['type'];
			$archivo = $this->var_shx ['name'];
			
			/*
			 * guardamos el fichero en el Directorio
			 */
			
			$ruta_absoluta = $this->miConfigurador->configuracion ['rutaBloque'] . "/funcion/procesarShapes/" . $this->prefijo . "_" . $archivo;
			
			if (! copy ( $this->var_shx ['tmp_name'], $ruta_absoluta )) {
				
				Redireccionador::redireccionar ( "ErrorCargarFicheroDirectorio" );
			}
		}
		
		/*
		 * fichero shp
		 */
		
		{
			/*
			 * obtenemos los datos del Fichero
			 */
			$tamano = $this->var_shp ['size'];
			$tipo = $this->var_shp ['type'];
			$archivo = $this->var_shp ['name'];
			
			/*
			 * guardamos el fichero en el Directorio
			 */
			
			$this->var_shp ['nombreActualArchivo'] = $this->prefijo . "_" . $archivo;
			
			$ruta_absoluta = $this->miConfigurador->configuracion ['rutaBloque'] . "/funcion/procesarShapes/" . $this->prefijo . "_" . $archivo;
			$this->var_shp ['rutaDirectorio'] = $ruta_absoluta;
			
			if (! copy ( $this->var_shp ['tmp_name'], $ruta_absoluta )) {
				
				Redireccionador::redireccionar ( "ErrorCargarFicheroDirectorio" );
			}
		}
	}
	function verificarExtencionFicheros() {
		if (isset ( $_FILES ['fichero_dbf'] )) {
			
			$archivo = $_FILES ['fichero_dbf'];
			$trozos = explode ( ".", $archivo ['name'] );
			$extension = end ( $trozos );
			($extension != 'dbf') ? Redireccionador::redireccionar ( "ErrorExtension" ) : $this->var_dbf = $archivo;
		}
		
		if (isset ( $_FILES ['fichero_prj'] )) {
			
			$archivo = $_FILES ['fichero_prj'];
			$trozos = explode ( ".", $archivo ['name'] );
			$extension = end ( $trozos );
			($extension != 'prj') ? Redireccionador::redireccionar ( "ErrorExtension" ) : $this->var_prj = $archivo;
		}
		
		if (isset ( $_FILES ['fichero_shx'] )) {
			
			$archivo = $_FILES ['fichero_shx'];
			$trozos = explode ( ".", $archivo ['name'] );
			$extension = end ( $trozos );
			($extension != 'shx') ? Redireccionador::redireccionar ( "ErrorExtension" ) : $this->var_shx = $archivo;
		}
		
		if (isset ( $_FILES ['fichero_shp'] )) {
			
			$archivo = $_FILES ['fichero_shp'];
			$trozos = explode ( ".", $archivo ['name'] );
			$extension = end ( $trozos );
			($extension != 'shp') ? Redireccionador::redireccionar ( "ErrorExtension" ) : $this->var_shp = $archivo;
		}
	}
}

$miProcesador = new FormProcessor ( $this->lenguaje, $this->sql );

$resultado = $miProcesador->procesarFormulario ();

?>