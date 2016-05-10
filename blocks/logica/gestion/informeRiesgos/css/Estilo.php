<?php
$indice = 0;
$estilo [$indice ++] = "validationEngine.jquery.css";

$estilo [$indice ++] = "jquery.auto-complete.css";

$estilo [$indice ++] = "select2.css";

$estilo [$indice ++] = "estiloBloque.css";

$estilo [$indice ++] = "nv.d3.css";

$estilo [$indice ++] = "nv.d3.min.css";

$estilo [$indice ++] = "jquery.dataTables_themeroller.css";

$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "host" );
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion ( "site" );

if ($unBloque ["grupo"] == "") {
	$rutaBloque .= "/blocks/" . $unBloque ["nombre"];
} else {
	$rutaBloque .= "/blocks/" . $unBloque ["grupo"] . "/" . $unBloque ["nombre"];
}

foreach ( $estilo as $nombre ) {
	echo "<link rel='stylesheet' type='text/css' href='" . $rutaBloque . "/css/" . $nombre . "'>\n";
}
?>
