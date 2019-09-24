<?php
define('ABS_CUR_LOGIN_DIR', dirname(__FILE__) . '/');
require_once(ABS_CUR_LOGIN_DIR.'../inc/conf.php');
require_once(ABS_CUR_LOGIN_DIR.'../../../kernel/inc/checkSession.php');
require_once( ABS_CUR_LOGIN_DIR.'../../../kernel/comm/formCheck.php' );
global $GLOBAL;

$opt = $_REQUEST['opt'];

//连接新的数据库，比如:host=>localhost,port=3306;等
//$GLOBAL['G_DB_OBJ'] = new DBBaseClass();
//参数含serverinfo和dbinfo
//表test在sales数据库里

//$GLOBAL['G_DB_OBJ']->initDBPara($GLOBAL['serverInfo']['dbInfo']);

if ($opt === "listFlag") {
    $searchType=!Empty($_REQUEST['searchType'])?$_REQUEST['searchType']:'';
    $key1=!Empty($_REQUEST['key1'])?$_REQUEST['key1']:'';
    $key2=!Empty($_REQUEST['key2'])?$_REQUEST['key2']:'';
    $key3=!Empty($_REQUEST['key3'])?$_REQUEST['key3']:'';
    $customSql = "";
    $searchUrl="";
    $markArray=array();
    if ( !Empty( $key1 ) )
    {
            $searchStr1 = " srcFileName like '%".$key1."%' ";
            array_push( $markArray, $key1 );
    }
    else 
    {
            $searchStr1="";
    }
    if ( !Empty( $key2 ) )
    {
            $searchStr2 = " srcFileName like '%".$key2."%' ";
            array_push( $markArray, $key2 );
    }
    else 
            $searchStr2="";
    if ( !Empty( $key3 ) )
    {
        array_push( $markArray, $key3 );
        $searchStr3 = " srcFileName like '%".$key2."%' ";
    }
    else
        $searchStr3="";
    $subSql = "";
    if (!Empty( $searchStr1 ) )
    {
        $searchUrl="key1=".$key1;
        $subSql =  $searchStr1;
        $customSql = "replace(srcFileName, '".$key1."','<font color=\"red\">".$key1."</font>')";
    }
    else 
        $customSql="";
    if (!Empty( $searchStr2 ) )
    {
        if ( !Empty( $subSql ) )
        {
            $searchUrl=$searchUrl."&key2=".$key2;
            $subSql = $subSql." and ".$searchStr2;
            $customSql = "replace(".$customSql.", '".$key2."','<font color=\"red\">".$key2."</font>')";
        }
        else 
        {
            $searchUrl="key2=".$key2;
            $subSql = $searchStr2;
            $customSql = "replace(srcFileName, '".$key2."','<font color=\"red\">".$key2."</font>')";
        }
    }
    if (!Empty( $searchStr3 ) )
    {
        if ( !Empty( $subSql ) )
        {
            $searchUrl=$searchUrl."&key3=".$key3;
            $subSql = $subSql." and ".$searchStr3;
            $customSql = "replace(".$customSql.", '".$key3."','<font color=\"red\">".$key3."</font>')";
        }
        else
        {
            $customSql = "replace(srcFileName, '".$key2."','<font color=\"red\">".$key2."</font>')";
            $searchUrl="key3=".$key3;
            $subSql = $searchStr3;
        }
    }
    if ( Empty( $customSql ))
        $customSql="srcFileName";
    if ( !Empty( $searchType ) )
    {
        if ( $searchType == "body" )
            $subSql = str_replace(" srcFileName ", " fileBody ", $subSql );
    }

    if ( $_SESSION['userData']['uid'] === 'user1'  )
        if ( !Empty( $subSql ) )
            $subSql = $subSql." and menuID not in( select menuID from treemenu where  MenuPId in(214,200,196,204,212))";
        else 
            $subSql = " menuID not in( select menuID from treemenu where  MenuPId in(214,200,196,204,212))";

    $GLOBAL['modulesInfo']['userKey'] = array(
        'fileID' => '__FILEID__',
        $customSql=> '__SRCFILENAME__',
        'srcFilePath'=> '__SRCFILEPATH__',
        '(select MenuName from webadmin.treemenu where MenuId = (select MenuPId from webadmin.treemenu where MenuId=fileList.menuID limit 1) limit 1)'=>'__FILELEVEL2__',
        '(select MenuName from webadmin.treemenu where MenuId =(select MenuPid from webadmin.treemenu where MenuId = (select MenuPId from webadmin.treemenu where MenuId=fileList.menuID limit 1) limit 1))'=>'__FILELEVEL1__',        '(select MenuName from webadmin.treemenu where MenuId=fileList.menuID limit 1)' => '__CLUSTERNAME__',
        'regTime' => '__REGTIME__'
    );
    $GLOBAL['htmlDefine']['replaceArray']['__KEY1__'] = $key1;
    $GLOBAL['htmlDefine']['replaceArray']['__KEY2__'] = $key2;
    $GLOBAL['htmlDefine']['replaceArray']['__KEY3__'] = $key3;
    
    $GLOBAL['modulesInfo']['tableName'] = 'fileList';//这个地方需要修改
    $GLOBAL['modulesInfo']['orderSubSql'] = ' order by fileID';
    $GLOBAL['modulesInfo']['subSql'] = $subSql;
    $GLOBAL[ 'modulesInfo' ][ 'buttomStr' ]=str_replace("__SEARCHLIST__",$searchUrl,$GLOBAL[ 'modulesInfo' ][ 'buttomStr' ]);
    $GLOBAL['htmlDefine']['replaceArray']['__SEARCHTYPE__'] = $searchType;
    
    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
    $moduleShowtmpl = loadModules("webPage", $errMsg);
}

if ($opt === "detail") {
    $searchType=!Empty($_REQUEST['searchType'])?$_REQUEST['searchType']:'';
    $key1=!Empty($_REQUEST['key1'])?$_REQUEST['key1']:'';
    $key2=!Empty($_REQUEST['key2'])?$_REQUEST['key2']:'';
    $key3=!Empty($_REQUEST['key3'])?$_REQUEST['key3']:'';
    $fileID=$_REQUEST['fileID'];
    $id = $_REQUEST["id"];
    $info = $GLOBAL['G_DB_OBJ']->executeSql("select fileID as __FILEID__,menuID, srcFileName as __SRCFILENAME__, srcFilePath as __SRCFILEPATH__, fileBody as __FILEBODY__ from fileList where fileID = '".$fileID."';");
    $GLOBAL['htmlDefine']['replaceArray']['__KEY1__']=$key1;
    $GLOBAL['htmlDefine']['replaceArray']['__KEY2__']=$key2;
    $GLOBAL['htmlDefine']['replaceArray']['__KEY3__']=$key3;
    
    if (substr( $info["__SRCFILEPATH__"], strrpos($info["__SRCFILEPATH__"],".")+1 ) == "pdf" )
    {
        $GLOBAL['htmlDefine']['replaceArray']['__PDFITEMSTYLE__']="block";
        $GLOBAL['htmlDefine']['replaceArray']['__PDFJS__']="$(function () {PDFObject.embed('".$info["__SRCFILEPATH__"]."', \"#pdfitem\");})";
        $GLOBAL['htmlDefine']['replaceArray']['__DOCSTYLE__']="none";
    }
    else
    {
    
        $GLOBAL['htmlDefine']['replaceArray']['__DOCSTYLE__']="block";
        $GLOBAL['htmlDefine']['replaceArray']['__PDFITEMSTYLE__']="none";
        $GLOBAL['htmlDefine']['replaceArray']['__PDFJS__']="";
    }
    
    
    $GLOBAL['htmlDefine']['replaceArray']['__SEARCHTYPE__']=$searchType;
    if (!Empty( $info ) )
        $GLOBAL['htmlDefine']['replaceArray']=array_merge($GLOBAL['htmlDefine']['replaceArray'],$info);
    $GLOBAL['htmlDefine']['replaceArray']['__TREEPATH__']=getTreePath($info['menuID'],'');

    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
    $moduleShowtmpl = loadModules("webPage", $errMsg);

    //print_r( $GLOBAL );
    //require_once($moduleShowtmpl);
}
//参考配置文件
$GLOBAL['modulesArray'][GLOBAL_ROOT_PATH . '/fileList.php'] = array(
    'default' => array(
        'to_path' => GLOBAL_ROOT_PATH . 'fileList.php',
        'to_query' => 'opt=listFlag',
        'type' => 'reload',
        'info' => '删除服务器成功'
    ),
    'opt=search'=>array(
        'to_path' => GLOBAL_ROOT_PATH . 'fileList.php',
        'to_query' => 'opt=search',
        'type' => 'reload'
    )
);
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


?>	