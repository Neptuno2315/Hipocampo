<?php
if (!isset($GLOBALS["autorizado"])) {
    include "../index.php";
    exit();
}

$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
/*
//$URL = $rutaBloque . ":8080/geoserver/web";

$URL = 'http://admin:geoserver@172.16.146.128:8080/geoserver';
echo $URL;
echo "<br>";

$url = "http://172.16.146.128:8080/geoserver/j_spring_security_check";

$parametros_post = "username=admin&password=geoserver";

$sesion = curl_init($url);
// definir tipo de petición a realizar: POST
curl_setopt($sesion, CURLOPT_POST, true);
// Le pasamos los parámetros definidos anteriormente
curl_setopt($sesion, CURLOPT_POSTFIELDS, $parametros_post);
// sólo queremos que nos devuelva la respuesta
curl_setopt($sesion, CURLOPT_HEADER, true);
curl_setopt($sesion, CURLOPT_RETURNTRANSFER, true);
// ejecutamos la petición
$respuesta = curl_exec($sesion);
// cerramos conexión
curl_close($sesion);
var_dump($respuesta);
var_dump($sesion);*/
?>

<form action="?username=admin&password=geoserver" method="post" target="my_iframe">

</form>

<form id="moodleform" target="my_iframe" method="post" action="http://172.16.146.128:8080/geoserver/j_spring_security_check">

    <input type="hidden" name="username" value="admin"/>
    <input type="hidden" name="password" value="geoserver"/>
    <input type="hidden" name="testcookies" value="1"/>
</form>


<center>
	<iframe name="my_iframe" width="98%" height="950"> </iframe>
</center>

<script type="text/javascript">
    document.getElementById('moodleform').submit();
</script>