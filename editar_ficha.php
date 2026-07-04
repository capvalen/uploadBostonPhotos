<?php
include __DIR__ . "/conexion.php";
if (isset($_COOKIE['ckPower'])) {
	if ($_COOKIE['ckPower'] == '2') {
		header('Location: fichas.php');
	}
} else {
	header('Location: index.php');
}

$idFicha = isset($_GET['cursor']) ? (int)$_GET['cursor'] : 0;
if (!$idFicha) {
	header('Location: fichas.php');
	exit;
}

$sql = "SELECT `idFicha`, `fichTitulo`, `fichPrecio`, `fichDireccion`, `fichTipoPropiedad`,
  `fichAreaTerreno`, `fichAreaConstruccion`, `superficie_descubierta`, `superficie_semicubierta`, `superficie_cubierta`,
  `fichFrontis`, `fichDormitorios`,
  `fichBanios`, `medios_banios`, `fichCochera`, `fichDescipcion`, `antiguedad`,
  `idAsesor`, `fotos`, `moneda`, `beneficios`, `resumen`, `tipo_operacion`
  FROM `fichas` WHERE idFicha = {$idFicha}";
/** @var mysqli $cadena */
$resultado = $cadena->query($sql);
if ($resultado->num_rows !== 1) {
	header('Location: fichas.php');
	exit;
}
$row = $resultado->fetch_assoc();
$fotosExistentes = json_decode($row['fotos'], true);
if (!is_array($fotosExistentes)) $fotosExistentes = array();
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<?php include "headers.php"; ?>
</head>

<body class="mb-5">
	<?php include "nav.php"; ?>
	<div class="container mt-2">
		<div class="d-flex justify-content-between align-items-center mb-2">
			<div class="d-flex align-items-center gap-2" style="gap:8px">
				<a href="ficha.php" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Ver todas las fichas</a>
			</div>
			<div class="d-flex">
				<p class="lead-2 mb-0"><strong>Editando la ficha:</strong> <span class="badge" style="background:#343a40;color:#fff;">BR-<?= str_pad($idFicha, 4, 0, STR_PAD_LEFT) ?></span></p>
				<button class="btn btn-sm ml-3" style="background:#C59641;color:#fff;border-color:#C59641;" title="Ficha PDF con asesor" onclick="abrirModalAsesor(<?= $idFicha ?>)"><i class="bi bi-file-pdf"></i> Ver ficha con asesor</button>
			</div>
		</div>
		<form id="formEditarFicha">
			<input type="hidden" name="idFicha" value="<?= $idFicha ?>">
			<div class="card">
				<div class="card-body">
					<p>Modifique los campos que desee actualizar.</p>
				</div>
			</div>

			<div class="card mt-3">
				<div class="card-body">
					<h5 class="text-uppercase" style="color:#C59641;border-bottom:2px solid #C59641;padding-bottom:6px;"><i class="bi bi-info-circle"></i> Información general</h5>

					<div class="form-row">
						<div class="col-3">
							<label for="">Operación</label>
						</div>
						<div class="col-7">
							<select class="form-control" name="txtOperacion">
								<option value="venta" <?= ($row['tipo_operacion'] ?? 'venta') == 'venta' ? 'selected' : '' ?>>Venta</option>
								<option value="alquiler" <?= ($row['tipo_operacion'] ?? '') == 'alquiler' ? 'selected' : '' ?>>Alquiler</option>
								<option value="traspaso" <?= ($row['tipo_operacion'] ?? '') == 'traspaso' ? 'selected' : '' ?>>Traspaso</option>
								<option value="permuta" <?= ($row['tipo_operacion'] ?? '') == 'permuta' ? 'selected' : '' ?>>Permuta</option>
							</select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-3">
							<label for="">Título de la ficha</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtTitulo" value="<?= htmlspecialchars($row['fichTitulo']) ?>" autocomplete="off">
						</div>
					</div>
					<div class="form-row">
						<div class="col-3">
							<label for="">Precio</label>
						</div>
						<div class="col-7">
							<div class="input-group">
								<div class="input-group-prepend">
									<select class="form-control" name="txtMoneda" id="txtMoneda" style="width:auto;">
										<option value="soles" <?= $row['moneda'] == 'soles' ? 'selected' : '' ?>>Soles (S/.)</option>
										<option value="dólares" <?= $row['moneda'] == 'dólares' ? 'selected' : '' ?>>Dólares ($)</option>
									</select>
								</div>
								<input type="text" class="form-control" name="txtPrecio" id="txtPrecio" value="<?= htmlspecialchars($row['fichPrecio']) ?>" autocomplete="off">
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="col-3">
							<label for="">Dirección</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtDireccion" value="<?= htmlspecialchars($row['fichDireccion']) ?>" autocomplete="off">
						</div>
					</div>
					<div class="form-row">
						<div class="col-3">
							<label for="">Tipo de propiedad</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtPropiedad" value="<?= htmlspecialchars($row['fichTipoPropiedad']) ?>" autocomplete="off">
						</div>
					</div>
					<div class="form-row">
						<div class="col-3">
							<label for="">Dormitorios</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtDormitorios" value="<?= htmlspecialchars($row['fichDormitorios']) ?>" autocomplete="off">
						</div>
					</div>
					<div class="form-row">
						<div class="col-3">
							<label for="">Baños</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtBanio" value="<?= htmlspecialchars($row['fichBanios']) ?>" autocomplete="off">
						</div>
					</div>
					<div class="form-row">
						<div class="col-3">
							<label for="">Medio baños</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtMediosBanios" value="<?= htmlspecialchars($row['medios_banios']) ?>" autocomplete="off">
						</div>
					</div>
					<div class="form-row">
						<div class="col-3">
							<label for="">Cocheras</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtCochera" value="<?= htmlspecialchars($row['fichCochera']) ?>" autocomplete="off">
						</div>
					</div>
					<div class="form-row">
						<div class="col-3">
							<label for="">Antigüedad</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtAntiguedad" value="<?= htmlspecialchars($row['antiguedad']) ?>" autocomplete="off">
						</div>
					</div>
				</div>
			</div>

			<div class="card mt-3">
				<div class="card-body">
					<h5 class="text-uppercase" style="color:#C59641;border-bottom:2px solid #C59641;padding-bottom:6px;"><i class="bi bi-arrows-angle-expand"></i> Superficies y medidas</h5>

					<div class="form-row">
						<div class="col-3">
							<label for="">Terreno</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtATerreno" value="<?= htmlspecialchars($row['fichAreaTerreno']) ?>" autocomplete="off">
						</div>
					</div>
					<div class="form-row">
						<div class="col-3">
							<label for="">Total construido</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtAConstruccion" value="<?= htmlspecialchars($row['fichAreaConstruccion']) ?>" autocomplete="off">
						</div>
					</div>
					<div class="form-row">
						<div class="col-3">
							<label for="">Superficie descubierta</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtSuperficieDescubierta" value="<?= htmlspecialchars($row['superficie_descubierta']) ?>" autocomplete="off">
						</div>
					</div>
					<div class="form-row">
						<div class="col-3">
							<label for="">Superficie semicubierta</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtSuperficieSemicubierta" value="<?= htmlspecialchars($row['superficie_semicubierta']) ?>" autocomplete="off">
						</div>
					</div>
					<div class="form-row">
						<div class="col-3">
							<label for="">Superficie cubierta</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtSuperficieCubierta" value="<?= htmlspecialchars($row['superficie_cubierta']) ?>" autocomplete="off">
						</div>
					</div>
					<div class="form-row">
						<div class="col-3">
							<label for="">Frontis</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtFrontis" value="<?= htmlspecialchars($row['fichFrontis']) ?>" autocomplete="off">
						</div>
					</div>
				</div>
			</div>

			<div class="card mt-3">
				<div class="card-body">
					<h5 class="text-uppercase" style="color:#C59641;border-bottom:2px solid #C59641;padding-bottom:6px;"><i class="bi bi-text-paragraph"></i> Descripción</h5>

					<div class="form-row">
						<div class="col-3">
							<label for="">Resumen</label>
						</div>
						<div class="col-7">
							<textarea class="form-control" name="txtResumen" rows="4" autocomplete="off"><?= htmlspecialchars($row['resumen'] ?? '') ?></textarea>
						</div>
					</div>
					<div class="form-row mt-4">
						<div class="col-3">
							<label for="">Descripción</label>
						</div>
						<div class="col-7">
							<input type="hidden" name="txtDescripcion" id="txtDescripcion">
							<div id="editorDescripcion" style="min-height:150px;"><?= $row['fichDescipcion'] ?></div>
						</div>
					</div>
				</div>
			</div>

			<div class="card mt-3">
				<div class="card-body">
					<h5 class="text-uppercase" style="color:#C59641;border-bottom:2px solid #C59641;padding-bottom:6px;"><i class="bi bi-star"></i> Beneficios</h5>

					<div class="form-row">
						<div class="col-3">
							<label for="">Beneficios</label>
						</div>
						<div class="col-7">
							<textarea class="form-control" name="txtBeneficios" rows="4" autocomplete="off"><?= htmlspecialchars($row['beneficios']) ?></textarea>
						</div>
					</div>

					<div class="form-row">
						<div class="col-3">
							<label for="">Asesor</label>
						</div>
						<div class="col-7">
							<select class="form-control" name="txtAsesor">
								<?php
								global $cadena;
								$sqlAsesor = "SELECT `idAsesor`, upper(`aseNombre`) as aseNombre, `aseCelular`, `aseCorreo`, `aseActivo` FROM `asesor` WHERE aseActivo=1 ORDER BY aseNombre ASC;";
								$resultadoAsesor = $cadena->query($sqlAsesor);
								while ($rowAsesor = $resultadoAsesor->fetch_assoc()) {
									$selected = ($rowAsesor['idAsesor'] == $row['idAsesor']) ? ' selected' : '';
								?>
									<option value="<?= $rowAsesor['idAsesor'] ?>"<?= $selected ?>><?= $rowAsesor['aseNombre'] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
			</div>

			<div class="fixed-top">
				<div class="toast ml-auto mr-3 mt-3" role="alert" id="tostadaError" data-delay="700" data-autohide="false">
					<div class="toast-header">
						<strong class="mr-auto text-danger">Advertencias</strong>
						<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="toast-body" id="toastError"></div>
				</div>
				<div class="toast ml-auto mr-3 mt-3" role="alert" id="tostadaSuccess" data-delay="3000" data-autohide="true">
					<div class="toast-header">
						<strong class="mr-auto text-success">Éxito</strong>
						<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="toast-body" id="toastSuccess"></div>
				</div>
			</div>

			<div class="card mt-3">
				<div class="card-body">
					<p class="font-weight-bold">Fotografías</p>
					<div id="dropzone" class="dropzone text-center p-4 border border-2 border-dashed rounded cursor-pointer">
						<input type="file" id="fileInput" accept="image/*" multiple style="display:none">
						<p class="mb-1"><i class="icofont-cloud-upload" style="font-size:42px;color:#6c757d;"></i></p>
						<p class="mb-1 font-weight-bold"><i class="bi bi-file-earmark-arrow-up"></i> Arrastra y suelta fotos nuevas aquí</p>
						<p class="text-muted mb-0">o haz clic para agregar · <small>Máx. 8 en total</small></p>
					</div>
					<p class="text-muted small mb-2"><i class="bi bi-arrow-up-down"></i> Arrastra las fotos existentes para reordenarlas</p>
					<div id="fotosPreview" class="row mt-3"></div>
					<input type="hidden" name="ordenFotos" id="txtOrdenFotos">
					<div class="d-flex justify-content-center mt-4">
						<button type="submit" class="btn btn-lg" id="btnGuardarFicha" style="background:#C59641;color:#fff;border-color:#C59641;"><i class="bi bi-floppy"></i> Guardar cambios</button>
					</div>
				</div>
			</div>

		</form>

		<div id="overlay">
			<div class="text">
				<div class="spinner-border text-light mb-3" role="status" style="width:3rem;height:3rem;">
					<span class="sr-only">Cargando...</span>
				</div><br>
				<span id="hojita"><i class="icofont-leaf"></i></span>
				<p id="pFrase">Guardando cambios... <span id="porcentajeSub"></span></p>
			</div>
		</div>
	</div>

	<?php include "footers.php" ?>

	<!-- Modal seleccionar asesor para ficha PDF -->
	<div class="modal fade" id="modalAsesor" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-sm modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header border-0">
					<h5 class="modal-title">Seleccionar asesor</h5>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<select id="selectAsesor" class="form-control">
						<option value="">-- Cargando --</option>
					</select>
				</div>
				<div class="modal-footer border-0">
					<button type="button" class="btn" style="background:#C59641;color:#fff;border-color:#C59641;" id="btnVerFichaAsesor"><i class="bi bi-file-pdf"></i> Ver ficha con asesor</button>
				</div>
			</div>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>
	<script>
		<?php if (isset($_GET['creada'])): ?>
		$(function() {
			$('#toastSuccess').text('Ficha creada exitosamente');
			$('#tostadaSuccess').toast('show');
		});
		<?php endif; ?>

		var quill = new Quill('#editorDescripcion', {
			theme: 'snow',
			modules: {
				toolbar: [
					['bold', 'italic'],
					[{ 'list': 'ordered' }, { 'list': 'bullet' }]
				]
			}
		});

		function pantallaOver(tipo) {
			$('#overlay').css('display', tipo ? 'initial' : 'none');
		}

		// --- Fotos existentes y nuevo dropzone ---
		var fotosExistentes = <?= json_encode($fotosExistentes) ?>;
		var fotosNuevas = [];
		var fotosEliminar = [];
		var maxFotos = 8;

		function renderPreviews() {
			var container = $('#fotosPreview').empty();

			if (window.sortableInstance) {
				window.sortableInstance.destroy();
			}

			fotosExistentes.forEach(function(nombre, index) {
				var col = $('<div class="col-md-3 col-6 mb-2" data-foto="' + nombre + '"></div>');
				var div = $('<div class="position-relative border rounded overflow-hidden" style="background:#f5f5f5;"></div>');
				div.append('<img src="images/inmuebles/' + nombre + '?t=' + Date.now() + '" class="img-fluid" style="height:120px;width:100%;object-fit:cover;cursor:grab">');
				div.append('<div class="position-absolute" style="top:4px;right:4px;display:flex;gap:4px;">' +
					'<span class="badge" style="font-size:10px;padding:3px 6px;margin-right:4px;background-color:#1a1c1d;line-height:1rem;color:#fff">En línea</span>' +
					'<button type="button" class="btn btn-danger btn-sm" style="line-height:1;padding:2px 6px;font-size:16px;border-radius:50%" onclick="eliminarExistente(' + index + ')">&times;</button>' +
					'</div>');
				col.append(div);
				container.append(col);
			});

			var nuevasCount = fotosNuevas.length;
			fotosNuevas.forEach(function(file, index) {
				var reader = new FileReader();
				reader.onload = function(e) {
					var col = $('<div class="col-md-3 col-6 mb-2"></div>');
					var div = $('<div class="position-relative border rounded overflow-hidden"></div>');
					div.append('<img src="' + e.target.result + '" class="img-fluid" style="height:120px;width:100%;object-fit:cover">');
					div.append('<button type="button" class="btn btn-danger btn-sm position-absolute" style="top:4px;right:4px;line-height:1;padding:2px 6px;font-size:16px;border-radius:50%" onclick="eliminarNueva(' + index + ')">&times;</button>');
					col.append(div);
					container.append(col);
				};
				reader.readAsDataURL(file);
			});

			if (fotosExistentes.length > 0) {
				window.sortableInstance = Sortable.create(document.getElementById('fotosPreview'), {
					animation: 150,
					handle: 'img',
					filter: '.btn',
					onEnd: function() {
						var orden = [];
						$('#fotosPreview > div[data-foto]').each(function() {
							orden.push($(this).data('foto'));
						});
						if (orden.length > 0) {
							fotosExistentes = orden;
							$('#txtOrdenFotos').val(JSON.stringify(orden));
						}
					}
				});
			}
		}

		function eliminarExistente(index) {
			var nombre = fotosExistentes.splice(index, 1)[0];
			fotosEliminar.push(nombre);
			renderPreviews();
		}

		function eliminarNueva(index) {
			fotosNuevas.splice(index, 1);
			renderPreviews();
		}

		// Dropzone
		$('#dropzone').on('click', function(e) {
			if (e.target.id !== 'fileInput') $('#fileInput').click();
		});
		$('#fileInput').on('click', function(e) { e.stopPropagation(); });
		$('#fileInput').on('change', function() {
			for (var i = 0; i < this.files.length; i++) {
				var file = this.files[i];
				if (!file.type.startsWith('image/')) continue;
				if (fotosExistentes.length + fotosNuevas.length >= maxFotos) break;
				fotosNuevas.push(file);
			}
			this.value = '';
			renderPreviews();
		});

		var dz = document.getElementById('dropzone');
		dz.addEventListener('dragover', function(e) { e.preventDefault();
			this.classList.add('dropzone-hover'); });
		dz.addEventListener('dragleave', function(e) { e.preventDefault();
			this.classList.remove('dropzone-hover'); });
		dz.addEventListener('drop', function(e) {
			e.preventDefault();
			this.classList.remove('dropzone-hover');
			var files = e.dataTransfer.files;
			for (var i = 0; i < files.length; i++) {
				var file = files[i];
				if (!file.type.startsWith('image/')) continue;
				if (fotosExistentes.length + fotosNuevas.length >= maxFotos) break;
				fotosNuevas.push(file);
			}
			renderPreviews();
		});

		// Render inicial
		renderPreviews();

		// --- Submit ---
		$('#formEditarFicha').submit(function() {
			event.preventDefault();
			pantallaOver(true);

			var totalFotos = fotosExistentes.length + fotosNuevas.length;
			if (totalFotos < 2) {
				$('#toastError').text("Debe haber al menos 2 fotos en total");
				$('#tostadaError').toast('show');
				pantallaOver(false);
				return;
			}

			$('#txtDescripcion').val(quill.root.innerHTML);
			$('#txtOrdenFotos').val(JSON.stringify(fotosExistentes));
			var formData = new FormData(this);
			formData.set('fotosEliminar', JSON.stringify(fotosEliminar));
			fotosNuevas.forEach(function(file) {
				formData.append('txtFoto[]', file);
			});

			$.ajax({
				url: 'api/actualizarFicha.php',
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				beforeSend: function() {
					$('#porcentajeSub').text('0%');
				},
				xhr: function() {
					var xhr = new XMLHttpRequest();
					xhr.upload.addEventListener('progress', function(e) {
						if (e.lengthComputable) {
							$('#porcentajeSub').text(Math.round(e.loaded / e.total * 100) + '%');
						}
					});
					return xhr;
				},
				success: function(resp) {
					if ($.isNumeric(resp)) {
						$('#toastSuccess').text('Campos actualizados correctamente');
						$('#tostadaSuccess').toast('show');
						setTimeout(function() {
							location.href = "editar_ficha.php?cursor=" + resp;
						}, 1500);
					} else {
						$('#toastError').text("Error al guardar: " + resp);
						$('#tostadaError').toast('show');
						pantallaOver(false);
					}
				},
				error: function() {
					$('#toastError').text("Error de conexión al guardar");
					$('#tostadaError').toast('show');
					pantallaOver(false);
				}
			});
		});

	var idFichaActual = <?= $idFicha ?>;

	function abrirModalAsesor(idFicha) {
		idFichaActual = idFicha;
		$('#selectAsesor').html('<option value="">Cargando...</option>');
		fetch('api/asesores.php')
			.then(res => res.json())
			.then(data => {
				var select = $('#selectAsesor');
				select.empty();
				select.append('<option value="">-- Seleccione --</option>');
				data.forEach(function(a) {
					select.append('<option value="' + a.idAsesor + '">' + a.aseNombre + '</option>');
				});
				$('#modalAsesor').modal('show');
			});
	}

	$(document).on('click', '#btnVerFichaAsesor', function() {
		var idAsesor = $('#selectAsesor').val();
		if (!idAsesor) {
			alertify.error('Seleccione un asesor');
			return;
		}
		var json = JSON.stringify({cursor: idFichaActual, asesor: parseInt(idAsesor)});
		var invertido = json.split('').reverse().join('');
		var codificado = btoa(invertido);
		window.open('propiedad.php?p=' + codificado, '_blank');
		$('#modalAsesor').modal('hide');
	});
	</script>
	<style>
		.form-row .col-7 {
			max-width: 58.33%;
			flex: 0 0 58.33%;
			overflow: hidden;
			min-width: 0;
		}
		.ql-toolbar.ql-snow,
		.ql-container.ql-snow {
			width: 100% !important;
			max-width: 100% !important;
			box-sizing: border-box;
		}
		.ql-toolbar.ql-snow {
			white-space: normal !important;
			flex-wrap: wrap;
		}
		.ql-editor {
			width: 100% !important;
			max-width: 100% !important;
			word-wrap: break-word !important;
			white-space: normal !important;
		}
		img {
			max-width: 100vh;
		}

		.form-row {
			margin-top: 20px;
		}

		.form-row label {
			font-weight: 700;
		}

		.dropzone {
			border: 2px dashed #ccc !important;
			background: #fafafa;
			transition: all .2s ease;
			cursor: pointer;
		}

		.dropzone:hover,
		.dropzone-hover {
			border-color: #ffc107 !important;
			background: #fff8e1;
		}

		.fixed-top {
			top: 50px;
		}

		#overlay {
			position: fixed;
			display: none;
			width: 100%;
			height: 100%;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background-color: rgba(0, 0, 0, 0.75);
			z-index: 1051;
		}

		#overlay .text {
			position: absolute;
			top: 50%;
			left: 50%;
			font-size: 18px;
			color: white;
			user-select: none;
			transform: translate(-50%, -50%);
			text-align: center;
		}

		#hojita {
			font-size: 36px;
			display: inline;
			animation: cargaData 6s ease infinite;
		}

		@keyframes cargaData {
			0% {
				color: #96f368;
			}
			25% {
				color: #f3dd68;
			}
			50% {
				color: #f54239;
			}
			75% {
				color: #c173ce;
			}
			100% {
				color: #33dbdb;
			}
		}
	</style>
</body>

</html>
