<?php
require __DIR__ . '/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// ---------------------------------------------------------------------
// 1) DECODIFICAR CURSOR DESDE PARÁMETRO p
// ---------------------------------------------------------------------
$cursor = 0;
if (isset($_GET['p'])) {
	$invertido = base64_decode($_GET['p']);
	$json = strrev($invertido);
	$data = json_decode($json, true);
	if (isset($data['cursor'])) {
		$cursor = (int)$data['cursor'];
	}
	$idAsesor = (isset($data['asesor'])) ? (int)$data['asesor'] : 0;
}

$colorPrincipal = '#c0392b';

// Si no hay cursor válido, mostrar datos de ejemplo
if (!$cursor) {
	echo 'Parámetro inválido';
	exit;
}

// ---------------------------------------------------------------------
// 2) CONSULTAR DATOS DESDE LA BD
// ---------------------------------------------------------------------
include __DIR__ . '/conexion.php';

$sql = "SELECT `idFicha`, `fichTitulo`, `fichPrecio`, `moneda`, `fichDireccion`, `fichTipoPropiedad`,
  `fichAreaTerreno`, `fichAreaConstruccion`, `fichFrontis`, `fichDormitorios`,
  `fichBanios`, `medios_banios`, `fichCochera`, `fichDescipcion`, `antiguedad`,
  `beneficios`, `fotos`, `resumen`, `tipo_operacion`,
  `superficie_descubierta`, `superficie_semicubierta`, `superficie_cubierta`
  FROM `fichas` WHERE idFicha = {$cursor}";
/** @var mysqli $cadena */
$resultado = $cadena->query($sql);
if ($resultado->num_rows !== 1) {
	echo 'Ficha no encontrada';
	exit;
}
$row = $resultado->fetch_assoc();

$codigo       = 'BR-' . str_pad($cursor, 4, 0, STR_PAD_LEFT);
$tipo         = ucfirst($row['fichTipoPropiedad'] ?? 'Terreno');
$titulo       = ucfirst($row['fichTitulo'] ?? '');
$ubicacion    = 'Junín | Huancayo | Huancayo';
$precioRaw      = $row['fichPrecio'];
$precioFormateado = is_numeric($precioRaw) ? number_format($precioRaw, 0, ',', '.') : $precioRaw;
$precio       = ($row['moneda'] == 'dólares' ? '$' : 'S/') . ' ' . $precioFormateado;

$banos        = $row['fichBanios'] ?? 0;
$medioBanos   = $row['medios_banios'] ?? 0;
$antiguedad   = $row['antiguedad'] ?? '-';
$dormitorios  = $row['fichDormitorios'] ?? 0;
$cocheras     = $row['fichCochera'] ?? 0;

$totalConstruido    = ($row['fichAreaConstruccion'] ?? '-');
$superficieDescub    = $row['superficie_descubierta'] ?? '-';
$superficieSemicub   = $row['superficie_semicubierta'] ?? '-';
$superficieCubierta  = $row['superficie_cubierta'] ?? '-';
$terreno             = ($row['fichAreaTerreno'] ?? '-');

$descripcion = $row['fichDescipcion'] ? [$row['fichDescipcion']] : [];

$datosRapidos = [
	'Área Terreno: ' . ($row['fichAreaTerreno'] ?? ''),
	'Área Construcción: ' . ($row['fichAreaConstruccion'] ?? ''),
	'Precio: ' . $precio,
];

$caracteristicas = [];

$beneficios = ucfirst($row['beneficios'] ?? '');

$notaImportante = "Toda la información y medidas provistas son aproximadas y deberán ratificarse con la "
	. "documentación\n pertinente y no compromete contractualmente a nuestra empresa.";

$notaCondiciones = '* Sujeto a disponibilidad y condiciones crediticias';

// Imágenes desde el campo fotos (JSON)
$fotosGuardadas = json_decode($row['fotos'], true);
if (!is_array($fotosGuardadas)) $fotosGuardadas = array();

$host = $_SERVER['HTTP_HOST'] ?? '';
$baseImg = (strpos($host, 'localhost') !== false || $host === '127.0.0.1')
	? "http://localhost/bostonabregu/images/inmuebles/"
	: "https://intranet.bostonabregurealty.com/images/inmuebles/";
$fotosPrincipales = array();
$fotosGrid        = array();
foreach ($fotosGuardadas as $i => $foto) {
	if ($i < 2) {
		$fotosPrincipales[] = $baseImg . $foto;
	} else {
		$fotosGrid[] = $baseImg . $foto;
	}
}
$mapaImg = ''; // Placeholder

// Agente
include __DIR__ . '/conexion.php';
$agenteNombre   = '';
$agenteTelefono = '';
$agenteEmail    = 'contacto@bostonabregurealty.com';
$agenteFotoUrl  = '';

if (!empty($idAsesor)) {
	$sqlAg = "SELECT `aseNombre`, `aseCelular`, `aseCorreo` FROM `asesor` WHERE `idAsesor` = {$idAsesor}";
	$resAg = $cadena->query($sqlAg);
	if ($resAg && $rowAg = $resAg->fetch_assoc()) {
		$agenteNombre   = ucfirst($rowAg['aseNombre']);
		$agenteTelefono = $rowAg['aseCelular'];
		$agenteEmail    = $rowAg['aseCorreo'];
		// Foto del asesor
		$baseEmpleado  = 'https://intranet.bostonabregurealty.com/images/empleado/';
		$agenteFotoUrl = $baseEmpleado . $idAsesor . '_foto1.jpg';
	}
}

$firmaUrl = 'https://intranet.bostonabregurealty.com/images/firma.jpg?v=1';
$logoUrl  = 'https://intranet.bostonabregurealty.com/images/logo_amarillo.jpg';

$footerCertificacion = 'Boston Abregu Realty certificada por el Ministerio de Vivienda, Construcción y Saneamiento del Perú';
$footerSlogan         = '"Somos la inmobiliaria de los Huancaínos"';

// ---------------------------------------------------------------------
// 2) HTML DEL DOCUMENTO
// ---------------------------------------------------------------------
ob_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<style>
		@page {
			margin: 16px 16px;
		}

		* {
			box-sizing: border-box;
		}

		body {
			font-family: Arial, sans-serif;
			font-size: 10px;
			color: #222;
		}

		table.layout {
			width: 100%;
			border-collapse: collapse;
		}

		table.layout>tr>td {
			vertical-align: top;
		}

		td.col-left {
			width: 48%;
			height: 90%;
			padding-right: 14px;

			vertical-align: top;
		}

		td.col-right {
			width: 52%;
			padding-left: 14px;
			border-left: 1px solid #ddd;
			vertical-align: top;
		}

		/* ---------- Encabezado columna izquierda ---------- */
		.codigo {
			color: #888;
			font-size: 10px;
			margin-bottom: 2px;
		}

		h1.titulo {
			font-size: 18px;
			color: #1b2a4a;
			margin: 2px 0 4px 0;
			line-height: 1.25;
		}

		.ubicacion {
			color: #555;
			font-size: 9px;
			margin-bottom: 10px;
		}

		h2.seccion {
			color: <?= $colorPrincipal ?>;
			font-size: 11px;
			text-transform: uppercase;
			border-bottom: 1px solid #e0e0e0;
			padding-bottom: 3px;
			margin: 10px 0 6px 0;
		}

		table.datos {
			width: 100%;
			margin-bottom: 4px;
		}

		table.datos td {
			padding: 2px 4px 2px 0;
			font-size: 11px;
			vertical-align: top;
			width: 33%;
		}

		table.datos td b {
			color: #000;
		}

		p.parrafo {
			margin: 3px 0;
			line-height: 1.35;
		}

		.lista,
		.lista ol,
		.lista ul {
			margin: 4px 0 4px 7px;
			padding: 0;
			list-style: none;
		}

		.lista-caracteristicas ol,
		ul {
			margin: 4px 0 4px 7px;
			padding: 0;
			list-style: none;
		}

		.lista li::before,
		.lista-caracteristicas li::before {
			content: "- ";
			/* font-weight: bold; */
		}

		.lista li,
		.lista-caracteristicas li {
			margin-bottom: 2px;
			line-height: 1.3;
		}

		.nota {
			position: fixed;
			bottom: 30px;
			left: 30px;
			font-size: 9px;
			color: #4a4a4a;
			margin-top: 10px;
			line-height: 1.3;
		}

		.nota-condiciones {
			position: fixed;
			bottom: 15px;
			left: 30px;
			font-size: 9px;
			color: #4a4a4a;
			margin-top: 6px;
		}

		/* ---------- Columna derecha ---------- */
		.venta-precio-wrap {
			width: 100%;
			text-align: left;
			margin-bottom: 6px;
		}

		table.venta-precio {
			margin: 0;
			border-collapse: collapse;
			border: 1px solid #c2c2c2;
		}

		table.venta-precio td {
			padding: 6px 16px;
			vertical-align: middle;
		}

		.badge-venta {
			background: <?= $colorPrincipal ?>;
			color: #fff;
			font-weight: bold;
			font-size: 11px;
			text-align: center;
		}

		.precio {
			font-size: 14px;
			font-weight: bold;
			color: #1b2a4a;
			text-align: center;
			background: #fff;
		}

		.foto-principal {
			width: 100%;
			border-collapse: collapse;
			margin-bottom: 5px;
		}

		.foto-principal td {
			width: 50%;
			padding: 2px;
		}

		.foto-principal img {
			width: 100%;
			height: 190px;
			object-fit: cover;
			border: 1px solid #ddd;
		}

		table.grid-fotos {
			width: 100%;
			border-collapse: collapse;
			margin-bottom: 6px;
		}

		table.grid-fotos td {
			width: 33.33%;
			padding: 2px;
		}

		table.grid-fotos img {
			width: 100%;
			height: 95px;
			object-fit: cover;
			border: 1px solid #ddd;
		}

		.asesor-tabla {
			width: 100%;
			border-collapse: collapse;
			margin-top: 4px;
			font-size: 8.5px;
		}

		.asesor-tabla td {
			vertical-align: top;
			padding: 4px 6px;
		}

		.asesor-tabla td.col-izq {
			width: 34%;
			border-right: 1px solid #ddd;
		}

		.asesor-tabla td.col-der {
			width: 66%;
			text-align: center;
		}

		.asesor-label {
			background: <?= $colorPrincipal ?>;
			color: #fff;
			font-size: 7.5px;
			font-weight: bold;
			padding: 2px 6px;
			display: inline-block;
			margin-bottom: 4px;
		}

		.asesor-foto-circulo {
			display: table;
			width: 70px;
			height: 70px;
			border-radius: 50% !important;
			overflow: hidden;
			margin: 0 auto 4px auto;
		}

		.asesor-foto-celda {
			display: table-cell;
			vertical-align: middle;
			text-align: center;
		}

		.asesor-foto {
			width: 100px;
			height: auto;
			display: inline-block;
			border: none !important;
			box-shadow: none !important;
		}

		.asesor-dato {
			font-size: 8px;
			line-height: 1.4;
			margin: 1px 0;
		}

		.asesor-dato b {
			font-size: 8.5px;
		}

		.firma-url {
			max-width: 100%;
			margin-top: 4px;
		}

		.footer-tabla {
			width: 100%;
			border-collapse: collapse;
			margin-top: 10px;
			position: fixed;
			bottom: 70px;
			right: 15px;
		}

		.footer-tabla td {
			vertical-align: middle;
		}

		.footer-texto {
			font-size: 9px;
			color: #666;
			text-align: right;
			line-height: 1.3;
			padding-right: 8px;
			border-right: 1px solid #999;
		}

		.footer-logo {
			width: 34px;
			text-align: center;
			padding-left: 8px;
		}

		.footer-logo img {
			width: 35px;
			height: 35px;
			object-fit: contain;
		}
	</style>
</head>

<body>
	<table class="layout">
		<tr>
			<!-- ===================== COLUMNA IZQUIERDA ===================== -->
			<td class="col-left">
				<div class="codigo"><?= htmlspecialchars($codigo) ?> | <?= htmlspecialchars($tipo) ?></div>
				<h1 class="titulo"><?= htmlspecialchars($titulo) ?></h1>
				<div class="ubicacion"><?= htmlspecialchars($ubicacion) ?></div>

				<h2 class="seccion">Información General</h2>
				<table class="datos">
					<tr>
						<td>Baños: <b><?= $banos ?></b></td>
						<td>Medio Baños: <b><?= $medioBanos ?></b></td>
						<td>Antigüedad: <b><?= htmlspecialchars($antiguedad) ?></b></td>
					</tr>
					<tr>
						<td>Dormitorios: <b><?= $dormitorios ?></b></td>
						<td>Cocheras: <b><?= $cocheras ?></b></td>
						<td></td>
					</tr>
				</table>

				<h2 class="seccion">Superficies y Medidas</h2>
				<table class="datos">
					<tr>
						<td>Total construido: <b><?= str_replace('m2', 'm²', htmlspecialchars($totalConstruido)) ?></b></td>
						<td>Sup. descubierta: <b><?= str_replace('m2', 'm²', htmlspecialchars($superficieDescub)) ?></b></td>
						<td>Sup. semicubierta: <b><?= str_replace('m2', 'm²', htmlspecialchars($superficieSemicub)) ?></b></td>
					</tr>
					<tr>
						<td>Superficie cubierta: <b><?= str_replace('m2', 'm²', htmlspecialchars($superficieCubierta)) ?></b></td>
						<td>Terreno: <b><?= str_replace('m2', 'm²', htmlspecialchars($terreno)) ?></b></td>
						<td></td>
					</tr>
				</table>

				<h2 class="seccion">Descripción</h2>

				<?php if (!empty($row['resumen'])): ?>
					<p class="parrafo"><b><?= nl2br(htmlspecialchars($row['resumen'])) ?></b></p>
				<?php endif; ?>

				<ul class="lista">
					<?php foreach ($datosRapidos as $dato): ?>
						<li><?= str_replace('m2', 'm²', htmlspecialchars($dato)) ?></li>
					<?php endforeach; ?>
				</ul>

				<p class="parrafo"><b>Características:</b></p>
				<div class="lista-caracteristicas">
					<?php foreach ($descripcion as $parrafo): ?>
						<?= $parrafo ?>
					<?php endforeach; ?>
				</div>

				<div class="beneficios">
					<b>Beneficios:</b><br><b><?= htmlspecialchars($beneficios) ?></b>
				</div>

				<div class="nota">
					<b>Nota importante:</b> <?= nl2br(htmlspecialchars($notaImportante)) ?>
				</div>
				<div class="nota-condiciones"><?= htmlspecialchars($notaCondiciones) ?></div>
			</td>

			<!-- ===================== COLUMNA DERECHA ===================== -->
			<td class="col-right">
				<div class="venta-precio-wrap">
					<table class="venta-precio">
						<tr>
							<td class="badge-venta"><?= strtoupper(htmlspecialchars($row['tipo_operacion'] ?? 'VENTA')) ?></td>
							<td class="precio"><?= htmlspecialchars($precio) ?></td>
						</tr>
					</table>
				</div>

				<table class="foto-principal">
					<tr>
						<?php for ($i = 0; $i < 2; $i++): ?>
							<td>
								<?php if (isset($fotosPrincipales[$i])): ?>
									<img src="<?= htmlspecialchars($fotosPrincipales[$i]) ?>" alt="Foto principal">
								<?php endif; ?>
							</td>
						<?php endfor; ?>
					</tr>
				</table>

				<table class="grid-fotos">
					<?php if (count($fotosGrid) > 0): ?>
						<?php foreach (array_chunk($fotosGrid, 3) as $chunk): ?>
							<tr>
								<?php foreach ($chunk as $foto): ?>
									<td><img src="<?= htmlspecialchars($foto) ?>" alt="Foto"></td>
								<?php endforeach; ?>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</table>

				<table class="asesor-tabla">
					<tr>
						<td class="col-izq">
							<span class="asesor-label">ASESOR INMOBILIARIO</span>
							<?php if ($agenteFotoUrl): ?>
								<br>
								<div class="asesor-foto-circulo">
									<div class="asesor-foto-celda">
										<img class="asesor-foto" src="<?= htmlspecialchars($agenteFotoUrl) ?>" alt="Asesor" onerror="this.parentNode.parentNode.style.display='none'">
									</div>
								</div>
							<?php endif; ?>
							<p class="asesor-dato"><b>Nombre:</b> <?= htmlspecialchars($agenteNombre) ?></p>
							<p class="asesor-dato"><b>Celular:</b> <?= htmlspecialchars($agenteTelefono) ?></p>
							<p class="asesor-dato"><b>Correo:</b> <?= htmlspecialchars($agenteEmail) ?></p>
						</td>
						<td class="col-der">
							<img class="firma-url" src="<?= htmlspecialchars($firmaUrl) ?>" alt="Firma">
						</td>
					</tr>
				</table>

				<table class="footer-tabla">
					<tr>
						<td class="footer-texto">
							<?= htmlspecialchars($footerCertificacion) ?><br>
							<?= htmlspecialchars($footerSlogan) ?>
						</td>
						<td class="footer-logo">
							<img src="<?= htmlspecialchars($logoUrl) ?>" alt="Logo">
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>

</html>
<?php
$html = ob_get_clean();

// ---------------------------------------------------------------------
// 3) GENERACIÓN DEL PDF CON DOMPDF
// ---------------------------------------------------------------------
$options = new Options();
$options->set('isRemoteEnabled', true);   // necesario para cargar imágenes por URL
$options->set('isHtml5ParserEnabled', true);
$options->set('defaultFont', 'Arial');

$dompdf = new Dompdf($options);

// Registrar fuentes Arial desde la carpeta local
$fontDir = __DIR__ . '/fonts';
$dompdf->getFontMetrics()->registerFont(
	['family' => 'Arial', 'style' => 'normal', 'weight' => 'normal'],
	"$fontDir/ARIAL.TTF"
);
$dompdf->getFontMetrics()->registerFont(
	['family' => 'Arial', 'style' => 'normal', 'weight' => 'bold'],
	"$fontDir/ARIALBD.TTF"
);

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

// Salida: 'I' = mostrar en navegador, 'D' = forzar descarga, 'F' = guardar en archivo
$dompdf->stream("Ficha_{$codigo}.pdf", ['Attachment' => false]);
