<?php
define('ABS_CUR_LOGIN_DIR', dirname(__FILE__) . '/');
require_once(ABS_CUR_LOGIN_DIR . '../inc/conf.php');
require_once(ABS_CUR_LOGIN_DIR . '../../../kernel/inc/checkSession.php');
global $GLOBAL;

$opt = $_REQUEST['opt'];

//连接新的数据库，比如:host=>localhost,port=3306;等
//$GLOBAL['G_DB_OBJ'] = new DBBaseClass();
//参数含serverinfo和dbinfo
//表test在sales数据库里

//$GLOBAL['G_DB_OBJ']->initDBPara($GLOBAL['serverInfo']['dbInfo']);
/*
     <dd>
    <div class="title">
    <span><img src="images/leftico01.png" /></span>管理信息
    </div>
    	<ul class="menuson">
        <li><cite></cite><a href="index.html" target="rightFrame">首页模版</a><i></i></li>
        <li class="active"><cite></cite><a href="right.html" target="rightFrame">数据列表</a><i></i></li>
        <li><cite></cite><a href="imgtable.html" target="rightFrame">图片数据表</a><i></i></li>
        <li><cite></cite><a href="form.html" target="rightFrame">添加编辑</a><i></i></li>
        <li><cite></cite><a href="imglist.html" target="rightFrame">图片列表</a><i></i></li>
        <li><cite></cite><a href="imglist1.html" target="rightFrame">自定义</a><i></i></li>
        <li><cite></cite><a href="tools.html" target="rightFrame">常用工具</a><i></i></li>
        <li><cite></cite><a href="filelist.html" target="rightFrame">信息管理</a><i></i></li>
        <li><cite></cite><a href="tab.html" target="rightFrame">Tab页</a><i></i></li>
        <li><cite></cite><a href="error.html" target="rightFrame">404页面</a><i></i></li>
        </ul>    
    </dd>
 */
function getMenuLevel0($menuName,$ddList,$display="display:none")
{
    return '<div class="lefttop"><span></span>'.$menuName.'</div>
<dl class="leftmenu" style="width:370px;'.$display.';">'.$ddList.'</dl>';
}
function getMenuLevel1($menuName)
{
    return '<div class="title"><span><img src="images/leftico01.png" /></span>'.$menuName.'</div>';
}
function getMenuLevel2($menuName,$url,$activate=FALSE)
{
    if ( $activate )
        return '<li><cite></cite><a href="'.$url.'" target="mainFrame">'.$menuName.'</a><i></i></li>';
    else 
        return '<li><cite></cite><a href="'.$url.'" target="mainFrame">'.$menuName.'</a><i></i></li>';
        
}
if ($opt === "listFlag") {
    
    
    $info = $GLOBAL['G_DB_OBJ']->executeSqlMap( "select id as bankID,bankName from banklist where bankLevel='0' limit 1",1);
    $bankName = $info["bankName"];
    $bankID = $info["bankID"];
    $htmlStr = "";
    $departmentList = $GLOBAL['G_DB_OBJ']->executeSqlMap( 'select id,(select MenuName from treemenu where MenuId=department.menuID) as name,userID from department order by sortValue,id asc' );
    for ( $i=0; $i < count( $departmentList ); $i++ )
    {
        $htmlStr.="<dd>";
        $htmlStr .= getMenuLevel1( $departmentList[$i]['name'] );
        $htmlStr .='<ul class="menuson" style="display:none">';
        $workFlowList = $GLOBAL['G_DB_OBJ']->executeSqlMap("select fileID,name,srcFileName from fileListOther where departmentID='".$departmentList[$i]['id']."' and fileType='workFlow' and bankID='".$bankID."'");
        if ( checkAcl($departmentList[$i]['id']) )
            $htmlStr .= getMenuLevel2("填加流程图", "/workFlow.php?opt=addFlag&departmentID=".$departmentList[$i]['id']."&otherFlag=0");
        for ( $j = 0; $j < count( $workFlowList ); $j++ )
        {
            $htmlStr .= getMenuLevel2( $workFlowList[$j]['name'],"/workFlow.php?opt=readFlag&departmentID=".$departmentList[$i]['id']."&fileID=".$workFlowList[$j]['fileID']."&otherFlag=0");
        }
        $htmlStr .= '</ul>';
        $htmlStr .= "</dd>";
}
    $menuHtmlStr .= getMenuLevel0( $bankName, $htmlStr, "display:block" );
    
    
    $bankList = $GLOBAL['G_DB_OBJ']->executeSqlMap("select id as bankID,bankName from banklist where bankLevel='1'");
    while ( current( $bankList ) !== false )
    {
        $v1 = current( $bankList );
        $bankName = $v1["bankName"];
        $bankID = $v1["bankID"];
        $departmentList = $GLOBAL['G_DB_OBJ']->executeSqlMap( "select id,(select MenuName from treemenu where MenuId=departmentOther.menuID) as name,userID from departmentOther where bankID='".$bankID."' order by sortValue,id asc" );
        $htmlStr = "";
        for ( $i=0; $i < count( $departmentList ); $i++ )
        {
            $htmlStr.="<dd>";
            $htmlStr .= getMenuLevel1( $departmentList[$i]['name'] );
            $htmlStr .='<ul class="menuson" style="display:none">';
            $workFlowList = $GLOBAL['G_DB_OBJ']->executeSqlMap("select fileID,name,srcFileName from fileListOther where departmentID='".$departmentList[$i]['id']."' and fileType='workFlow' and bankID='0'");

            if ( checkAcl($departmentList[$i]['id']) )
                $htmlStr .= getMenuLevel2("填加流程图", "/workFlow.php?opt=addFlag&departmentID=".$departmentList[$i]['id']."&otherFlag=1");
            for ( $j = 0; $j < count( $workFlowList ); $j++ )
            {
                $htmlStr .= getMenuLevel2( $workFlowList[$j]['name'],"/workFlow.php?opt=readFlag&departmentID=".$departmentList[$i]['id']."&fileID=".$workFlowList[$j]['fileID']."&otherFlag=1");
            }
            $htmlStr .= '</ul>';
            $htmlStr .= "</dd>";
        }
        $menuHtmlStr .= getMenuLevel0( $bankName, $htmlStr );
        next( $bankList );
    }
    
    
    

    $GLOBAL['htmlDefine']['replaceArray'] = array_merge($GLOBAL['htmlDefine']['replaceArray'], array(
        '__MENUBODY__' => $menuHtmlStr
    ));
    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
    $moduleShowtmpl = loadModules("webPage", $errMsg);
	//print_r( $GLOBAL );
	//require_once($moduleShowtmpl);
	
} 
//参考配置文件
$GLOBAL['modulesArray'][GLOBAL_ROOT_PATH . '/taskManage.php'] = array(
    'default' => array(
        'to_path' => GLOBAL_ROOT_PATH . 'taskManage.php',
        'to_query' => 'opt=listFlag',
        'type' => 'reload',
        'info' => '删除任务成功'
    ),
    'opt=addFlag' => array(
        'to_path' => GLOBAL_ROOT_PATH . 'taskManage.php',
        'to_query' => 'opt=listFlag',
        'type' => 'reload',
        'info' => '添加任务成功'
    ),
    'opt=editFlag' => array(
        'to_path' => GLOBAL_ROOT_PATH . 'taskManage.php',
        'to_query' => 'opt=listFlag',
        'type' => 'reload',
        'info' => '修改任务成功'
    )
);



?>	