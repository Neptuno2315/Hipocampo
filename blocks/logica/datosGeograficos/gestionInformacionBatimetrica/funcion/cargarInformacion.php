    <?php
use logica\datosGeograficos\gestionInformacionBatimetrica\funcion\Redireccionador;

include_once 'Redireccionador.php';
include_once "core/builder/InspectorHTML.class.php";
class FormProcessor {
    public $miConfigurador;
    public $miInspectorHTML;
    public $lenguaje;
    public $miFormulario;
    public $miSql;
    public $conexion;
    public $var_dbf;
    public $var_prj;
    public $var_shx;
    public $var_shp;
    public $prefijo;
    public $archivoSql;
    public $resultado_insercion;
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

                    $_REQUEST = $respuesta;
                } else {
                    Redireccionador::redireccionar("ErrorModificacionFormulario");
                }
            }
        }

        /*
         * Verificar Extensión Ficheros
         */

        $this->actualizarBatimetriaZona();

        /*
         * Verificar Extensión Ficheros
         */

        $this->verificarExtencionFicheros();

        /*
         * Cargar Ficheros en el Directorio
         */

        $this->cargarFicherosDirectorio();

        /*
         * Cargar Estructura a la Tabla Espacial
         */

        $this->cargarEstruturaEspacial();

        /*
         * Eliminar Archivos Procesados
         */

        $this->eliminarArchivosInnecesarios();

        if ($this->resultado_insercion == 'COMMIT') {
            Redireccionador::redireccionar("Inserto");
        } else {
            Redireccionador::redireccionar("NoInserto");
        }
    }
    public function eliminarArchivosInnecesarios() {

        /*
         * fichero dbf
         */
        unlink($this->var_dbf['rutaDirectorio']);
        /*
         * fichero prj
         */
        unlink($this->var_prj['rutaDirectorio']);
        /*
         * fichero shx
         */
        unlink($this->var_shx['rutaDirectorio']);
        /*
         * fichero shp y acrhivo sql
         */
        unlink($this->var_shp['rutaDirectorio']);
        unlink($this->var_shp['ruta_sql']);

    }
    public function cargarEstruturaEspacial() {

        $this->archivoSql = reset(explode(".", $this->var_shp['nombreActualArchivo']));

        $this->archivoSql = str_replace(" ", "", $this->archivoSql);

        $rutaStatica = $this->miConfigurador->configuracion['rutaBloque'] . "/funcion/procesarShapes/";

        $this->var_shp['ruta_sql'] = $rutaStatica . $this->archivoSql . ".slq";

        $conexion = "geografico";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        $SentenciaShape = "shp2pgsql  -D -W LATIN1 -I -s " . $_REQUEST['srid'] . " -a ";
        $SentenciaShape .= $this->var_shp['rutaDirectorio'] . "  geografico.batimetria >  ";
        $SentenciaShape .= $rutaStatica . $this->archivoSql . ".slq ; ";

        $queries = exec($SentenciaShape);

        /**
         *Agregar Identificador Zona de Estudio para asociar la Batimetria
         **/
        $this->editarArchivoSQL();

        $SentenciaLinux = "PGUSER=" . $esteRecursoDB->usuario;
        $SentenciaLinux .= " PGPASSWORD=" . $esteRecursoDB->clave;
        $SentenciaLinux .= " psql -d " . $this->miConfigurador->configuracion['dbnombre'];
        $SentenciaLinux .= " -a -f " . $this->var_shp['ruta_sql'];

        $this->resultado_insercion = exec($SentenciaLinux);

    }

    public function editarArchivoSQL() {

        $contenidoArchivo = file_get_contents($this->var_shp['ruta_sql']);

        $contenidoArchivo = explode("\n", $contenidoArchivo);

        $max = max(array_keys($contenidoArchivo));

        foreach ($contenidoArchivo as $key => $value) {

            if ($key == 3) {

                $contenidoArchivo[$key] = 'COPY "geografico"."batimetria" ("id_zona_estudio","x","y","z",geom) FROM stdin;';

            }

            if ($key >= 4 && $key <= ($max - 4)) {

                $contenidoArchivo[$key] = $_REQUEST['id_zona'] . "\t" . $value;

            }
            if ($key == $max - 2) {

                $contenidoArchivo[$key] = "REINDEX INDEX batimetria_geom_idx ;";

            }
        }

        $archivoReescribir = fopen($this->var_shp['ruta_sql'], "w+b");

        foreach ($contenidoArchivo as $linea) {
            fwrite($archivoReescribir, $linea . "\n");
        }

        fclose($archivoReescribir);

    }

    public function cargarFicherosDirectorio() {

        /**
         *
         * @var unknown $this->prefijo Cadena Aleatoria para evitar que los shapes se dupliquen al subir.
         */
        $this->prefijo = substr(md5(uniqid(time())), 0, 6);

        /*
         * fichero dbf
         */
        {
            /*
             * obtenemos los datos del Fichero
             */
            $tamano = $this->var_dbf['size'];
            $tipo = $this->var_dbf['type'];
            $archivo = $this->var_dbf['name'];

            /*
             * guardamos el fichero en el Directorio
             */
            $ruta_absoluta = $this->miConfigurador->configuracion['rutaBloque'] . "/funcion/procesarShapes/" . $this->prefijo . "_" . $archivo;
            $this->var_dbf['rutaDirectorio'] = $ruta_absoluta;
            if (!copy($this->var_dbf['tmp_name'], $ruta_absoluta)) {

                Redireccionador::redireccionar("ErrorCargarFicheroDirectorio");
            }
        }
        /*
         * fichero prj
         */

        {
            /*
             * obtenemos los datos del Fichero
             */
            $tamano = $this->var_prj['size'];
            $tipo = $this->var_prj['type'];
            $archivo = $this->var_prj['name'];

            /*
             * guardamos el fichero en el Directorio
             */
            $ruta_absoluta = $this->miConfigurador->configuracion['rutaBloque'] . "/funcion/procesarShapes/" . $this->prefijo . "_" . $archivo;
            $this->var_prj['rutaDirectorio'] = $ruta_absoluta;

            if (!copy($this->var_prj['tmp_name'], $ruta_absoluta)) {

                Redireccionador::redireccionar("ErrorCargarFicheroDirectorio");
            }
        }

        /*
         * fichero shx
         */

        {
            /*
             * obtenemos los datos del Fichero
             */
            $tamano = $this->var_shx['size'];
            $tipo = $this->var_shx['type'];
            $archivo = $this->var_shx['name'];

            /*
             * guardamos el fichero en el Directorio
             */

            $ruta_absoluta = $this->miConfigurador->configuracion['rutaBloque'] . "/funcion/procesarShapes/" . $this->prefijo . "_" . $archivo;
            $this->var_shx['rutaDirectorio'] = $ruta_absoluta;
            if (!copy($this->var_shx['tmp_name'], $ruta_absoluta)) {

                Redireccionador::redireccionar("ErrorCargarFicheroDirectorio");
            }
        }

        /*
         * fichero shp
         */

        {
            /*
             * obtenemos los datos del Fichero
             */
            $tamano = $this->var_shp['size'];
            $tipo = $this->var_shp['type'];
            $archivo = $this->var_shp['name'];

            /*
             * guardamos el fichero en el Directorio
             */

            $this->var_shp['nombreActualArchivo'] = $this->prefijo . "_" . $archivo;

            $ruta_absoluta = $this->miConfigurador->configuracion['rutaBloque'] . "/funcion/procesarShapes/" . $this->prefijo . "_" . $archivo;
            $this->var_shp['rutaDirectorio'] = $ruta_absoluta;

            if (!copy($this->var_shp['tmp_name'], $ruta_absoluta)) {

                Redireccionador::redireccionar("ErrorCargarFicheroDirectorio");
            }
        }
    }
    public function verificarExtencionFicheros() {
        if (isset($_FILES['fichero_dbf'])) {

            $archivo = $_FILES['fichero_dbf'];
            $trozos = explode(".", $archivo['name']);
            $extension = end($trozos);
            ($extension != 'dbf') ? Redireccionador::redireccionar("ErrorExtension") : $this->var_dbf = $archivo;
        }

        if (isset($_FILES['fichero_prj'])) {

            $archivo = $_FILES['fichero_prj'];
            $trozos = explode(".", $archivo['name']);
            $extension = end($trozos);
            ($extension != 'prj') ? Redireccionador::redireccionar("ErrorExtension") : $this->var_prj = $archivo;
        }

        if (isset($_FILES['fichero_shx'])) {

            $archivo = $_FILES['fichero_shx'];
            $trozos = explode(".", $archivo['name']);
            $extension = end($trozos);
            ($extension != 'shx') ? Redireccionador::redireccionar("ErrorExtension") : $this->var_shx = $archivo;
        }

        if (isset($_FILES['fichero_shp'])) {

            $archivo = $_FILES['fichero_shp'];
            $trozos = explode(".", $archivo['name']);
            $extension = end($trozos);
            ($extension != 'shp') ? Redireccionador::redireccionar("ErrorExtension") : $this->var_shp = $archivo;
        }
    }

    public function actualizarBatimetriaZona() {

        $conexion = "geografico";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        $cadenaSql = $this->miSql->getCadenaSql("actualiza_batimetria_zona");
        $actualizacion = $esteRecursoDB->ejecutarAcceso($cadenaSql, "accion", $_REQUEST['id_zona'], "actualiza_batimetria_zona");

    }

}

$miProcesador = new FormProcessor($this->lenguaje, $this->sql);

$resultado = $miProcesador->procesarFormulario();

?>