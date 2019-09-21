<?php
define('ABS_CUR_DIR_COMM', dirname(__FILE__) . '/');
require_once(ABS_CUR_DIR_COMM . '../../kernel/inc/conf.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/conf.php');
require_once(ABS_CUR_DIR_COMM . '../../kernel/inc/global.php');
require_once(ABS_CUR_DIR_COMM . '../../kernel/function/parseUrl.php');
require_once(ABS_CUR_DIR_COMM . '../../kernel/function/webOptCode.php');

try
{
    $postPageOBJ = new postPage($_POST);
}
catch (Exception $e)
{
    if ( $moduleFrom[$parseUrl['query']]['type'] == 'json' )
        echo  json_encode( array( 'retCode'=>-1, 'errMsg'=>'数据非法！('.__LINE__.')info('.$e->getMessage().')', 'data'=>array() ) );
        else
            echo $e->getMessage() . BASEURL . '<br>';
            return;
}
$errMsg = "";
$sqlstring = $postPageOBJ->get_string_from_post_array($errMsg);

try
{
    $result = $GLOBAL['G_DB_OBJ']->executeSql($sqlstring);
} catch (Exception $e)
{
	if ( $moduleFrom[$parseUrl['query']]['type'] == 'json' )
		echo json_encode( array( 'retCode'=>-1, 'errMsg'=>$e->getMessage(), 'data'=>array() ) );
	else
    echo $e->getMessage() . BASEURL  . '<br>';
    return;
}
if (count($result) === 0) {
    echo "该用户不存在!&nbsp;&nbsp;<a href='" . BASEURL  ."'>返回</a>";
    exit;
}
else
{
    $checkAuthor = new checkAuthClass();
    //$_SESSION['influenceData'] = $this->xmlArray['influenceStruct'];
    $checkAuthor->setLoginame( $result['uid']  );
    $checkAuthor->setPasswd( $result['passwd'] );
    $checkAuthor->checkAuth( );
    
    $checkAuthor->setSession($result);//权限已经加入session,权限列表为influenceData
    
    session_start();
    $GLOBAL['runData']['userData'] = $_SESSION['userData'];
    if ($GLOBAL['checkACL']) {
        	
    }
    
    $tmpSql = "update webadmin.user set lastLoginTime=now() where id=" . $result['id'] . ";";
    if ($GLOBAL['G_DB_OBJ']->executeSql($tmpSql) !== 1) {
        $GLOBAL['G_DB_OBJ']->writeLog($GLOBAL['G_DB_OBJ']->errLog, "f=" . __FILE__ . "\tl=" . __LINE__ . "\tinfo(" . $tmpSql . ")");
        echo getErrorTmpl("登录失败!info('修改登录时间失败')" . $tmpSql);
        exit;
    }
    $tmpSql = "insert into optlog(title,text,userID,ip) values('登录','登录成功','".$result['id']."','".getClientIP()."');";
    $GLOBAL['G_DB_OBJ']->executeSql($tmpSql);
    $tmpSql = "delete FROM `optlog` WHERE unix_timestamp(now())-UNIX_TIMESTAMP(regTime)>3600*24*365;";
    $GLOBAL['G_DB_OBJ']->executeSql($tmpSql);

    //header("Location:" . BASEURL . "/systemHomeApp.html");
 
    echo getWebLocationScript(BASEURL . "systemHomeApp.html", "登录成功！");
}
?>