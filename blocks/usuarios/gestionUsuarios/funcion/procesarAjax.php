<?php
class procesarAjax {
    public $miConfigurador;
    public $miSql;
    public function __construct($sql) {
        $this->miConfigurador = \Configurador::singleton();

        $this->ruta = $this->miConfigurador->getVariableConfiguracion("rutaBloque");

        $this->miSql = $sql;

        // Conexion de Base de Datos
        $conexion = "estructura";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        switch ($_REQUEST['funcion']) {

            case 'eliminarFuncionalidad':

                $cadenaSql = $this->miSql->getCadenaSql('eliminar_funcionalidad');
                $eliminar_funcionalidades = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

                if ($eliminar_funcionalidades) {
                    return true;
                } else {
                    return false;
                }

                break;
            case 'consultarRelaciones':

                $cadenaSql = $this->miSql->getCadenaSql('consultar_funcionalidad_relacion');
                $funcionalidades = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

                $tabla = new \stdClass();

                $page = $_REQUEST['page'];

                $limit = $_REQUEST['rows'];

                $sidx = $_REQUEST['sidx'];

                $sord = $_REQUEST['sord'];

                if (!$sidx) {
                    $sidx = 1;
                }

                $filas = count($funcionalidades);

                if ($filas > 0 && $limit > 0) {
                    $total_pages = ceil($filas / $limit);
                } else {
                    $total_pages = 0;
                }

                if ($page > $total_pages) {
                    $page = $total_pages;
                }
                $start = $limit * $page - $limit;
                if ($funcionalidades != false) {
                    $tabla->page = $page;
                    $tabla->total = $total_pages;
                    $tabla->records = $filas;

                    $i = 0;
                    $j = 1;
                    foreach ($funcionalidades as $row) {
                        $tabla->rows[$i]['id'] = $row['id_rol_pagina'];
                        $tabla->rows[$i]['cell'] = array(
                            $row['id_rol_pagina'],
                            trim($row['descripcion']),

                        );

                        $i++;
                    }

                    $tabla = json_encode($tabla);
                } else {

                    $tabla->page = 1;
                    $tabla->total = 1;
                    $tabla->records = 1;

                    $tabla->rows[0]['id'] = 1;
                    $tabla->rows[0]['cell'] = array(
                        "1",
                        "Sin Funcionalidades Registradas",

                    );
                    $tabla = json_encode($tabla);

                }

                echo $tabla;

                break;

            case 'adicionFuncionalidad':

                $cadenaSql = $this->miSql->getCadenaSql('registrar_funcionalidad');
                $funcionalidad = $esteRecursoDB->ejecutarAcceso($cadenaSql, "acceso");

                if ($funcionalidad) {
                    return true;
                } else {
                    return false;
                }

                break;

            case 'consultarPaginas':

                $cadenaSql = $this->miSql->getCadenaSql('consultar_paginas');
                $paginas = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
                //var_dump($paginas);
                $select = "<select>";

                $select .= "<option value=''> </option> ";
                foreach ($paginas as $key => $value) {

                    $select .= "<option value='" . $value['id_pagina'] . "'>" . trim($value['descripcion']) . "</option>";

                }
                $select .= "</select>";

                echo $select;
                break;
            case 'eliminarRol':
                $cadenaSql = $this->miSql->getCadenaSql('eliminar_rol');

                $rol_eliminado = $esteRecursoDB->ejecutarAcceso($cadenaSql, "acceso");

                if ($rol_eliminado) {
                    return true;
                } else {
                    return false;
                }

                break;
            case 'editarRol':

                $cadenaSql = $this->miSql->getCadenaSql('actualizar_rol');

                $rol_actualizado = $esteRecursoDB->ejecutarAcceso($cadenaSql, "acceso");

                if ($rol_actualizado) {
                    return true;
                } else {
                    return false;
                }

                break;
            case 'crearRol':

                $cadenaSql = $this->miSql->getCadenaSql('crear_rol');

                $rol_creado = $esteRecursoDB->ejecutarAcceso($cadenaSql, "acceso");

                if ($rol_creado) {
                    return true;
                } else {
                    return false;
                }

                break;
            case 'consultarRol':

                $cadenaSql = $this->miSql->getCadenaSql('consultar_roles');

                $roles_consultados = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

                $tabla = new \stdClass();

                $page = $_REQUEST['page'];

                $limit = $_REQUEST['rows'];

                $sidx = $_REQUEST['sidx'];

                $sord = $_REQUEST['sord'];

                if (!$sidx) {
                    $sidx = 1;
                }

                $filas = count($roles_consultados);

                if ($filas > 0 && $limit > 0) {
                    $total_pages = ceil($filas / $limit);
                } else {
                    $total_pages = 0;
                }

                if ($page > $total_pages) {
                    $page = $total_pages;
                }
                $start = $limit * $page - $limit;
                if ($roles_consultados != false) {
                    $tabla->page = $page;
                    $tabla->total = $total_pages;
                    $tabla->records = $filas;

                    $i = 0;
                    $j = 1;
                    foreach ($roles_consultados as $row) {
                        $tabla->rows[$i]['id'] = $row['id_rol'];
                        $tabla->rows[$i]['cell'] = array(
                            $row['id_rol'],
                            trim($row['nombre']),
                            trim($row['descripcion']),
                        );
                        $i++;
                    }

                    $tabla = json_encode($tabla);
                } else {

                    $tabla->page = 1;
                    $tabla->total = 1;
                    $tabla->records = 1;

                    $tabla->rows[0]['id'] = 1;
                    $tabla->rows[0]['cell'] = array(
                        "1",
                        "Sin Roles Registrados",
                        "Sin Roles Registrados",

                    );
                    $tabla = json_encode($tabla);

                }

                echo $tabla;

                break;

        }

        exit();
    }
}

$miProcesarAjax = new procesarAjax($this->sql);

?>
