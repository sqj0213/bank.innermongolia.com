<?php
//web develop require
define('ABS_CUR_DIR_MENU_CONF', dirname(__FILE__).'/');
require_once(ABS_CUR_DIR_MENU_CONF . '../inc/conf.php');
require_once( ABS_CUR_DIR_MENU_CONF.'../../../kernel/inc/checkSession.php' );
require_once( ABS_CUR_DIR_MENU_CONF.'../../../kernel/modules/menu/datastruct/treeDBClass.php' );
require_once( ABS_CUR_DIR_MENU_CONF.'../../../kernel/comm/formCheck.php' );
require_once( ABS_CUR_DIR_MENU_CONF.'../../../kernel/baselib/postPage.php' );

$opt = $_REQUEST['opt'];


$influenceID =  intval( $GLOBAL['runData']['userData']['influenceID'] );
$GLOBAL['htmlDefine']['replaceArray']['__CSSFILEPATH__'] = '../../cssimg/style.css';

$selfMenu = 0;
if (  $influenceID == -1 && $selfMenu == 1 )//超级管理员才可以有菜单
    $TselfMenu = 0;
else
{
    $TselfMenu = 0;
    $selfMenu = 0;
}
$menuID = $_REQUEST['menuID'];
if ( $opt === "editFlagSave")//增加子项后台
{
    $fileBody = $_POST["editor1"];
    $srcFilePath = isset($_POST["srcFilePath"])?$_POST["srcFilePath"]:'';
    $srcFileName = isset($_POST["srcFileName"])?$_POST["srcFileName"]:'';
    if ( Empty( $srcFileName ) || Empty( $srcFilePath ) || strlen($fileBody) < 10 )
    {
        
        echo getErrorTmpl("文件名与内容不能为空!");
        exit;
    }
    $fileInfo=$GLOBAL['G_DB_OBJ']->executeSqlMap("select srcFilePath,srcFileName from fileList where menuID='".$menuID."' limit 1;", 1 );
    $rootDir = str_replace("/ckfinder/userfiles/","",$appConf['GLOBAL']['uploadDir']);
    $destFilePath = str_replace("/tmp/","/result/",$srcFilePath);
    $srcRootFilePath = $rootDir.$srcFilePath;
    $destRootFilePath = str_replace("/tmp/","/result/",$srcRootFilePath);
    if ( !rename($srcRootFilePath, $destRootFilePath) )
        echo "move file failed!".$rootDir.$fileInfo['srcFilePath']."<br>";

    if ( !Empty($fileInfo['srcFilePath']) && $fileInfo['srcFilePath'] != $destFilePath)
    {
         $oldRootFilePath = $rootDir.$fileInfo['srcFilePath'];
         
         if ( !unlink($oldRootFilePath) )
             echo "delete file failed!".$oldRootFilePath."<br>";
    }
     $sqlStr = "delete from fileList where menuID='".$menuID."';";
     if ( $GLOBAL['G_DB_OBJ']->executeSql($sqlStr) !== 1 )
     {
         echo getErrorTmpl('/fileEdit.php?opt=editFlag&menuID='.$menuID,"保存失败，请联络管理员!");
         exit;
     }

     $sqlStr = "insert into fileList(srcFilePath,srcFileName,fileBody,menuID) values('".$destFilePath."','".$srcFileName."','".$fileBody."','".$menuID."');";

    $GLOBAL['G_DB_OBJ']->executeSql("update treemenu set MenuName='".$srcFileName."' where MenuId='".$menuID."' limit 1;");
    if ($GLOBAL['G_DB_OBJ']->executeSql($sqlStr) === 1 )
    {
        
        echo getAlertFormLocationJSCode('/fileEdit.php?opt=editFlag&menuID='.$menuID,"","","parent.parent.leftFrame.location.reload(true);");
        
    }
    else 
    {
        echo getErrorTmpl("保存失败，请联络管理员!");
    }
    exit;
}

if ($opt === "editFlag") {

    if ( $_SESSION['userData']['uid'] === 'user' )
    {

        $GLOBAL['htmlDefine']['tmplPath'] = ABS_CUR_DIR_MENU_CONF."../static/tmpl/fileList_read.tmpl";

        $searchType=!Empty($_REQUEST['searchType'])?$_REQUEST['searchType']:'';
        $key1=!Empty($_REQUEST['key1'])?$_REQUEST['key1']:'';
        $key2=!Empty($_REQUEST['key2'])?$_REQUEST['key2']:'';
        $key3=!Empty($_REQUEST['key3'])?$_REQUEST['key3']:'';
        $fileID=$_REQUEST['fileID'];
        $id = $_REQUEST["id"];
        $info = $GLOBAL['G_DB_OBJ']->executeSql("select fileID as __FILEID__,menuID, srcFileName as __SRCFILENAME__, srcFilePath as __SRCFILEPATH__, fileBody as __FILEBODY__ from fileList where menuID ='".$menuID."' limit 1;");
        $GLOBAL['htmlDefine']['replaceArray']['__KEY1__']=$key1;
        $GLOBAL['htmlDefine']['replaceArray']['__KEY2__']=$key2;
        $GLOBAL['htmlDefine']['replaceArray']['__KEY3__']=$key3;
        if (substr( $info["__SRCFILEPATH__"], strrpos($info["__SRCFILEPATH__"],".")+1 ) == "pdf" )
        {
            $GLOBAL['htmlDefine']['replaceArray']['__PDFITEMSTYLE__']="block";
			$ua = $_SERVER["HTTP_USER_AGENT"];
			if (preg_match("/MSIE/", $ua)) 
			{

				$GLOBAL['htmlDefine']['replaceArray']['__PDFITEMSTYLE__']="block";
				$GLOBAL['htmlDefine']['replaceArray']['__PDFJS__']="$(function () {PDFObject.embed('".$info["__SRCFILEPATH__"]."', \"#pdfitem\");})";
				$GLOBAL['htmlDefine']['replaceArray']['__DOCSTYLE__']="none";
			}
			else
			{
				$GLOBAL['htmlDefine']['replaceArray']['__PDFJS__']="$(function () {PDFObject.embed('".$fileInfo["srcFilePath"]."', \"#pdfitem\");})";
				$GLOBAL['htmlDefine']['replaceArray']['__PDFHTML__']="";
			}
            $GLOBAL['htmlDefine']['replaceArray']['__DOCSTYLE__']="block";

        }
        else 
        {
            
            $GLOBAL['htmlDefine']['replaceArray']['__DOCSTYLE__']="block";
            $GLOBAL['htmlDefine']['replaceArray']['__PDFITEMSTYLE__']="none";
            $GLOBAL['htmlDefine']['replaceArray']['__PDFJS__']="";
        }
        if ( Empty($info)  )
        {
            $GLOBAL['htmlDefine']['replaceArray']['__PDFJS__']="";
            $GLOBAL['htmlDefine']['replaceArray']['__DOCSTYLE__']="none";
            $GLOBAL['htmlDefine']['replaceArray']['__PDFITEMSTYLE__']="none";
			$GLOBAL['htmlDefine']['replaceArray']['__FILEID__'] = $info["__FILEID__"];
        }
        
        $GLOBAL['htmlDefine']['replaceArray']['__SEARCHTYPE__']=$searchType;
        if (!Empty( $info ) )
            $GLOBAL['htmlDefine']['replaceArray']=array_merge($GLOBAL['htmlDefine']['replaceArray'],$info);
        $GLOBAL['htmlDefine']['replaceArray']['__TREEPATH__']=getTreePath($info['menuID'],'');
    
        require_once(ABS_CUR_DIR_MENU_CONF . "../../../kernel/comm/loadModules.php");
        $moduleShowtmpl = loadModules("webPage", $errMsg);
    }
    else
    {
        require_once(ABS_CUR_DIR_MENU_CONF . "../../../kernel/comm/loadModules.php");
        $MenuIDList = $GLOBAL['G_DB_OBJ']->executeSqlMap("select MenuId from webadmin.treemenu where MenuPid=0;");
        $MenuIDListStr="";
        foreach ($MenuIDList as  $value)
            $MenuIDListStr .= $value["MenuId"].",";
        $GLOBAL['htmlDefine']['replaceArray']['__NOMENUPIDLIST__'] = substr( $MenuIDListStr,0,-1);
        $GLOBAL['htmlDefine']['replaceArray']['__MENUPATH__']=getTreePath($menuID,"");
        $GLOBAL['htmlDefine']['replaceArray']['__MENUID__']=$menuID;
        $fileInfo=$GLOBAL['G_DB_OBJ']->executeSqlMap("select fileID, srcFilePath,srcFileName,fileBody from fileList where menuID='".$menuID."' limit 1;", 1 );
    
        if (substr( $fileInfo["srcFilePath"], strrpos($fileInfo["srcFilePath"],".")+1 ) == "pdf" )
        {
            $GLOBAL['htmlDefine']['replaceArray']['__FORMSTYLE__']="none";
            $GLOBAL['htmlDefine']['replaceArray']['__GDITEMSTYLE__']="none";
    
            $GLOBAL['htmlDefine']['replaceArray']['__PDFITEMSTYLE__']="block";
            $GLOBAL['htmlDefine']['replaceArray']['__PDFSAVESTYLE__']="block";
			$ua = $_SERVER["HTTP_USER_AGENT"];
			if (preg_match("/MSIE/", $ua)) 
			{
				$GLOBAL['htmlDefine']['replaceArray']['__PDFHTML__']='<object width="100%" height="100%" data="'.$fileInfo["srcFilePath"].'" type="application/pdf">
   <p><b>Example fallback content</b>: This browser does not support PDFs. Please download the PDF to view it: <a href="'.$fileInfo["srcFilePath"].'">Download PDF</a>.</p>
</object>';
				$GLOBAL['htmlDefine']['replaceArray']['__PDFJS__']='';
			}
			else
			{
				$GLOBAL['htmlDefine']['replaceArray']['__PDFJS__']="$(function () {PDFObject.embed('".$fileInfo["srcFilePath"]."', \"#pdfitem\");})";
				$GLOBAL['htmlDefine']['replaceArray']['__PDFHTML__']="";
			}

			//PDFObject.embed("myfile.pdf", "#my-container", {fallbackLink: false});

            //$("#pdfitem").html('<object data="'+data.filePath+'" type="application/pdf" width="100%" height="100%">');
            //$GLOBAL['htmlDefine']['replaceArray']['__PDFHTML__']="<object data=\"".$fileInfo["srcFilePath"]."\" type=\"application/pdf\" width=\"100%\" height=\"100%\">";

            
            //$GLOBAL['htmlDefine']['replaceArray']['__PDFJS__']="$(function () {document.getElementById(\"#pdfitem\").html('<object data=\"".$fileInfo["srcFilePath"]."\" type=\"application/pdf\" width=\"100%\" height=\"100%\">');}";
        }
        else
        {
            $GLOBAL['htmlDefine']['replaceArray']['__FORMSTYLE__']="block";
            $GLOBAL['htmlDefine']['replaceArray']['__PDFITEMSTYLE__']="none";
            $GLOBAL['htmlDefine']['replaceArray']['__PDFSAVESTYLE__']="none";
            $GLOBAL['htmlDefine']['replaceArray']['__PDFJS__']="";
        }
        if ( !Empty($fileInfo)  )
        {
            
            $GLOBAL['htmlDefine']['replaceArray']['__FILEBODY__'] = $fileInfo["fileBody"];
            $GLOBAL['htmlDefine']['replaceArray']['__SRCFILEPATH__'] = $fileInfo["srcFilePath"];
			$GLOBAL['htmlDefine']['replaceArray']['__FILEID__'] = $fileInfo["fileID"];
            $GLOBAL['htmlDefine']['replaceArray']['__SRCFILENAME__'] = $fileInfo["srcFileName"];
            $GLOBAL['htmlDefine']['replaceArray']['__DOWNLOADSTYLE__']="block";
        }
        else 
        {
            $GLOBAL['htmlDefine']['replaceArray']['__DOWNLOADSTYLE__']="none";
            $GLOBAL['htmlDefine']['replaceArray']['__FILEBODY__'] = '';
			$GLOBAL['htmlDefine']['replaceArray']['__FILEID__']="";
            $GLOBAL['htmlDefine']['replaceArray']['__SRCFILEPATH__'] = '';
            $GLOBAL['htmlDefine']['replaceArray']['__SRCFILENAME__'] = '';

        }
        
        //select userkey from test order by id;
    
        $moduleShowtmpl = loadModules("webPage", $errMsg);
    }
}

function getTreePath( $menuID=0,$menuPath )
{
    global $GLOBAL;
    $retVal = "";
    $menuArr = $GLOBAL['G_DB_OBJ']->executeSqlMap("select MenuPId,MenuName from webadmin.treemenu where MenuId=".$menuID,1);
    if ( empty( $menuArr ) )
        return substr($menuPath,0,-3);
    if ( $menuArr['MenuPId'] !== 0 )
    {
       $menuPath = $menuArr['MenuName']."-->".$menuPath; 
       return getTreePath( $menuArr['MenuPId'],$menuPath );

    }
}
//参考配置文件
$GLOBAL['modulesArray'][GLOBAL_ROOT_PATH . '/appMenu.php'] = array(
    'default' => array(
        'to_path' => GLOBAL_ROOT_PATH . 'appMenu.php',
        'to_query' => 'opt=addSubFlag',
        'type' => 'reload',
        'info' => '删除任务成功'
    ),
    
    'opt=addSubFlag' => array(
        'to_path' => GLOBAL_ROOT_PATH . 'appMenu.php',
        'to_query' => 'opt=addSubFlag',
        'type' => 'reload',
        'info' => '填加成功'
    ),
    'opt=updFlag' => array(
        'to_path' => GLOBAL_ROOT_PATH . 'appMenu.php',
        'to_query' => 'opt=updFlag',
        'type' => 'json',
        'info' => getWinCloseScriptNoReload('修改成功')
    ),
    'opt=delFlag' => array(
        'to_path' => GLOBAL_ROOT_PATH . 'appMenu.php',
        'to_query' => 'opt=delFlag',
        'type' => 'json',
        'info' => '修改成功'
    )
);


?>
