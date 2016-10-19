<?php

namespace gui\menuAplicativo;

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
        $miSesion = \Sesion::singleton();
        $usuario = $miSesion->getSesionUsuarioId();
        include_once "core/builder/FormularioHtml.class.php";
        $this->ruta = $this->miConfigurador->getVariableConfiguracion("rutaBloque");

        include_once $this->ruta . "/formulario/nuevo.php";
    }
}

?>