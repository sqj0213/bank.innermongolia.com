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
$departmentID = $_REQUEST['departmentID'];

if ( $opt === "addFlagSave")//增加子项后台
{
    $fileBody = $_POST["editor1"];
    $srcFilePath = isset($_POST["srcFilePath"])?$_POST["srcFilePath"]:'';
    $srcFileName = isset($_POST["srcFileName"])?$_POST["srcFileName"]:'';
    $flowChartName = isset($_POST["flowChartName"])?$_POST["flowChartName"]:'';
    $otherFlag=$_GET["otherFlag"];
    if (!Empty( $flowChartName ) && !Empty( $fileBody ) && Empty( $srcFileName )  )
    {

            $srcFileName = $flowChartName;
        
    }
    
    if ( Empty( $flowChartName ) ||Empty( $srcFileName )|| strlen($fileBody) < 10 )
    {

        echo getErrorTmpl("流程图名称与流程图内容不能为空!");
        exit;
    }

    //$fileBody = "<p>".$fileBody."</p>";
    if ( $otherFlag == "1" )
        $sqlStr = "insert into fileListOther(name,srcFilePath,srcFileName,fileBody,departmentID,fileType) values('".$flowChartName."','nofile','".$srcFileName."','".$fileBody."','".$departmentID."','workFlow');";
    else
    {
        $bankID = $GLOBAL["G_DB_OBJ"]->getFieldValue( "select id from banklist where bankLevel='0' limit 1");
        $sqlStr = "insert into fileListOther(name,srcFilePath,srcFileName,fileBody,departmentID,fileType,bankID) values('".$flowChartName."','nofile','".$srcFileName."','".$fileBody."','".$departmentID."','workFlow','".$bankID."');";
    }

    if ($GLOBAL['G_DB_OBJ']->executeSql($sqlStr) === 1 )
    {
        $fileID=$GLOBAL['G_DB_OBJ']->getfieldValue("select fileID from fileListOther where name='".$flowChartName."' and srcFilePath='nofile' and srcFileName='".$srcFileName."' and fileType='workFlow' order by fileID desc");
        echo getAlertFormLocationJSCode('/workFlow.php?opt=editFlag&departmentID='.$departmentID.'&fileID='.$fileID.'&otherFlag='.$otherFlag,"填加成功","","parent.parent.leftFrame.location.reload(true);");
    }
    else 
    {
        echo getErrorTmpl("保存失败，请联络管理员!");
    }
    exit;
}
if ( $opt === "readFlag")
{
    $fileID=$_REQUEST['fileID'];
    $departmentID=$_REQUEST["departmentID"];
    $otherFlag = $_GET["otherFlag"];
    if ( checkReadAcl($departmentID) ===false )
    {
        echo getHistoryBackScript( '您无查看权限!' );
        exit;
    }
    $info = $GLOBAL['G_DB_OBJ']->executeSql("select name as __WORKFLOWNAME__,fileID as __FILEID__,departmentID as __DEPARTMENTID__, srcFileName as __SRCFILENAME__, srcFilePath as __SRCFILEPATH__, fileBody as __FILEBODY__ from fileListOther where fileId ='".$fileID."' limit 1;");
    $GLOBAL['htmlDefine']['replaceArray']['__FILEURL__'] = BASEURL.$info['__SRCFILEPATH__'];
    $GLOBAL['htmlDefine']['replaceArray']['__OTHERFLAG__'] = $otherFlag;
    if (!Empty( $info ) )
        $GLOBAL['htmlDefine']['replaceArray']=array_merge($GLOBAL['htmlDefine']['replaceArray'],$info);
    if ( $otherFlag == 1 )
        $GLOBAL['htmlDefine']['replaceArray']['__DEPARTMENTNAME__'] = $GLOBAL['G_DB_OBJ']->getfieldValue("select (select MenuName from treemenu where MenuId=departmentOther.menuID) as name from departmentOther where id='".$departmentID."'");
    else
        $GLOBAL['htmlDefine']['replaceArray']['__DEPARTMENTNAME__'] = $GLOBAL['G_DB_OBJ']->getfieldValue("select (select MenuName from treemenu where MenuId=department.menuID) as name from department where id='".$departmentID."'");
    require_once(ABS_CUR_DIR_MENU_CONF . "../../../kernel/comm/loadModules.php");

    $moduleShowtmpl = loadModules("webPage", $errMsg);
    exit;
    
}
if ($opt === "editFlag") {
    $fileID=$_REQUEST['fileID'];
    $departmentID=$_REQUEST["departmentID"];
    $otherFlag=$_GET["otherFlag"];
    if ( checkAcl($departmentID) ===false )
    {
        echo getHistoryBackScript( '您无操作权限!' );
        exit;
    }

    $GLOBAL['htmlDefine']['replaceArray']['__FILEID__'] = $fileID;
    $GLOBAL['htmlDefine']['replaceArray']['__DEPARTMENTNAME__'] = $GLOBAL['G_DB_OBJ']->getfieldValue("select (select MenuName from treemenu where MenuId=department.menuID) as name from department where id='".$departmentID."'");
    require_once(ABS_CUR_DIR_MENU_CONF . "../../../kernel/comm/loadModules.php");

    $fileInfo=$GLOBAL['G_DB_OBJ']->executeSqlMap("select name,fileID, srcFilePath,srcFileName,fileBody,name from fileListOther where fileID='".$fileID."' limit 1;", 1 );

    $GLOBAL['htmlDefine']['replaceArray']['__DEPARTMENTID__'] = $departmentID;
    $GLOBAL['htmlDefine']['replaceArray']['__FORMSTYLE__']="block";

    if ( !Empty($fileInfo)  )
    {
        $GLOBAL['htmlDefine']['replaceArray']['__FILEBODY__'] = $fileInfo["fileBody"];
        $GLOBAL['htmlDefine']['replaceArray']['__FILEBODY__'] = $fileInfo["fileBody"];
        $GLOBAL['htmlDefine']['replaceArray']['__SRCFILEPATH__'] = $fileInfo["srcFilePath"];
		$GLOBAL['htmlDefine']['replaceArray']['__FILEID__'] = $fileInfo["fileID"];
        $GLOBAL['htmlDefine']['replaceArray']['__SRCFILENAME__'] = $fileInfo["name"];
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
if ( $opt==="delFlag" )
{
    $fileID=$_REQUEST["fileID"];
    //$fileType=$_REQUEST["fileType"];
    $departmentID=$_REQUEST["departmentID"];
    if ( checkAcl($departmentID) ===false )
    {
        echo getHistoryBackScript( '您无操作权限!' );
        exit;
    }
    $srcFilePath = $GLOBAL['G_DB_OBJ']->getfieldValue("select srcFilePath from fileListOther where fileID='".$fileID."'");
    $rootDir = str_replace("/ckfinder/userfiles/","",$appConf['GLOBAL']['uploadDir']);
    $destRootFilePath = $rootDir.$srcFilePath;
    if ( !unlink($oldRootFilePath) )
        echo "delete file failed!".$oldRootFilePath."<br>";
    
    $sqlStr = "delete from fileListOther where fileID='".$fileID."';";
    if ( $GLOBAL['G_DB_OBJ']->executeSql($sqlStr) !== 1 )
    {
        echo getErrorTmpl('/workFlow.php?opt=editFlag&fileID='.$fileID.'&departmentID='.$departmentID,"保存失败，请联络管理员!");
        exit;
    }
    else 
    {
        echo getAlertFormLocationJSCode('/workFlow.php?opt=addFlag&departmentID='.$departmentID,"删除成功!","","parent.parent.leftFrame.location.reload(true);");
        exit;
    }
    
    
}
if ( $opt === "editFlagSave")//增加子项后台
{
    $fileID=$_REQUEST["fileID"];

    $departmentID=$_REQUEST["departmentID"];
    $fileBody = $_POST["editor1"];
    $otherFlag = $_GET["otherFlag"];
    $srcFileName = isset($_POST["srcFileName"])?$_POST["srcFileName"]:'';
    $flowChartName = isset($_POST["flowChartName"])?$_POST["flowChartName"]:'';
    if ( Empty( $flowChartName ) ||Empty( $srcFileName )  || strlen($fileBody) < 10 )
    {

        echo getErrorTmpl("流程图名称，流程图内容都不能为空!");
        exit;
    }

    //exit;
    $fileInfo=$GLOBAL['G_DB_OBJ']->executeSqlMap("select srcFilePath,srcFileName from fileListOther where fileID='".$fileID."' limit 1;", 1 );

    $sqlStr = "delete from fileListOther where fileID='".$fileID."';";
    if ( $GLOBAL['G_DB_OBJ']->executeSql($sqlStr) !== 1 )
    {
        echo getErrorTmpl('/workFlow.php?opt=editFlag&fileID='.$fileID.'&departmentID='.$departmentID,"保存失败，请联络管理员!");
        exit;
    }
    if ( $otherFlag == 1 )
    {
        $bankID=0;
        $sqlStr = "insert into fileListOther(name,srcFilePath,srcFileName,fileBody,departmentID,fileType) values('".$flowChartName."','nofile','".$srcFileName."','".$fileBody."','".$departmentID."','workFlow');";
    }
    else
    {
        $bankID=$GLOBAL["G_DB_OBJ"]->getFieldValue("select id from banklist where bankLevel='0' limit 1");
        $sqlStr = "insert into fileListOther(name,srcFilePath,srcFileName,fileBody,departmentID,fileType,bankID) values('".$flowChartName."','nofile','".$srcFileName."','".$fileBody."','".$departmentID."','workFlow','".$bankID."');";  
    }
    if ($GLOBAL['G_DB_OBJ']->executeSql($sqlStr) === 1 )
    {
        $fileID=$GLOBAL['G_DB_OBJ']->getFieldValue("select fileID from fileListOther where name='".$flowChartName."' and srcFilePath='nofile' and srcFileName='".$srcFileName."' and departmentID='".$departmentID."' and fileType='workFlow' band bankID='".$bankID."'");
        echo getAlertFormLocationJSCode('/workFlow.php?opt=readFlag&departmentID='.$departmentID.'&fileID='.$fileID."&otherFlag=".$otherFlag,"","","parent.parent.leftFrame.location.reload(true);");
        exit;
    }
    else
    {
        echo getErrorTmpl("保存失败，请联络管理员!");
    }
    exit;
}
if ($opt === "addFlag") {
    $departmentID=$_GET["departmentID"];
    $otherFlag = $_GET["otherFlag"];
    if ( checkAcl($departmentID) ===false )
    {
        echo getHistoryBackScript( '您无操作权限!' );
        exit;
    }

    $GLOBAL['htmlDefine']['replaceArray']['__DEPARTMENTID__']=$departmentID;
    $GLOBAL['htmlDefine']['replaceArray']['__OTHERFLAG__']=$otherFlag;
    if ( $otherFlag == "0" )
        $GLOBAL['htmlDefine']['replaceArray']['__DEPARTMENTNAME__'] = $GLOBAL['G_DB_OBJ']->getfieldValue("select (select MenuName from treemenu where MenuId=department.menuID) as name from department where id='".$departmentID."'");
    else 
        $GLOBAL['htmlDefine']['replaceArray']['__DEPARTMENTNAME__'] = $GLOBAL['G_DB_OBJ']->getfieldValue("select (select MenuName from treemenu where MenuId=departmentOther.menuID) as name from departmentOther where id='".$departmentID."'");
        
    require_once(ABS_CUR_DIR_MENU_CONF . "../../../kernel/comm/loadModules.php");
    
    $GLOBAL['htmlDefine']['replaceArray']['__FILEBODY__'] = '';
    $GLOBAL['htmlDefine']['replaceArray']['__FILEID__']="";
    $GLOBAL['htmlDefine']['replaceArray']['__SRCFILENAME__'] = '';

        $moduleShowtmpl = loadModules("webPage", $errMsg);
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
