<?php
$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "host" );
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/";
$rutaBloque .= $esteBloque ['grupo'] . "/" . $esteBloque ['nombre'];

$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$miSesion = Sesion::singleton ();

?>
<div class="container">
<nav>
		<ul class="mcd-menu">
			<li>
				<a href="">
					<i class="fa fa-home"><img SRC="<?php echo $rutaBloque ?>/css/images/home.png"></i>
					<strong>Inicio</strong>
					<small>Página Principal</small>
				</a>
			</li>
			<li>
				<a href="" class="">
					<i class="fa fa-edit"><img SRC="<?php echo $rutaBloque ?>/css/images/risk.png"></i>
					<strong>Riegos</strong>
					<small>Gestíon Riegos a la Navegación</small>
				</a>
			</li>
			<li>
				<a href="">
					<i class="fa fa-gift"><img SRC="<?php echo $rutaBloque ?>/css/images/world.png"></i>
					<strong>Datos</strong>
					<small>Información Geográfica</small>
				</a>
			</li>
			<li>
				<a href="">
					<i class="fa fa-globe"><img SRC="<?php echo $rutaBloque ?>/css/images/users.png"></i>
					<strong>Usuarios</strong>
					<small>Gestión Usuarios</small>
				</a>
			</li>
			<li>
				<a href="">
					<i class="fa fa-comments-o"></i>
					<strong>Blog</strong>
					<small>what they say</small>
				</a>
				<ul>
					<li><a href="#"><i class="fa fa-globe"><img SRC="<?php echo $rutaBloque ?>/css/images/world.png"></i>Mission</a></li>
					<li>
						<a href="#"><i class="fa fa-group"><img SRC="<?php echo $rutaBloque ?>/css/images/world.png"></i>Our Team</a>
						<ul>
							<li><a href="#"><i class="fa fa-female"><img SRC="<?php echo $rutaBloque ?>/css/images/world.png"></i>Leyla Sparks</a></li>
							<li>
								<a href="#"><i class="fa fa-male"></i>Gleb Ismailov</a>
								<ul>
									<li><a href="#"><i class="fa fa-leaf"></i>About</a></li>
									<li><a href="#"><i class="fa fa-tasks"></i>Skills</a></li>
								</ul>
							</li>
							<li><a href="#"><i class="fa fa-female"></i>Viktoria Gibbers</a></li>
						</ul>
					</li>
					<li><a href="#"><i class="fa fa-trophy"></i>Rewards</a></li>
					<li><a href="#"><i class="fa fa-certificate"></i>Certificates</a></li>
				</ul>
			</li>
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