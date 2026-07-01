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
		<p class="lead-2"><strong>Información general</strong></p>
		<form id="formUploadImage" action="upload.php" method="post">
			<div class="card ">
				<div class="card-body">

					<p>Por favor rellene cuidadosamente los campos para que pueda colgar una ficha nueva.</p>
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
							<label for="">Área del terreno</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtATerreno" autocomplete="off">
						</div>
					</div>
					<div class="form-row">
						<div class="col-3">
							<label for="">Área de construcción</label>
						</div>
						<div class="col-7">
							<input type="text" class="form-control" name="txtAConstruccion" autocomplete="off">
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
							<label for="">Medio Baños</label>
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
							<label for="">Descripción</label>
						</div>
						<div class="col-7">
							<input type="hidden" name="txtDescripcion" id="txtDescripcion">
							<div id="editorDescripcion" style="min-height:200px;"></div>
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
					<div class="form-row">
						<div class="col-3">
							<label for="">Asesor</label>
						</div>
						<div class="col-7">
							<select class="form-control" name="txtAsesor">
								<?php
								global $cadena; //indica al liter que viene de un ámbito global
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
					<div id="dropzone" class="dropzone text-center p-4 border border-2 border-dashed rounded cursor-pointer">
						<input type="file" id="fileInput" accept="image/*" multiple style="display:none">
						<p class="mb-1"><i class="icofont-cloud-upload" style="font-size:42px;color:#6c757d;"></i></p>
						<p class="mb-1 font-weight-bold">Arrastra y suelta tus fotos aquí</p>
						<p class="text-muted mb-0">o haz clic para seleccionar · <small>Mín. 2, Máx. 8</small></p>
					</div>
					<div id="fotosPreview" class="row mt-3"></div>
					<div class="d-flex justify-content-center mt-4">
						<input type="submit" class="btn btn-outline-warning btn-lg" id="btnGuardarFicha" value="Guardar ficha">
					</div>
				</div>
			</div>

		</form>
		<div id="overlay">
			<div class="text"><span id="hojita"><i class="icofont-leaf"></i></span>
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