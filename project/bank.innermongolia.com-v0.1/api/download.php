<?php
define( 'ABS_CUR_DIR_PROJECT_LOGIN', dirname(__FILE__).'/' );
require_once(ABS_CUR_DIR_PROJECT_LOGIN . '../inc/conf.php');
require_once( ABS_CUR_DIR_PROJECT_LOGIN.'../../../kernel/inc/checkSession.php' );
//�ļ�����
//readfile
$srcFilePath=$_GET['filePath'];
$fileID=$_GET['fileID'];
if ( Empty( $srcFilePath ) || Empty( $fileID ) )
{
	exit;
}
$srcFileName=$GLOBAL['G_DB_OBJ']->getFieldValue("select srcFileName from fileList where fileID='".$fileID."' limit 1;");

$rootDir = str_replace("/ckfinder/userfiles/","",$appConf['GLOBAL']['uploadDir']);
$srcRootFilePath = $rootDir.$srcFilePath;



$fileinfo = pathinfo($srcRootFilePath);
header('Content-type: application/x-'.$fileinfo['extension']);
$encoded_filename = urlencode($srcFileName);
$encoded_filename = str_replace("+", "%20", $encoded_filename);
$ua = $_SERVER["HTTP_USER_AGENT"];
header('Content-Type: application/octet-stream');
if (preg_match("/MSIE/", $ua)) { // www.jbxue.com
   header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
} else if (preg_match("/Firefox/", $ua)) {
   header('Content-Disposition: attachment; filename*="utf8\'\'' . $srcFileName . '"');
} else {
   header('Content-Disposition: attachment; filename="' . $srcFileName . '"');
}

header('Content-Length: '.filesize($srcRootFilePath));
readfile($srcRootFilePath);
exit();
?>
