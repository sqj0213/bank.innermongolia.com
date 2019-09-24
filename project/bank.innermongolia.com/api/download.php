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
    $srcFileName=$GLOBAL['G_DB_OBJ']->getFieldValue("select srcFileName,menuID from fileList where fileID='".$fileID."' limit 1;");
    $menuID=$GLOBAL['G_DB_OBJ']->getFieldValue("select menuID from fileList where fileID='".$fileID."' limit 1;");
    $publicFlag=$GLOBAL['G_DB_OBJ']->getFieldValue("select publicFlag from fileList where fileID='".$fileID."' limit 1;");
    
}
else
    $srcFileName=basename($srcFilePath);

$aclFlag=checkMenuOptAcl( $menuID );

if ( $aclFlag === false && $publicFlag== '1')
{
    if ($_SESSION['userData']['uid'] !== 'user'
        && $_SESSION['userData']['uid'] !== 'nsk1'
        && $_SESSION['userData']['uid'] !== 'jwjcs1')
    {
        echo getWinAlert("对不起，您无查看权限!");
        exit;
    }
}
    
    
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
    ob_clean();
    flush();
    @readfile($srcRootFilePath);
}
else
{
    header('Content-Length: 0');
    header('Accept-Length: 0');
    header( 'Content-Transfer-Encoding: binary' );
    echo "源文件已经不存在，下载错误";
}
function checkMenuOptAcl( $menuID=0,$_sessionUserMenuID=0 )
{

    global $GLOBAL;
    if ( $GLOBAL['runData']['userData']["uid"] ===  "admin" )
        return True;
        $sessionUserMenuID=$_sessionUserMenuID;
        if ( $sessionUserMenuID === 0 )
            $sessionUserMenuID=$GLOBAL['G_DB_OBJ']->getFieldValue("select menuID from department where userID='".$GLOBAL['runData']['userData']["id"]."' or viewUserID='".$GLOBAL['runData']['userData']["id"]."';");
            $menuArr = $GLOBAL['G_DB_OBJ']->executeSqlMap("select MenuPId,MenuName from webadmin.treemenu where MenuId=".$menuID,1);
            if ( Empty( $menuArr ) )
            {
                return False;
            }
            if ( $menuArr['MenuPId'] !== "0" )
            {
                return checkMenuOptAcl( $menuArr['MenuPId'],$sessionUserMenuID );
            }
            else
            {
                return ($sessionUserMenuID===$menuID)?True:False;
            }
}
exit();
?>
