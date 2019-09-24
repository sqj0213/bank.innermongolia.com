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
    $departmentList = $GLOBAL['G_DB_OBJ']->executeSqlMap('select id,(select MenuName from treemenu where MenuId=department.menuID) as name,note,userID from department order by sortValue,id asc');
    //print_r( $departmentList );
	//select userkey from test order by id;
    $htmlStr="";
    for ( $i=0; $i < count( $departmentList ); $i++ )
    {
	   $htmlStr.="<dd>";
	   $htmlStr .= getMenuLevel1($departmentList[$i]['name']);
	   $htmlStr .='<ul class="menuson" style="display:none">';
        $resiponsibilityList = $GLOBAL['G_DB_OBJ']->executeSqlMap("select id,name from responsibility where departmentID='".$departmentList[$i]['id']."' order by id asc");
        if ( checkAcl($departmentList[$i]['id']) )
            $htmlStr .= getMenuLevel2("填加岗位", "/department.php?opt=addResponsibilityFlag&departmentID=".$departmentList[$i]['id']);
        if ( $i == 0 )
            $htmlStr .= getMenuLevel2("科室职责", "/department.php?opt=detail&departmentID=".$departmentList[$i]['id'],TRUE);
        else
            $htmlStr .= getMenuLevel2("科室职责", "/department.php?opt=detail&departmentID=".$departmentList[$i]['id']);
            
        for ( $j = 0; $j < count( $resiponsibilityList ); $j++ )
        {
            $htmlStr .= getMenuLevel2( $resiponsibilityList[$j]['name'],"/department.php?opt=detail&departmentID=".$departmentList[$i]['id']."&responsibilityID=".$resiponsibilityList[$j]['id']);   
        }
        $htmlStr .= '</ul>';
        $htmlStr .= "</dd>";
    }

    $GLOBAL['htmlDefine']['replaceArray'] = array_merge($GLOBAL['htmlDefine']['replaceArray'], array(
        '__MENUBODY__' => $htmlStr
    ));
    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
    $moduleShowtmpl = loadModules("webPage", $errMsg);
	//print_r( $GLOBAL );
	//require_once($moduleShowtmpl);
	
} else if ($opt === "addResponsibilityFlag") {
	//静态页面中需要注意，input框的name属性需要按照规则命名
    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
    $departmentID=$_GET['departmentID'];

    if ( checkAcl($departmentID) ===false )
    {
        echo getHistoryBackScript( '您无操作权限!' );
        exit;
    }

    $GLOBAL['htmlDefine']['replaceArray']['__DEPARTMENTNAME__']=$GLOBAL['G_DB_OBJ']->getFieldValue( "select (select MenuName from treemenu where MenuId=department.menuID) as name from department where id ='".$departmentID."' limit 1" );
    $GLOBAL['htmlDefine']['replaceArray']['__DEPARTMENTID__']=$departmentID;
    $moduleShowtmpl = loadModules("webPage", $errMsg);
	//require_once($moduleShowtmpl);
	
}else if ($opt === "addResponsibilityFlagSave") {
    //静态页面中需要注意，input框的name属性需要按照规则命名
    $departmentID = $_GET['departmentID'];
    $name = $_POST["name_岗位名称_textarea_1_20_1_1"];
    $note = $_POST["note_岗位职责_textarea_1_4096_1_1"];
    if ( Empty( $name ) || Empty( $note ) )
    {
        echo getHistoryBackScript( '岗位名称与岗位职责不能为空!' );
        exit;   
    }
    $sql = "insert into responsibility ( name, note, departmentID) values('".$name."','".$note."','".$departmentID."')";

    
    if ( $GLOBAL['G_DB_OBJ']->executeSql( $sql ) === 1 )
    {

                echo getWinReload_parent( '/department.php?&opt=detail&departmentID='.$departmentID, '岗位职责填加成功!' );
                exit;
    }
    else 
    {
        echo getHistoryBackScript( '岗位职责填加失败,请联系管理员!' );
        exit;
        
    }
    //require_once($moduleShowtmpl);

}else if ($opt === "detail") {
    //静态页面中需要注意，input框的name属性需要按照规则命名
    $departmentID = $_GET['departmentID'];
    $responsibilityID = isset($_GET['responsibilityID'])?$_GET['responsibilityID']:0;
    $department = $GLOBAL['G_DB_OBJ']->executeSql("select id as __DEPARTMENTID__, (select MenuName from treemenu where MenuId=department.menuID) as __DEPARTMENTNAME__,note as __DEPARTMENTNOTE__ from department where id='".$departmentID."'");

    $GLOBAL['modulesInfo']['userKey'] = array(
        'id' => '__RESPONSIBILITYID__',
        'name'=> '__RESPONSIBILITYNAME__',
        'note'=> '__RESPONSIBILITYNOTE__'
    );
    $GLOBAL['htmlDefine']['replaceArray'] = array_merge($GLOBAL['htmlDefine']['replaceArray'],$department);
    
    $GLOBAL['modulesInfo']['tableName'] = 'responsibility';//这个地方需要修改
    $GLOBAL['modulesInfo']['subSql'] = "departmentID='".$departmentID."'";
    $GLOBAL['modulesInfo']['orderSubSql'] = ' order by id asc';
    /*
    $GLOBAL['htmlDefine']['replaceArray'] = array_merge($GLOBAL['htmlDefine']['replaceArray'], array(
        '__MENUBODY__' => $htmlStr
    ));
    */
    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
    $moduleShowtmpl = loadModules("webPage", $errMsg);

}else if ($opt === "editResponsibilityFlag") {
	//静态页面中需要注意，input框的name属性需要按照规则命名
    $responsibilityID = $_REQUEST["responsibilityID"];
    $departmentID = $_REQUEST["departmentID"];
    if ( checkAcl($departmentID) ===false )
    {
        echo getHistoryBackScript( '您无操作权限!' );
        exit;
    }

    $info = $GLOBAL['G_DB_OBJ']->executeSql("select id as __RESPONSIBILITYID__,name as __RESPONSIBILITYNAME__,note as __RESPONSIBILITYNOTE__,departmentID as __DEPARTMENTID__ from responsibility where id = '".$responsibilityID."'");
    $GLOBAL['htmlDefine']['replaceArray']['__DEPARTMENTNAME__'] = $GLOBAL['G_DB_OBJ']->getFieldValue("select (select MenuName from treemenu where MenuId=department.menuID) as name from department where id='".$departmentID."'");
    if ($info != null) {
        $GLOBAL['htmlDefine']['replaceArray'] = array_merge($GLOBAL['htmlDefine']['replaceArray'], $info);
    }

    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
    $moduleShowtmpl = loadModules("webPage", $errMsg);
	//require_once($moduleShowtmpl);
	
}else if ($opt === "editResponsibilityFlagSave") {
    //静态页面中需要注意，input框的name属性需要按照规则命名
    //静态页面中需要注意，input框的name属性需要按照规则命名
    $departmentID = $_GET['departmentID'];
    $responsibilityID = $_GET['responsibilityID'];
    $name = $_POST["name_岗位名称_textarea_1_20_1_1"];
    $note = $_POST["note_岗位职责_textarea_1_4096_1_1"];
    if ( Empty( $name ) || Empty( $note ) )
    {
        echo getHistoryBackScript( '岗位名称与岗位职责不能为空!' );
        exit;
    }
    $sql = "update responsibility set name ='".$name."',note='".$note."' where id='".$responsibilityID."'";
    
    if ( $GLOBAL['G_DB_OBJ']->executeSql( $sql ) === 1 )
    {
        echo getWinReload_parent( '/department.php?&opt=detail&departmentID='.$departmentID.'&responsibilityID='.$responsibilityID, '职责修改成功!' );
        exit;
    }
    else
    {
        echo getHistoryBackScript( '职责修改失败,请联系管理员!' );
        exit;
    
    }
}else if ($opt === "editDepartmentFlag") {
	//静态页面中需要注意，input框的name属性需要按照规则命名
    $responsibilityID = $_REQUEST["responsibilityID"];
    $departmentID = $_REQUEST["departmentID"];
    if ( checkAcl($departmentID) ===false )
    {
        echo getHistoryBackScript( '您无操作权限!' );
        exit;
    }
    $info = $GLOBAL['G_DB_OBJ']->executeSql("select id as __DEPARTMENTID__,(select MenuName from treemenu where MenuId=department.menuID) as __DEPARTMENTNAME__,note as __DEPARTMENTNOTE__ from department where id = '".$departmentID."'");

    if ($info != null) {
        $GLOBAL['htmlDefine']['replaceArray'] = array_merge($GLOBAL['htmlDefine']['replaceArray'], $info);
    }

    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
    $moduleShowtmpl = loadModules("webPage", $errMsg);
	//require_once($moduleShowtmpl);
	
}else if ($opt === "editDepartmentFlagSave") {
    //静态页面中需要注意，input框的name属性需要按照规则命名
    //静态页面中需要注意，input框的name属性需要按照规则命名
    $departmentID = $_GET['departmentID'];
    $note = $_POST["note_部门职责_textarea_1_9012_1_1"];
    if (  Empty( $note ) )
    {
        echo getHistoryBackScript( '科室职责不能为空!' );
        exit;
    }
    $sql = "update department set note='".$note."' where id='".$departmentID."'";
    
    if ( $GLOBAL['G_DB_OBJ']->executeSql( $sql ) === 1 )
    {
    
        echo getWinReload_parent( '/department.php?&opt=detail&departmentID='.$departmentID, '职责修改成功!' );
        exit;
    }
    else
    {
        echo getHistoryBackScript( '职责修改失败,请联系管理员!' );
        exit;
    
    }
}
else if ($opt === "delFlag") {
	//静态页面中需要注意，input框的name属性需要按照规则命名
    $responsibilityID = $_REQUEST["responsibilityID"];
    $departmentID = $_REQUEST["departmentID"];
    if ( checkAcl($departmentID) ===false )
    {
        echo getHistoryBackScript( '您无操作权限!' );
        exit;
    }
    $sql="delete from responsibility where id='".$responsibilityID."' limit 1";
    if ( $GLOBAL['G_DB_OBJ']->executeSql( $sql ) ===  1 )
    {
        echo getWinReload_parent( '/department.php?&opt=detail&departmentID='.$departmentID, '岗位职责删除成功!' );
        exit;
    }else
    {
        echo getHistoryBackScript( '部门修改失败,请联系管理员3!' );
        exit;
    }
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