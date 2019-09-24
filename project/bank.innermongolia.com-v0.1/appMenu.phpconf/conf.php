<?php
//web develop require
define('ABS_CUR_DIR_MENU_CONF', dirname(__FILE__).'/');
require_once(ABS_CUR_DIR_MENU_CONF . '../inc/conf.php');
require_once( ABS_CUR_DIR_MENU_CONF.'../../../kernel/inc/checkSession.php' );
require_once( ABS_CUR_DIR_MENU_CONF.'../../../kernel/modules/menu/datastruct/treeDBClass.php' );
require_once( ABS_CUR_DIR_MENU_CONF.'../../../kernel/comm/formCheck.php' );
require_once( ABS_CUR_DIR_MENU_CONF.'../../../kernel/baselib/postPage.php' );

//define( 'DEF_URL', '<a href=../html/login.php>重新登录</a>' );
define('MODULE_NAME',											'菜单管理'	);
define('MODULE_NAME_EN',											'MENU'	);
define('MODULE_NAME_EN_LOW',											'menu'	);

define('ROOT_PATH',											GLOBAL_ROOT_PATH.'/modules/'.MODULE_NAME_EN_LOW.'/'	);

define( 'DEF_LINK', GLOBAL_ROOT_PATH.'modules/mainFrame/blank.php?flag=1&opt=listFlag' );    // The name of the database
define( 'MENU_ADD_SUB', 'menu_add_sub'	);
define( 'MENU_ADD_SUB_SAVE', 'menu_add_sub_save'	);
define( 'MENU_ADD', 'menu_add'			);
define( 'MENU_ADD_SAVE', 'menu_add_save'			);
define( 'MENU_UPD', 'menu_upd'			);
define( 'MENU_UPD_SAVE', 'menu_upd_save'			);
define( 'MENU_DEL_SAVE', 'menu_del_save'			);
define( 'MENU_CLOSE', 'menu_close'			);
//定义菜单模板css路径
global $GLOBAL;
//$GLOBAL['htmlDefine']['tmplPath'] = ABS_CUR_DIR_MENU_CONF."../tmpl/menu.tmpl";
//$tmplOPTPath = ABS_CUR_DIR_MENU_CONF."../tmpl/menuopt.tmpl";

//菜单属性定义
$menu_pic= array(
				'plus_img_0'	=>'../../cssimg/tree_plus.gif',	//中+
				'plus_img_1'	=>'../../cssimg/tree_plus1.gif',	//底+
				'minus_img_0'	=>'../../cssimg/tree_minus.gif',	//中-
				'minus_img_1'	=>'../../cssimg/tree_minusl.gif',	//底-
				'blank_img_0'	=>'../../cssimg/tree_blank.gif',	//中空
				'blank_img_1'	=>'../../cssimg/tree_blank1.gif',	//底空
				'line_img'		=>'../../cssimg/tree_line.gif',		//连接竖线
				'query_img_0'	=>'../../cssimg/info_query.gif',		//未展开图标
				'query_img_1'	=>'../../cssimg/info_query1.gif',		//展开后图标
				'query_img_2'	=>'../../cssimg/info_query2.gif',		//叶子图标
				'css'			=>'../../cssimg/style.css'
			);
$selfMenu = 1;	//1表示显示右键菜单，0表示不显示右键菜单
define( 'RIGHTMENUSTR',"<div id='ie5menu' class='skin0' onMouseover='highlightie5()' onMouseout='lowlightie5()' >
						<div class='menuitems' id='a1' url=''  onClick='jumptoie5();'>新建子项</div>
						<hr>
						<div class='menuitems' id='a2' url=''  onClick='jumptoie5();'>新建项</div>
						<hr>
						<div class='menuitems' id='a3' url='' onClick='jumptoie5();'>修改</div>
						<hr>
						<div class='menuitems' id='a4' url='' onClick=\"javascript:if(confirm('确定要删除吗?'))jumptoie5();\">删除</div>
						" );
define( 'RIGHTMENUOPTSTR',	"<Script Language='javascript'>
<!--
	if (document.all && window.print)
	{
		ie5menu.className = menuskin;
		document.body.onclick = hidemenuie5;
	}
	document.body.oncontextmenu = Click;
	//<!--是否显示右键菜单//-->
</Script>" );



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


if ($opt === "listFlag") {
    require_once(ABS_CUR_DIR_MENU_CONF . "../../../kernel/comm/loadModules.php");
    if ( $_SESSION['userData']['uid'] === 'user1'  )
        $subSqlStr = " and menuID<>214 and MenuPId<>214 and menuID<>200 AND MenuPId<>200 and menuID<>196 AND MenuPId<>196 and menuID<>204 AND MenuPId<>204 and menuID<>212 AND MenuPId<>212";
    else
        $subSqlStr = "";
        
    $tree_class = new treeDBClass(0, $subSqlStr, $influenceID );
    $GLOBAL['htmlDefine']['replaceArray']['__MENUBODY__']=$tree_class->buildTreeHtml();
    $GLOBAL['htmlDefine']['replaceArray']['__RIGHTMENUOPT__']=RIGHTMENUSTR.RIGHTMENUOPTSTR;
    $MenuIDList = $GLOBAL['G_DB_OBJ']->executeSqlMap("select MenuId from webadmin.treemenu where MenuPid=0;");
    $MenuIDListStr="";
    if ($_SESSION['userData']['uid'] === 'user' || $_SESSION['userData']['uid'] === 'user1'  )
    {
        $GLOBAL['htmlDefine']['replaceArray']['__NOUSEFLAGBEGIN__']="<!--";
        $GLOBAL['htmlDefine']['replaceArray']['__NOUSEFLAGEND__']="//-->";
    }
    else
    {
        $GLOBAL['htmlDefine']['replaceArray']['__NOUSEFLAGBEGIN__']="";
        $GLOBAL['htmlDefine']['replaceArray']['__NOUSEFLAGEND__']="";
    }
    foreach ($MenuIDList as  $value)
        $MenuIDListStr .= $value["MenuId"].",";
    $GLOBAL['htmlDefine']['replaceArray']['__NOMENUPIDLIST__'] = substr( $MenuIDListStr,0,-1);
    
    $MenuIDList = $GLOBAL['G_DB_OBJ']->executeSqlMap("select MenuId from webadmin.treemenu where MenuLevel=1;");
    $MenuLevelIDListStr="";
    foreach ($MenuIDList as  $value)
        $MenuIDListStr .= $value["MenuId"].",";
    $GLOBAL['htmlDefine']['replaceArray']['__NOUPDATEPIDLIST__'] = substr( $MenuIDListStr,0,-1);
    
    
    //$GLOBAL['htmlDefine']['replaceArray']['__PIDLIST__']= $GLOBAL['G_DB_OBJ']->getMutiRowFieldValue("select MenuId from webadmin.treemenu where MenuPid=0;");
    //select userkey from test order by id;

    $moduleShowtmpl = loadModules("webPage", $errMsg);
    //print_r( $GLOBAL );
    //require_once($moduleShowtmpl);

}
if ( $opt === "addSubFlagSave")//增加子项后台
{
    $menuID = $_REQUEST['menuID'];
    $post_arr =  new postPage( $_POST );

    $menu_arr = $post_arr->getPostDataArr( );

    $menu_arr['MenuId'] = intval( $menu_arr['MenuId'] );
    $tree_arr = new treeDBClass();
    $ret = $tree_arr->updTreeNode( $menu_arr, MENU_ADD_SUB_SAVE );
    echo getAlertFormLocationJSCode('/appMenu.php?opt=addSubFlag&menuID='.$menuID,"填加成功","","parent.parent.leftFrame.location.reload(true);");
}
if ( $opt === "updFlagSave")//增加子项后台
{
    $menuID = $_REQUEST['menuID'];
    $post_arr =  new postPage( $_POST );
    $menu_arr = $post_arr->getPostDataArr( );
    $menu_arr['MenuId'] = intval( $menu_arr['MenuId'] );
    $tree_arr = new treeDBClass();
    $ret = $tree_arr->updTreeNode( $menu_arr, MENU_UPD_SAVE );
    echo getAlertFormJSCode("修改成功","parent.parent.leftFrame.location.reload(true);");
    exit;
}
if ( $opt === "delFlagSave")//增加子项后台
{
    $menuID = $_REQUEST['menuID'];
	$menu_arr['MenuId'] =  $menuID;
	$tree_arr = new treeDBClass();
	try{$ret = $tree_arr->updTreeNode( $menu_arr, MENU_DEL_SAVE );}
	catch (Exception $e)
	{ 
	    echo getAlertFormJSCode("删除有问题，请联络管理员！(".$e->getMessage().")","parent.parent.leftFrame.location.reload(true);");
	    exit;
	}
	
	
	$fileInfo=$GLOBAL['G_DB_OBJ']->executeSqlMap("select srcFilePath,srcFileName from fileList where menuID='".$menuID."' limit 1;", 1 );

	if ( !Empty( $fileInfo ) )
	{
    	$rootDir = str_replace("/ckfinder/userfiles/","",$appConf['GLOBAL']['uploadDir']);
        $oldRootFilePath = $rootDir.$fileInfo['srcFilePath'];
        if ( !unlink($oldRootFilePath) )
            echo "delete file failed!".$oldRootFilePath."<br>";
        if ( $GLOBAL['G_DB_OBJ']->executeSql("delete from fileList where menuID='".$menuID."';") !== 1 )
        {
            echo getAlertFormJSCode("删除有问题，请联络管理员！","parent.parent.leftFrame.location.reload(true);");
            exit;
        }
	}
    echo getAlertFormJSCode("删除成功","parent.parent.leftFrame.location.reload(true);");
    exit;
}
if ($opt === "addSubFlag") {
    $menuID = $_REQUEST['menuID'];
    if (  !Empty( $GLOBAL['G_DB_OBJ']->getFieldValue("select fileID from webadmin.fileList where menuID='".$menuID."' limit 1;") ) )
    {
        echo getAlertFormJSCode("该结点已经有文章存在，不能创建子目录，请先删除，重新建立为目录后，再创建子目录!");
        exit;
    }

    require_once(ABS_CUR_DIR_MENU_CONF . "../../../kernel/comm/loadModules.php");
    $MenuIDList = $GLOBAL['G_DB_OBJ']->executeSqlMap("select MenuId from webadmin.treemenu where MenuPid=0;");
    $MenuIDListStr="";
    foreach ($MenuIDList as  $value)
        $MenuIDListStr .= $value["MenuId"].",";
    $GLOBAL['htmlDefine']['replaceArray']['__NOMENUPIDLIST__'] = substr( $MenuIDListStr,0,-1);
    $tree_class = new treeDBClass(0, "", $influenceID );
    $GLOBAL['htmlDefine']['replaceArray']['__MENUPATH__']=getTreePath($menuID,"");
    $GLOBAL['htmlDefine']['replaceArray']['__MENULEVEL__'] = $GLOBAL['G_DB_OBJ']->getFieldValue("select MenuLevel from webadmin.treemenu where menuID='".$menuID."' limit 1;");
    $GLOBAL['htmlDefine']['replaceArray']['__MENUNAME__']="";
    $GLOBAL['htmlDefine']['replaceArray']['__MENUID__']=$menuID;
    $GLOBAL['htmlDefine']['replaceArray']['__ID__']="-1";
    $GLOBAL['htmlDefine']['replaceArray']['__SORTVALUE__']=1;
    //select userkey from test order by id;

    $moduleShowtmpl = loadModules("webPage", $errMsg);
}
if ($opt === "delFlag") {
    $menuID = $_REQUEST['menuID'];

    require_once(ABS_CUR_DIR_MENU_CONF . "../../../kernel/comm/loadModules.php");
    $MenuIDList = $GLOBAL['G_DB_OBJ']->executeSqlMap("select MenuId from webadmin.treemenu where MenuPid=0;");
    $MenuIDListStr="";
    foreach ($MenuIDList as  $value)
        $MenuIDListStr .= $value["MenuId"].",";
        $GLOBAL['htmlDefine']['replaceArray']['__NOMENUPIDLIST__'] = substr( $MenuIDListStr,0,-1);
        $tree_class = new treeDBClass(0, "", $influenceID );
        $GLOBAL['htmlDefine']['replaceArray']['__MENUPATH__']=getTreePath($menuID,"");

        $menuArr = $GLOBAL['G_DB_OBJ']->executeSqlMap("select MenuName,MenuType,SortValue from webadmin.treemenu where MenuId=".$menuID,1);


        $GLOBAL['htmlDefine']['replaceArray']['__MENUNAME__']=$menuArr['MenuName'];
        $GLOBAL['htmlDefine']['replaceArray']['__MENUTYPE__']=$menuArr['MenuType'];
        $GLOBAL['htmlDefine']['replaceArray']['__SUBNODENUM__'] = $GLOBAL['G_DB_OBJ']->getFieldValue("select count(MenuId) from webadmin.treemenu where MenuPID='".$menuID."'");
        $GLOBAL['htmlDefine']['replaceArray']['__MENUID__']=$menuID;
        if ( $menuArr['MenuType'] == '目录' )
        {
            $GLOBAL['htmlDefine']['replaceArray']['__DIRECTORY__']='';
            $GLOBAL['htmlDefine']['replaceArray']['__FILE__']='checked';
            $GLOBAL['htmlDefine']['replaceArray']['__LINKADDR__']='/kernel.php?module=mainFrame&app=blank';

        }
        else
        {
            $GLOBAL['htmlDefine']['replaceArray']['__DIRECTORY__']='checked';
            $GLOBAL['htmlDefine']['replaceArray']['__FILE__']='';
            $GLOBAL['htmlDefine']['replaceArray']['__LINKADDR__']='/fileEdit.php?opt=editFlag';
        }
        $GLOBAL['htmlDefine']['replaceArray']['__ID__']="-1";
        $GLOBAL['htmlDefine']['replaceArray']['__SORTVALUE__']=$menuArr['SortValue'];;
        //select userkey from test order by id;

        $moduleShowtmpl = loadModules("webPage", $errMsg);
}
if ($opt === "updFlag") {
    $menuID = $_REQUEST['menuID'];

    require_once(ABS_CUR_DIR_MENU_CONF . "../../../kernel/comm/loadModules.php");
    $MenuIDList = $GLOBAL['G_DB_OBJ']->executeSqlMap("select MenuId from webadmin.treemenu where MenuPid=0;");
    $MenuIDListStr="";
    foreach ($MenuIDList as  $value)
        $MenuIDListStr .= $value["MenuId"].",";
    $GLOBAL['htmlDefine']['replaceArray']['__NOMENUPIDLIST__'] = substr( $MenuIDListStr,0,-1);
    $tree_class = new treeDBClass(0, "", $influenceID );
    $GLOBAL['htmlDefine']['replaceArray']['__MENUPATH__']=getTreePath($menuID,"");

    $menuArr = $GLOBAL['G_DB_OBJ']->executeSqlMap("select MenuName,MenuType,SortValue,MenuLink from webadmin.treemenu where MenuId=".$menuID,1);

    
    $GLOBAL['htmlDefine']['replaceArray']['__MENUNAME__']=$menuArr['MenuName'];
    $GLOBAL['htmlDefine']['replaceArray']['__MENUID__']=$menuID;
    $GLOBAL['htmlDefine']['replaceArray']['__LINKADDR__']=$menuArr['MenuLink'];
    if ( $menuArr['MenuLink'] == '/kernel.php?module=mainFrame&app=blank' )
    {
        $GLOBAL['htmlDefine']['replaceArray']['__DIRECTORY__']='checked';
        $GLOBAL['htmlDefine']['replaceArray']['__FILE__']='';
    }
    else
    {
        $GLOBAL['htmlDefine']['replaceArray']['__DIRECTORY__']='';
        $GLOBAL['htmlDefine']['replaceArray']['__FILE__']='checked';
    }
    $GLOBAL['htmlDefine']['replaceArray']['__ID__']="-1";
    $GLOBAL['htmlDefine']['replaceArray']['__SORTVALUE__']=$menuArr['SortValue'];;
    //select userkey from test order by id;

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
        'info' => '删除成功'
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
