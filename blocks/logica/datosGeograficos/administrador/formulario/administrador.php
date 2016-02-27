<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}


$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "host" );

$URL=$rutaBloque.":8080/geoserver";
echo "<br>";

?>





<center>
	<iframe src="<?php echo $URL;?>" width="98%" height="950"> </iframe>
</center>