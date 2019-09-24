<?php 

define( 'ABS_CUR_DIR_PROJECT_LOGIN', dirname(__FILE__).'/' );
require_once(ABS_CUR_DIR_PROJECT_LOGIN."../bootstrap.php");

require_once(ABS_CUR_DIR_PROJECT_LOGIN . '../inc/conf.php');
use PhpOffice\PhpWord\Settings;
use function GuzzleHttp\Psr7\build_query;
\PhpOffice\PhpWord\Settings::setZipClass(\PhpOffice\PhpWord\Settings::PCLZIP);
Settings::loadConfig();

$dompdfPath = $vendorDirPath . '/dompdf/dompdf';
if (file_exists($dompdfPath)) {
    define('DOMPDF_ENABLE_AUTOLOAD', false);
    Settings::setPdfRenderer(Settings::PDF_RENDERER_DOMPDF, $vendorDirPath . '/dompdf/dompdf');
}

// Set PDF renderer
if (null === Settings::getPdfRendererPath()) {
    $writers['PDF'] = null;
}

// Turn output escaping on
//Settings::setOutputEscapingEnabled(true);




$writers = array('HTML' => 'html');


function buildHtml($webFilePath)
{
    global $appConf,$writers;
    $file=$appConf['GLOBAL']['uploadDir'].$webFilePath;
   // $file="/usr/local/webapp/web-admin/project/bank.innermongolia.com/static//ckfinder/userfiles//tmp/201712201626589.doc";

    //$file="/usr/local/webapp/web-admin/project/bank.innermongolia.com/static/ckfinder/userfiles/tmp/201712200908468.pdf";
    $extName =pathinfo($file, PATHINFO_EXTENSION);

    if ( $extName == "doc")
        $phpWord = \PhpOffice\PhpWord\IOFactory::load($file, 'MsDoc');
        //$phpWord = \PhpOffice\PhpWord\IOFactory::load($file);
    elseif ( $extName == "docx")
        $phpWord = \PhpOffice\PhpWord\IOFactory::load($file);
    elseif  ( $extName == "gd")
        $phpWord = \PhpOffice\PhpWord\IOFactory::load($file);
    elseif  ( $extName == "pdf")
        $phpWord = \PhpOffice\PhpWord\IOFactory::load($file);
    else 
        $phpWord = \PhpOffice\PhpWord\IOFactory::load($file);

    //$writers = array('Word2007' => 'docx', 'ODText' => 'odt', 'RTF' => 'rtf', 'HTML' => 'html', 'PDF' => 'pdf');
    $targetFile = str_replace(pathinfo($file, PATHINFO_EXTENSION),'',$file);
    write($phpWord, $targetFile, $writers,$extName);
    if ( $extName == "doc")
        return "请copy粘贴";
    else
        return  file_get_contents($targetFile."html");
}

function write($phpWord, $filename, $writers,$fileType="docx")
{
    global $writers;
    $result = '';
    
    // Write documents
    foreach ($writers as $format => $extension) {
        $result .= date('H:i:s') . " Write to {$format} format";
        if (null !== $extension) {

            //$targetFile = __DIR__ . "/../static/phpWord/result/{$filename}.{$extension}";
            $targetFile=$filename.$extension;
            //echo $targetFile;
            //exit;
            if ( $fileType == "docx")
            {
                $phpWord->save($targetFile, $format);

            }
            else 
            {
                $phpWord->save($targetFile, $format);
                //$xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, $format);
                //$xmlWriter->save($targetFile);
            }
        } else {
            $result .= ' ... NOT DONE!';
        }
        $result .= EOL;
    }

    $result .= getEndingNotes($writers);

    return $result;
}
function getEndingNotes($writers)
{
    $result = '';

    // Do not show execution time for index
    if (!IS_INDEX) {
        $result .= date('H:i:s') . ' Done writing file(s)' . EOL;
        $result .= date('H:i:s') . ' Peak memory usage: ' . (memory_get_peak_usage(true) / 1024 / 1024) . ' MB' . EOL;
    }

    // Return
    if (CLI) {
        $result .= 'The results are stored in the "results" subdirectory.' . EOL;
    } else {
        if (!IS_INDEX) {
            $types = array_values($writers);
            $result .= '<p>&nbsp;</p>';
            $result .= '<p>Results: ';
            foreach ($types as $type) {
                if (!is_null($type)) {
                    $resultFile = 'results/' . SCRIPT_FILENAME . '.' . $type;
                    if (file_exists($resultFile)) {
                        $result .= "<a href='{$resultFile}' class='btn btn-primary'>{$type}</a> ";
                    }
                }
            }
            $result .= '</p>';
        }
    }

    return $result;
}
//echo buildHtml('');

?>