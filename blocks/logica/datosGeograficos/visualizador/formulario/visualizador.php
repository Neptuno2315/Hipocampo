<?php
if (!isset($GLOBALS["autorizado"])) {
    include "../index.php";
    exit();
}

$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
$Host = $this->miConfigurador->getVariableConfiguracion("host");

$URL = $Host . ":8080/geoexplorer";

$Visualizador = "<br>
				<div class='fluidMedia'>
					<iframe id='visorIframe'  src='" . $URL . "'> </iframe>
				</div>";
echo $Visualizador;

$directorio = $this->miConfigurador->getVariableConfiguracion("host");
$directorio .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion("enlace");
$variablePerfil['enlace'] = "pagina=indexAplicativo";
$variablePerfil['enlace'] .= "&usuario=" . $_REQUEST['usuario'];
$variablePerfil['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variablePerfil['enlace'], $directorio);

$botonSalida = "<div id='Inicio'>
<input type='button' value='Salida Visualizador' class='ui-button ui-state-default ui-corner-all ui-widget ui-button-text-only' onClick=\"window.location.href='" . $variablePerfil['urlCodificada'] . "'\">
</div>";
echo $botonSalida;

?>


