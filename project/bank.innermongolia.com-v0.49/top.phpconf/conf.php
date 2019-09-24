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

if ($opt === "listFlag") {
	//select userkey from test order by id;

	
    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
    $GLOBAL['htmlDefine']['replaceArray']['__UID__'] = $_SESSION['userData']['uid'];
    $GLOBAL['htmlDefine']['replaceArray']['__USERNAME__'] = $_SESSION['userData']['userName'];
    $GLOBAL['htmlDefine']['replaceArray']['__LASTLOGINTIME__'] = $_SESSION['userData']['lastLoginTime'];
    //$GLOBAL['htmlDefine']['replaceArray']['__INFLUENCENAME__'] = $GLOBAL['G_DB_OBJ']->getFieldValue('select name from webadmin.influence where id='.$_SESSION['userData']['influenceID'] );
    $GLOBAL['htmlDefine']['replaceArray']['__IP__'] = $_SESSION['userData']['ip'];
    $moduleShowtmpl = loadModules("webPage", $errMsg);
	//print_r( $GLOBAL );
	//require_once($moduleShowtmpl);
	
}

//参考配置文件
$GLOBAL['modulesArray'][GLOBAL_ROOT_PATH . '/userInfo.php'] = array(
    'default' => array(
        'to_path' => GLOBAL_ROOT_PATH . 'userInfo.php',
        'to_query' => 'opt=listFlag&menuID=28',
        'type' => 'reload',
        'info' => '删除类型成功'
    ),
    'opt=editFlag' => array(
        'to_path' => GLOBAL_ROOT_PATH . 'userInfo.php',
        'to_query' => 'opt=listFlag&menuID=28',
        'type' => 'reload',
        'info' => '修改类型成功'
    )
);

?>