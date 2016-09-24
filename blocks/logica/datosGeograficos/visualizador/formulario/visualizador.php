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

$botonSalida = "<div id='Inicio'>
<input type='button' value='Salida Visualizador' class='ui-button ui-state-default ui-corner-all ui-widget ui-button-text-only' onClick=\"window.location.href='http://172.16.146.128/Hipocampo/index.php?data=prpPsvSB0yFdazuuesPxaPvDACYu-6vcUXM3iE7jaxBNUqt-LCEwDyOxL8TCNdPkR_LD2CaXijo8o8-Sr70JfqH0vdWLwQROQpC6gSaC9oq4P9trwn1yWEwgn-LchvU4p4EWqGQzio1CTb-zdyFi3DuksTrXgrMkYfRxZ4nbQQMrD4Y1yl0-iafakhB7K240qoOWjdt_0K1BH1YiUj4gxryjLJh72gH9cuR4OWDDyWjx7DY34jGpJoWkL8gswq4rWHefliUstQGYN-DBEWbZUsW-_T-UA6hvgCbR_hkcRUrQEDmrJS4PcAVnYfs-32ErSTHaHVdU37YtIaKtTh0pxSWAGp4yJxaufVbFB8JpmcE-5GxePojN3vUpRvRrHmxJ0CU6ltCej6zKOmazdZlkMSo535ONlA8UlSme62CBVcGK95J0K3tAj5AcHfdfu7Nfff6zyMHEfqNRC3rOP5dpV2tXKcgabfkO-UMNhC93TwoU_129qRHg1ZrU4ECc8gl46jPfJu_vFWgqVAxHhCSkmkAVXvtWffbw_jkqItGXS7zac3ZOxftK5JszEtStJsc885WOi9aXeofvd80BsMAT8ZznTjrZpS_3pt7HVV_MAw-EOyYFqOmKlkIkuZCl4uqJgaCS0ja_MD1OoygE4D_QavtTNhzNM0upfGmCkhr_8-hUvqkEZrt_yUCvTPHxsNb20gAmolNUDAxShMOfYEQJWalk8ysRbeeZayECwhDd8isOgDifPewJC-PYF96UJjiK2xuE6wMobSuGRe2J9wkC8v5cHZaY6pJhGHtzKFB0Q1DgWRi3YNJxOPbFL9j1NnbKlz9YGWiBbtR_FGGQyE9nQEORa_Yyk7U0JpRuex0Da-n_ObX4CLaJRRwWMF4DT1D3R19ZXfDtvwQbg3ytLIYH5RaQWtDDEU4YomhthoQAk9jCbamyQx6e1Sr7ee68W7zPA7-p1xe6h-06OCPRGHy3PgluMFfOXyrf0D7KBsDY2g4vAEEvM9D7q5CNpsDwRdJIoY9Zti2tDNZZGH5o1k0KCgTVEDn_3X_8dGvQiEEGtCo'\">
</div>";
echo $botonSalida;

?>


