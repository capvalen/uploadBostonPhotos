<?php include "conexion.php";
if( isset($_COOKIE['ckPower'])){
	if($_COOKIE['ckPower']=='1' && $_COOKIE['ckPower']=='2'){
	header('Location: ficha.php');    
	}

}else{ header('Location: index.php'); }

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<?php include "headers.php";?>
	<?php include "nav.php";?>
</head>
<body>
<div class="container mb-5" id="app">
	<h3 class="text-center my-3">Carta de presentación</h3>
	<div class="row mb-2">
		<div class="col-12 col-md-8 mx-auto">
		<div class="card mb-2">
		<div class="card-body">
			<div class="row ">
				<div class="col-12 my-2">
					<label for="">Nombre del Cliente</label>
					<input type="text" class="form-control" v-model="carta.cliente">
				</div>
				<div class="col-12 my-2">
					<label for="">Fecha de la carta</label>
					<input type="date" class="form-control" v-model="carta.fecha">
				</div>
				<div class="col-12 d-flex justify-content-center my-2">
					<button class="btn btn-outline-primary" title="Generar PDF" @click="generarPDF2()">Generar PDF<i class="icofont-double-right"></i></button>
				</div>
			</div>
		</div>
	</div>
		</div>
	</div>
	
	
</div>
	
<?php include "footers.php";?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/e_rebuild_active_project.js"></script>

<script src="js/arial-normal.js"></script>
<script src="js/arial_narrow-normal.js"></script>
<script src="js/logo.js?v=2"></script>
<script>
	
	const { createApp, ref, onMounted, computed } = Vue

  createApp({
    setup() {
			
			let carta = ref({fecha: moment().format("YYYY-MM-DD"), cliente: ''})

			function generarPDF() {
				window.jsPDF = window.jspdf.jsPDF;

				// Crear una nueva instancia de jsPDF
				const doc = new jsPDF({
					lineHeight: 1.2
				});
				const ancho = doc.internal.pageSize.getWidth();
				let linea = 70, salto=5, x=15;
      	doc.addImage(imgData, 'PNG', ancho/2-75, 10, 150, 50);
				
				doc.setFont('Arial');
				doc.setFont('Arial', 'italic');

				// Agregar contenido al PDF
				doc.setFontSize(13);
				doc.text("Jr. San Antonio N°260 San Carlos – HUANCAYO, Telf. 977 220 220 - (064) 217 255", 105, linea, null, null, 'center'); 
				doc.setDrawColor(245, 146, 64);
				doc.setLineWidth(0.6);linea+=2
				doc.line(10, linea, 200, linea);
				linea+=salto+2;
				doc.setFont('Arial', 'bold');
				
				
				moment.locale('es')
				doc.text("SR. "+carta.cliente, x, linea);
				doc.text( moment(carta.fecha).format("DD [de] MMMM [del] YYYY") , x+130, linea); linea+=salto*2;
				doc.setFont('arial_narrow', 'normal');
				doc.setFontSize(14);
				const textWidth = 180; // Ancho del área de texto en unidades jsPDF
				const textLines = "BOSTON ABREGÚ REALTY E.I.R.L. Es una empresa de servicios de BIENES RAICES, certificada por el Ministerio de Vivienda Construcción y Saneamiento del Perú, con código de registro como Empresa Inmobiliaria 01439-PJ-MVCS, integrada por expertos profesionales del rubro, con varios años de experiencia, conocedores del mercado Local, Nacional e Internacional con conexiones con una vasta red de agentes inmobiliarios. Contamos con una amplia cartera de clientes que posibilita la realización de operaciones inmobiliarias en tiempos cortos, nuestro personal calificado puede orientarlo en cualquier consulta que tenga sobre el particular y poder obtener los mejores resultados.";
				const textHeight = doc.splitTextToSize(textLines, textWidth); // Calcula la altura necesaria
				doc.text(textLines, 10, linea, { align: 'justify', maxWidth: textWidth, lineHeightFactor: 1.2 });
				// Guardar el PDF
				doc.save('ejemplo.pdf');
			}
			
			function generarPDF2(){
				console.log(carta)
				moment.locale('es')
				var url = "carta.php";
				var data = {
					destinatario: carta.value.cliente,
					fecha: moment(carta.value.fecha).format('DD [de] MMMM [del] YYYY')
				};
				var form = document.createElement("form");
				form.target = "_blank"; // Abrir en una nueva ventana/pestaña
				form.method = "POST"; // Método POST
				form.action = url; // URL de destino

				// Agregar los campos de datos al formulario
				for (var key in data) {
					var input = document.createElement("input");
					input.type = "hidden";
					input.name = key;
					input.value = data[key];
					form.appendChild(input);
				}

				// Agregar el formulario al documento y enviarlo
				document.body.appendChild(form);
				form.submit();

				// Eliminar el formulario temporal
				document.body.removeChild(form);
			}

			onMounted(()=> {
				pedirDatos();
			})

      return {
        carta,
				generarPDF2
      }
    }
  }).mount('#app')
</script>

<style>
	.custom-file-input ~ .custom-file-label::after {
    content: "Seleccionar";
	}
</style>
</body>
</html>