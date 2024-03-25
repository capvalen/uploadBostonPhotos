<?php
require('fpdf/fpdf.php');
require('fpdf/font/arial.php'); // Reemplaza "arial-narrow.php" con el nombre real del archivo generado
require('fpdf/font/arial_narrow.php'); // Reemplaza "arial-narrow.php" con el nombre real del archivo generado

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetMargins(20, 10, 20);
$pdf->AddFont('ArialNarrow','','arial_narrow.php'); // Nombre lógico de la fuente
$pdf->AddFont('Arial','','arial.php'); // Nombre lógico de la fuente

$pdf->Image('images/logoBlank.png', 25, 10, 160,0);

$pdf->setY(60);

$pdf->SetFont('Arial','I',12);
$pdf->MultiCell(0,6.5, utf8_decode("Jr. San Antonio N°260 San Carlos - HUANCAYO, Telf. 977 220 220 - (064) 217 255"), 0, 'C');
$pdf->SetLineWidth(0.5); 
$pdf->SetDrawColor(191,143,44);
$pdf->Line(20, 67, $pdf->GetPageWidth()-20, 67); // Línea negra de 1pt de grosor que abarca el ancho de la página a una altura de 60
$pdf->setY(75);



$pdf->SetFont('Arial', 'B', 12.5);
$pdf->Cell(130, 5, utf8_decode("SR (A): ".ucwords($_POST['destinatario'])), 0, 0, 'L');
$pdf->Cell(0, 5, utf8_decode($_POST['fecha']), 0, 0, 'R');
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('ArialNarrow','',13.5);
$text = utf8_decode("BOSTON ABREGÚ REALTY E.I.R.L. Es una empresa de servicios de BIENES RAICES, certificada por el Ministerio de Vivienda Construcción y Saneamiento del Perú, con código de registro como Empresa Inmobiliaria 01439-PJ-MVCS, integrada por expertos profesionales del rubro, con varios años de experiencia, conocedores del mercado Local, Nacional e Internacional con conexiones con una vasta red de agentes inmobiliarios. Contamos con una amplia cartera de clientes que posibilita la realización de operaciones inmobiliarias en tiempos cortos, nuestro personal calificado puede orientarlo en cualquier consulta que tenga sobre el particular y poder obtener los mejores resultados.\n
Nuestra experiencia ha hecho que en muy poco tiempo nos posicionáramos en el mercado de Huancayo, Oxapampa y Pozuzo Representado, Asesorando y ayudándolos en las ventas y determinando sus valores en el mercado de la manera más adecuada a propietarios de casas, locales comerciales, departamentos, terrenos, casas de campos y empresas constructoras - inmobiliarias muy Importantes en el Perú con excelentes resultados.\n
Estas son Algunas Empresas Constructoras con las que estamos trabajando o hemos trabajado. El Sahara Proyecto de 97 Dep. Altos del Valle de 53 Dep. Edificio Confort de 10 Dep. Bella Vista de 45 Dep. Los Sauces 4 Lujosos departamentos, El Edén de 120 casas, Edificio Castillo Azul 12 Dep. Edificio Stop de 6 departamentos y 1 duplex, Edificio Alameda Sur 3 Duplex y 6 Flats, Edificio La Amistad 12 departamentos, Edificio Los jardines 17 departamentos y 2 Penthouses, Edificio Alameda Norte 6 Departamentos, Edificio Alameda Sur II 3 Duplex y 6 Flats, Edificio Santa Maria 5 departamentos y 2 Triplex, Edificio Bellavista II 3 Dep , 1 Duplex, 1 Triplex , Edificio El Paraiso 8 departamentos y 2 Duplex, Edificio Royal  8 Dep, Edificio Elite 7 Flats. Ahora la alianza con la empresa Española Jlo de 37 Casas uno de los proyectos más importantes de Huancayo.\n
Empresas como, Linde, Piscis, Lima Gas, Sazon Lopesa, Graña y Montero, Inka farma, Mifarma, Oruga, Centro Coop, Banco Continental, Banco de Crédito, Boutique Celular, Entel, Inca Cola, Ballo Contratistas, Adecco, SEF Perú Holding, Imave, etc. están confiando en nosotros para compra, venta y alquiler de sus propiedades, y conseguir locales y terrenos para desarrollar sus proyectos.\n
También estamos y hemos representado a muchas familias en ventas de sus propiedades, Terrenos, Casas, Departamentos, Casa de campo, Locales comerciales, Alquileres etc.\n
Al confiar en nosotros para la representación de la venta o alquiler de su propiedad firmamos un contrato de intermediación de servicios donde en sus cláusulas explicamos los compromisos de ambas partes.\n
Tales como:\n");
$pdf->MultiCell(0, 7, $text,0);$pdf->Ln();
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(25, 5, utf8_decode("Asesoría.- "), 0, 0, 'L'); $pdf->Ln();
$pdf->SetFont('ArialNarrow','',13.5);
$pdf->MultiCell(0,6.5, utf8_decode("Ayudamos a determinar el precio actual de venta en el mercado de Huancayo, Lima, Oxapampa y Selva Central."), 0); $pdf->Ln();
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(25, 5, utf8_decode("Promoción.- "), 0, 0, 'L'); $pdf->Ln();
$pdf->SetFont('ArialNarrow','',13.5);
$pdf->MultiCell(0,6.5, utf8_decode("Nos comprometemos a promover su propiedad utilizando los medios de difusión online y offline que consideremos los más adecuados como marketing digital inmobiliario, videos, email marketing, volantes, módulos, banners, letreros, magazine inmobiliario, videos drone, caravanas, videos tik tok, Open House, fichas técnicas, etc. Con el objetivo de localizar a potenciales compradores siendo los gastos por nuestra empresa."), 0); $pdf->Ln();
$pdf->SetFont('Arial', 'B', 11);

$pdf->Cell(25, 5, utf8_decode("Plataforma de Venta de Inmuebles.- "), 0, 0, 'L'); $pdf->Ln();
$pdf->SetFont('ArialNarrow','',13.5);
$pdf->MultiCell(0,6.5, utf8_decode("Promoción de su propiedad en Tokko Broker y en la mejor plataforma de compra y venta de propiedades, siendo la única empresa inmobiliaria en Huancayo con contrato exclusivo con Urbania."), 0); $pdf->Ln();

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(25, 5, utf8_decode("Mediación.- "), 0, 0, 'L'); $pdf->Ln();
$pdf->SetFont('ArialNarrow','',13.5);
$pdf->MultiCell(0,6.5, utf8_decode("Prestaremos asesoramiento y colaboración a todos los posibles compradores llevándolos a la propiedad, coordinando con las entidades financieras y bancarias para su calificación de compra y seguimiento hasta el otorgamiento del contrato privado o escritura pública de compraventa en la notaria, prestando los servicios profesionales necesarios para el buen fin de la operación."), 0); $pdf->Ln();

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(25, 5, utf8_decode("Información.- "), 0, 0, 'L'); $pdf->Ln();
$pdf->SetFont('ArialNarrow','',13.5);
$pdf->MultiCell(0,6.5, utf8_decode("Rendiremos cada 30 días un informe verbal o por escrito de las labores, seguimientos y avances que se estén realizando."), 0); $pdf->Ln();

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(25, 5, utf8_decode("Documentos.- "), 0, 0, 'L'); $pdf->Ln();
$pdf->SetFont('ArialNarrow','',13.5);
$pdf->MultiCell(0,6.5, utf8_decode("El propietario se compromete en proporcionarnos copias del CRI actualizado, copia del Testimonio de como adquirieron el inmueble (compra venta, sucesión intestada o prescripción adquisitiva), copia del Autovaluo, copia del DNI de los Propietarios, copia de los servicios de Agua y Electricidad."), 0); $pdf->Ln();

$y = $pdf->GetY()+10;
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(25, 5, utf8_decode("Asesoría.- "), 0, 0, 'L'); $pdf->Ln();
$pdf->SetFont('ArialNarrow','',13.5);
$pdf->MultiCell(0,6.5, utf8_decode("Los honorarios a percibir Boston Abregú Realty E.I.R.L., si fuese el caso de venta será del 4 % (Cuatro por Ciento) del precio final de venta de la propiedad, y si sea el caso de alquiler será el valor de un mes de arriendo. Comprometiéndonos a entregar facturas por los servicios prestados. El cobro del 100 % de los Honorarios es a la firma de la Escritura Pública."), 0);
$pdf->SetDrawColor(0,0,0);
$pdf->SetLineWidth(0.2);
$pdf->Line(121, $y, $pdf->GetPageWidth()- 21, $y); $y+=7;
$pdf->Line(21, $y, $pdf->GetPageWidth()- 21, $y); $y+=6;
$pdf->Line(21, $y, 78, $y);
$pdf->Ln();

$pdf->MultiCell(0,6.5, utf8_decode("Cualquier información adicional o preguntas al respecto por favor no dude en llamarnos y dejarnos saber."), 0); $pdf->Ln();
$pdf->MultiCell(0,6.5, utf8_decode("Gracias por darnos la oportunidad de presentarle nuestros deseos de representarlos en la venta de su propiedad."), 0); $pdf->Ln();

$y = $pdf->GetY();
$pdf->SetLineWidth(0.5);
$pdf->SetDrawColor(191,143,44);
$pdf->Line(20, $y, $pdf->GetPageWidth()-20, $y); // Línea negra de 1pt de grosor que abarca el ancho de la página a una altura de 60

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 11);
$pdf->MultiCell(0,6.5, utf8_decode("AHORA EN HUANCAYO, LIMA, OXAPAMPA Y SELVA CENTRAL, VENDE Y ALQUILA TU PROPIEDAD CON GARANTIA CON BOSTON ABREGÙ REALTY"), 0, 'C'); $pdf->Ln();
$pdf->MultiCell(0,6.5, utf8_decode("Visitando nuestra renovada página web:"), 0, 'C'); $pdf->Ln();
$pdf->SetTextColor(24,34,230);
$pdf->AddLink('https://bostonabregurealty.com', 0);

$pdf->MultiCell(0,6.5, utf8_decode("https://bostonabregurealty.com"), 0, 'C'); $pdf->Ln();

$pdf->Output();
?>