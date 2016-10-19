<?php

include_once "core/manager/Configurador.class.php";

Class SessionUsuario {

    private $elements;
    private $module;
    private $info;
    private $connection;
    private $miConfigurador;

    public function __construct() {

        // El objeto de la clase Configurador debe ser único en toda la aplicación
        $this->miConfigurador = \Configurador::singleton();

        $this->module = array_pop(explode("/", dirname(__FILE__)));
        $this->elements = array();

    }

    public function executeFuntion($accion = '', $usuario = '') {

        @session_start();

        $response = false;

        /**
         * Acción Realizar Sesion
         **/

        switch ($accion) {
            case 'Iniciar':
                $this->createSession($usuario);
                break;

            case 'Validar':

                $this->validateSession();
                break;

            case 'Finalizar':
                $this->closeSession();
                break;

            default:
                # code...
                break;
        }

        return $response;
    }

    private function validateUser() {

        $response = $this->connection->select('t2ir_user', array('name', 'lastname'), array('AND' => array(
            'email' => $_POST['usuario'], 'password' => $_POST['contrasena'], 'status' => 'TRUE')));

        if (count($response) > 0) {
            $username = $response[0]['name']+" "+$response[0]['lastname'];
            $this->createSession($username);
            return true;
        } else {
            return false;
        }
    }

    private function createSession($username) {

        $arreglo_config = $this->miConfigurador->registro[18];

        $tiempo_config = trim($arreglo_config['valor']);

        $time = $tiempo_config . 'M';
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('America/Bogota'));
        $date->add(new DateInterval('PT' . $time));

        $_SESSION['expiration'] = $date->getTimestamp();
        $_SESSION['username'] = $username;
        $_SESSION['acceso'] = 1;

    }

    private function closeSession() {

        session_destroy();

    }

    private function validateSession() {

        $arreglo_config = $this->miConfigurador->registro[18];
        $tiempo_config = trim($arreglo_config['valor']);

        $time = $tiempo_config . 'M';
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('America/Bogota'));

        if (isset($_SESSION['expiration']) && isset($_SESSION['username'])) {

            if ($date->getTimestamp() < $_SESSION['expiration']) {
                $date->add(new DateInterval('PT' . $time));
                $_SESSION['expiration'] = $date->getTimestamp();
                return true;
            }
        }

        $this->closeSession();

        return false;
    }

    private function confirmRegistration($token) {

        $response = $this->connection->select('t2ir_user', array('name', 'lastname'), array('AND' => array(
            'status' => FALSE, 'token' => $token)));
        if (count($response) > 0) {
            $username = $response[0]['name']+" "+$response[0]['lastname'];
            $this->createSession($username);

            $response = $this->connection->update('t2ir_user', array('status' => 'TRUE'), array('AND' => array('token' => $token)));

            return true;
        } else {
            return false;
        }
    }
}

?>
