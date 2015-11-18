<?php
$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "host" );
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/";
$rutaBloque .= $esteBloque ['grupo'] . "/" . $esteBloque ['nombre'];

$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$miSesion = Sesion::singleton ();

// **********Index Inicio**************//

$enlaceIndexAplicativo ['enlace'] = "pagina=indexAplicativo";
$enlaceIndexAplicativo ['enlace'] .= "&usuario=" . $_REQUEST ['usuario'];
$enlaceIndexAplicativo ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceIndexAplicativo ['enlace'], $directorio );

// **********Gestión Zona Estudio**************//

$enlaceZonaEstudio ['enlace'] = "pagina=zonaEstudio";
$enlaceZonaEstudio ['enlace'] .= "&usuario=" . $_REQUEST ['usuario'];
$enlaceZonaEstudio ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceZonaEstudio ['enlace'], $directorio );
$enlaceZonaEstudio ['nombre'] = "Descripción Zona Estudio";





// **********Administrador Datos Geograficos**************//

$enlaceAdministradorGeografico ['enlace'] = "pagina=administrador";
$enlaceAdministradorGeografico ['enlace'] .= "&usuario=" . $_REQUEST ['usuario'];
$enlaceAdministradorGeografico ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceAdministradorGeografico ['enlace'], $directorio );
$enlaceAdministradorGeografico ['nombre'] = "Administrador";




// **********Visualizador Datos Geograficos**************//

$enlaceVisualizadorGeografico ['enlace'] = "pagina=visualizador";
$enlaceVisualizadorGeografico ['enlace'] .= "&usuario=" . $_REQUEST ['usuario'];
$enlaceVisualizadorGeografico ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceVisualizadorGeografico ['enlace'], $directorio );
$enlaceVisualizadorGeografico ['nombre'] = "Visualizador";




// **********Visualizador Datos Geograficos**************//

$enlaceAplicativo ['enlace'] = "index.php";
$enlaceAplicativo ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlaceVisualizadorGeografico ['enlace'], $directorio );
$enlaceAplicativo ['nombre'] = "Cerrar Session";








?>
<div class="container">
	<nav>
		<ul class="mcd-menu">
			<li><a href="<?php echo $enlaceIndexAplicativo['urlCodificada'];  ?>">
					<i class="fa fa-home"><img
						SRC="<?php echo $rutaBloque ?>/css/images/home.png"></i> <strong>Inicio</strong>
					<small>Página Principal</small>
			</a></li>
			<li><a href="" class=""> <i class="fa fa-edit"><img
						SRC="<?php echo $rutaBloque ?>/css/images/risk.png"></i> <strong>Análisis
						Riegos</strong> <small>Gestión Riegos a la Navegación</small>
			</a>
				<ul>
					<li>
						<a href="<?php echo $enlaceZonaEstudio ['urlCodificada'];?>"><i class="fa fa-globe"><img SRC="<?php echo $rutaBloque ?>/css/images/paisaje.png"></i><?php echo $enlaceZonaEstudio ['nombre'];?></a>
					</li>
					<li>
						<a href="#"><i class="fa fa-group"><img SRC="<?php echo $rutaBloque ?>/css/images/analizar.png"></i>Analizar Variables</a>
					<li>
						<a href="#"><i class="fa fa-group"><img SRC="<?php echo $rutaBloque ?>/css/images/report.png"></i>Resultado o Informe</a>
					</li>
				</ul></li>
			<li><a href=""> <i class="fa fa-gift"><img
						SRC="<?php echo $rutaBloque ?>/css/images/world.png"></i> <strong>Datos Geográficos</strong>
					<small>Información Geográfica</small>
			</a>
			<ul>
					<li>
						<a href="<?php echo $enlaceAdministradorGeografico ['urlCodificada'];?>"><i class="fa fa-globe"><img SRC="<?php echo $rutaBloque ?>/css/images/administrador.png"></i><?php echo $enlaceAdministradorGeografico ['nombre'];?></a>
					</li>
					<li>
						<a href="<?php echo $enlaceVisualizadorGeografico ['urlCodificada'];?>"><i class="fa fa-globe"><img SRC="<?php echo $rutaBloque ?>/css/images/geoposition	.png"></i><?php echo $enlaceVisualizadorGeografico ['nombre'];?></a>
					</li>
				</ul>
			
			</li>
			<li><a href=""> <i class="fa fa-globe"><img
						SRC="<?php echo $rutaBloque ?>/css/images/users.png"></i> <strong>Usuarios</strong>
					<small>Gestión Usuarios</small>
			</a></li>
			<li><a href="<?php echo $enlaceAplicativo['enlace']; ?>"> <i class="fa fa-globe"><img
						SRC="<?php echo $rutaBloque ?>/css/images/salir.png"></i> <strong><?php echo  $enlaceAplicativo['nombre']; ?></strong>
					<small>Salir</small>
			</a></li>
			
			
			
			<!--<li><a href=""> <i class="fa fa-comments-o"></i> <strong>Blog</strong>
					<small>what they say</small>
			</a>
				<ul>
					<li><a href="#"><i class="fa fa-globe"><img
								SRC="<?php echo $rutaBloque ?>/css/images/world.png"></i>Mission</a></li>
					<li><a href="#"><i class="fa fa-group"><img
								SRC="<?php echo $rutaBloque ?>/css/images/world.png"></i>Our
							Team</a>
						<ul>
							<li><a href="#"><i class="fa fa-female"><img
										SRC="<?php echo $rutaBloque ?>/css/images/world.png"></i>Leyla
									Sparks</a></li>
							<li><a href="#"><i class="fa fa-male"></i>Gleb Ismailov</a>
								<ul>
									<li><a href="#"><i class="fa fa-leaf"></i>About</a></li>
									<li><a href="#"><i class="fa fa-tasks"></i>Skills</a></li>
								</ul></li>
							<li><a href="#"><i class="fa fa-female"></i>Viktoria Gibbers</a></li>
						</ul></li>
					<li><a href="#"><i class="fa fa-trophy"></i>Rewards</a></li>
					<li><a href="#"><i class="fa fa-certificate"></i>Certificates</a></li>
				</ul></li> --!>
			<!-- <li class="float">
				<a class="search">
					<input type="text" value="Buscar ...">
					<button><i class="fa fa-search"></i><img SRC="<?php echo $rutaBloque ?>/css/images/find.png"></button>
				</a>
				<a href="" class="search-mobile">
					<i class="fa fa-search"></i>
				</a>
			</li>-->
		</ul>
	</nav>
</div>
