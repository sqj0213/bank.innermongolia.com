<?php
define( 'ABS_CUR_DIR_PROJECT_LOGIN', dirname(__FILE__).'/' );
require_once(ABS_CUR_DIR_PROJECT_LOGIN . '../inc/conf.php');
require_once( ABS_CUR_DIR_PROJECT_LOGIN.'../../../kernel/inc/checkSession.php' );


$srcFilePath=$_GET['filePath'];
$downloadType=isset($_GET['downloadType'])?$_GET['downloadType']:'';
if ( Empty( $downloadType ) )
{
    $fileID=$_GET['fileID'];
    if ( Empty( $srcFilePath ) || Empty( $fileID ) )
    {
    	exit;
    }
    $srcFileName=$GLOBAL['G_DB_OBJ']->getFieldValue("select srcFileName from fileList where fileID='".$fileID."' limit 1;");
}
else
    $srcFileName=basename($srcFilePath);
$rootDir = str_replace("/ckfinder/userfiles/","",$appConf['GLOBAL']['uploadDir']);
$srcRootFilePath = $rootDir.$srcFilePath;

$fileinfo = pathinfo($srcRootFilePath);
//header('Content-type: application/x-'.$fileinfo['extension']);
$encoded_filename = rawurlencode($srcFileName);
$encoded_filename = str_replace("+", "%20", $encoded_filename);
$ua = $_SERVER["HTTP_USER_AGENT"];

header('Cache-Control: max-age=0');
header('Content-Type: application/octet-stream');
if (preg_match("/MSIE/", $ua)) { // www.jbxue.com
   header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
} else if (preg_match("/Firefox/", $ua)) {
   header('Content-Disposition: attachment; filename*="utf8\'\'' . $srcFileName . '"');
} else {
   header('Content-Disposition: attachment; filename="' . $srcFileName . '"');
}
header('Accept-Ranges: bytes');
if ( file_exists( $srcRootFilePath ) )
{
    header('Content-Length: '.filesize($srcRootFilePath));
    header('Accept-Length: '.filesize($srcRootFilePath));
    header( 'Content-Transfer-Encoding: binary' );
    @readfile($srcRootFilePath);
}
else
{
    header('Content-Length: 0');
    header('Accept-Length: 0');
    header( 'Content-Transfer-Encoding: binary' );
    echo "源文件已经不存在，下载错误";
}

exit();
?>
