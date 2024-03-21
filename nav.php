<?php $pagina = basename($_SERVER['SCRIPT_FILENAME']); ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

	<span class="navbar-brand mb-0 h1">Boston Abregú Realty</span>

	<div class="collapse navbar-collapse">

		<ul class="navbar-nav mr-auto">

			<li class="nav-item">

				<a class="nav-link <?= $pagina == 'ficha.php' ? 'active':''?>" href="ficha.php">Fichas </a>

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