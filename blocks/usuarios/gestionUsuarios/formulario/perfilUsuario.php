<?php
if (!isset($GLOBALS["autorizado"])) {
    include "../index.php";
    exit();
}
class consultarForm {
    public $miConfigurador;
    public $lenguaje;
    public $miFormulario;
    public $miSql;
    public function __construct($lenguaje, $formulario, $sql) {
        $this->miConfigurador = \Configurador::singleton();

        $this->miConfigurador->fabricaConexiones->setRecursoDB('principal');

        $this->lenguaje = $lenguaje;

        $this->miFormulario = $formulario;

        $this->miSql = $sql;
    }
    public function miFormulario() {

        /**
         * IMPORTANTE: Este formulario está utilizando jquery.
         * Por tanto en el archivo ready.php se delaran algunas funciones js
         * que lo complementan.
         */
        // Rescatar los datos de este bloque
        $conexion = "estructura";

        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
        $esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

        $_REQUEST['id'] = $_REQUEST['usuario'];

        $cadenaSql = $this->miSql->getCadenaSql('consultar_usuario_particular');

        $info_usuario = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

        $arreglo = array(
            'num_identificacion' => $info_usuario[0]['identificacion'],
            'tipo_ident' => $info_usuario[0]['tipo_identificacion'],
            'nombres' => $info_usuario[0]['nombre'],
            'apellidos' => $info_usuario[0]['apellido'],
            'email' => $info_usuario[0]['correo'],

        );

        $_REQUEST = array_merge($_REQUEST, $arreglo);

        // ---------------- SECCION: Parámetros Globales del Formulario ----------------------------------
        /**
         * Atributos que deben ser aplicados a todos los controles de este formulario.
         * Se utiliza un arreglo
         * independiente debido a que los atributos individuales se reinician cada vez que se declara un campo.
         *
         * Si se utiliza esta técnica es necesario realizar un mezcla entre este arreglo y el específico en cada control:
         * $atributos= array_merge($atributos,$atributosGlobales);
         */
        $atributosGlobales['campoSeguro'] = 'true';
        $_REQUEST['tiempo'] = time();

        // -------------------------------------------------------------------------------------------------
        // ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------
        $esteCampo = $esteBloque['nombre'];
        $atributos['id'] = $esteCampo;
        $atributos['nombre'] = $esteCampo;

        // Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
        $atributos['tipoFormulario'] = 'multipart/form-data';

        // Si no se coloca, entonces toma el valor predeterminado 'POST'
        $atributos['metodo'] = 'POST';

        // Si no se coloca, entonces toma el valor predeterminado 'index.php' (Recomendado)
        $atributos['action'] = 'index.php';
        $atributos['titulo'] = $this->lenguaje->getCadena("TituloUsuario");

        // Si no se coloca, entonces toma el valor predeterminado.
        $atributos['estilo'] = '';
        $atributos['marco'] = true;
        $tab = 1;
        // ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
        // ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
        $atributos['tipoEtiqueta'] = 'inicio';
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->formulario($atributos);
        unset($atributos);

        $esteCampo = "marcoDatosBasicos";
        $atributos['id'] = $esteCampo;
        $atributos["estilo"] = "jqueryui";
        $atributos['tipoEtiqueta'] = 'inicio';
        $atributos["leyenda"] = "Información Usuario : " . $info_usuario[0]['identificacion'] . " - " . $info_usuario[0]['nombre'] . " " . $info_usuario[0]['apellido'];
        echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);
        unset($atributos);

        {

            $esteCampo = 'num_identificacion';
            $atributos['id'] = $esteCampo;
            $atributos['nombre'] = $esteCampo;
            $atributos['tipo'] = 'text';
            $atributos['estilo'] = 'jqueryui';
            $atributos['marco'] = true;
            $atributos['estiloMarco'] = '';
            $atributos["etiquetaObligatorio"] = false;
            $atributos['columnas'] = 1;
            $atributos['dobleLinea'] = false;
            $atributos['tabIndex'] = $tab;
            $atributos['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
            $atributos['validar'] = 'required,custom[onlyNumberSp],maxSize[20],minSize[5]';

            if (isset($_REQUEST[$esteCampo])) {
                $atributos['valor'] = $_REQUEST[$esteCampo];
            } else {
                $atributos['valor'] = '';
            }
            $atributos['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
            $atributos['deshabilitado'] = false;
            $atributos['tamanno'] = 35;
            $atributos['maximoTamanno'] = '20';
            $atributos['anchoEtiqueta'] = 200;

            $tab++;

            // Aplica atributos globales al control
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->campoCuadroTexto($atributos);
            unset($atributos);

            // ---------------- CONTROL: Cuadro Lista ----------------------
            $esteCampo = 'tipo_ident';
            $atributos['nombre'] = $esteCampo;
            $atributos['id'] = $esteCampo;

            if (isset($_REQUEST[$esteCampo])) {
                $atributos['seleccion'] = $_REQUEST[$esteCampo];
            } else {
                $atributos['seleccion'] = 'CC';
            }

            $atributos['evento'] = '';
            $atributos['deshabilitado'] = false;
            $atributos["etiquetaObligatorio"] = false;
            $atributos['tab'] = $tab;
            $atributos['tamanno'] = 1;
            $atributos['columnas'] = 1;
            $atributos['estilo'] = 'jqueryui';
            $atributos['validar'] = 'required';
            $atributos['limitar'] = true;
            $atributos['anchoCaja'] = 60;
            $atributos['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
            $atributos['anchoEtiqueta'] = 200;
            $atributos['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
            $matrizItems = array(
                array(
                    'CC',
                    'Cedula Ciudadanía',
                ),
                array(
                    'CE',
                    'Cedula Extranjería',
                ),
            );
            $atributos['matrizItems'] = $matrizItems;

            // Utilizar lo siguiente cuando no se pase un arreglo:
            // $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
            // $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
            $tab++;
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->campoCuadroLista($atributos);
            unset($atributos);

            $esteCampo = 'nombres';
            $atributos['id'] = $esteCampo;
            $atributos['nombre'] = $esteCampo;
            $atributos['tipo'] = 'text';
            $atributos['estilo'] = 'jqueryui';
            $atributos['marco'] = true;
            $atributos['estiloMarco'] = '';
            $atributos["etiquetaObligatorio"] = false;
            $atributos['columnas'] = 2;
            $atributos['dobleLinea'] = false;
            $atributos['tabIndex'] = $tab;
            $atributos['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
            $atributos['validar'] = 'required, maxSize[50]';

            if (isset($_REQUEST[$esteCampo])) {
                $atributos['valor'] = $_REQUEST[$esteCampo];
            } else {
                $atributos['valor'] = '';
            }
            $atributos['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
            $atributos['deshabilitado'] = false;
            $atributos['tamanno'] = 35;
            $atributos['maximoTamanno'] = '50';
            $atributos['anchoEtiqueta'] = 200;

            $tab++;

            // Aplica atributos globales al control
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->campoCuadroTexto($atributos);
            unset($atributos);

            $esteCampo = 'apellidos';
            $atributos['id'] = $esteCampo;
            $atributos['nombre'] = $esteCampo;
            $atributos['tipo'] = 'text';
            $atributos['estilo'] = 'jqueryui';
            $atributos['marco'] = true;
            $atributos['estiloMarco'] = '';
            $atributos["etiquetaObligatorio"] = false;
            $atributos['columnas'] = 2;
            $atributos['dobleLinea'] = false;
            $atributos['tabIndex'] = $tab;
            $atributos['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
            $atributos['validar'] = 'required, maxSize[50]';

            if (isset($_REQUEST[$esteCampo])) {
                $atributos['valor'] = $_REQUEST[$esteCampo];
            } else {
                $atributos['valor'] = '';
            }
            $atributos['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
            $atributos['deshabilitado'] = false;
            $atributos['tamanno'] = 35;
            $atributos['maximoTamanno'] = '50';
            $atributos['anchoEtiqueta'] = 100;

            $tab++;

            // Aplica atributos globales al control
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->campoCuadroTexto($atributos);
            unset($atributos);

            $esteCampo = 'email';
            $atributos['id'] = $esteCampo;
            $atributos['nombre'] = $esteCampo;
            $atributos['tipo'] = 'text';
            $atributos['estilo'] = 'jqueryui';
            $atributos['marco'] = true;
            $atributos['estiloMarco'] = '';
            $atributos["etiquetaObligatorio"] = false;
            $atributos['columnas'] = 1;
            $atributos['dobleLinea'] = false;
            $atributos['tabIndex'] = $tab;
            $atributos['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
            $atributos['validar'] = 'required,custom[email],maxSize[100]';

            if (isset($_REQUEST[$esteCampo])) {
                $atributos['valor'] = $_REQUEST[$esteCampo];
            } else {
                $atributos['valor'] = '';
            }
            $atributos['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
            $atributos['deshabilitado'] = false;
            $atributos['tamanno'] = 35;
            $atributos['maximoTamanno'] = '100';
            $atributos['anchoEtiqueta'] = 200;

            $tab++;

            // Aplica atributos globales al control
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->campoCuadroTexto($atributos);
            unset($atributos);

            // ---------------- CONTROL: Cuadro Lista ----------------------
            $esteCampo = 'actualizar_password';
            $atributos['nombre'] = $esteCampo;
            $atributos['id'] = $esteCampo;
            $atributos['seleccion'] = "0";
            $atributos['evento'] = '';
            $atributos['deshabilitado'] = false;
            $atributos["etiquetaObligatorio"] = false;
            $atributos['tab'] = $tab;
            $atributos['tamanno'] = 1;
            $atributos['columnas'] = 1;
            $atributos['estilo'] = 'jqueryui';
            $atributos['validar'] = '';
            $atributos['limitar'] = true;
            $atributos['anchoCaja'] = 60;
            $atributos['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
            $atributos['anchoEtiqueta'] = 200;
            $atributos['titulo'] = "**";
            $matrizItems = array(
                array(
                    '0',
                    'NO',
                ),
                array(
                    '1',
                    'SI',
                ),
            );
            $atributos['matrizItems'] = $matrizItems;

            // Utilizar lo siguiente cuando no se pase un arreglo:
            // $atributos['baseDatos']='ponerAquiElNombreDeLaConexión';
            // $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
            $tab++;
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->campoCuadroLista($atributos);
            unset($atributos);

            $esteCampo = 'contrasenia';
            $atributos['id'] = $esteCampo;
            $atributos['nombre'] = $esteCampo;
            $atributos['tipo'] = 'password';
            $atributos['estilo'] = 'jqueryui';
            $atributos['marco'] = true;
            $atributos['estiloMarco'] = '';
            $atributos["etiquetaObligatorio"] = false;
            $atributos['columnas'] = 1;
            $atributos['dobleLinea'] = false;
            $atributos['tabIndex'] = $tab;
            $atributos['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
            $atributos['validar'] = 'required,maxSize[100],minSize[10]';

            if (isset($_REQUEST[$esteCampo])) {
                $atributos['valor'] = $_REQUEST[$esteCampo];
            } else {
                $atributos['valor'] = '';
            }
            $atributos['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
            $atributos['deshabilitado'] = false;
            $atributos['tamanno'] = 35;
            $atributos['maximoTamanno'] = '100';
            $atributos['anchoEtiqueta'] = 200;

            $tab++;

            // Aplica atributos globales al control
            $atributos = array_merge($atributos, $atributosGlobales);
            echo $this->miFormulario->campoCuadroTexto($atributos);
            unset($atributos);

            // ------------------Division para los botones-------------------------
            $atributos["id"] = "botones";
            $atributos["estilo"] = "marcoBotones";
            echo $this->miFormulario->division("inicio", $atributos);
            {
                // -----------------CONTROL: Botón ----------------------------------------------------------------
                $esteCampo = 'botonActualizar';
                $atributos["id"] = $esteCampo;
                $atributos["tabIndex"] = $tab;
                $atributos["tipo"] = 'boton';
                // submit: no se coloca si se desea un tipo button genérico
                $atributos['submit'] = true;
                $atributos["estiloMarco"] = '';
                $atributos["estiloBoton"] = 'jqueryui';
                // verificar: true para verificar el formulario antes de pasarlo al servidor.
                $atributos["verificar"] = '';
                $atributos["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
                $atributos["valor"] = $this->lenguaje->getCadena($esteCampo);
                $atributos['nombreFormulario'] = $esteBloque['nombre'];
                $tab++;

                // Aplica atributos globales al control
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoBoton($atributos);
                unset($atributos);

                // -----------------FIN CONTROL: Botón -----------------------------------------------------------
            }
            // ------------------Fin Division para los botones-------------------------
            echo $this->miFormulario->division("fin");
            unset($atributos);
        }

        echo $this->miFormulario->marcoAgrupacion('fin');
        unset($atributos);

        // ------------------- SECCION: Paso de variables ------------------------------------------------

        /**
         * En algunas ocasiones es útil pasar variables entre las diferentes páginas.
         * SARA permite realizar esto a través de tres
         * mecanismos:
         * (a). Registrando las variables como variables de sesión. Estarán disponibles durante toda la sesión de usuario. Requiere acceso a
         * la base de datos.
         * (b). Incluirlas de manera codificada como campos de los formularios. Para ello se utiliza un campo especial denominado
         * formsara, cuyo valor será una cadena codificada que contiene las variables.
         * (c) a través de campos ocultos en los formularios. (deprecated)
         */
        // En este formulario se utiliza el mecanismo (b) para pasar las siguientes variables:
        // Paso 1: crear el listado de variables

        $valorCodificado = "action=" . $this->miConfigurador->getVariableConfiguracion('pagina');
        $valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina');
        $valorCodificado .= "&bloque=" . $esteBloque['nombre'];
        $valorCodificado .= "&bloqueGrupo=" . $esteBloque["grupo"];
        $valorCodificado .= "&usuario=" . $_REQUEST["usuario"];
        $valorCodificado .= "&opcion=actualizarUsuario";
        /**
         * SARA permite que los nombres de los campos sean dinámicos.
         * Para ello utiliza la hora en que es creado el formulario para
         * codificar el nombre de cada campo.
         */
        $valorCodificado .= "&campoSeguro=" . $_REQUEST['tiempo'];
        /*
         * Sara permite validar los campos en el formulario o funcion destino.
         * Para ello se envía los datos atributos["validadar"] de los componentes del formulario
         * Estos se pueden obtener en el atributo $this->miFormulario->validadorCampos del formulario
         * La función $this->miFormulario->codificarCampos() codifica automáticamente el atributo validadorCampos
         */
        $valorCodificado .= "&validadorCampos=" . $this->miFormulario->codificarCampos();

        // Paso 2: codificar la cadena resultante
        $valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar($valorCodificado);

        $atributos["id"] = "formSaraData"; // No cambiar este nombre
        $atributos["tipo"] = "hidden";
        $atributos['estilo'] = '';
        $atributos["obligatorio"] = false;
        $atributos['marco'] = true;
        $atributos["etiqueta"] = "";
        $atributos["valor"] = $valorCodificado;
        echo $this->miFormulario->campoCuadroTexto($atributos);
        unset($atributos);

        // ----------------FIN SECCION: Paso de variables -------------------------------------------------
        // ---------------- FIN SECCION: Controles del Formulario -------------------------------------------
        // ----------------FINALIZAR EL FORMULARIO ----------------------------------------------------------
        // Se debe declarar el mismo atributo de marco con que se inició el formulario.
        $atributos['marco'] = true;
        $atributos['tipoEtiqueta'] = 'fin';
        echo $this->miFormulario->formulario($atributos);

        return true;
    }

    public function mensaje() {
        if (isset($_REQUEST['mensaje'])) {

            $tab = 1;

            // ------------------Division para los botones-------------------------
            $atributos["id"] = "MensajeRespuesta";
            $atributos["estilo"] = " ";
            echo $this->miFormulario->division("inicio", $atributos);
            unset($atributos);
            {

                switch ($_REQUEST['mensaje']) {

                    case 'ErrorProcesamiento':

                        $atributos['tipo'] = 'error';
                        $atributos['mensaje'] = 'Datos No Validos o Error al Procesar la Información.<br>Verifique los Datos.';

                        break;

                    case 'ErrorActualizar':
                        $atributos['tipo'] = 'error';
                        $atributos['mensaje'] = 'Error al Actualizar los Datos.<br>Verifique los Datos.';

                        break;
                }

                $esteCampo = 'mensajeGeneral';
                $atributos['id'] = $esteCampo;
                $atributos['estilo'] = 'textoCentrar';

                $tab++;

                // Aplica atributos globales al control
                $atributos = array_merge($atributos);
                echo $this->miFormulario->cuadroMensaje($atributos);
                unset($atributos);
            }
            // ------------------Fin Division para los botones-------------------------
            echo $this->miFormulario->division("fin");
            unset($atributos);
        }
    }
}
$miSeleccionador = new consultarForm($this->lenguaje, $this->miFormulario, $this->sql);
$miSeleccionador->mensaje();
$miSeleccionador->miFormulario();
?>