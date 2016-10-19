<?php
/**
 * Bootstrap.class.php
 *
 * Administra el inicio de la aplicacion.
 *
 * @author      Paulo Cesar Coronado - Karen Palacios
 *
 */
require_once 'core/manager/Configurador.class.php';
require_once 'core/auth/Sesion.class.php';
require_once 'core/connection/FabricaDbConexion.class.php';
require_once 'core/crypto/Encriptador.class.php';
require_once 'core/builder/Mensaje.class.php';
require_once 'core/builder/InspectorHTML.class.php';
require_once "core/auth/Sesion.php";

class Bootstrap {

    /**
     * Objeto.
     * Con los atributos y métodos para gestionar la sesión de usuario
     *
     * @var Sesion
     */
    public $sesionUsuario;

    /**
     *
     * Objeto.
     * Encargado de inicializar las variables globales. Su atributo $configuracion contiene los valores necesarios
     * para gestionar la aplicacion.
     *
     * @var Configurador
     */
    public $miConfigurador;

    /**
     * Objeto de la clase Encriptador se encarga de codificar/decodificar cadenas de texto.
     *
     * @var Encriptador
     */
    private $cripto;

    /**
     *
     * Objeto. Actua como controlador del modulo de instalación del framework/aplicativo
     *
     * @var Instalador
     */
    public $miInstalador;

    /**
     *
     * Objeto. Instancia de la pagina que se está visitando
     *
     * @var Pagina
     */
    public $miPagina;

    /**
     *
     * Arreglo.Ruta de acceso a los archivos, se utilizan porque aún no se ha rescatado las
     * variables de configuración.
     *
     * @var string
     */
    public $misVariables;

    /**
     * Objeto que se encarga de mostrar los mensajes de error fatales.
     *
     * @var Mensaje
     */
    public $cuadroMensaje;

    public $miInspectorHtml;

    const PAGINA = 'pagina';

    const ERROR = 'error';

    const ENLACE = 'enlace';

    /**
     * Contructor
     *
     * @param
     *            none
     * @return integer
     *
     */
    public function __construct() {

        $this->cuadroMensaje = Mensaje::singleton();
        $this->conectorDB = FabricaDbConexion::singleton();
        $this->cripto = Encriptador::singleton();

        /**
         * Importante conservar el orden de creación de los siguientes objetos porque tienen
         * referencias cruzadas.
         */
        $this->miConfigurador = Configurador::singleton();
        $this->miConfigurador->setConectorDB($this->conectorDB);

        /**
         * El objeto del a clase Sesion es el último que se debe crear.
         */

        /*
        $this->sesionUsuario = Sesion::singleton();
         */

        $this->sesionUsuario = new \SessionUsuario();

        $this->miInspectorHtml = InspectorHTML::singleton();

    }

    /**
     * Iniciar la aplicación.
     */
    public function iniciar() {

        // Poblar el atributo miConfigurador->configuracion
        $this->miConfigurador->variable();
        $this->miConfigurador->variablesCodificadas();

        if (!$this->miConfigurador->getVariableConfiguracion("instalado")) {
            $this->instalarAplicativo();
        } else {

            $this->ingresar();
        }

    }

    /**
     *
     * Asigna los valores a las variables que indican las rutas predeterminadas.
     *
     * @param
     *            strting array $variables
     */
    public function setMisVariables($variables) {

        $this->misVariables = $variables;
        $this->miConfigurador->setRutas($variables);

    }

    /**
     *
     * Ingresar al aplicativo.
     *
     * @param
     *            Ninguno
     * @return int
     */
    private function ingresar() {

        /**
         *
         * @global boolean $GLOBALS['autorizado']
         * @name $autorizado
         */
        $GLOBALS["autorizado"] = TRUE;

        $pagina = $this->determinarPagina();

        $this->miConfigurador->setVariableConfiguracion(self::PAGINA, $pagina);

        /**
         * Verificar que se tenga una sesión válida
         */

        require_once $this->miConfigurador->getVariableConfiguracion("raizDocumento") . "/core/auth/Autenticador.class.php";
        $this->autenticador = Autenticador::singleton();
        $this->autenticador->setPagina($pagina);
        @session_start();

        //Crear Session Usuario

        if ($this->autenticador->iniciarAutenticacion()) {

            //if ($pagina === 'index' || $this->sesionUsuario->executeFuntion('Validar')) {

            /**
             * Procesa la página solicitada por el usuario
             */

            /**
             * Evitar que se ingrese codigo HTML y PHP en los campos de texto
             * Campos que se quieren excluir de la limpieza de código. Formato: nombreCampo1|nombreCampo2|nombreCampo3
             */

            $excluir = '';
            $_REQUEST = $this->miInspectorHtml->limpiarPHPHTML($_REQUEST);
            //Evitar que se ingrese código malicioso SQL

            $_REQUEST = $this->miInspectorHtml->limpiarSQL($_REQUEST);

            require_once $this->miConfigurador->getVariableConfiguracion("raizDocumento") . "/core/builder/Pagina.class.php";
            $this->miPagina = new Pagina();

            if ($this->miPagina->inicializarPagina($pagina)) {
                return true;
            } else {
                $this->mostrarMensajeError($this->miPagina->getError());
                return false;
            }
        } else {

            unset($_REQUEST);
            $this->redireccionar('indice', 'pagina=index&error=formularioExpirado');

        }

    }

    private function mostrarMensajeError($mensaje, $tipoMensaje = '') {

        $this->miConfigurador->setVariableConfiguracion(self::ERROR, true);
        if ($tipoMensaje == '') {
            $this->cuadroMensaje->mostrarMensaje($mensaje, self::ERROR);
        } else {
            $this->cuadroMensaje->mostrarMensaje($mensaje, $tipoMensaje);
        }

    }

    private function mostrarMensajeRedireccion($mensaje, $tipoMensaje = '', $url) {

        if ($tipoMensaje == '') {
            $this->cuadroMensaje->mostrarMensajeRedireccion($mensaje, self::ERROR, $url);
        } else {
            $this->cuadroMensaje->mostrarMensajeRedireccion($mensaje, $tipoMensaje, $url);
        }

    }

    private function determinarPagina() {

        /**
         * Determinar la página que se desea cargar
         */
        $respuesta = '';

        if (isset($_REQUEST[$this->miConfigurador->getVariableConfiguracion(self::ENLACE)])) {
            $this->miConfigurador->fabricaConexiones->crypto->decodificar_url($_REQUEST[$this->miConfigurador->getVariableConfiguracion(self::ENLACE)]);
            unset($_REQUEST[$this->miConfigurador->getVariableConfiguracion(self::ENLACE)]);

            if (isset($_REQUEST["redireccionar"])) {
                $this->redireccionar();
                $respuesta = false;
            }

        }

        if (isset($_REQUEST[self::PAGINA])) {
            $respuesta = $_REQUEST[self::PAGINA];
        } else {

            if (isset($_REQUEST['development'])) {

                $respuesta = 'development';

            } else {
                $respuesta = 'index';
            }
        }

        return $respuesta;

    }

    /**
     * Instalar el aplicativo.
     */
    private function instalarAplicativo() {

        require_once "install/Instalador.class.php";
        $this->miInstalador = new Instalador();
        if (isset($_REQUEST["instalador"])) {
            $this->miInstalador->procesarInstalacion();
        } else {
            $this->miInstalador->mostrarFormularioDatosConexion();
        }
        return 0;

    }

    /**
     * Redireccionar a otra página
     *
     * @return number
     */
    public function redireccionar($pagina = '', $opciones = '') {

        $enlace = $this->miConfigurador->getVariableConfiguracion(self::ENLACE);
        $indice = $this->miConfigurador->configuracion["host"] . $this->miConfigurador->configuracion["site"] . "/index.php?";

        switch ($pagina) {

            case '':
                $redireccion = $indice . $this->getVariable();
                break;

            case 'indice':

                $redireccion = $indice . $this->miConfigurador->fabricaConexiones->crypto->codificar_url($opciones, $enlace);
                break;

            default:
                $redireccion = $pagina;

                break;
        }

        echo "<script>location.replace('" . $redireccion . "')</script>";

    }

    private function getVariable() {

        $variable = "";

        foreach ($_REQUEST as $clave => $val) {
            if ($clave != "redireccionar" && $clave != $enlace) {
                $variable .= "&" . $clave . "=" . $val;
            }
        }
        $variable = substr($variable, 1);
        return $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $enlace);

    }

}
?>
