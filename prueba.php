<?php 
var_dump($_POST);?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	<button onclick="generatePDF()">Generar PDF</button>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>

	<script >
		function generatePDF() {
			window.jsPDF = window.jspdf.jsPDF;

      // Crear una nueva instancia de jsPDF
      const doc = new jsPDF();

			const imgData = 'data:image/png;base64,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'; // Reemplaza con la codificación base64 de tu imagen
      doc.addImage(imgData, 'PNG', 20, 20, 50, 17);
      // Agregar contenido al PDF
      doc.setFontSize(18);
      doc.text('Hola, este es un PDF creado con jsPDF', 20, 20);
      doc.setFontSize(12);
      doc.text('Este es un ejemplo simple de cómo generar un PDF usando jsPDF en su versión 2.', 20, 40);

      // Guardar el PDF
      doc.save('ejemplo.pdf');
    }
	</script>
</body>
</html>