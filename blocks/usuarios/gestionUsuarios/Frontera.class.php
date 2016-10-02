<?php

namespace usuarios\gestionUsuarios;

if (!isset($GLOBALS["autorizado"])) {
    include "../index.php";
    exit();
}

include_once "core/manager/Configurador.class.php";
class Frontera {
    public $ruta;
    public $sql;
    public $funcion;
    public $lenguaje;
    public $formulario;
    public $miConfigurador;
    public function __construct() {
        $this->miConfigurador = \Configurador::singleton();
    }
    public function setRuta($unaRuta) {
        $this->ruta = $unaRuta;
    }
    public function setLenguaje($lenguaje) {
        $this->lenguaje = $lenguaje;
    }
    public function setFormulario($formulario) {
        $this->formulario = $formulario;
    }
    public function frontera() {
        $this->html();
    }
    public function setSql($a) {
        $this->sql = $a;
    }
    public function setFuncion($funcion) {
        $this->funcion = $funcion;
    }
    public function html() {
        include_once "core/builder/FormularioHtml.class.php";

        $this->ruta = $this->miConfigurador->getVariableConfiguracion("rutaBloque");

        $this->miFormulario = new \FormularioHtml();

        if (isset($_REQUEST['opcion'])) {

            switch ($_REQUEST['opcion']) {

                case 'cuentaUsuario':
                    include_once $this->ruta . "formulario/perfilUsuario.php";
                    break;

                case 'admnistracionUsuarios':
                    include_once $this->ruta . "formulario/administrarUsuarios.php";
                    break;

//----------------------------------------------------------
                case "mensaje":

                    break;

                case "verificarDatos":
                    include_once $this->ruta . "/formulario/verificarDatos.php";
                    break;

                case "nuevo":
                    include_once $this->ruta . "formulario/nuevo.php";
                    break;

                case "editar":
                    include_once $this->ruta . "formulario/nuevo.php";
                    break;

                case "borrar":
                    include_once $this->ruta . "formulario/borrar.php";
                    break;

                case "inhabilitar":
                    include_once $this->ruta . "formulario/cambiaEstado.php";
                    break;

                case "habilitar":
                    include_once $this->ruta . "formulario/cambiaEstado.php";
                    break;

                case "perfil":
                    include_once $this->ruta . "/formulario/consultarPerfil.php";
                    break;

                case "nuevoPerfil":
                    include_once $this->ruta . "/formulario/nuevoPerfil.php";
                    break;

                case "editarPerfil":
                    include_once $this->ruta . "/formulario/nuevoPerfil.php";
                    break;

                case "inhabilitarPerfil":
                    include_once $this->ruta . "formulario/cambiaEstadoPerfil.php";
                    break;
                case "habilitarPerfil":
                    include_once $this->ruta . "formulario/cambiaEstadoPerfil.php";
                    break;
            }
        } else {
            $_REQUEST['opcion'] = "mostrar";
            include_once $this->ruta . "/formulario/consultarUsuarios.php";
        }
    }
}
?>
