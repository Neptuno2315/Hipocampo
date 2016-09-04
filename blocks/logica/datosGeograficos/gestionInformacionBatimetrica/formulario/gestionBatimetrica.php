<?php
if (!isset($GLOBALS["autorizado"])) {
    include "../index.php";
    exit();
}
class registrarForm {
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
    public function miForm() {

        /**
         * IMPORTANTE: Este formulario está utilizando jquery.
         * Por tanto en el archivo ready.php se delaran algunas funciones js
         * que lo complementan.
         */
        $conexion = "logica";

        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        $esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
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
        $atributos['titulo'] = $this->lenguaje->getCadena($esteCampo);

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

        // ------------------Division para los botones-------------------------
        $atributos["id"] = "DivRegistro";
        $atributos["estilo"] = " ";
        echo $this->miFormulario->division("inicio", $atributos);
        unset($atributos);
        {
            $esteCampo = "marcoDatosBasicos";
            $atributos['id'] = $esteCampo;
            $atributos["estilo"] = "jqueryui";
            $atributos['tipoEtiqueta'] = 'inicio';
            $atributos["leyenda"] = "Gestión Información Batimetríca";
            echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);
            unset($atributos);

            {
                $atributos["id"] = "divisionProjecto";
                $atributos["estilo"] = " ";
                $atributos["estiloEnLinea"] = "display:block";
                echo $this->miFormulario->division("inicio", $atributos);
                unset($atributos);

                {

                    $esteCampo = 'ficheros';
                    $atributos['id'] = $esteCampo;
                    $atributos['leyenda'] = "Información Zona Estudio";
                    echo $this->miFormulario->agrupacion('inicio', $atributos);
                    unset($atributos);
                    {
                        $esteCampo = 'nombre_projecto'; // Nombre o Titulo Proyecto
                        $atributos['id'] = $esteCampo;
                        $atributos['nombre'] = $esteCampo;
                        $atributos['tipo'] = 'text';
                        $atributos['estilo'] = 'textoElegante';
                        $atributos['columnas'] = 1;
                        $atributos['dobleLinea'] = false;
                        $atributos['tabIndex'] = $tab;

                        $atributos['texto'] = "&nbsp&nbsp" . $this->lenguaje->getCadena($esteCampo) . "<B>" . $_REQUEST['titulo_proyecto'] . "</B>";
                        $tab++;

                        // Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoTexto($atributos);
                        unset($atributos);

                        $esteCampo = 'nombre_region'; // Nombre o Titulo Proyecto
                        $atributos['id'] = $esteCampo;
                        $atributos['nombre'] = $esteCampo;
                        $atributos['tipo'] = 'text';
                        $atributos['estilo'] = 'textoElegante';
                        $atributos['columnas'] = 1;
                        $atributos['dobleLinea'] = false;
                        $atributos['tabIndex'] = $tab;
                        $atributos['texto'] = "&nbsp&nbsp" . $this->lenguaje->getCadena($esteCampo) . "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<B>" . $_REQUEST['region'] . "</B>";
                        $tab++;

                        // Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoTexto($atributos);
                        unset($atributos);

                        $esteCampo = 'nombre_sector'; // Nombre o Titulo Proyecto
                        $atributos['id'] = $esteCampo;
                        $atributos['nombre'] = $esteCampo;
                        $atributos['tipo'] = 'text';
                        $atributos['estilo'] = 'textoElegante';
                        $atributos['columnas'] = 1;
                        $atributos['dobleLinea'] = false;
                        $atributos['tabIndex'] = $tab;
                        $atributos['texto'] = "&nbsp&nbsp" . $this->lenguaje->getCadena($esteCampo) . "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<B>" . $_REQUEST['sector'] . "</B>";
                        $tab++;

                        // Aplica atributos globales al control
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoTexto($atributos);
                        unset($atributos);
                    }

                    echo $this->miFormulario->agrupacion('fin');
                    unset($atributos);
                }

                echo $this->miFormulario->division('fin');
                unset($atributos);

                $atributos["id"] = "divisionCarga";
                $atributos["estilo"] = " ";
                $atributos["estiloEnLinea"] = "display:block";
                echo $this->miFormulario->division("inicio", $atributos);
                unset($atributos);

                {

                    // -----------------CONTROL: Botón ----------------------------------------------------------------
                    $esteCampo = 'botonCargar';
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

                echo $this->miFormulario->division('fin');
                unset($atributos);

                $esteCampo = 'ficheros';
                $atributos['id'] = $esteCampo;
                $atributos['leyenda'] = "Ficheros Componentes del Shapefile";
                echo $this->miFormulario->agrupacion('inicio', $atributos);
                unset($atributos);
                {

                    $atributos["id"] = "ficheros_parte_1";
                    $atributos["estilo"] = " ";
                    $atributos["estiloEnLinea"] = "display:block";
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos);

                    {

                        $esteCampo = "fichero_dbf";
                        $atributos["id"] = $esteCampo; // No cambiar este nombre
                        $atributos["nombre"] = $esteCampo;
                        $atributos["tipo"] = "file";
                        $atributos["obligatorio"] = true;
                        $atributos["etiquetaObligatorio"] = true;
                        $atributos["tabIndex"] = $tab++;
                        $atributos["columnas"] = 2;
                        $atributos["estilo"] = "textoIzquierda";
                        $atributos["anchoEtiqueta"] = 190;
                        $atributos["tamanno"] = 500000;
                        $atributos["validar"] = "required";
                        $atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
                        // $atributos ["valor"] = $valorCodificado;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroTexto($atributos);
                        unset($atributos);

                        $esteCampo = "fichero_prj";
                        $atributos["id"] = $esteCampo; // No cambiar este nombre
                        $atributos["nombre"] = $esteCampo;
                        $atributos["tipo"] = "file";
                        $atributos["obligatorio"] = true;
                        $atributos["etiquetaObligatorio"] = true;
                        $atributos["tabIndex"] = $tab++;
                        $atributos["columnas"] = 2;
                        $atributos["estilo"] = "textoderecha";
                        $atributos["anchoEtiqueta"] = 190;
                        $atributos["tamanno"] = 500000;
                        $atributos["validar"] = "required";
                        $atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
                        // $atributos ["valor"] = $valorCodificado;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroTexto($atributos);
                        unset($atributos);
                    }

                    echo $this->miFormulario->division('fin');
                    unset($atributos);

                    $atributos["id"] = "ficheros_parte_2";
                    $atributos["estilo"] = " ";
                    $atributos["estiloEnLinea"] = "display:block";
                    echo $this->miFormulario->division("inicio", $atributos);
                    unset($atributos);

                    {

                        $esteCampo = "fichero_shx";
                        $atributos["id"] = $esteCampo; // No cambiar este nombre
                        $atributos["nombre"] = $esteCampo;
                        $atributos["tipo"] = "file";
                        $atributos["obligatorio"] = true;
                        $atributos["etiquetaObligatorio"] = true;
                        $atributos["tabIndex"] = $tab++;
                        $atributos["columnas"] = 2;
                        $atributos["estilo"] = "textoIzquierda";
                        $atributos["anchoEtiqueta"] = 190;
                        $atributos["tamanno"] = 500000;
                        $atributos["validar"] = "required";
                        $atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
                        // $atributos ["valor"] = $valorCodificado;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroTexto($atributos);
                        unset($atributos);

                        $esteCampo = "fichero_shp";
                        $atributos["id"] = $esteCampo; // No cambiar este nombre
                        $atributos["nombre"] = $esteCampo;
                        $atributos["tipo"] = "file";
                        $atributos["obligatorio"] = true;
                        $atributos["etiquetaObligatorio"] = true;
                        $atributos["tabIndex"] = $tab++;
                        $atributos["columnas"] = 2;
                        $atributos["estilo"] = "textoderecha";
                        $atributos["anchoEtiqueta"] = 190;
                        $atributos["tamanno"] = 500000;
                        $atributos["validar"] = "required";
                        $atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
                        // $atributos ["valor"] = $valorCodificado;
                        $atributos = array_merge($atributos, $atributosGlobales);
                        echo $this->miFormulario->campoCuadroTexto($atributos);
                        unset($atributos);
                    }
                    echo $this->miFormulario->division('fin');
                    unset($atributos);
                }

                echo $this->miFormulario->agrupacion('fin');
                unset($atributos);

                $esteCampo = 'ficheros';
                $atributos['id'] = $esteCampo;
                $atributos['leyenda'] = "Identificador del Sistema Espacial de Referencia";
                echo $this->miFormulario->agrupacion('inicio', $atributos);
                unset($atributos);
                {

                    // ---------------- CONTROL: Cuadro Lista ----------------------
                    $esteCampo = "srid";
                    $atributos['nombre'] = $esteCampo;
                    $atributos['id'] = $esteCampo;
                    $atributos['seleccion'] = 4326;
                    $atributos['evento'] = '';
                    $atributos['deshabilitado'] = false;
                    $atributos["etiquetaObligatorio"] = true;
                    $atributos['tab'] = $tab;
                    $atributos['tamanno'] = 1;
                    $atributos['columnas'] = 1;
                    $atributos['estilo'] = 'jqueryui';
                    $atributos['validar'] = 'required';
                    $atributos['limitar'] = false;
                    $atributos['anchoCaja'] = 60;
                    $atributos['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
                    $atributos['anchoEtiqueta'] = 50;

                    $atributos['cadena_sql'] = $this->miSql->getCadenaSql("consultar_srid");

                    $atributos['titulo'] = $this->lenguaje->getCadena($esteCampo . 'Titulo');
                    // $atributos ['matrizItems'] = $matrizItems;

                    // Utilizar lo siguiente cuando no se pase un arreglo:
                    $atributos['baseDatos'] = 'geografico';
                    // $atributos ['cadena_sql']='ponerLaCadenaSqlAEjecutar';
                    $tab++;
                    $atributos = array_merge($atributos, $atributosGlobales);
                    echo $this->miFormulario->campoCuadroLista($atributos);
                    unset($atributos);

                    $esteCampo = 'SRID_info';
                    $atributos['id'] = $esteCampo;
                    $atributos['leyenda'] = "Información SRID";
                    echo $this->miFormulario->agrupacion('inicio', $atributos);
                    unset($atributos);
                    {

                        $atributos["id"] = "informacion_srid";
                        $atributos["estilo"] = " ";
                        $atributos["estiloEnLinea"] = "display:block";
                        echo $this->miFormulario->division("inicio", $atributos);
                        unset($atributos);

                        {
                        }

                        echo $this->miFormulario->division('fin');
                        unset($atributos);

                        $atributos["id"] = "informacion_proj4text";
                        $atributos["estilo"] = " ";
                        $atributos["estiloEnLinea"] = "display:block";
                        echo $this->miFormulario->division("inicio", $atributos);
                        unset($atributos);

                        {
                        }

                        echo $this->miFormulario->division('fin');
                        unset($atributos);
                    }
                    echo $this->miFormulario->agrupacion('fin');
                    unset($atributos);
                }

                echo $this->miFormulario->agrupacion('fin');
                unset($atributos);
            }

            echo $this->miFormulario->marcoAgrupacion('fin');
            unset($atributos);

            // -----------------FIN CONTROL: Botón -----------------------------------------------------------
        }
        // ------------------Fin Division para los botones-------------------------
        echo $this->miFormulario->division("fin");
        unset($atributos);

        // ------------------Fin Division para los botones-------------------------
        echo $this->miFormulario->division("fin");
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

        $valorCodificado = "action=" . $esteBloque["nombre"];
        $valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina');
        $valorCodificado .= "&bloque=" . $esteBloque['nombre'];
        $valorCodificado .= "&bloqueGrupo=" . $esteBloque["grupo"];
        $valorCodificado .= "&usuario=" . $_REQUEST["usuario"];
        $valorCodificado .= "&opcion=CargarInformacionBatimetríca";
        $valorCodificado .= "&usuario=" . $_REQUEST['usuario'];
        $valorCodificado .= "&id_zona=" . $_REQUEST['id_zona'];
        $valorCodificado .= "&titulo_proyecto=" . $_REQUEST['titulo_proyecto'];
        $valorCodificado .= "&region=" . $_REQUEST['region'];
        $valorCodificado .= "&sector=" . $_REQUEST['sector'];
        /*
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

                    case 'RegistroExito':
                        $atributos['tipo'] = 'success';
                        $atributos['mensaje'] = 'Se Registro con Exito.<br>Recomendación a la Navegación.';
                        break;

                    case 'RegistroError':
                        $atributos['tipo'] = 'error';
                        $atributos['mensaje'] = 'Error en el Registro.<br>Recomendación a la Navegación.<br>Verifique los Datos.';
                        break;

                    case 'ActualizoExito':
                        $atributos['tipo'] = 'success';
                        $atributos['mensaje'] = 'Se Actualizado la Recomendación a la Navegación con Exito.';
                        break;

                    case 'ActualizacionError':
                        $atributos['tipo'] = 'error';
                        $atributos['mensaje'] = 'Error en la Actualización de la Recomendación  a la Navegación.<br>Verifique los Datos.';
                        break;

                    case 'EliminoExito':
                        $atributos['tipo'] = 'success';
                        $atributos['mensaje'] = 'Se Elimino con Exito Recomendación a la Navegación de la Zona de Estudio<br>Nombre Proyecto : <br>' . $_REQUEST['titulo_proyecto'] . ".";
                        break;

                    case 'ErrorCargarDirectorioProcesar':

                        $atributos['tipo'] = 'error';
                        $atributos['mensaje'] = 'Error al Intentar Cargar Fichero al Directorio de Procesamiento.<br>Verifique los Datos.';

                        break;

                    case 'ErrorExtensionArchivos':

                        $atributos['tipo'] = 'error';
                        $atributos['mensaje'] = 'Error en la Extensión de los Ficheros.<br>Verifique los Datos.';

                        break;

                    case 'ErrorProcesamiento':

                        $atributos['tipo'] = 'error';
                        $atributos['mensaje'] = 'Datos No Validos o Error al Procesar la Información.<br>Verifique los Datos.';

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
$miSeleccionador = new registrarForm($this->lenguaje, $this->miFormulario, $this->sql);
$miSeleccionador->mensaje();
$miSeleccionador->miForm();
?>