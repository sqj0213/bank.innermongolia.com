<?php

define( 'ABS_CUR_DIR_PROJECT_LOGIN', dirname(__FILE__).'/' );
require_once(ABS_CUR_DIR_PROJECT_LOGIN . '../inc/conf.php');
require_once( ABS_CUR_DIR_PROJECT_LOGIN.'../../../kernel/inc/checkSession.php' );

function whoami( $userID=0 )
{
    global $GLOBAL;
    $ret = array();
    $userID = $GLOBAL["runData"]["userData"]["id"];
    $ret["uid"] = $GLOBAL["runData"]["userData"]["uid"];
    //echo "userID:".$userID."<br>";
    $v1 = $GLOBAL["G_DB_OBJ"]->executeSqlMap( "select (select MenuName from treemenu where MenuId = departmentOther.menuID limit 1) as departmentName,(select bankName from banklist where id=departmentOther.bankID limit 1 ) as bankName from departmentOther where userID='".$userID."' limit 1;" ,1);
    if ( !Empty( $v1 ) )
    {
        $ret["bankName"]=$v1["bankName"];
        $ret["departmentName"]=$v1["departmentName"];
        $ret["name"] = "科长";
        echo json_encode($ret);
        exit;
    }
    $v1 = $GLOBAL["G_DB_OBJ"]->executeSqlMap( "select (select MenuName from treemenu where MenuId = departmentOther.menuID limit 1) as departmentName,(select bankName from banklist where id=departmentOther.bankID limit 1 ) as bankName from departmentOther where viewUserID='".$userID."' limit 1;" ,1);
    if ( !Empty( $v1 ) )
    {
        $ret["bankName"]=$GLOBAL["G_DB_OBJ"]->getFieldValue( "select bankName from banklist where id='".$v1["bankID"]."' limit 1;" );
        $ret["departmentName"]=$v1["departmentName"];
        $ret["name"] = "科员";
        echo json_encode($ret);
        exit;
    }
    $v1 = $GLOBAL["G_DB_OBJ"]->executeSqlMap( "select id,name,(select bankName from banklist where banklist.id=leader.bankID limit 1) as bankName,(select bankLevel from banklist where banklist.id=leader.bankID limit 1) as bankLevel from leader where userID='".$userID."';",1 );
    if ( !Empty( $v1 ) )
    {
        if ( $ret["bankLevel"] == "1" )
            $ret["name"] = "领导";
        else
            $ret["name"] = "领导";
        $ret["bankName"]=$v1["bankName"];
        $ret["departmentName"]="";
        $ret["name"]=$v1["name"];
        echo json_encode($ret);
        exit;
    }
    $v1 = $GLOBAL["G_DB_OBJ"]->executeSqlMap( "select (select MenuName from treemenu where MenuId = department.menuID limit 1) as departmentName,(select bankName from banklist where id=department.bankID limit 1 ) as bankName from department where userID='".$userID."' limit 1;" ,1);
    if ( !Empty( $v1 ) )
    {
        $ret["bankName"]=$v1["bankName"];
        $ret["departmentName"]=$v1["departmentName"];
        $ret["name"] = "科长";
        echo json_encode($ret);
        exit;
    }
    $v1 = $GLOBAL["G_DB_OBJ"]->executeSqlMap( "select (select MenuName from treemenu where MenuId = department.menuID limit 1) as departmentName,(select bankName from banklist where id=department.bankID limit 1 ) as bankName from department where viewUserID='".$userID."' limit 1;" ,1);
    if ( !Empty( $v1 ) )
    {
        $ret["bankName"]=$v1["bankName"];
        $ret["departmentName"]=$v1["departmentName"];
        $ret["name"] = "科员";
        echo json_encode($ret);
        exit;
    }
    $v1 = $GLOBAL["G_DB_OBJ"]->executeSqlMap( "select id,bankLevel,bankName from banklist where userID='".$userID."';", 1 );
    if ( !Empty( $v1  ) )
    {
        //echo  "select id,bankLevel,bankName from banklist where userID='".$userID."';";
        $ret["bankName"]=$v1["bankName"];
        $ret["departmentName"]="3333";
        $ret["name"] = "审计11";
        echo json_encode($ret);
        exit;
    }
    if ( $GLOBAL["G_DB_OBJ"]->getFieldValue( "select uid from user where id='".$userID."';" ) == "admin" )
    {
        $ret["bankName"]=$GLOBAL["G_DB_OBJ"]->getFieldValue( "select bankName from banklist where bankLevel='0' limit 1;" );
        $ret["departmentName"]="科技科";
        $ret["name"] = "超级管理员";
        echo json_encode($ret);
        exit;
    }
    $ret["bankName"]=$GLOBAL["G_DB_OBJ"]->getFieldValue( "select bankName from banklist where bankLevel='0' limit 1;" );
    $ret["departmentName"]="未知";
    $ret["name"] = "未知";
    echo json_encode($ret);
    exit;
}

$ua = $_SERVER["HTTP_USER_AGENT"];
if ( preg_match( "/MSIE/", $ua ) )
    header( "Content-Type: text/html" );
else if (preg_match( "/Firefox/", $ua ) )
    header( 'Content-type:text/json' );
else
    header( 'Content-type:text/json' );
whoami();
exit;