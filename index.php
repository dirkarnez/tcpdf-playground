<?php
/**
 * index.php
 *
 * @since       2017-05-08
 * @category    Library
 * @package     Pdf
 * @author      Nicola Asuni <info@tecnick.com>
 * @copyright   2002-2024 Nicola Asuni - Tecnick.com LTD
 * @license     http://www.gnu.org/copyleft/lesser.html GNU-LGPL v3 (see LICENSE.TXT)
 * @link        https://github.com/tecnickcom/tc-lib-pdf
 *
 * This file is part of tc-lib-pdf software library.
 */

// NOTE: run make deps fonts in the project root to generate the dependencies and example fonts.

// autoloader when using Composer
require(__DIR__ . './vendor/autoload.php');


define('OUTPUT_FILE', 'example.pdf');

// define fonts directory
// define('K_PATH_FONTS', __DIR__ . './fonts');

// $buffer = new \Com\Tecnick\Pdf\Font\Stack(1);
// new \Com\Tecnick\Pdf\Font\Import(__DIR__.'./fonts/OpenSans-Regular.ttf');



// main TCPDF object
$pdf = new \Com\Tecnick\Pdf\Tcpdf(
    'mm', // string $unit = 'mm',
    true, // bool $isunicode = true,
    false, // bool $subsetfont = false,
    true, // bool $compress = true,
    '', // string $mode = '',
    null, // ?ObjEncrypt $objEncrypt = null,
);

// ----------


$pdf->setCreator('tc-lib-pdf');
$pdf->setAuthor('John Doe');
$pdf->setSubject('tc-lib-pdf example');
$pdf->setTitle('Example');
$pdf->setKeywords('TCPDF tc-lib-pdf example');
$pdf->setPDFFilename('test_index.pdf');

// $pdf->setViewerPreferences(['DisplayDocTitle' => true]);

// $pdf->enableDefaultPageContent();



try {
    $import = new \Com\Tecnick\Pdf\Font\Import(
        realpath(__DIR__.'./fonts/OpenSans-Regular.ttf')
    );
    $fontname = $import->getFontName();
} catch (Exception) {

}


// echo $fontname;
$bfont2 = $pdf->font->insert($pdf->pon, 'opensans', 'BI', 24);


// ----------
// Add first page

$page01 = $pdf->addPage();

// $pdf->page->addContent($bfont2['out']);
// $pdf->addPage();
// alternative to set the current font (last entry in the font stack):
// $pdf->page->addContent($pdf->font->getOutCurrentFont());

// // Add text
$txt = $pdf->getTextLine(
    'Test PDF text with justification (stretching).',
    0,
    $pdf->toUnit($bfont2['ascent']),
    $page01['width']
);

$pdf->page->addContent($txt);

$style7 = [
    'lineWidth' => 0.5,
    'lineCap' => 'butt',
    'lineJoin' => 'miter',
    'dashArray' => [],
    'dashPhase' => 0,
    'lineColor' => 'darkorange',
    'fillColor' => 'palegreen',
];

$pdf->graph->setPageWidth($page01['width']);
$pdf->graph->setPageHeight($page01['height']);

$circle1 = $pdf->graph->getCircle(25, 105, 20);
$pdf->page->addContent($circle1);

$circle2 = $pdf->graph->getCircle(25, 105, 10, 90, 180, '', $style7);
$pdf->page->addContent($circle2);

$rawpdf = $pdf->getOutPDFString();
$pdf->renderPDF($rawpdf);
// echo $pdf->getMIMEAttachmentPDF($rawpdf);

