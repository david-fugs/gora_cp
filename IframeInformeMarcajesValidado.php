

<?php
ob_start();
require_once('vendor/autoload.php'); // Ajusta la ruta según tu instalación

$any_actual = intval($_GET['any']);
$mes_actual = intval($_GET['mes']);
$id = intval($_GET['id']);

// Crear una nueva instancia de TCPDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Configurar el encabezado y el pie de página
$pdf->SetHeaderData('', 0, 'Informe Marcajes mes ' .$mes_actual .' ' .$any_actual, '');
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));


$pdf->SetFont('dejavusans', '', 12, '', 'UTF-8');

// Establecer márgenes
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Establecer el modo de subconjunto de fuentes
$pdf->setFontSubsetting(true);

// Añadir una página
$pdf->AddPage();

// Contenido HTML a ser convertido a PDF
$url = "https://grupo-minim.controlpresencia.online/EmpleatInformValidaMarcatge.php?setmana=Todas&id=" . urlencode($id) . "&any=" . urlencode($any_actual) . "&mes=" . urlencode($mes_actual);

// Obtener el contenido HTML de la URL
$content = file_get_contents($url);

// Agregar el contenido al PDF
$pdf->writeHTML($content, true, false, true, false, '');

// Nombre del archivo PDF generado
$filename = 'Informe.pdf';

// Salida del PDF
$pdf->Output($filename, 'I');

ob_end_flush();
?>