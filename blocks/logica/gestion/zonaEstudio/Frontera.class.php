<?

namespace logica\gestion\zonaEstudio;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
class Frontera {
	var $ruta;
	var $sql;
	var $funcion;
	var $lenguaje;
	var $miFormulario;
	var 

	$miConfigurador;
	function __construct() {
		$this->miConfigurador = \Configurador::singleton ();
	}
	public function setRuta($unaRuta) {
		$this->ruta = $unaRuta;
	}
	public function setLenguaje($lenguaje) {
		$this->lenguaje = $lenguaje;
	}
	public function setFormulario($formulario) {
		$this->miFormulario = $formulario;
	}
	function frontera() {
		$this->html ();
	}
	function setSql($a) {
		$this->sql = $a;
	}
	function setFuncion($funcion) {
		$this->funcion = $funcion;
	}
	function html() {
		
		// Como se tiene un solo formulario no es necesario un switch para cargarlo:
		$this->ruta = $this->miConfigurador->getVariableConfiguracion ( "rutaBloque" );
		// var_dump($_REQUEST);exit;
		if (isset ( $_REQUEST ['opcion'] )) {
			
			switch ($_REQUEST ['opcion']) {
				
				case 'mensaje' :
					
					include_once ($this->ruta . "/formulario/mensaje.php");
					
					break;
				
				case 'consultarInformacionZona' :
					
					include_once ($this->ruta . "/formulario/resultadoConsulta.php");
					
					break;
				
				case 'modificarInformacionZona' :
					include_once ($this->ruta . "/formulario/modificacion.php");
					break;
				
				case 'eliminarInformacionZona' :
					include_once ($this->ruta . "/formulario/eliminacion.php");
					
					break;
				
				default :
					
					include_once ($this->ruta . "/formulario/nuevo.php");
					
					break;
			}
		} else {
			include_once ($this->ruta . "/formulario/nuevo.php");
		}
	}
}
?>
