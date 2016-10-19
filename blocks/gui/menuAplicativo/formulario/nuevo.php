<?php

$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque .= $esteBloque['grupo'] . "/" . $esteBloque['nombre'];

$directorio = $this->miConfigurador->getVariableConfiguracion("host");
$directorio .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion("enlace");
$miSesion = Sesion::singleton();

// Conexion de Base de Datos
$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

$cadenaSql = $this->sql->getCadenaSql('consultar_acceso_paginas');
$paginas = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

$cadenaSql = $this->sql->getCadenaSql('consultar_Menu_General');
$MenuGeneral = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

// **********Index Inicio**************//

$enlaceIndexAplicativo['enlace'] = "pagina=indexAplicativo";
$enlaceIndexAplicativo['enlace'] .= "&usuario=" . $_REQUEST['usuario'];
$enlaceIndexAplicativo['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceIndexAplicativo['enlace'], $directorio);

//**********************Cerrar Sesión Aplicativo**************//
$enlaceAplicativo['enlace'] = "pagina=index";
$enlaceAplicativo['enlace'] = "&variable=Finalizar";
$enlaceAplicativo['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceAplicativo['enlace'], $directorio);
$enlaceAplicativo['nombre'] = "Cerrar Sesion";

//**********************Mi Cuenta*************************//
$variablePerfil['enlace'] = "pagina=gestionUsuarios";
$variablePerfil['enlace'] .= "&opcion=cuentaUsuario";
$variablePerfil['enlace'] .= "&usuario=" . $_REQUEST['usuario'];
$variablePerfil['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variablePerfil['enlace'], $directorio);
$variablePerfil['nombre'] = "Mi Cuenta";

if ($MenuGeneral) {
    foreach ($MenuGeneral as $key => $value) {

        foreach ($paginas as $llave => $valor) {

            if ($valor['nombre_menu_general'] == $value['nombre_menu_general']) {

                $variable['enlace'] = "pagina=" . trim($valor['nombre_url_pagina']);
                $variable['enlace'] .= "&usuario=" . $_REQUEST['usuario'];
                $variable['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable['enlace'], $directorio);
                $variable['nombre'] = $valor['nombre_menu'];

                $paginas[$llave]['url'] = $variable;

            }

        }

    }
}

$contenido = '<div class="container">
	<nav>
		<ul class="mcd-menu">
			<li>
				<a href="' . $enlaceIndexAplicativo['urlCodificada'] . '">
					<i class="fa fa-home"><img SRC="' . $rutaBloque . '/css/images/home.png">
					</i><strong>Inicio</strong>
					<small>Página Principal</small>
				</a>
			</li>';

$menu = '';
if ($MenuGeneral) {
    foreach ($MenuGeneral as $key => $value) {

        $menu .= '<li>
			<a>
				<i class="fa fa-edit"><img SRC="' . $rutaBloque . $value['imagen_general'] . '">
				</i>
		    	<strong>' . $value['nombre_menu_general'] . '</strong>
		    	<small>' . $value['nombre_subtitulo_menu_general'] . '</small>
		    </a>
			<ul>';

        foreach ($paginas as $llave => $valor) {

            if ($valor['nombre_menu_general'] == $value['nombre_menu_general']) {

                $menu .= '<li>
						<a href="' . $valor['url']['urlCodificada'] . '">
							<i class="fa fa-globe">
							<img SRC="' . $rutaBloque . $valor['imagen_menu'] . '">
							</i>' . $valor['url']['nombre'] . '
						</a>
				 </li>';
            }

        }

        $menu .= '</ul>
			</li>';

    }

}
$contenido .= $menu;

$contenido .= '<li>
				<a href="' . $variablePerfil['urlCodificada'] . '">
					<i class="fa fa-globe"><img SRC="' . $rutaBloque . '/css/images/usuario.png"></i>
					<strong>' . $variablePerfil['nombre'] . '</strong>
					<small>Perfil</small>
				</a>
			</li>
			<li>
				<a href="' . $enlaceAplicativo['urlCodificada'] . '">
					<i class="fa fa-globe"><img SRC="' . $rutaBloque . '/css/images/salir.png"></i>
					<strong>' . $enlaceAplicativo['nombre'] . '</strong>
					<small>Salir</small>
				</a>
			</li>
	</ul>
	</nav>
</div>
';

echo $contenido;

?>
