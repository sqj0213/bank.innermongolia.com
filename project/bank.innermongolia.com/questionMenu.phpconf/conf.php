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
$userID=$GLOBAL["runData"]["userData"]["id"];
if ( whoami( $userID ) === "巴市支行科长" )
    $menuStr = '<vv><ul class="menuson">
        <li><cite></cite><a href="/question.php?opt=listFlag1tab" target="mainFrame">待审核台帐</a><i></i></li>
        <li><cite></cite><a href="/question.php?opt=listFlag2tab" target="mainFrame">待销号台帐</a><i></i></li>
        <li><cite></cite><a href="/question.php?opt=listFlag3tab" target="mainFrame">被驳回台帐</a><i></i></li>
        <li><cite></cite><a href="/question.php?opt=listFlag4tab" target="mainFrame">已销号台帐</a><i></i></li>
        </ul></vv>';
elseif (whoami( $userID ) === "巴市支行科员"||whoami( $userID ) === "旗县支行科长" )
    $menuStr = '<vv><ul class="menuson">
        <li><cite></cite><a href="/question.php?opt=addFlag" target="mainFrame">新建台帐</a><i></i></li>
        <li><cite></cite><a href="/question.php?opt=listFlag0" target="mainFrame">台帐草稿</a><i></i></li>
        <li><cite></cite><a href="/question.php?opt=listFlag1" target="mainFrame">待审核台帐</a><i></i></li>
        <li><cite></cite><a href="/question.php?opt=listFlag2" target="mainFrame">待销号台帐</a><i></i></li>
        <li><cite></cite><a href="/question.php?opt=listFlag3" target="mainFrame">被驳回台帐</a><i></i></li>
        <li><cite></cite><a href="/question.php?opt=listFlag4" target="mainFrame">已销号台帐</a><i></i></li>
        </ul></vv>';
else 
{
    $menuStr = '<vv><ul class="menuson">
        <li><cite></cite><a href="/question.php?opt=listFlag1" target="mainFrame">待审核台帐</a><i></i></li>
        <li><cite></cite><a href="/question.php?opt=listFlag2" target="mainFrame">待销号台帐</a><i></i></li>
        <li><cite></cite><a href="/question.php?opt=listFlag3" target="mainFrame">被驳回台帐</a><i></i></li>
        <li><cite></cite><a href="/question.php?opt=listFlag4" target="mainFrame">已销号台帐</a><i></i></li>
        </ul></vv>';
}
function getMenuLevel0($menuName,$ddList,$display="display:none")
{
    return '<div class="lefttop"><span></span>'.$menuName.'</div>
<dl class="leftmenu" style="width:370px;'.$display.';">'.$ddList.'</dl>';
}
function getMenuLevel1($url,$menuName)
{
    return '<li><cite></cite><a href="'.$url.'" target="mainFrame">'.$menuName.'</a><i></i></li>';
}
function getMenuLevel2($menuName,$url,$activate=FALSE)
{
    if ( $activate )
        return '<li><cite></cite><a href="'.$url.'" target="mainFrame">'.$menuName.'</a><i></i></li>';
    else
        return '<li><cite></cite><a href="'.$url.'" target="mainFrame">'.$menuName.'</a><i></i></li>';

}
if ($opt === "listFlag") {
    
    $menuHtmlStr="";
    $menuHtmlStr .= getMenuLevel0( "我的台帐", $menuStr, "display:block" );
	$info = $GLOBAL['G_DB_OBJ']->executeSqlMap( "select id as bankID,bankName from banklist where bankLevel='0' limit 1",1);
	$bankName = $info["bankName"];
	$bankID = $info["bankID"];
    $htmlStr = "";
    $departmentList = $GLOBAL['G_DB_OBJ']->executeSqlMap( 'select id,(select MenuName from treemenu where MenuId=department.menuID) as name,userID from department order by sortValue,id asc' );
    //$htmlStr .= "<dd><ul class="menuson">";
    for ( $i=0; $i < count( $departmentList ); $i++ )
    {
	   $htmlStr.="<dd>";
	   $htmlStr .='<ul class="menuson">';
	   $htmlStr .= getMenuLevel1( "/question.php?opt=listFlag&departmentID=".$departmentList[$i]['id']."&bankID=".$bankID,$departmentList[$i]['name'] );
	   

	   /*
        $resiponsibilityList = $GLOBAL['G_DB_OBJ']->executeSqlMap( "select id,name from responsibility where departmentID='".$departmentList[$i]['id']."' and bankID='".$bankID."' order by id asc" );
        if ( checkAcl($departmentList[$i]['id']) )
            $htmlStr .= getMenuLevel2( "填加岗位", "/department.php?opt=addResponsibilityFlag&departmentID=".$departmentList[$i]['id']."&otherFlag=0" );
        if ( $i == 0 )
            $htmlStr .= getMenuLevel2( "科室职责", "/department.php?opt=detail&departmentID=".$departmentList[$i]['id']."&otherFlag=0",TRUE );
        else
            $htmlStr .= getMenuLevel2( "科室职责", "/department.php?opt=detail&departmentID=".$departmentList[$i]['id']."&otherFlag=0" );
            
        for ( $j = 0; $j < count( $resiponsibilityList ); $j++ )
        {
            $htmlStr .= getMenuLevel2( $resiponsibilityList[$j]['name'],"/department.php?opt=detail&departmentID=".$departmentList[$i]['id']."&responsibilityID=".$resiponsibilityList[$j]['id']."&otherFlag=0" );   
        }
        */
        $htmlStr .= '</ul>';
        $htmlStr .= "</dd>";
    }
    $menuHtmlStr .= getMenuLevel0( $bankName, $htmlStr, "display:none" );
    

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
            $htmlStr .='<ul class="menuson">';
            $htmlStr .= getMenuLevel1( "/question.php?opt=listFlag&departmentID=".$departmentList[$i]['id']."&bankID=".$bankID,$departmentList[$i]['name'] );
            

            /*
            $resiponsibilityList = $GLOBAL['G_DB_OBJ']->executeSqlMap( "select id,name from responsibility where departmentID='".$departmentList[$i]['id']."' and bankID='0' order by id asc" );
            if ( checkAcl($departmentList[$i]['id']) )
                $htmlStr .= getMenuLevel2( "填加岗位", "/department.php?opt=addResponsibilityFlag&departmentID=".$departmentList[$i]['id']."&otherFlag=1" );
            if ( $i == 0 )
                $htmlStr .= getMenuLevel2( "科室职责", "/department.php?opt=detail&departmentID=".$departmentList[$i]['id']."&otherFlag=1" );
            else
                $htmlStr .= getMenuLevel2( "科室职责", "/department.php?opt=detail&departmentID=".$departmentList[$i]['id']."&otherFlag=1" );

            for ( $j = 0; $j < count( $resiponsibilityList ); $j++ )
            {
                $htmlStr .= getMenuLevel2( $resiponsibilityList[$j]['name'],"/department.php?opt=detail&departmentID=".$departmentList[$i]['id']."&responsibilityID=".$resiponsibilityList[$j]['id']."&otherFlag=1" );
            }
            */
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
}
function whoami( $userID=0 )
{
    global $GLOBAL;
    if ( !Empty( $GLOBAL["G_DB_OBJ"]->getFieldValue( "select id from departmentOther where userID='".$userID."';" ) ) )
        return "旗县支行科长";
    if ( !Empty( $GLOBAL["G_DB_OBJ"]->getFieldValue( "select id from departmentOther where viewUserID='".$userID."';" ) ) )
        return "旗县支行科员";
    $ret = $GLOBAL["G_DB_OBJ"]->executeSqlMap( "select id,(select bankLevel from banklist where banklist.id=leader.bankID limit 1) as bankLevel from leader where userID='".$userID."';",1 );
    if ( !Empty( $ret ) )
    {
        if ( $ret["bankLevel"] == "1" )
            return "旗县支行领导";
        else
            return "巴市支行领导";
    }
    if ( !Empty( $GLOBAL["G_DB_OBJ"]->getFieldValue( "select id from department where userID='".$userID."';" ) ) )
        return "巴市支行科长";
    if ( !Empty( $GLOBAL["G_DB_OBJ"]->getFieldValue( "select id from department where viewUserID='".$userID."';" ) ) )
        return "巴市支行科员";
    $ret = $GLOBAL["G_DB_OBJ"]->executeSqlMap( "select id,bankLevel from banklist where userID='".$userID."';", 1 );
    if ( !Empty( $ret  ) )
    {
        if ( $ret["bankLevel"] == "1" )
            return "旗县全局帐号";
        else
            return "巴市支行全局帐号";
    }
    if ( $GLOBAL["G_DB_OBJ"]->getFieldValue( "select uid from user where id='".$userID."';" ) == "admin" )
        return "超级管事员";
    return "未知帐号";
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