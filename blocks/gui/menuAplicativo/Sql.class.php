<?php

namespace gui\menuAplicativo;

if (!isset($GLOBALS["autorizado"])) {
    include "../index.php";
    exit();
}

include_once "core/manager/Configurador.class.php";
include_once "core/connection/Sql.class.php";

/**
 * IMPORTANTE: Se recomienda que no se borren registros. Utilizar mecanismos para - independiente del motor de bases de datos,
 * poder realizar rollbacks gestionados por el aplicativo.
 */

class Sql extends \Sql {

    public $miConfigurador;

    public function getCadenaSql($tipo, $variable = '') {

        /**
         * 1.
         * Revisar las variables para evitar SQL Injection
         */
        $prefijo = $this->miConfigurador->getVariableConfiguracion("prefijo");
        $idSesion = $this->miConfigurador->getVariableConfiguracion("id_sesion");

        switch ($tipo) {

            /**
             * Clausulas específicas
             */
            case 'consultar_acceso_paginas':

                $cadenaSql = " SELECT DISTINCT pn.nombre as nombre_url_pagina, pn.nombre_menu, ";
                $cadenaSql .= " pn.nombre_menu_general, pn.nombre_subtitulo_menu_general, pn.orden,  pn.imagen_menu ";
                $cadenaSql .= " FROM " . $prefijo . "pagina as pn";
                $cadenaSql .= " JOIN " . $prefijo . "rol_pagina as rp ON rp.id_pagina=pn.id_pagina AND rp.estado_registro=TRUE";
                $cadenaSql .= " JOIN " . $prefijo . "rol as rl ON rl.id_rol=rp.id_rol AND rl.estado_registro=TRUE";
                $cadenaSql .= " JOIN " . $prefijo . "usuario as us ON us.tipo=rl.id_rol";
                $cadenaSql .= " WHERE us.id_usuario='" . $_REQUEST['usuario'] . "' ";
                $cadenaSql .= " ORDER BY  pn.nombre_menu_general, pn.orden  ASC; ";
                break;

            case 'consultar_Menu_General':
                $cadenaSql = " SELECT DISTINCT pn.nombre_menu_general, pn.nombre_subtitulo_menu_general, pn.imagen_general ";
                $cadenaSql .= " FROM poseidon.hipocampo_pagina as pn";
                $cadenaSql .= " JOIN hipocampo_rol_pagina as rp ON rp.id_pagina=pn.id_pagina AND rp.estado_registro=TRUE";
                $cadenaSql .= " JOIN hipocampo_rol as rl ON rl.id_rol=rp.id_rol AND rl.estado_registro=TRUE";
                $cadenaSql .= " JOIN hipocampo_usuario as us ON us.tipo=rl.id_rol";
                $cadenaSql .= " WHERE us.id_usuario='" . $_REQUEST['usuario'] . "' ";
                $cadenaSql .= " AND pn.nombre_menu_general IS NOT NULL";
                $cadenaSql .= " ORDER BY nombre_menu_general ASC;";
                break;

        }

        return $cadenaSql;

    }
}
?>
