<?php

namespace usuarios\gestionUsuarios;

if (!isset($GLOBALS["autorizado"])) {
    include "../index.php";
    exit();
}

include_once "core/manager/Configurador.class.php";
include_once "core/connection/Sql.class.php";

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class Sql extends \Sql {
    public $miConfigurador;
    public function __construct() {
        $this->miConfigurador = \Configurador::singleton();
    }
    public function getCadenaSql($tipo, $variable = "") {

        /**
         * 1.
         * Revisar las variables para evitar SQL Injection
         */
        $prefijo = $this->miConfigurador->getVariableConfiguracion("prefijo");
        //$idSesion = $this->miConfigurador->getVariableConfiguracion("id_sesion");

        switch ($tipo) {

            /**
             * Clausulas específicas
             */

            case "consultar_roles":
                $cadenaSql = " SELECT id_rol, nombre, descripcion, estado_registro, fecha_registro";
                $cadenaSql .= " FROM " . $prefijo . "rol ";
                $cadenaSql .= " WHERE estado_registro = TRUE ";
                $cadenaSql .= " ORDER BY id_rol " . $_REQUEST['sord'] . ";";
                break;

            case "crear_rol":
                $cadenaSql = " INSERT INTO " . $prefijo . "rol(nombre, descripcion)";
                $cadenaSql .= " VALUES ('" . $_REQUEST['nombre'] . "',";
                $cadenaSql .= " '" . $_REQUEST['descripcion'] . "');";
                break;

            case 'actualizar_rol':
                $cadenaSql = " UPDATE " . $prefijo . "rol ";
                $cadenaSql .= " SET nombre='" . $_REQUEST['nombre'] . "', descripcion='" . $_REQUEST['descripcion'] . "'";
                $cadenaSql .= " WHERE id_rol= '" . $_REQUEST['id'] . "';";
                break;

            case 'eliminar_rol':
                $cadenaSql = " UPDATE " . $prefijo . "rol ";
                $cadenaSql .= " SET estado_registro= FALSE ";
                $cadenaSql .= " WHERE id_rol= '" . $_REQUEST['id'] . "';";
                break;

            case 'consultar_paginas':
                $cadenaSql = " SELECT id_pagina, nombre_menu||'('|| nombre_menu_general ||')' as descripcion";
                $cadenaSql .= " FROM " . $prefijo . "pagina";
                $cadenaSql .= " WHERE nombre_menu IS NOT NULL;";
                break;

            case 'registrar_funcionalidad':
                $cadenaSql = " INSERT INTO " . $prefijo . "rol_pagina(id_rol, id_pagina)";
                $cadenaSql .= " VALUES ('" . $_REQUEST['identificador'] . "', '" . $_REQUEST['funcionalidad'] . "');";
                break;

            case 'consultar_funcionalidad_relacion':
                $cadenaSql = " SELECT rp.id_rol_pagina,rp.id_rol,pn.nombre_menu||'('|| pn.nombre_menu_general ||')' as descripcion";
                $cadenaSql .= " FROM " . $prefijo . "rol_pagina rp ";
                $cadenaSql .= " JOIN " . $prefijo . "pagina pn ON pn.id_pagina= rp.id_pagina ";
                $cadenaSql .= " WHERE estado_registro= TRUE";
                $cadenaSql .= " AND rp.id_rol= '" . $_REQUEST['id_gestion'] . "' ";
                $cadenaSql .= " ORDER BY rp.id_rol_pagina " . $_REQUEST['sord'] . ";";
                break;

            case 'eliminar_funcionalidad':
                $cadenaSql = " UPDATE " . $prefijo . "rol_pagina";
                $cadenaSql .= " SET estado_registro=FALSE ";
                $cadenaSql .= " WHERE id_rol_pagina='" . $_REQUEST['id'] . "';";
                break;

            case 'consultar_roles_seleccion':
                $cadenaSql = " SELECT id_rol, nombre ";
                $cadenaSql .= " FROM " . $prefijo . "rol ";
                $cadenaSql .= " WHERE estado_registro = TRUE ;";

                break;

            case 'consultar_usuarios':
                $cadenaSql = " SELECT usa.* , rol.nombre as nombre_rol ";
                $cadenaSql .= " FROM " . $prefijo . "usuario as usa";
                $cadenaSql .= " JOIN " . $prefijo . "rol as rol ON rol.id_rol= usa.tipo AND rol.estado_registro= TRUE";
                $cadenaSql .= " WHERE usa.estado=TRUE ";
                $cadenaSql .= " ORDER BY usa.id_usuario " . $_REQUEST['sord'] . ";";
                break;

            case 'registrar_usuario':
                $cadenaSql = " INSERT INTO " . $prefijo . "usuario(id_usuario, identificacion, tipo_identificacion, nombre, apellido, ";
                $cadenaSql .= " correo, clave, tipo)";
                $cadenaSql .= " VALUES ('" . $_REQUEST['num_ident'] . "', ";
                $cadenaSql .= " '" . $_REQUEST['num_ident'] . "',";
                $cadenaSql .= " '" . $_REQUEST['tipo_id'] . "',";
                $cadenaSql .= " '" . $_REQUEST['nombres'] . "',";
                $cadenaSql .= " '" . $_REQUEST['apellidos'] . "',";
                $cadenaSql .= " '" . $_REQUEST['email'] . "',";
                $cadenaSql .= " '" . $_REQUEST['contrasena'] . "',";
                $cadenaSql .= " '" . $_REQUEST['rol'] . "');";
                break;

            case 'actualizar_usuario':

                $cadenaSql = " UPDATE " . $prefijo . "usuario";
                $cadenaSql .= " SET estado=FALSE ";
                $cadenaSql .= " WHERE id_usuario='" . $_REQUEST['id'] . "'; ";
                $cadenaSql .= " INSERT INTO " . $prefijo . "usuario(id_usuario, identificacion, tipo_identificacion, nombre, apellido, ";
                $cadenaSql .= " correo, clave,firma_usuario , tipo)";
                $cadenaSql .= " VALUES ('" . $_REQUEST['num_ident'] . "', ";
                $cadenaSql .= " '" . $_REQUEST['num_ident'] . "',";
                $cadenaSql .= " '" . $_REQUEST['tipo_id'] . "',";
                $cadenaSql .= " '" . $_REQUEST['nombres'] . "',";
                $cadenaSql .= " '" . $_REQUEST['apellidos'] . "',";
                $cadenaSql .= " '" . $_REQUEST['email'] . "',";
                $cadenaSql .= " '" . $_REQUEST['contrasena'] . "',";
                $cadenaSql .= " '" . $_REQUEST['firma_usuario'] . "',";
                $cadenaSql .= " '" . $_REQUEST['rol'] . "');";

                break;

            case 'consultar_usuario_particular':
                $cadenaSql = " SELECT usa.* , rol.nombre as nombre_rol ";
                $cadenaSql .= " FROM " . $prefijo . "usuario as usa";
                $cadenaSql .= " JOIN " . $prefijo . "rol as rol ON rol.id_rol= usa.tipo AND rol.estado_registro= TRUE";
                $cadenaSql .= " WHERE usa.estado=TRUE ";
                $cadenaSql .= " AND  id_usuario='" . $_REQUEST['id'] . "' ;";
                break;

            case 'eliminar_usuario':
                $cadenaSql = " UPDATE " . $prefijo . "usuario";
                $cadenaSql .= " SET estado=FALSE ";
                $cadenaSql .= " WHERE id_usuario='" . $_REQUEST['id'] . "'; ";
                break;

        }
        return $cadenaSql;
    }
}

?>
