<?php

// Parse pdf file and build necessary objects.
include '../vendor/autoload.php';
$parser = new \Smalot\PdfParser\Parser();
$pdf    = $parser->parseFile('ccc.pdf');

$text = $pdf->getText();
echo $text;
$pages  = $pdf->getPages();

// Loop over each page to extract text.
foreach ($pages as $page) {
 echo $page->getText();
}
?>