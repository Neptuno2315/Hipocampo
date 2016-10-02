<?php

namespace usuarios\gestionUsuarios;

if (!isset($GLOBALS["autorizado"])) {
    include "../index.php";
    exit();
}

include_once "core/manager/Configurador.class.php";
include_once "core/builder/InspectorHTML.class.php";
include_once "core/builder/Mensaje.class.php";
include_once "core/crypto/Encriptador.class.php";

// Esta clase contiene la logica de negocio del bloque y extiende a la clase funcion general la cual encapsula los
// metodos mas utilizados en la aplicacion

// Para evitar redefiniciones de clases el nombre de la clase del archivo funcion debe corresponder al nombre del bloque
// en camel case precedido por la palabra Funcion
class Funcion {
    public $sql;
    public $funcion;
    public $lenguaje;
    public $ruta;
    public $miConfigurador;
    public $miInspectorHTML;
    public $error;
    public $miRecursoDB;
    public $crypto;
    public $miLogger;
    // function verificarCampos() {
    // include_once ($this->ruta . "/funcion/verificarCampos.php");
    // if ($this->error == true) {
    // return false;
    // } else {
    // return true;
    // }
    // }
    public function redireccionar($opcion, $valor = "") {
        include_once $this->ruta . "/funcion/redireccionar.php";
    }
    public function funcionEjemplo() {
        include_once $this->ruta . "/funcion/funcionEjemplo.php";
    }
    public function procesarAjax() {
        include_once $this->ruta . "funcion/procesarAjax.php";
    }
    public function registrar() {
        include_once $this->ruta . "funcion/registrar.php";
    }
    public function action() {

        // Evitar qu44444444rrrre se ingrese codigo HTML y PHP en los campos de texto
        // Campos que se quieren excluir de la limpieza de código. Formato: nombreCampo1|nombreCampo2|nombreCampo3
        $excluir = "";
        $_REQUEST = $this->miInspectorHTML->limpiarPHPHTML($_REQUEST);

        // Aquí se coloca el código que procesará los diferentes formularios que pertenecen al bloque
        // aunque el código fuente puede ir directamente en este script, para facilitar el mantenimiento
        // se recomienda que aqui solo sea el punto de entrada para incluir otros scripts que estarán
        // en la carpeta funcion

        // Importante: Es adecuado que sea una variable llamada opcion o action la que guie el procesamiento:
        if (isset($_REQUEST['procesarAjax'])) {
            $this->procesarAjax();
        } elseif (isset($_REQUEST["opcion"])) {

            switch ($_REQUEST['opcion']) {
                case "guardarDatos":
                    $_REQUEST = $this->miInspectorHTML->limpiarSQL($_REQUEST);
                    $this->guardarDatos();
                    break;

                case "editarDatos":
                    $_REQUEST = $this->miInspectorHTML->limpiarSQL($_REQUEST);
                    $this->editarDatos();
                    break;
                case "resumen":
                    $this->resumen();
                    break;

                case "borrar":
                    $this->borrarDatos();
                    break;

                case "inhabilitar":
                    $_REQUEST["estado"] = 0;
                    $this->cambiarEstado();
                    break;

                case "habilitar":
                    $_REQUEST["estado"] = 1;
                    $this->cambiarEstado();
                    break;

                case "guardarDatosPerfil":
                    $this->guardarDatosPerfil();
                    break;

                case "editarPerfil":
                    $this->editarDatosPerfil();
                    break;

                case "inhabilitarPerfil":
                    $_REQUEST["estado"] = 0;
                    $this->cambiarEstadoPerfil();
                    break;
                case "habilitarPerfil":
                    $_REQUEST["estado"] = 1;
                    $this->cambiarEstadoPerfil();
                    break;

            }

//             if ($validacion == false) {
            //                 // Instanciar a la clase pagina con mensaje de correcion de datos
            //                 echo "Datos Incorrectos";
            //             } else {
            //                 // Validar las variables para evitar un tipo insercion de SQL
            //                 $_REQUEST = $this->miInspectorHTML->limpiarSQL ( $_REQUEST );

//                 $this->funcionEjemplo ();
            //                 $this->redireccionar ( "exito" );
            //             }
        }
    }
    public function __construct() {
        $this->miConfigurador = \Configurador::singleton();

        $this->miInspectorHTML = \InspectorHTML::singleton();

        $this->ruta = $this->miConfigurador->getVariableConfiguracion("rutaBloque");

        $this->miMensaje = \Mensaje::singleton();

        $conexion = "aplicativo";
        $this->miRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        if (!$this->miRecursoDB) {

            $this->miConfigurador->fabricaConexiones->setRecursoDB($conexion, "tabla");
            $this->miRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
        }
    }
    public function setRuta($unaRuta) {
        $this->ruta = $unaRuta;
    }
    public function setSql($a) {
        $this->sql = $a;
    }
    public function setFuncion($funcion) {
        $this->funcion = $funcion;
    }
    public function setLenguaje($lenguaje) {
        $this->lenguaje = $lenguaje;
    }
    public function setFormulario($formulario) {
        $this->formulario = $formulario;
    }

    /*Funciones propias*/

    public function verificarCampos() {
        include_once $this->ruta . "/funcion/verificarCampos.php";
        if ($this->error == true) {
            return false;
        } else {
            return true;
        }
    }

    public function guardarDatos() {
        include_once $this->ruta . "/funcion/registrarUsuario.php";
    }

    public function borrarDatos() {
        include_once $this->ruta . "/funcion/borrarUsuario.php";
    }

    public function editarDatos() {
        include_once $this->ruta . "/funcion/editarUsuario.php";
    }

    public function cambiarEstado() {
        include_once $this->ruta . "/funcion/cambiarEstado.php";
    }

    public function guardarDatosPerfil() {
        include_once $this->ruta . "/funcion/registrarPerfil.php";
    }

    public function editarDatosPerfil() {
        include_once $this->ruta . "/funcion/editarPerfil.php";
    }

    public function cambiarEstadoPerfil() {
        include_once $this->ruta . "/funcion/cambiarEstadoPerfil.php";
    }

    public function resumen() {
        include_once $this->ruta . "/funcion/resumenUsuario.php";
    }

}
?>
