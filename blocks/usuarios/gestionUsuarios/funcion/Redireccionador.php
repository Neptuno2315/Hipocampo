<?php
namespace usuarios\gestionUsuarios\funcion;

if (!isset($GLOBALS["autorizado"])) {
    include "index.php";
    exit();
}
class Redireccionador {
    public static function redireccionar($opcion, $valor = "") {
        $miConfigurador = \Configurador::singleton();

        switch ($opcion) {

            case 'ErrorModificacionFormulario':
                $variable = 'pagina=gestionUsuarios';
                $variable .= "&opcion=cuentaUsuario";
                $variable .= "&mensaje=ErrorProcesamiento";
                $variable .= "&usuario=" . $_REQUEST['usuario'];

                break;

            case 'NoActualizo':
                $variable = 'pagina=gestionUsuarios';
                $variable .= "&opcion=cuentaUsuario";
                $variable .= "&mensaje=ErrorActualizar";
                $variable .= "&usuario=" . $_REQUEST['usuario'];

                break;

            case 'ActualizacionExito':
                $variable = 'pagina=index';
                $variable .= "&actualizacion_datos=TRUE";
                break;

        }
        foreach ($_REQUEST as $clave => $valor) {
            unset($_REQUEST[$clave]);
        }

        $url = $miConfigurador->configuracion["host"] . $miConfigurador->configuracion["site"] . "/index.php?";
        $enlace = $miConfigurador->configuracion['enlace'];
        $variable = $miConfigurador->fabricaConexiones->crypto->codificar($variable);
        $_REQUEST[$enlace] = $enlace . '=' . $variable;
        $redireccion = $url . $_REQUEST[$enlace];

        echo "<script>location.replace('" . $redireccion . "')</script>";
        exit();
    }
}
?>