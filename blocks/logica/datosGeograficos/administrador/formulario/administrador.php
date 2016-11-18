<?php
if (!isset($GLOBALS["autorizado"])) {
    include "../index.php";
    exit();
}

$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");

if ($_SERVER['HTTPS'] == 'on') {

    $URL = $rutaBloque . ":8443";

} else {

    $URL = $rutaBloque . ":8080";

}

?>

<form action="?username=admin&password=geoserver" method="post" target="my_iframe">

</form>

<form id="moodleform" target="my_iframe" method="post" action="<?php echo $URL;?>/geoserver/j_spring_security_check">

    <input type="hidden" name="username" value="admin"/>
    <input type="hidden" name="password" value="geoserver"/>

</form>


<center>
	<iframe name="my_iframe" width="98%" height="950"> </iframe>
</center>

<script type="text/javascript">
    document.getElementById('moodleform').submit();
</script>