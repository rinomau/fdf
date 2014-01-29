<?php

require_once('xfdf.php');

// Nome del pdf da compilare
$file = 'Test_moduli.pdf';
// Nome del file pdf contenente i campi modulo (completo di path)
$pdf_template_path = dirname( __FILE__ ) . '/Test_moduli.pdf';
// Nome del file fdf da generare (completo di path)
$xfdf_file_path = '/tmp/dati_test.fdf';
// Nome del file pdf da generare (completo di path)
$pdf_name = substr( $xfdf_file_path, 0, -4 ) . '.pdf';
// Percorso dell'eseguibile pdftk
$pdftk = '/usr/bin/pdftk';


// Elenco delle coppie chiave valore da inserire nel pdf
$info = array(
	'nome' => 'Mauro',
	'cognome' => 'Rainis',
	'sesso' => '2',
	'mtb' => 'Yes',
	'sci' => 'Yes',
	'nuoto' => 'Yes',
	// 'danza' => 'Yes'
);

$xfdf = createXfdf($file,$info);

// Salvo su disco il file fdf
$handle = fopen($xfdf_file_path,'w+');
if (fwrite($handle, $xfdf) === FALSE) {
    echo "Impossibile scrivere sul file ($filename)";
    exit;
}
fclose($handle);

// Unisco i dati del fdf al pdf
$command = "$pdftk $pdf_template_path fill_form $xfdf_file_path output $pdf_name flatten";
exec( $command, $output, $ret );
