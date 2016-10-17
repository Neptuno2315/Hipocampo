<?php
use usuarios\gestionUsuarios\funcion\Redireccionador;

include_once 'Redireccionador.php';
include_once "core/builder/InspectorHTML.class.php";
class FormProcessor {
    public $miConfigurador;
    public $miInspectorHTML;
    public $lenguaje;
    public $miFormulario;
    public $miSql;
    public $conexion;
    public function __construct($lenguaje, $sql) {
        $this->miInspectorHTML = \InspectorHTML::singleton();
        $this->miConfigurador = \Configurador::singleton();
        $this->miConfigurador->fabricaConexiones->setRecursoDB('principal');
        $this->lenguaje = $lenguaje;
        $this->miSql = $sql;
    }
    public function procesarFormulario() {

        /*
         * Validar que los Campos no fuesen manipulados para saltarse la validaciones del plugin Validation Engine
         */
        {
            if (isset($_REQUEST['validadorCampos'])) {
                $validadorCampos = $this->miInspectorHTML->decodificarCampos($_REQUEST['validadorCampos']);
                $respuesta = $this->miInspectorHTML->validacionCampos($_REQUEST, $validadorCampos, false);

                if ($respuesta != false) {

                } else {
                    Redireccionador::redireccionar("ErrorModificacionFormulario");
                }
            }
        }

        /*
         * Actualizar Usuario
         */

        // Conexion de Base de Datos
        $conexion = "estructura";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        $_REQUEST['id'] = $_REQUEST['usuario'];
        $cadenaSql = $this->miSql->getCadenaSql('consultar_usuario_particular');
        $usuario = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

        if ($_REQUEST['actualizar_password'] == '1') {

            $_REQUEST['contrasenia'] = $this->miConfigurador->fabricaConexiones->crypto->codificarClave($_REQUEST["contrasenia"]);

        } else if ($_REQUEST['actualizar_password'] == '0') {

            $_REQUEST['contrasenia'] = $usuario[0]['clave'];
        }

        $arreglo = array(
            "num_ident" => $_REQUEST['num_identificacion'],
            "tipo_id" => $_REQUEST['tipo_ident'],
            "nombres" => $_REQUEST['nombres'],
            "apellidos" => $_REQUEST['apellidos'],
            "email" => $_REQUEST['email'],
            "contrasena" => $_REQUEST['contrasenia'],
            "rol" => $usuario[0]['tipo'],

        );

        $_REQUEST = array_merge($_REQUEST, $arreglo);

        $cadenaSql = $this->miSql->getCadenaSql('actualizar_usuario');

        $Actualizacion = $esteRecursoDB->ejecutarAcceso($cadenaSql, "acceso");

        if ($Actualizacion) {

            Redireccionador::redireccionar("ActualizacionExito");
        } else {
            Redireccionador::redireccionar("NoActualizo");
        }
    }
}

$miProcesador = new FormProcessor($this->lenguaje, $this->sql);

$resultado = $miProcesador->procesarFormulario();

?>