<?php $pagina = basename($_SERVER['SCRIPT_FILENAME']); ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark " style="background-color: #201e1c!important;">

	<span class="navbar-brand mb-0 h1">Boston Abregú Realty</span>

	<div class="collapse navbar-collapse">

		<ul class="navbar-nav mr-auto">

			<li class="nav-item">

				<a class="nav-link <?= $pagina == 'ficha.php' ? 'active':''?>" href="ficha.php">Fichas </a>

			</li>
			<li class="nav-item">
				<a class="nav-link <?= $pagina == 'documentos.php' ? 'active':''?>" href="documentos.php">Documentos</a>
			</li>
			<li class="nav-item">
				<a class="nav-link <?= $pagina == 'carta-presentacion.php' ? 'active':''?>" href="carta-presentacion.php">Carta de presentación</a>
			</li>

			<?php if($_COOKIE['ckPower']=="1"): ?>

			<li class="nav-item">
				<a class="nav-link <?= $pagina == 'subida.php' ? 'active':''?>" href="subida.php">Nueva ficha</a>
			</li>
			

			<li class="nav-item">
				<a class="nav-link <?= $pagina == 'asesor.php' ? 'active':''?>" href="asesor.php">Control de asesores</a>
			</li>

			 <?php endif;?>

			 <li class="nav-item">

				<a class="nav-link" href="desconectar.php">Desconectar</a>

			</li>

		</ul>

	</div>

</nav>

<?php if($pagina<>'ficha.php'): ?>
<div class="row ">
	<div class="col text-center">
		<img src="images/logo.png" class=" img-fluid mx-auto mt-2">
		<p><strong>Bienes Raices</strong></p>
	</div>
</div>
<?php endif; ?>