<?php include __DIR__ . "/conexion.php";
if (isset($_COOKIE['ckPower'])) {
	if ($_COOKIE['ckPower'] == '2') {
		header('Location: fichas.php');
	}
} else {
	header('Location: index.php');
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
	<?php include "headers.php"; ?>
</head>

<body class=" mb-5">
	<?php include "nav.php"; ?>
	<div class="container mt-2">
		
		<form id="formUploadImage" action="upload.php" method="post">
			<div class="card">
				<div class="card-body">
					<p>Por favor rellene cuidadosamente los campos para que pueda colgar una ficha nueva.</p>
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
							<select class="form-control" name="txtOperacion" id="txtOperacion">
								<option value="anticresis">Anticresis</option>
								<option value="venta">Venta</option>
								<option value="alquiler">Alquiler</option>
							</select>
						</div>
					</div>
					<div id="divDatosAlquiler" style="display:none;">
						<div class="form-row">
							<div class="col-3">
								<label for="">Garantía</label>
							</div>
							<div class="col-7">
								<input type="text" class="form-control" name="txtGarantia" autocomplete="off" placeholder="Ej: 1 mes">
							</div>
						</div>
						<div class="form-row">
							<div class="col-3">
								<label for="">Anticipo</label>
							</div>
							<div class="col-7">
								<input type="text" class="form-control" name="txtAnticipo" autocomplete="off" placeholder="Ej: 1 mes">
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="col-3">
							<label for="">Título de la ficha</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtTitulo" autocomplete="off">
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
										<option value="soles">Soles (S/.)</option>
										<option value="dólares">Dólares ($)</option>
									</select>
								</div>
								<input type="text" class="form-control" name="txtPrecio" id="txtPrecio" autocomplete="off">
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="col-3">
							<label for="">Dirección</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtDireccion" autocomplete="off">
						</div>
					</div>
					<div class="form-row">
						<div class="col-3">
							<label for="">Tipo de propiedad</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtPropiedad" autocomplete="off">
						</div>
					</div>
					<div class="form-row">
						<div class="col-3">
							<label for="">Dormitorios</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtDormitorios" autocomplete="off">
						</div>
					</div>
					<div class="form-row">
						<div class="col-3">
							<label for="">Baños</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtBanio" autocomplete="off">
						</div>
					</div>
					<div class="form-row">
						<div class="col-3">
							<label for="">Medio baños</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtMediosBanios" autocomplete="off">
						</div>
					</div>
					<div class="form-row">
						<div class="col-3">
							<label for="">Cocheras</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtCochera" autocomplete="off">
						</div>
					</div>
					<div class="form-row">
						<div class="col-3">
							<label for="">Antigüedad</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtAntiguedad" autocomplete="off">
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
							<input type="text" class="form-control" name="txtATerreno" autocomplete="off">
						</div>
					</div>
					<div class="form-row">
						<div class="col-3">
							<label for="">Total construido</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtAConstruccion" autocomplete="off">
						</div>
					</div>
					<div class="form-row d-none">
						<div class="col-3">
							<label for="">Superficie descubierta</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtSuperficieDescubierta" autocomplete="off">
						</div>
					</div>
					<div class="form-row d-none">
						<div class="col-3">
							<label for="">Superficie semicubierta</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtSuperficieSemicubierta" autocomplete="off">
						</div>
					</div>
					<div class="form-row d-none">
						<div class="col-3">
							<label for="">Superficie cubierta</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtSuperficieCubierta" autocomplete="off">
						</div>
					</div>
					<div class="form-row">
						<div class="col-3">
							<label for="">Frontis</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtFrontis" autocomplete="off">
						</div>
					</div>
					<div class="form-row">
						<div class="col-3">
							<label for="">Pisos</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtPisos" autocomplete="off">
						</div>
					</div>
					<div class="form-row">
						<div class="col-3">
							<label for="">Azoteas</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtAzoteas" autocomplete="off">
						</div>
					</div>
					<div class="form-row">
						<div class="col-3">
							<label for="">Área de construcción</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtAreaConstruccion" autocomplete="off">
						</div>
					</div>
					<div class="form-row">
						<div class="col-3">
							<label for="">Área de cochera</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtAreaCochera" autocomplete="off">
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
							<textarea class="form-control" name="txtResumen" rows="4" autocomplete="off"></textarea>
						</div>
					</div>
					<div class="form-row mt-4">
						<div class="col-3">
							<label for="">Descripción</label>
						</div>
						<div class="col-7">
							<input type="hidden" name="txtDescripcion" id="txtDescripcion">
							<div id="editorDescripcion" style="min-height:150px;"></div>
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
							<textarea class="form-control" name="txtBeneficios" id="txtBeneficios" rows="4" autocomplete="off"></textarea>
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
								$sqlAsesor = "SELECT `idAsesor`, upper(`aseNombre`) as aseNombre, `aseCelular`, `aseCorreo`, `aseActivo` FROM `asesor` WHERE aseActivo=1 order by aseNombre asc;";
								$resultadoAsesor = $cadena->query($sqlAsesor);
								while ($rowAsesor = $resultadoAsesor->fetch_assoc()) { ?>
									<option value="<?= $rowAsesor['idAsesor']; ?>"><?= $rowAsesor['aseNombre']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="card mt-3">
				<div class="card-body">
					<h5 class="text-uppercase" style="color:#C59641;border-bottom:2px solid #C59641;padding-bottom:6px;"><i class="bi bi-tools"></i> Servicios</h5>

					<div class="form-row">
						<div class="col-3">
							<label for="">Agua</label>
						</div>
						<div class="col-7">
							<select class="form-control" name="txtServicioAgua">
								<option value="">Sin especificar</option>
								<option value="Sí">Sí</option>
								<option value="No">No</option>
							</select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-3">
							<label for="">Luz</label>
						</div>
						<div class="col-7">
							<select class="form-control" name="txtServicioLuz">
								<option value="">Sin especificar</option>
								<option value="Sí">Sí</option>
								<option value="No">No</option>
							</select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-3">
							<label for="">Desagüe</label>
						</div>
						<div class="col-7">
							<select class="form-control" name="txtServicioDesague">
								<option value="">Sin especificar</option>
								<option value="Sí">Sí</option>
								<option value="No">No</option>
							</select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-3">
							<label for="">Mantenimiento</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtMantenimiento" autocomplete="off">
						</div>
					</div>
				</div>
			</div>
			<div class="fixed-top">
				<div class="toast ml-auto mr-3 mt-3" role="alert" id="tostadaError" data-delay="700" data-autohide="false">
					<div class="toast-header">
						<strong class="mr-auto text-danger">Advertencias para subir</strong>
						<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="toast-body" id="toastError">
					</div>
				</div>
			</div>

			<div class="card mt-3">
				<div class="card-body">
					<p class="font-weight-bold">Fotografías</p>
					<div id="dropzone" class="dropzone text-center p-4 border border-2 border-dashed rounded cursor-pointer">
						<input type="file" id="fileInput" accept="image/*" multiple style="display:none">
						<p class="mb-1"><i class="icofont-cloud-upload" style="font-size:42px;color:#6c757d;"></i></p>
						<p class="mb-1 font-weight-bold"><i class="bi bi-file-earmark-arrow-up"></i> Arrastra y suelta tus fotos aquí</p>
						<p class="text-muted mb-0">o haz clic para seleccionar · <small>Mín. 2, Máx. 8</small></p>
					</div>
					<div id="fotosPreview" class="row mt-3"></div>
					<div class="d-flex justify-content-center mt-4">
						<button type="submit" class="btn btn-lg" id="btnGuardarFicha" style="background:#C59641;color:#fff;border-color:#C59641;"><i class="bi bi-floppy"></i> Guardar ficha</button>
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
				<p id="pFrase"> Subiendo los datos... <span id="porcentajeSub"></span> <br> <span>«Pregúntate si lo que estás haciendo hoy <br> te acerca al lugar en el que quieres estar mañana» <br> Walt Disney</span></p>
			</div>
		</div>
	</div>



	<?php include "footers.php" ?>
	<script>
		var quill = new Quill('#editorDescripcion', {
			theme: 'snow',
			modules: {
				toolbar: [
					['bold', 'italic'],
					[{ 'list': 'ordered' }, { 'list': 'bullet' }]
				]
			}
		});

		// Toggle garantía/anticipo según tipo de operación
		function toggleDatosAlquiler() {
			if ($('#txtOperacion').val() === 'alquiler') {
				$('#divDatosAlquiler').slideDown(200);
			} else {
				$('#divDatosAlquiler').slideUp(200);
			}
		}
		$('#txtOperacion').on('change', toggleDatosAlquiler);
		toggleDatosAlquiler();

		function pantallaOver(tipo) {
			if (tipo) {
				$('#overlay').css('display', 'initial');
			} else {
				$('#overlay').css('display', 'none');
			}
		}

		// Dropzone: arrastrar, soltar, seleccionar y previsualizar
		var fotosSeleccionadas = [];
		var maxFotos = 8;
		var minFotos = 2;

		$('#dropzone').on('click', function(e) { if (e.target.id !== 'fileInput') $('#fileInput').click(); });
		$('#fileInput').on('click', function(e) { e.stopPropagation(); });

		$('#fileInput').on('change', function() {
			agregarFotos(this.files);
			this.value = '';
		});

		var dz = document.getElementById('dropzone');
		dz.addEventListener('dragover', function(e) { e.preventDefault(); this.classList.add('dropzone-hover'); });
		dz.addEventListener('dragleave', function(e) { e.preventDefault(); this.classList.remove('dropzone-hover'); });
		dz.addEventListener('drop', function(e) {
			e.preventDefault();
			this.classList.remove('dropzone-hover');
			agregarFotos(e.dataTransfer.files);
		});

		function agregarFotos(files) {
			for (var i = 0; i < files.length; i++) {
				var file = files[i];
				if (!file.type.startsWith('image/')) continue;
				if (fotosSeleccionadas.length >= maxFotos) break;
				fotosSeleccionadas.push(file);
			}
			renderPreviews();
		}

		function eliminarFoto(index) {
			fotosSeleccionadas.splice(index, 1);
			renderPreviews();
		}

		function renderPreviews() {
			var container = $('#fotosPreview').empty();
			fotosSeleccionadas.forEach(function(file, index) {
				var reader = new FileReader();
				reader.onload = function(e) {
					var col = $('<div class="col-md-3 col-6 mb-2"></div>');
					var div = $('<div class="position-relative border rounded overflow-hidden"></div>');
					div.append('<img src="' + e.target.result + '" class="img-fluid" style="height:120px;width:100%;object-fit:cover">');
					div.append('<button type="button" class="btn btn-danger btn-sm position-absolute" style="top:4px;right:4px;line-height:1;padding:2px 6px;font-size:16px;border-radius:50%" onclick="eliminarFoto(' + index + ')">&times;</button>');
					col.append(div);
					container.append(col);
				};
				reader.readAsDataURL(file);
			});
		}

		$('#formUploadImage').submit(function() {
			event.preventDefault();
			pantallaOver(true);
			if (fotosSeleccionadas.length >= minFotos) {
					$('#txtDescripcion').val(quill.root.innerHTML);
					var formData = new FormData(this);
					fotosSeleccionadas.forEach(function(file) {
						formData.append('txtFoto[]', file);
					});
					$.ajax({
						url: 'upload.php',
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
							if (resp == 'vacio') {
								$('#toastError').text("No se subieron las fotos por falta de fotos");
								$('#tostadaError').toast('show');
							}
							if ($.isNumeric(resp)) {
								location.href = "editar_ficha.php?cursor=" + resp + "&creada=1";
							}
							pantallaOver(false);
						}
					});
				} else {
					$('#toastError').text("Debe seleccionar al menos " + minFotos + " fotos para subir la ficha");
					$('#tostadaError').toast('show');
					pantallaOver(false);
					return false;
				}
		});
	</script>
	<style>
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

		.form-row .col-7 {
			max-width: 58.33%;
			flex: 0 0 58.33%;
			overflow: hidden;
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
			pointer-events: none;
		}
		.fixed-top .toast {
			pointer-events: auto;
		}

		#overlay {
			position: fixed;
			/* Sit on top of the page content */
			display: none;
			/* Hidden by default */
			width: 100%;
			/* Full width (cover the whole page) */
			height: 100%;
			/* Full height (cover the whole page) */
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background-color: rgba(0, 0, 0, 0.75);
			/* Black background with opacity */
			z-index: 1051;
			/* Specify a stack order in case you're using a different order for other elements */
			/* Add a pointer on hover */
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

		#pFrase {
			display: inline;
		}

		#pFrase span {
			font-size: 13px;
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