<?php
if (!isset($GLOBALS["autorizado"])) {
    include "../index.php";
    exit();
}
/**
 * Este script está incluido en el método html de la clase Frontera.class.php.
 *
 * La ruta absoluta del bloque está definida en $this->ruta
 */
$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
$nombreFormulario = $esteBloque["nombre"];
include_once "core/crypto/Encriptador.class.php";
$cripto = Encriptador::singleton();
$valorCodificado = "action=" . $esteBloque["nombre"];
$valorCodificado .= "&bloque=" . $esteBloque["id_bloque"];
$valorCodificado .= "&bloqueGrupo=" . $esteBloque["grupo"];
$valorCodificado = $cripto->codificar($valorCodificado);
$directorio = $this->miConfigurador->getVariableConfiguracion("rutaUrlBloque") . "/imagen/";

// ------------------Division para las pestañas-------------------------
$atributos["id"] = "tabs";
$atributos["estilo"] = "";
echo $this->miFormulario->division("inicio", $atributos);
unset($atributos);
{
    // -------------------- Listado de Pestañas (Como lista No Ordenada) -------------------------------

    $items = array(
        "tabGestionGeneral" => $this->lenguaje->getCadena("tabGestionGeneral"),
        "tabAsociacion" => $this->lenguaje->getCadena("tabAsociacion"),
    );
    $atributos["items"] = $items;
    $atributos["estilo"] = "jqueryui";
    $atributos["pestañas"] = "true";
    echo $this->miFormulario->listaNoOrdenada($atributos);

    {
        // Pestañas de Gestionar Usuarios
        $esteCampo = "tabGestionGeneral";
        $atributos['id'] = $esteCampo;
        $atributos["estilo"] = "jqueryui";
        $atributos['tipoEtiqueta'] = 'inicio';
        echo $this->miFormulario->agrupacion('inicio', $atributos);
        unset($atributos);
        {

            include $this->ruta . "formulario/tabs/tabGestionGeneral.php";
            // -----------------Fin Division para la pestaña 2-------------------------
        }
        echo $this->miFormulario->agrupacion('fin');
        unset($atributos);
    }
    {
        // Pestañas de Asosiar Funcionalidades
        $esteCampo = "tabAsociacion";
        $atributos['id'] = $esteCampo;
        $atributos["estilo"] = "jqueryui";
        $atributos['tipoEtiqueta'] = 'inicio';
        echo $this->miFormulario->agrupacion('inicio', $atributos);
        unset($atributos);
        {

            include $this->ruta . "formulario/tabs/tabAsociacion.php";
            // -----------------Fin Division para la pestaña 2-------------------------
        }
        echo $this->miFormulario->agrupacion('fin');
    }
}
echo $this->miFormulario->division("fin");
unset($atributos);
?>