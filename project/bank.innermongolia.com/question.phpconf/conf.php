<?php
//notice 在内核加载之前要先运行这个进行hook，才能保证正常运行
if ( strpos($_SERVER["HTTP_REFERER"],"opt=listFlag1tab" ) !== false )
{
    $_SERVER["QUERY_STRING"] = str_replace('opt=listFlag1','opt=listFlag1tab',$_SERVER["QUERY_STRING"]);
}
if ( strpos($_SERVER["HTTP_REFERER"],"opt=listFlag2tab" ) !== false )
{
    $_SERVER["QUERY_STRING"] = str_replace('opt=listFlag2','opt=listFlag2tab',$_SERVER["QUERY_STRING"]);
}
if ( strpos($_SERVER["HTTP_REFERER"],"opt=listFlag3tab" ) !== false )
{
    $_SERVER["QUERY_STRING"] = str_replace('opt=listFlag3','opt=listFlag3tab',$_SERVER["QUERY_STRING"]);
}
if ( strpos($_SERVER["HTTP_REFERER"],"opt=listFlag4tab" ) !== false )
{
    $_SERVER["QUERY_STRING"] = str_replace('opt=listFlag4','opt=listFlag4tab',$_SERVER["QUERY_STRING"]);
}
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
$selectStr = '<select name="timeLimit">
    <option value="0" __OPTION0__>请选择</option>
    <option value=30 __OPTION30__>30天</option><option value=60 __OPTION60__>60天</option>
    <option value=90 __OPTION90__>90天</option><option value=120 __OPTION120__>120天</option>
    <option value=150 __OPTION150__>150天</option><option value=180 __OPTION180__>180天</option>
    </select>';
if ( $opt === "addFlagSave")//增加子项后台
{

    $userID = $GLOBAL["runData"]["userData"]["id"];
    $bankID = $_POST["bankID"];
    $departmentID = $_POST["departmentID"];
    $userID1 = $_POST["userID1"];
    $userID2 = $_POST["userID2"];
    $bankFlag = $_POST["bankFlag"];
    $itemName = str_replace( "'", "\"", $_POST["itemName"] );
    $endTime = $_POST["endTime"];
    $responsiblePeople = str_replace( "'", "\"", $_POST["responsiblePeople"] );
    $departmentPeople = str_replace( "'", "\"", $_POST["departmentPeople"] );
    $statusFlag = $_POST["statusFlag"];
    $reason = str_replace( "'", "\"", $_POST["editor33"] );
    $questionDetail = str_replace("'", "\"", $_POST["editor11"] ) ;
    $situation  = str_replace("'", "\"", $_POST["editor22"] );
    $srcFilePath = $_POST["srcFilePath"];
    if ( Empty( $departmentID ) )
    {
        echo getHistoryBackScript( '只有中心支行的科员帐号与旗县支行的科长帐号有新建台帐的权限，您没有新建台帐的权限!' );
        exit;
    }
    if ( Empty( $userID1 ) )
    {    

        if ( $bankType == "0" )//中心支行
        {
            echo getHistoryBackScript( '科长帐号不能为空，请确认您所在的科室已经分配科长帐号!' );
            exit;
        }
        else//旗县支行
        {
            echo getHistoryBackScript( '分管领导不能为空，请确认您所在的科室已经分配分管领导!' );
            exit;
        }
    }
    if ( Empty( $userID2 ) )
    {
    
        if ( $bankType == "0" )//中心支行
        {
            echo getHistoryBackScript( '分管领导不能为空，请确认您所在的科室已经分配分管领导!' );
            exit;
        }
        else//旗县支行
        {
            echo getHistoryBackScript( '科长帐号不能为空，请确认您所在科室的上级审核科室已经分配科长帐号!' );
            exit;
        }
    }
    if ( Empty( $srcFilePath ) )
    {
        echo getHistoryBackScript( '台帐原始资料必须上传不能为空!' );
        exit;
    }
    if ( !isDatetime($endTime, "Y-m-d" ) )
    {
        echo getHistoryBackScript( '请输入有效的整改完成时间!' );
        exit;
    }
        
    $rootDir = str_replace("/ckfinder/userfiles/","",$appConf['GLOBAL']['uploadDir']);
    $destFilePath = str_replace("/tmp/","/result/",$srcFilePath);
    $srcRootFilePath = $rootDir.$srcFilePath;
    $destRootFilePath = str_replace("/tmp/","/result/",$srcRootFilePath);


    if ( !rename($srcRootFilePath, $destRootFilePath) )
        echo "move file failed!".$srcRootFilePath."<br>";

    $fileBody = "<p>".$fileBody."</p>";
    $sqlStr = "insert into question(
        itemName,endTime,responsiblePeople,departmentPeople,srcFilePath,questionDetail,situation,userID,userID1,userID2,bankFlag,departmentID,bankID,statusFlag,reason,note
        ) values(
        '".$itemName."','".$endTime."','".$responsiblePeople."','".$departmentPeople."','".$destFilePath."','".$questionDetail."','".$situation."','".$userID."','".$userID1."','".$userID2."','".$bankFlag."','".$departmentID."','".$bankID."','".$statusFlag."','".$reason."',''
            );";

    if ($GLOBAL['G_DB_OBJ']->executeSql($sqlStr) === 1 )
    {
        $questionID=$GLOBAL["G_DB_OBJ"]->getFieldValue("select id from question where itemName='".$itemName."' and questionDetail='".$questionDetail."' and now()-regTime<10;");
        $GLOBAL["G_DB_OBJ"]->executeSql("insert into questionMsg(questionID,msg,bankID,departmentID,userID) values('".$questionID."','新建','".$bankID."','".$departmentID."','".$userID."')");
        echo getAlertFormLocationJSCode('/question.php?opt=listFlag0',"台帐新建成功,请到台帐草稿里送审","");
    }
    else 
    {
        echo getErrorTmpl("保存失败，请联络管理员!");
    }
    exit;
}
//按科室列表显示台帐
if ( $opt === "listFlag")
{
    $userID = $GLOBAL["runData"]["userData"]["id"];

    $bankID=$_REQUEST["bankID"];
    $departmentID=$_REQUEST["departmentID"];
    /*"(case 
        when editFlag='0' then '草稿'
        when check1='0' and check2='0' and check3='0' and editFlag='1' then '被驳回'
        when check1='1' and check2='0' and check3='0' and editFlag='1' then '待审核'
        when check1='1' and check2='1' and check3='0' and editFlag='1' then '待销号'
        when check1='1' and check2='1' and check3='1' and endFlag='1' then '已销号'
        end)"
        */
    $GLOBAL['modulesInfo']['userKey'] = array(
        'itemName'=>'__ITEMNAME__',
        'questionDetail'=>'__QUESTIONDETAIL__',
        'timeLimit'=>'__TIMELIMIT__',
        '(case when endFlag=\'1\' then concat(endTime,\'<l></l>\') else concat(endTime,\'(<l>\',(unix_timestamp(endTime)-unix_timestamp())div(24*3600),\'</l>)\') end)'=>'__ENDTIME__',
        "(case
        when editFlag='0' then '草稿'
        when check1='0' and check2='0' and check3='0' and editFlag='1' then '被驳回'
        when check1='1' and check2='0' and check3='0' and editFlag='1' then '待审核'
        when check1='1' and check2='1' and check3='0' and editFlag='1' then '待销号'
        when check1='1' and check2='1' and check3='1' and endFlag='1' then '已销号'
        end)"=>'__STATUS__',
        'responsiblePeople'=>'__RESPONSIBLEPEOPLE__',
        'departmentPeople'=> '__DEPARTMENTPEOPLE__',
        'concat(\''.BASEURL.'\',srcFilePath)'=> '__SRCFILEPATH__',
        'situation'=>'__SITUATION__',
        'id'=> '__ID__',
        'regtime'=>'__REGTIME__'
    );
    $GLOBAL['modulesInfo']['tableName'] = 'question';
    $GLOBAL['modulesInfo']['subSql'] = " bankID='".$bankID."' and departmentID='".$departmentID."' ";
    $GLOBAL['modulesInfo']['orderSubSql'] = ' order by id desc';

    $GLOBAL['htmlDefine']['replaceArray']['__DEPARTMENTID__'] = $departmentID;
    require_once(ABS_CUR_DIR_MENU_CONF . "../../../kernel/comm/loadModules.php");

    $moduleShowtmpl = loadModules("webPage", $errMsg);
    exit;
}
//台帐草稿
if ( $opt === "listFlag0")
{
    $userID = $GLOBAL["runData"]["userData"]["id"];
    $GLOBAL['modulesInfo']['userKey'] = array(
        'itemName'=>'__ITEMNAME__',
        'questionDetail'=>'__QUESTIONDETAIL__',
        'timeLimit'=>'__TIMELIMIT__',
        
        '(select bankName from banklist where banklist.id=question.bankID limit 1)'=>'__BANKNAME__',
        '(case when bankFlag=\'0\' then (select (select MenuName from treemenu where treemenu.MenuId=department.menuID limit 1) from department where department.id=question.departmentID limit 1) when bankFlag=\'1\' then (select (select MenuName from treemenu where treemenu.MenuId=departmentOther.menuID limit 1) from departmentOther where departmentOther.id=question.departmentID limit 1) end)'=>'__DEPARTMENTNAME__',
        'concat(endTime,\'(<l class="num">\',(unix_timestamp(endTime)-unix_timestamp())div(24*3600),\'</l>)\')'=>'__ENDTIME__',
        'responsiblePeople'=>'__RESPONSIBLEPEOPLE__',
        'departmentPeople'=> '__DEPARTMENTPEOPLE__',
        'concat(\''.BASEURL.'\',srcFilePath)'=> '__SRCFILEPATH__',
        'situation'=>'__SITUATION__',
        'id'=> '__ID__',
        'regtime'=>'__REGTIME__'
    );
    $GLOBAL['modulesInfo']['tableName'] = 'question';
    $GLOBAL['modulesInfo']['subSql'] = " editFlag='0' and userID='".$userID."'";
    $GLOBAL['modulesInfo']['orderSubSql'] = ' order by id desc';
    
    $GLOBAL['htmlDefine']['replaceArray']['__DEPARTMENTID__'] = $departmentID;
    require_once(ABS_CUR_DIR_MENU_CONF . "../../../kernel/comm/loadModules.php");

    $moduleShowtmpl = loadModules("webPage", $errMsg);
    exit;
}
if ( $opt === "listFlag1tab"||$opt === "listFlag2tab"||$opt === "listFlag3tab"||$opt === "listFlag4tab")
{
    $subFlag = $_GET["subFlag"];
    $pagenum = $_GET["pagenum"];
    if ( !Empty( $pagenum ) )
        $GLOBAL['htmlDefine']['replaceArray']['__PAGENUM__'] = $pagenum;
    else 
        $GLOBAL['htmlDefine']['replaceArray']['__PAGENUM__'] = 0;
    if ( $subFlag == "other" )
    {
        $GLOBAL['htmlDefine']['replaceArray']['__OTHERACTIVE__']="class=\"selectActive\"";
        $GLOBAL['htmlDefine']['replaceArray']['__CENTERACTIVE__']="";
    }
    else
    {
        $GLOBAL['htmlDefine']['replaceArray']['__CENTERACTIVE__']="class=\"selectActive\"";
        $GLOBAL['htmlDefine']['replaceArray']['__OTHERACTIVE__']="";
    }
    require_once(ABS_CUR_DIR_MENU_CONF . "../../../kernel/comm/loadModules.php");
    $moduleShowtmpl = loadModules("webPage", $errMsg);
    exit;
    
}
//待审核台帐
if ( $opt === "listFlag1")
{
    $userID = $GLOBAL["runData"]["userData"]["id"];
    
    $GLOBAL['modulesInfo']['userKey'] = array(
        'itemName'=>'__ITEMNAME__',
        'questionDetail'=>'__QUESTIONDETAIL__',
        'timeLimit'=>'__TIMELIMIT__',
        'concat(endTime,\'(<l class="num">\',(unix_timestamp(endTime)-unix_timestamp())div(24*3600),\'</l>)\')'=>'__ENDTIME__',
        '(select bankName from banklist where banklist.id=question.bankID limit 1)'=>'__BANKNAME__',
        'responsiblePeople'=>'__RESPONSIBLEPEOPLE__',
        '(select uid from user where id=question.userID1)'=>'__CHECKUSER1__',
        'departmentPeople'=> '__DEPARTMENTPEOPLE__',
        'concat(\''.BASEURL.'\',srcFilePath)'=> '__SRCFILEPATH__',
        'situation'=>'__SITUATION__',
        'bankFlag',
        'id'=> '__ID__',
        'regtime'=>'__REGTIME__'
    );
    $GLOBAL['modulesInfo']['tableName'] = 'question';
    if ( whoami( $userID ) == "旗县支行科员" )
    {
        $userID1 = $GLOBAL["G_DB_OBJ"]->getFieldValue( "select userID from departmentOther where viewUserID='".$userID."' limit 1;" );
        $GLOBAL['modulesInfo']['userKey']['(select name from leader where leader.userID=question.userID1 limit 1)']='__CHECKUSER1__';
        $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=departmentOther.menuID limit 1) from departmentOther where id=question.departmentID limit 1)']='__DEPARTMENTNAME__';
        $GLOBAL['modulesInfo']['subSql'] = " editFlag='1' and (check1='1' and check2='0') and userID='".$userID1."'";
    }
    elseif ( whoami( $userID ) == "旗县支行科长" )
    {

        $GLOBAL['modulesInfo']['userKey']['(select name from leader where leader.userID=question.userID1 limit 1)']='__CHECKUSER1__';
        $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=departmentOther.menuID limit 1) from departmentOther where id=question.departmentID limit 1)']='__DEPARTMENTNAME__';
        $GLOBAL['modulesInfo']['subSql'] = " editFlag='1' and (check1='1' and check2='0') and userID='".$userID."'";
    }
    elseif ( whoami( $userID ) == "旗县支行领导" )
    {
        $GLOBAL['modulesInfo']['userKey']['(select name from leader where leader.userID=question.userID1 limit 1)']='__CHECKUSER1__';
        $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=departmentOther.menuID limit 1) from departmentOther where id=question.departmentID limit 1)']='__DEPARTMENTNAME__';
        $GLOBAL['modulesInfo']['subSql'] = " editFlag='1' and (check1='1' and check2='0') and userID1='".$userID."'";
    }
    //巴市支行科长看旗县的待审核台帐？？？？？需要判断旗县参数
    elseif ( whoami( $userID ) == "巴市支行科长" )
    {
        //显示旗县台帐
        if ( $_GET["subFlag"] == "other")
        {
            $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=department.menuID limit 1) from department where department.userID=question.userID2 limit 1)']='__CHECKUSER1__';
            $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=departmentOther.menuID limit 1) from departmentOther where id=question.departmentID limit 1)']='__DEPARTMENTNAME__';
            $GLOBAL['modulesInfo']['subSql'] .= " editFlag='1' and check1='1' and check2='0' and check3='0' and userID2='".$userID."'";
        }
        //显示巴市中心支行台帐
        else
        {
            $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=department.menuID limit 1) from department where department.userID=question.userID1 limit 1)']='__CHECKUSER1__';
            $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=department.menuID limit 1) from department where id=question.departmentID limit 1)']='__DEPARTMENTNAME__';
            $GLOBAL['modulesInfo']['subSql'] = " editFlag='1' and check1='1' and check2='0' and userID1='".$userID."' ";
        }
    }
    //巴市支行科员看巴市支行的台帐
    elseif ( whoami( $userID ) == "巴市支行科员" )
    {
        $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=department.menuID limit 1) from department where department.userID=question.userID1 limit 1)']='__CHECKUSER1__';
        $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=department.menuID limit 1) from department where id=question.departmentID limit 1)']='__DEPARTMENTNAME__';
        //待审核台账
        $GLOBAL['modulesInfo']['subSql'] = " editFlag='1' and check1='1' and check2='0' and userID='".$userID."' ";
    }
    //巴市支行领导看巴市支行的台帐
    elseif ( whoami( $userID ) == "巴市支行领导" )
    {
        $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=department.menuID limit 1) from department where department.userID=question.userID1 limit 1)']='__CHECKUSER1__';
        $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=department.menuID limit 1) from department where id=question.departmentID limit 1)']='__DEPARTMENTNAME__';
        //待审核台账
        $GLOBAL['modulesInfo']['subSql'] = " editFlag='1' and check1='1' and check2='0' and userID2='".$userID."' ";
    }
    //其它帐号看不了我的台账里的待审核台帐
    else{
        $GLOBAL['modulesInfo']['userKey']['(select name from leader where leader.userID=question.userID2 limit 1)']='__CHECKUSER1__';
        $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=department.menuID limit 1) from department where id=question.departmentID limit 1)']='__DEPARTMENTNAME__';
        $GLOBAL['modulesInfo']['subSql'] = " editFlag='1' and check1='1' and check2='0' and check3='0' and userID2='-1' ";
    }
    $GLOBAL['modulesInfo']['orderSubSql'] = ' order by id desc';

    $GLOBAL['htmlDefine']['replaceArray']['__DEPARTMENTID__'] = $departmentID;
    require_once(ABS_CUR_DIR_MENU_CONF . "../../../kernel/comm/loadModules.php");

    $moduleShowtmpl = loadModules("webPage", $errMsg);
    exit;
}
//待销号台账
if ( $opt === "listFlag2")
{
    $userID = $GLOBAL["runData"]["userData"]["id"];
    
    $GLOBAL['modulesInfo']['userKey'] = array(
        'itemName'=>'__ITEMNAME__',
        'questionDetail'=>'__QUESTIONDETAIL__',
        'timeLimit'=>'__TIMELIMIT__',
        'concat(endTime,\'(<l class="num">\',(unix_timestamp(endTime)-unix_timestamp())div(24*3600),\'</l>)\')'=>'__ENDTIME__',
        '(select bankName from banklist where banklist.id=question.bankID limit 1)'=>'__BANKNAME__',
        '(case when bankFlag=\'0\' then (select (select MenuName from treemenu where treemenu.MenuId=department.menuID limit 1) from department where department.id=question.departmentID limit 1) when bankFlag=\'1\' then (select (select MenuName from treemenu where treemenu.MenuId=departmentOther.menuID limit 1) from departmentOther where departmentOther.id=question.departmentID limit 1) end)'=>'__DEPARTMENTNAME__',
        'responsiblePeople'=>'__RESPONSIBLEPEOPLE__',
        '(select uid from user where id=question.userID1)'=>'__CHECKUSER1__',
        'departmentPeople'=> '__DEPARTMENTPEOPLE__',
        'concat(\''.BASEURL.'\',srcFilePath)'=> '__SRCFILEPATH__',
        'situation'=>'__SITUATION__',
        'id'=> '__ID__',
        'regtime'=>'__REGTIME__'
    );
    $GLOBAL['modulesInfo']['tableName'] = 'question';
    if ( whoami( $userID ) == "旗县支行科员" )
    {
        $userID1 = $GLOBAL["G_DB_OBJ"]->getFieldValue( "select userID from departmentOther where viewUserID='".$userID."' limit 1;" );
        $GLOBAL['modulesInfo']['userKey']['(select concat(\'上级支行:\',(select MenuName from treemenu where MenuId=department.menuID limit 1)) from department where department.userID=question.userID2 limit 1)']='__CHECKUSER1__';
        $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=departmentOther.menuID limit 1) from departmentOther where id=question.departmentID limit 1)']='__DEPARTMENTNAME__';
        $GLOBAL['modulesInfo']['subSql'] = " editFlag='1' and (check1='1' and check2='1' and check3='0') and userID='".$userID1."'";
    }
    elseif ( whoami( $userID ) == "旗县支行科长" )
    {

        $GLOBAL['modulesInfo']['userKey']['(select concat(\'上级支行:\',(select MenuName from treemenu where MenuId=department.menuID limit 1)) from department where department.userID=question.userID2 limit 1)']='__CHECKUSER1__';
        $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=departmentOther.menuID limit 1) from departmentOther where id=question.departmentID limit 1)']='__DEPARTMENTNAME__';
        $GLOBAL['modulesInfo']['subSql'] = " editFlag='1' and (check1='1' and check2='1' and check3='0') and userID='".$userID."'";
    }
    elseif ( whoami( $userID ) == "旗县支行领导" )
    {
        $GLOBAL['modulesInfo']['userKey']['(select concat(\'上级支行:\',(select MenuName from treemenu where MenuId=department.menuID limit 1)) from department where department.userID=question.userID2 limit 1)']='__CHECKUSER1__';
        $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=departmentOther.menuID limit 1) from departmentOther where id=question.departmentID limit 1)']='__DEPARTMENTNAME__';
        $GLOBAL['modulesInfo']['subSql'] = " editFlag='1' and (check1='1' and check2='1' and check3='0' ) and userID1='".$userID."'";
    }
    //巴市支行科长看旗县的待审核台帐？？？？？需要判断旗县参数
    elseif ( whoami( $userID ) == "巴市支行科长" )
    {
        //如果是旗县的台帐
        if ( $_GET["subFlag"] == "other")
        {
            $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=department.menuID limit 1) from department where department.userID=question.userID2 limit 1)']='__CHECKUSER1__';
            $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=departmentOther.menuID limit 1) from departmentOther where id=question.departmentID limit 1)']='__DEPARTMENTNAME__';
            $GLOBAL['modulesInfo']['subSql'] .= " editFlag='1' and check1='1' and check2='1' and check3='0' and userID2='".$userID."'";
        }
        //巴市支行科长看巴市支行的台帐
        else
        {
            $GLOBAL['modulesInfo']['userKey']['(select name from leader where leader.userID=question.userID2 limit 1)']='__CHECKUSER1__';
            $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=department.menuID limit 1) from department where id=question.departmentID limit 1)']='__DEPARTMENTNAME__';
            //待审核台账
            $GLOBAL['modulesInfo']['subSql'] = " editFlag='1' and check1='1' and check2='1' and check3='0' and userID1='".$userID."' ";
        }
    }
    //巴市支行科员看巴市支行的台帐
    elseif ( whoami( $userID ) == "巴市支行科员" )
    {
        $GLOBAL['modulesInfo']['userKey']['(select name from leader where leader.userID=question.userID2 limit 1)']='__CHECKUSER1__';
        $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=department.menuID limit 1) from department where id=question.departmentID limit 1)']='__DEPARTMENTNAME__';
        //待审核台账
        $GLOBAL['modulesInfo']['subSql'] = " editFlag='1' and check1='1' and check2='1' and check3='0' and userID='".$userID."' ";
    }
    //巴市支行领导看巴市支行的台帐
    elseif ( whoami( $userID ) == "巴市支行领导" )
    {
        $GLOBAL['modulesInfo']['userKey']['(select name from leader where leader.userID=question.userID2 limit 1)']='__CHECKUSER1__';
        $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=department.menuID limit 1) from department where id=question.departmentID limit 1)']='__DEPARTMENTNAME__';
        //待审核台账
        $GLOBAL['modulesInfo']['subSql'] = " editFlag='1' and check1='1' and check2='1' and check3='0' and userID2='".$userID."' ";
    }
    //其它帐号看不了我的台账里的待销号台帐
    else{
        $GLOBAL['modulesInfo']['userKey']['(select name from leader where leader.userID=question.userID2 limit 1)']='__CHECKUSER1__';
        $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=department.menuID limit 1) from department where id=question.departmentID limit 1)']='__DEPARTMENTNAME__';
        $GLOBAL['modulesInfo']['subSql'] = " editFlag='1' and check1='1' and check2='1' and check3='0' and userID2='-1' ";
    }
    $GLOBAL['modulesInfo']['orderSubSql'] = ' order by id desc';
        
    $GLOBAL['htmlDefine']['replaceArray']['__DEPARTMENTID__'] = $departmentID;
    require_once(ABS_CUR_DIR_MENU_CONF . "../../../kernel/comm/loadModules.php");

    $moduleShowtmpl = loadModules("webPage", $errMsg);
    exit;
}
//被驳回台账
if ( $opt === "listFlag3")
{
    $userID = $GLOBAL["runData"]["userData"]["id"];

    $userID = $GLOBAL["runData"]["userData"]["id"];

    $GLOBAL['modulesInfo']['userKey'] = array(
        'itemName'=>'__ITEMNAME__',
        'questionDetail'=>'__QUESTIONDETAIL__',
        'timeLimit'=>'__TIMELIMIT__',
        'concat(endTime,\'(<l class="num">\',(unix_timestamp(endTime)-unix_timestamp())div(24*3600),\'</l>)\')'=>'__ENDTIME__',
        '(select bankName from banklist where banklist.id=question.bankID limit 1)'=>'__BANKNAME__',
        '(case when bankFlag=\'0\' then (select (select MenuName from treemenu where treemenu.MenuId=department.menuID limit 1) from department where department.id=question.departmentID limit 1) when bankFlag=\'1\' then (select (select MenuName from treemenu where treemenu.MenuId=departmentOther.menuID limit 1) from departmentOther where departmentOther.id=question.departmentID limit 1) end)'=>'__DEPARTMENTNAME__',
        'responsiblePeople'=>'__RESPONSIBLEPEOPLE__',
        '(select uid from user where id=question.userID1)'=>'__CHECKUSER1__',
        'departmentPeople'=> '__DEPARTMENTPEOPLE__',
        'concat(\''.BASEURL.'\',srcFilePath)'=> '__SRCFILEPATH__',
        'situation'=>'__SITUATION__',
        'id'=> '__ID__',
        'regtime'=>'__REGTIME__'
    );
    $GLOBAL['modulesInfo']['tableName'] = 'question';
    if ( whoami( $userID ) == "旗县支行科员" )
    {
        $userID1 = $GLOBAL["G_DB_OBJ"]->getFieldValue( "select userID from departmentOther where viewUserID='".$userID."' limit 1;" );
        $GLOBAL['modulesInfo']['userKey']['(select concat(\'上级支行:\',(select MenuName from treemenu where MenuId=department.menuID limit 1)) from department where department.userID=question.userID2 limit 1)']='__CHECKUSER1__';
        $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=departmentOther.menuID limit 1) from departmentOther where id=question.departmentID limit 1)']='__DEPARTMENTNAME__';
        $GLOBAL['modulesInfo']['subSql'] = " editFlag='1' and (check1='0' and check2='0' and check3='0')  and userID='".$userID1."'";
    }
    elseif ( whoami( $userID ) == "旗县支行科长" )
    {
        $GLOBAL['modulesInfo']['userKey']['(select concat(\'上级支行:\',(select MenuName from treemenu where MenuId=department.menuID limit 1)) from department where department.userID=question.userID2 limit 1)']='__CHECKUSER1__';
        $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=departmentOther.menuID limit 1) from departmentOther where id=question.departmentID limit 1)']='__DEPARTMENTNAME__';
        $GLOBAL['modulesInfo']['subSql'] = " editFlag='1' and (check1='0' and check2='0' and check3='0') and userID='".$userID."'";
    }
    elseif ( whoami( $userID ) == "旗县支行领导" )
    {
        $GLOBAL['modulesInfo']['userKey']['(select concat(\'上级支行:\',(select MenuName from treemenu where MenuId=department.menuID limit 1)) from department where department.userID=question.userID2 limit 1)']='__CHECKUSER1__';
        $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=departmentOther.menuID limit 1) from departmentOther where id=question.departmentID limit 1)']='__DEPARTMENTNAME__';
        $GLOBAL['modulesInfo']['subSql'] = " editFlag='1' and (check1='0' and check2='0' and check3='0' ) and userID1='".$userID."'";
    }
    //巴市支行科长看旗县的待审核台帐？？？？？需要判断旗县参数
    elseif ( whoami( $userID ) == "巴市支行科长" )
    {
        //如果是旗县的台帐
        if ( $_GET["subFlag"] == "other")
        {
        $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=department.menuID limit 1) from department where department.userID=question.userID2 limit 1)']='__CHECKUSER1__';
        $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=departmentOther.menuID limit 1) from departmentOther where id=question.departmentID limit 1)']='__DEPARTMENTNAME__';
        $GLOBAL['modulesInfo']['subSql'] .= " editFlag='1' and check1='0' and check2='0' and check3='0' and userID2='".$userID."'";
        }
        //巴市支行科长看巴市支行的台帐
        else
        {
            $GLOBAL['modulesInfo']['userKey']['(select name from leader where leader.userID=question.userID2 limit 1)']='__CHECKUSER1__';
            $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=department.menuID limit 1) from department where id=question.departmentID limit 1)']='__DEPARTMENTNAME__';
            //待审核台账
            $GLOBAL['modulesInfo']['subSql'] = " editFlag='1' and check1='0' and check2='0' and check3='0' and userID1='".$userID."' ";
        }
    }
    //巴市支行科员看巴市支行的台帐
    elseif ( whoami( $userID ) == "巴市支行科员" )
    {
        $GLOBAL['modulesInfo']['userKey']['(select concat((select MenuName from treemenu where MenuId=department.menuID limit 1),":",(select uid from user where user.id=department.userID limit 1)) from department where id=question.departmentID limit 1)']='__CHECKUSER1__';
        $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=department.menuID limit 1) from department where id=question.departmentID limit 1)']='__DEPARTMENTNAME__';
        //待审核台账
        $GLOBAL['modulesInfo']['subSql'] = " editFlag='1' and check1='0' and check2='0' and check3='0' and userID='".$userID."' ";
    }
    //巴市支行领导看巴市支行的台帐
    elseif ( whoami( $userID ) == "巴市支行领导" )
    {
        $GLOBAL['modulesInfo']['userKey']['(select name from leader where leader.userID=question.userID2 limit 1)']='__CHECKUSER1__';
        $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=department.menuID limit 1) from department where id=question.departmentID limit 1)']='__DEPARTMENTNAME__';
        //待审核台账
        $GLOBAL['modulesInfo']['subSql'] = " editFlag='1' and check1='0' and check2='0' and check3='0' and userID2='".$userID."' ";
    }
    //其它帐号看不了我的台账里的疲驳回台账台帐
    else{
        $GLOBAL['modulesInfo']['userKey']['(select name from leader where leader.userID=question.userID2 limit 1)']='__CHECKUSER1__';
        $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=department.menuID limit 1) from department where id=question.departmentID limit 1)']='__DEPARTMENTNAME__';
        $GLOBAL['modulesInfo']['subSql'] = " editFlag='1' and check1='0' and check2='0' and check3='0' and userID2='-1' ";
    }
    $GLOBAL['modulesInfo']['orderSubSql'] = ' order by id desc';

    $GLOBAL['htmlDefine']['replaceArray']['__DEPARTMENTID__'] = $departmentID;
    require_once(ABS_CUR_DIR_MENU_CONF . "../../../kernel/comm/loadModules.php");

    $moduleShowtmpl = loadModules("webPage", $errMsg);
    exit;
}
//已销号台账
if ( $opt === "listFlag4")
{
    $userID = $GLOBAL["runData"]["userData"]["id"];
    $GLOBAL['modulesInfo']['userKey'] = array(
        'itemName'=>'__ITEMNAME__',
        'questionDetail'=>'__QUESTIONDETAIL__',
        '(select bankName from banklist where banklist.id=question.bankID limit 1)'=>'__BANKNAME__',
        '(case when bankFlag=\'0\' then (select (select MenuName from treemenu where treemenu.MenuId=department.menuID limit 1) from department where department.id=question.departmentID limit 1) when bankFlag=\'1\' then (select (select MenuName from treemenu where treemenu.MenuId=departmentOther.menuID limit 1) from departmentOther where departmentOther.id=question.departmentID limit 1) end)'=>'__DEPARTMENTNAME__',
        'timeLimit'=>'__TIMELIMIT__',
        'endTime'=>'__ENDTIME__',
        'responsiblePeople'=>'__RESPONSIBLEPEOPLE__',
        '(select uid from user where id=question.userID1)'=>'__CHECKUSER1__',
        'departmentPeople'=> '__DEPARTMENTPEOPLE__',
        'concat(\''.BASEURL.'\',srcFilePath)'=> '__SRCFILEPATH__',
        'situation'=>'__SITUATION__',
        'id'=> '__ID__',
        'regtime'=>'__REGTIME__'
    );
    $GLOBAL['modulesInfo']['tableName'] = 'question';
    if ( whoami( $userID ) == "旗县支行科员" )
    {
        $userID1 = $GLOBAL["G_DB_OBJ"]->getFieldValue( "select userID from departmentOther where viewUserID='".$userID."' limit 1;" );
        $GLOBAL['modulesInfo']['userKey']['(select concat(\'上级支行:\',(select MenuName from treemenu where MenuId=department.menuID limit 1)) from department where department.userID=question.userID2 limit 1)']='__CHECKUSER1__';
        $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=departmentOther.menuID limit 1) from departmentOther where id=question.departmentID limit 1)']='__DEPARTMENTNAME__';
        $GLOBAL['modulesInfo']['subSql'] = " editFlag='1' and (check1='1' and check2='1' and check3='1') and endFlag='1' and userID='".$userID1."'";
    }
    elseif ( whoami( $userID ) == "旗县支行科长" )
    {
        $GLOBAL['modulesInfo']['userKey']['(select concat(\'上级支行:\',(select MenuName from treemenu where MenuId=department.menuID limit 1)) from department where department.userID=question.userID2 limit 1)']='__CHECKUSER1__';
        $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=departmentOther.menuID limit 1) from departmentOther where id=question.departmentID limit 1)']='__DEPARTMENTNAME__';
        $GLOBAL['modulesInfo']['subSql'] = " editFlag='1' and (check1='1' and check2='1' and check3='1') and endFlag='1' and userID='".$userID."'";
    }
    elseif ( whoami( $userID ) == "旗县支行领导" )
    {
        $GLOBAL['modulesInfo']['userKey']['(select concat(\'上级支行:\',(select MenuName from treemenu where MenuId=department.menuID limit 1)) from department where department.userID=question.userID2 limit 1)']='__CHECKUSER1__';
        $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=departmentOther.menuID limit 1) from departmentOther where id=question.departmentID limit 1)']='__DEPARTMENTNAME__';
        $GLOBAL['modulesInfo']['subSql'] = " editFlag='1' and (check1='1' and check2='1' and check3='1' ) and endFlag='1' and userID1='".$userID."'";
    }
    //巴市支行科长看旗县的待审核台帐？？？？？需要判断旗县参数
    elseif ( whoami( $userID ) == "巴市支行科长" )
    {
        //如果是旗县的台帐
        if ( $_GET["subFlag"] == "other")
        {
        $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=department.menuID limit 1) from department where department.userID=question.userID2 limit 1)']='__CHECKUSER1__';
        $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=departmentOther.menuID limit 1) from departmentOther where id=question.departmentID limit 1)']='__DEPARTMENTNAME__';
        $GLOBAL['modulesInfo']['subSql'] .= " editFlag='1' and check1='1' and check2='1' and check3='1' and endFlag='1' and userID2='".$userID."'";
        }
        //如果是巴市支行的台帐
        else
        {
            $GLOBAL['modulesInfo']['userKey']['(select name from leader where leader.userID=question.userID2 limit 1)']='__CHECKUSER1__';
            $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=department.menuID limit 1) from department where id=question.departmentID limit 1)']='__DEPARTMENTNAME__';
            $GLOBAL['modulesInfo']['subSql'] = " editFlag='1' and check1='1' and check2='1' and check3='1' and endFlag='1' and userID1='".$userID."' ";
        }
    }
    //巴市支行科员看巴市支行的台帐
    elseif ( whoami( $userID ) == "巴市支行科员" )
    {
        $GLOBAL['modulesInfo']['userKey']['(select concat((select MenuName from treemenu where MenuId=department.menuID limit 1),":",(select uid from user where user.id=department.userID limit 1)) from department where id=question.departmentID limit 1)']='__CHECKUSER1__';
        $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=department.menuID limit 1) from department where id=question.departmentID limit 1)']='__DEPARTMENTNAME__';
        //待审核台账
        $GLOBAL['modulesInfo']['subSql'] = " editFlag='1' and check1='1' and check2='1' and check3='1' and endFlag='1' and userID='".$userID."' ";
    }
    //巴市支行领导看巴市支行的台帐
    elseif ( whoami( $userID ) == "巴市支行领导" )
    {
        $GLOBAL['modulesInfo']['userKey']['(select name from leader where leader.userID=question.userID2 limit 1)']='__CHECKUSER1__';
        $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=department.menuID limit 1) from department where id=question.departmentID limit 1)']='__DEPARTMENTNAME__';
        //待审核台账
        $GLOBAL['modulesInfo']['subSql'] = " editFlag='1' and check1='1' and check2='1' and check3='1' and endFlag='1' and userID2='".$userID."' ";
    }
    //其它帐号看不了我的台账里的疲驳回台账台帐
    else{
        $GLOBAL['modulesInfo']['userKey']['(select name from leader where leader.userID=question.userID2 limit 1)']='__CHECKUSER1__';
        $GLOBAL['modulesInfo']['userKey']['(select (select MenuName from treemenu where MenuId=department.menuID limit 1) from department where id=question.departmentID limit 1)']='__DEPARTMENTNAME__';
        $GLOBAL['modulesInfo']['subSql'] = " editFlag='1' and check1='0' and check2='0' and check3='0' and userID2='-1' ";
    }
    $GLOBAL['modulesInfo']['orderSubSql'] = ' order by id desc';

    $GLOBAL['htmlDefine']['replaceArray']['__DEPARTMENTID__'] = $departmentID;
    require_once(ABS_CUR_DIR_MENU_CONF . "../../../kernel/comm/loadModules.php");

    $moduleShowtmpl = loadModules("webPage", $errMsg);
    exit;
}
//台帐送审
if ( $opt === "check1save")
{
    $id=$_REQUEST["id"];
    $v1 = $GLOBAL["G_DB_OBJ"]->executeSqlMap("select bankID,departmentID,userID from question where id='".$id."';",1);
    $sql = "update question set check1='1',check2='0',editFlag='1' where id='".$id."';insert into questionMsg(questionID,msg,bankID,departmentID,userID) values('".$id."','送审','".$v1["bankID"]."','".$v1["departmentID"]."','".$v1["userID"]."');";
    $GLOBAL["G_DB_OBJ"]->executeMutiSqlTrans( $sql );
    if ( $GLOBAL["G_DB_OBJ"]->getFieldValue( "select check1 from question where id='".$id."';" ) == "1" )
    {
        if  ( strpos($_SERVER["HTTP_REFERER"],"&subFlag=reject&" )  === false )
            echo getAlertFormLocationJSCode('/question.php?opt=listFlag0',"已送审,请等待审批!","");
        else 
            echo getAlertFormLocationJSCode('/question.php?opt=listFlag1',"已送审,请等待审批!","");
        exit;
    }
    else {
        echo getHistoryBackScript( '送审失败!' );
        exit;
    }
    
}
//审核通过或驳回
if ( $opt === "check2save")
{
    $id=$_REQUEST["id"];
    $msg = str_replace( "'", "\"", $_POST["msg"]);
    $bankID = $GLOBAL["G_DB_OBJ"]->getFieldValue("select bankID from question where id='".$id."';");
    $userID = $GLOBAL["runData"]["userData"]["id"];
    $dbUserID = $GLOBAL["G_DB_OBJ"]->getFieldValue("select userID1 from question where id='".$id."';");
    if ( $dbUserID !== $userID )
    {
        echo getHistoryBackScript( '您没有审核台帐的权限!' );
        exit;   
    }
    $userID = $GLOBAL["runData"]["userData"]["id"];
    if ( $GLOBAL["G_DB_OBJ"]->getFieldValue( "select check1 from question where id='".$id."';" ) == "1" )
    {
        if ( Empty( $msg ) )
            $sql = "update question set check1='1',check2='1' where id='".$id."';insert into questionMsg(questionID,msg,bankID,departmentID,userID) values('".$id."','审核通过','".$bankID."','0','".$userID."');";
        else 
            $sql = "update question set check1='0',check2='0',editFlag='1' where id='".$id."';insert into questionMsg(questionID,msg,bankID,departmentID,userID) values('".$id."','审核未通过:".$msg."','".$bankID."','0','".$userID."');";
        $GLOBAL["G_DB_OBJ"]->executeMutiSqlTrans( $sql );
    }   
    if ( $GLOBAL["G_DB_OBJ"]->getFieldValue( "select check1 from question where id='".$id."';" ) == "1" )
    {
        if ( Empty( $msg ) )
        {
            echo getAlertFormLocationJSCode('/question.php?opt=listFlag2',"台帐已审核通过!","");
            exit;
        }
        else
        {
            echo getAlertFormLocationJSCode('/question.php?opt=listFlag2',"台帐已驳回!","");
            exit;
        }
    }
    else {

        echo getHistoryBackScript( '审核失败!' );
        exit;
    }
}
//销号通过或驳回
if ( $opt === "check3save")
{
    $id=$_REQUEST["id"];
    $msg = str_replace( "'", "\"", $_POST["msg"] );
    $bankID = $GLOBAL["G_DB_OBJ"]->getFieldValue("select bankID from question where id='".$id."';");
    $userID = $GLOBAL["runData"]["userData"]["id"];
    $dbUserID = $GLOBAL["G_DB_OBJ"]->getFieldValue("select userID2 from question where id='".$id."';");
    if ( $dbUserID !== $userID )
    {
        echo getHistoryBackScript( '您没有台帐销号的权限!' );
        exit;
    }
    $userID = $GLOBAL["runData"]["userData"]["id"];
    if ( $GLOBAL["G_DB_OBJ"]->getFieldValue( "select check1 from question where id='".$id."' limit 1;" ) != "" )
    {
        if ( Empty( $msg ) )
        {
            $sql = "update question set check1='1',check2='1',check3='1',endFlag='1' where id='".$id."';insert into questionMsg(questionID,msg,bankID,departmentID,userID) values('".$id."','销号','".$bankID."','0','".$userID."');";
            $GLOBAL["G_DB_OBJ"]->executeMutiSqlTrans( $sql );
            if ( $GLOBAL["G_DB_OBJ"]->getFieldValue( "select check3 from question where id='".$id."';" ) == "1" )
            {
                echo getAlertFormLocationJSCode('/question.php?opt=listFlag2',"台帐销号成功!","");
                exit;
            }
        }
        else
        {
            $sql = "update question set check1='0',check2='0',editFlag='1',rejectFlag='1' where id='".$id."';insert into questionMsg(questionID,msg,bankID,departmentID,userID) values('".$id."','销号审核未通过:".$msg."','".$bankID."','0','".$userID."');";
            $GLOBAL["G_DB_OBJ"]->executeMutiSqlTrans( $sql );
            if ( $GLOBAL["G_DB_OBJ"]->getFieldValue( "select rejectFlag from question where id='".$id."' limit 1;" ) == "1" )
            {
                echo getAlertFormLocationJSCode('/question.php?opt=listFlag2',"台帐已驳回!","");
                exit;
            }
        }
    }
    echo getHistoryBackScript( '操作失败!' );
    exit;
}
//台帐查阅
if ( $opt === "readFlag")
{
    $id=$_REQUEST["id"];

    $bankInfo = $GLOBAL["G_DB_OBJ"]->executeSqlMap( "select bankFlag,check1,check2,check3 from question where id='".$id."' limit 1;", 1 );
    $v1 = whoami( $GLOBAL["runData"]["userData"]["id"] );
    //若为旗县支行的台帐
    if ( $bankInfo["bankFlag"] == "1")
    {  
        switch ( $v1 ){
            case '旗县支行领导':
                $GLOBAL['htmlDefine']['replaceArray']['__CROSSSTYLE__'] = "display:";
                $GLOBAL['htmlDefine']['replaceArray']['__DELSTYLE__'] = "display:none";
                $GLOBAL['htmlDefine']['replaceArray']['__REJECTSTYLE__'] = "display:";
                $GLOBAL['htmlDefine']['replaceArray']['__DELREJECTSTYLE__'] = "display:none";
                break;
            case '巴市支行科员':
                $GLOBAL['htmlDefine']['replaceArray']['__CROSSSTYLE__'] = "display:none";
                $GLOBAL['htmlDefine']['replaceArray']['__DELSTYLE__'] = "display:none";
                $GLOBAL['htmlDefine']['replaceArray']['__REJECTSTYLE__'] = "display:none";
                $GLOBAL['htmlDefine']['replaceArray']['__DELREJECTSTYLE__'] = "display:none";
                break;
            case '巴市支行科长':
                $GLOBAL['htmlDefine']['replaceArray']['__CROSSSTYLE__'] = "display:none";
                $GLOBAL['htmlDefine']['replaceArray']['__DELSTYLE__'] = "display:";
                $GLOBAL['htmlDefine']['replaceArray']['__REJECTSTYLE__'] = "display:none";
                $GLOBAL['htmlDefine']['replaceArray']['__DELREJECTSTYLE__'] = "display:";
                break;
            default:
                $GLOBAL['htmlDefine']['replaceArray']['__CROSSSTYLE__'] = "display:none";
                $GLOBAL['htmlDefine']['replaceArray']['__DELSTYLE__'] = "display:none";
                $GLOBAL['htmlDefine']['replaceArray']['__REJECTSTYLE__'] = "display:none";
                $GLOBAL['htmlDefine']['replaceArray']['__DELREJECTSTYLE__'] = "display:none";
                break;
        }
    }
    //若为巴市支行的台帐
    else
    {
        switch ( $v1 ){
            case '巴市支行科员':
                $GLOBAL['htmlDefine']['replaceArray']['__CROSSSTYLE__'] = "display:none";
                $GLOBAL['htmlDefine']['replaceArray']['__DELSTYLE__'] = "display:none";
                $GLOBAL['htmlDefine']['replaceArray']['__REJECTSTYLE__'] = "display:none";
                $GLOBAL['htmlDefine']['replaceArray']['__DELREJECTSTYLE__'] = "display:none";
                break;
            case '巴市支行科长':
                $GLOBAL['htmlDefine']['replaceArray']['__CROSSSTYLE__'] = "display:";
                $GLOBAL['htmlDefine']['replaceArray']['__DELSTYLE__'] = "display:none";
                $GLOBAL['htmlDefine']['replaceArray']['__REJECTSTYLE__'] = "display:";
                $GLOBAL['htmlDefine']['replaceArray']['__DELREJECTSTYLE__'] = "display:none";
                break;
            case '巴市支行领导':
                $GLOBAL['htmlDefine']['replaceArray']['__CROSSSTYLE__'] = "display:none";
                $GLOBAL['htmlDefine']['replaceArray']['__DELSTYLE__'] = "display:";
                $GLOBAL['htmlDefine']['replaceArray']['__REJECTSTYLE__'] = "display:none";
                $GLOBAL['htmlDefine']['replaceArray']['__DELREJECTSTYLE__'] = "display:";
                break;
            default:
                $GLOBAL['htmlDefine']['replaceArray']['__CROSSSTYLE__'] = "display:none";
                $GLOBAL['htmlDefine']['replaceArray']['__DELSTYLE__'] = "display:none";
                $GLOBAL['htmlDefine']['replaceArray']['__REJECTSTYLE__'] = "display:none";
                $GLOBAL['htmlDefine']['replaceArray']['__DELREJECTSTYLE__'] = "display:none";
                break;
        }
    }
    if ( $bankInfo["check2"]== "1" )
    {
        $GLOBAL['htmlDefine']['replaceArray']['__CROSSSTYLE__'] = "display:none";
        $GLOBAL['htmlDefine']['replaceArray']['__REJECTSTYLE__'] = "display:none";
    }
    if ( $bankInfo["check3"]== "1" )
    {
        $GLOBAL['htmlDefine']['replaceArray']['__DELSTYLE__'] = "display:none";
        $GLOBAL['htmlDefine']['replaceArray']['__DELREJECTSTYLE__'] = "display:none";
    }    
    $data = $GLOBAL["G_DB_OBJ"]->executeSqlMap("select id as __ID__,
        questionDetail as __QUESTIONDETAIL__,
        itemName as __ITEMNAME__, 
        responsiblePeople as __RESONSIBLEPEOPLE__, 
        departmentPeople as __DEPARTMENTPEOPLE__,
        (select bankName from banklist where banklist.id=question.bankID limit 1) as __BANKNAME__,
        userID1 as __USERID1__,
        userID2 as __USERID2__,
        bankFlag as __BANKFLAG__,
        endTime as __ENDTIME__,
        bankID,
        departmentID,
        srcFilePath,
        statusFlag,
        check1,
        timeLimit,
        situation as __SITUATION__,
        reason as __REASON__
         from question where id='".$id."';
        ",1);
    if ( !Empty( $data ) )
    {
        if ( $GLOBAL["G_DB_OBJ"]->getFieldValue("select bankLevel from banklist where id='".$data["bankID"]."'") == "0" )            
            $data["__DEPARTMENTNAME__"] = $GLOBAL["G_DB_OBJ"]->getFieldValue("select (select MenuName from treemenu where treemenu.MenuId=department.menuID) from department where id='".$data["departmentID"]."'");
        else
            $data["__DEPARTMENTNAME__"] = $GLOBAL["G_DB_OBJ"]->getFieldValue("select (select MenuName from treemenu where treemenu.MenuId=departmentOther.menuID) from departmentOther where id='".$data["departmentID"]."' and bankID='".$data["bankID"]."';");
    }
    $GLOBAL['htmlDefine']['replaceArray'] = array_merge( $GLOBAL['htmlDefine']['replaceArray'], $data );
    
    $GLOBAL['htmlDefine']['replaceArray']['__SELECT__']=preg_replace('/__OPTION[0-9]+__/','',str_replace('__OPTION'.$data["timeLimit"].'__','selected',$selectStr));
    $GLOBAL['htmlDefine']['replaceArray']['__UID__'] = $GLOBAL['runData']['userData']['uid'];
    $sql="";
    $htmlStr = "<table>";
    $sqlStr = "select msg,userID,regtime from questionMsg where questionID='".$id."' order by id asc;";

    $v1 = $GLOBAL["G_DB_OBJ"]->executeSqlMap( $sqlStr,0 );

    while ( current( $v1 )!== false )
    {
        $val = current( $v1 );
        $htmlStr .= "<tr><td>".whoami_v1( $val["userID"] )."&nbsp;&nbsp;</td><td>".$val["msg"]."&nbsp;&nbsp;</td><td>".$val["regtime"]."</td></tr>";
        next( $v1 );
    }
    $htmlStr .= "</table>";
    $GLOBAL['htmlDefine']['replaceArray']['__QUESTIONMSGLIST__'] = $htmlStr;
    if ( $data["__BANKFLAG__"] == "0" )
    {
        $GLOBAL['htmlDefine']['replaceArray']['__BANK0STYLE__'] = "display:block";
        $GLOBAL['htmlDefine']['replaceArray']['__BANK1STYLE__'] = "display:none";
        $GLOBAL['htmlDefine']['replaceArray']['__CHECKUSER1__'] = $GLOBAL["G_DB_OBJ"]->getFieldValue( "select uid from user where user.id='".$data["__USERID1__"]."'",1);
        $GLOBAL['htmlDefine']['replaceArray']['__CHECKUSER2__'] = $GLOBAL["G_DB_OBJ"]->getFieldValue( "select uid from user where user.id='".$data["__USERID2__"]."'",1);
    }
    else
    {
        $GLOBAL['htmlDefine']['replaceArray']['__BANK0STYLE__'] = "display:none";
        $GLOBAL['htmlDefine']['replaceArray']['__BANK1STYLE__'] = "display:block";
        $sqlStr = "select userID,(select MenuName from treemenu where MenuId=department.menuID limit 1) as departmentName from department where menuID in ( select ownerMenuIDList from departmentOther where id='".$data["departmentID"]."');";
        $GLOBAL['htmlDefine']['replaceArray']['__CHECKUSER1__'] = $GLOBAL["G_DB_OBJ"]->getFieldValue( "select uid from user where user.id='".$data["__USERID2__"]."'",1);
        $GLOBAL['htmlDefine']['replaceArray']['__CHECKUSER2__'] = getComboxFromSql_v2( "userIDtmp", $sqlStr,$data["__USERID2__"],"","disabled=\"disabled\"" );
    }
    if ( $data["statusFlag"] == "0" )
    {
        $title1 = "整&nbsp;&nbsp;改&nbsp;&nbsp;情&nbsp;&nbsp;况";
        $title2 = "未&nbsp;整&nbsp;改&nbsp;原&nbsp;因";
        $GLOBAL['htmlDefine']['replaceArray']['__RADIO0CHECKED__'] = "checked";
        $GLOBAL['htmlDefine']['replaceArray']['__RADIO1CHECKED__'] = "";
        $GLOBAL['htmlDefine']['replaceArray']['__DISPLAY0__'] = "display:none";
        $GLOBAL['htmlDefine']['replaceArray']['__DISPLAY1__'] = "display:block";
        $GLOBAL['htmlDefine']['replaceArray']['__TITLE__'] = $title2;
        
    }
    else
    {
        $title1 = "整&nbsp;&nbsp;改&nbsp;&nbsp;情&nbsp;&nbsp;况";
        $title2 = "未&nbsp;整&nbsp;改&nbsp;原&nbsp;因";
        $GLOBAL['htmlDefine']['replaceArray']['__RADIO0CHECKED__'] = "";
        $GLOBAL['htmlDefine']['replaceArray']['__RADIO1CHECKED__'] = "checked";
        $GLOBAL['htmlDefine']['replaceArray']['__DISPLAY0__'] = "display:block";
        $GLOBAL['htmlDefine']['replaceArray']['__DISPLAY1__'] = "display:none";
        $GLOBAL['htmlDefine']['replaceArray']['__TITLE__'] = $title1;
        
    }
    if ( !Empty($data["srcFilePath"])  )
    {
        $GLOBAL['htmlDefine']['replaceArray']['__SRCFILEPATH__'] = $data["srcFilePath"];
        $GLOBAL['htmlDefine']['replaceArray']['__DOWNLOADSTYLE__']="block";
    }
    else 
    {
        $GLOBAL['htmlDefine']['replaceArray']['__DOWNLOADSTYLE__']="none";
        $GLOBAL['htmlDefine']['replaceArray']['__SRCFILEPATH__'] = '';
    }
    require_once(ABS_CUR_DIR_MENU_CONF . "../../../kernel/comm/loadModules.php");
    $moduleShowtmpl = loadModules("webPage", $errMsg);
    exit;
}
//被驳回台帐查阅
if ( $opt === "readRejectFlag")
{
    $id=$_REQUEST["id"];

    $data = $GLOBAL["G_DB_OBJ"]->executeSqlMap("select id as __ID__,
        questionDetail as __QUESTIONDETAIL__,
        itemName as __ITEMNAME__,
        responsiblePeople as __RESONSIBLEPEOPLE__,
        departmentPeople as __DEPARTMENTPEOPLE__,
        (select bankName from banklist where banklist.id=question.bankID limit 1) as __BANKNAME__,
        userID1 as __USERID1__,
        userID2 as __USERID2__,
        bankFlag as __BANKFLAG__,
        bankID,
        departmentID,
        srcFilePath,
        statusFlag,
        check1,
        timeLimit,
        endTime as __ENDTIME__,
        situation as __SITUATION__,
        reason as __REASON__
         from question where id='".$id."' and editFlag='1';
        ",1);
    if ( !Empty( $data ) )
    {
        if ( $GLOBAL["G_DB_OBJ"]->getFieldValue("select bankLevel from banklist where id='".$data["bankID"]."'") == "0" )
            $data["__DEPARTMENTNAME__"] = $GLOBAL["G_DB_OBJ"]->getFieldValue("select (select MenuName from treemenu where treemenu.MenuId=department.menuID) from department where id='".$data["departmentID"]."'");
            else
                $data["__DEPARTMENTNAME__"] = $GLOBAL["G_DB_OBJ"]->getFieldValue("select (select MenuName from treemenu where treemenu.MenuId=departmentOther.menuID) from departmentOther where id='".$data["departmentID"]."' and bankID='".$data["bankID"]."';");
    }
    $GLOBAL['htmlDefine']['replaceArray'] = array_merge( $GLOBAL['htmlDefine']['replaceArray'], $data );

    $GLOBAL['htmlDefine']['replaceArray']['__SELECT__']=preg_replace('/__OPTION[0-9]+__/','',str_replace('__OPTION'.$data["timeLimit"].'__','selected',$selectStr));
    $GLOBAL['htmlDefine']['replaceArray']['__UID__'] = $GLOBAL['runData']['userData']['uid'];
    $sql="";
    $htmlStr = "<table>";
    $sqlStr = "select msg,userID,regtime from questionMsg where questionID='".$id."' order by id asc;";

    $v1 = $GLOBAL["G_DB_OBJ"]->executeSqlMap( $sqlStr,0 );

    while ( current( $v1 )!== false )
    {
        $val = current( $v1 );
        $htmlStr .= "<tr><td>".whoami_v1( $val["userID"] )."&nbsp;&nbsp;</td><td>".$val["msg"]."&nbsp;&nbsp;</td><td>".$val["regtime"]."</td></tr>";
        next( $v1 );
    }
    $htmlStr .= "</table>";
    $GLOBAL['htmlDefine']['replaceArray']['__QUESTIONMSGLIST__'] = $htmlStr;
    if ( $data["bankFlag"] == "0" )
    {
        $GLOBAL['htmlDefine']['replaceArray']['__BANK0STYLE__'] = "display:block";
        $GLOBAL['htmlDefine']['replaceArray']['__BANK1STYLE__'] = "display:none";
        $GLOBAL['htmlDefine']['replaceArray']['__CHECKUSER1__'] = $GLOBAL["G_DB_OBJ"]->getFieldValue( "select uid from user where user.id='".$data["__USERID1__"]."'",1);
        $GLOBAL['htmlDefine']['replaceArray']['__CHECKUSER2__'] = $GLOBAL["G_DB_OBJ"]->getFieldValue( "select uid from user where user.id='".$data["__USERID2__"]."'",1);
    }
    else
    {
        $GLOBAL['htmlDefine']['replaceArray']['__BANK0STYLE__'] = "display:none";
        $GLOBAL['htmlDefine']['replaceArray']['__BANK1STYLE__'] = "display:block";
        $sqlStr = "select userID,(select MenuName from treemenu where MenuId=department.menuID limit 1) as departmentName from department where menuID in ( select ownerMenuIDList from departmentOther where id='".$data["departmentID"]."');";
        $GLOBAL['htmlDefine']['replaceArray']['__CHECKUSER1__'] = $GLOBAL["G_DB_OBJ"]->getFieldValue( "select uid from user where user.id='".$data["__USERID2__"]."'",1);
        $GLOBAL['htmlDefine']['replaceArray']['__CHECKUSER2__'] = getComboxFromSql_v2( "userIDtmp", $sqlStr,$data["__USERID2__"],"","disabled=\"disabled\"" );
    }
    if ( $data["statusFlag"] == "0" )
    {
        $title1 = "整&nbsp;&nbsp;改&nbsp;&nbsp;情&nbsp;&nbsp;况";
        $title2 = "未&nbsp;整&nbsp;改&nbsp;原&nbsp;因";
        $GLOBAL['htmlDefine']['replaceArray']['__RADIO0CHECKED__'] = "checked";
        $GLOBAL['htmlDefine']['replaceArray']['__RADIO1CHECKED__'] = "";
        $GLOBAL['htmlDefine']['replaceArray']['__DISPLAY0__'] = "display:none";
        $GLOBAL['htmlDefine']['replaceArray']['__DISPLAY1__'] = "display:block";
        $GLOBAL['htmlDefine']['replaceArray']['__TITLE__'] = $title2;

    }
    else
    {
        $title1 = "整&nbsp;&nbsp;改&nbsp;&nbsp;情&nbsp;&nbsp;况";
        $title2 = "未&nbsp;整&nbsp;改&nbsp;原&nbsp;因";
        $GLOBAL['htmlDefine']['replaceArray']['__RADIO0CHECKED__'] = "";
        $GLOBAL['htmlDefine']['replaceArray']['__RADIO1CHECKED__'] = "checked";
        $GLOBAL['htmlDefine']['replaceArray']['__DISPLAY0__'] = "display:block";
        $GLOBAL['htmlDefine']['replaceArray']['__DISPLAY1__'] = "display:none";
        $GLOBAL['htmlDefine']['replaceArray']['__TITLE__'] = $title1;

    }
    if ( !Empty($data["srcFilePath"])  )
    {
        $GLOBAL['htmlDefine']['replaceArray']['__SRCFILEPATH__'] = $data["srcFilePath"];
        $GLOBAL['htmlDefine']['replaceArray']['__DOWNLOADSTYLE__']="block";
    }
    else
    {
        $GLOBAL['htmlDefine']['replaceArray']['__DOWNLOADSTYLE__']="none";
        $GLOBAL['htmlDefine']['replaceArray']['__SRCFILEPATH__'] = '';
    }
    require_once(ABS_CUR_DIR_MENU_CONF . "../../../kernel/comm/loadModules.php");
    $moduleShowtmpl = loadModules("webPage", $errMsg);
    exit;
}

if ($opt === "editFlag") {
    $id=$_REQUEST['id'];
    $userID = $GLOBAL["G_DB_OBJ"]->getFieldValue("select userID from question where id='".$id."' limit 1;");
    if ( $userID !== $GLOBAL["runData"]["userData"]["id"] )
    {
        echo getHistoryBackScript( '您无权修改他人新建的台帐!' );
        exit;
    }

    if ( $_GET["subFlag"] == "reject" )
    {
        $sqlStr = "select id as __ID__,
            questionDetail as __QUESTIONDETAIL__,
            itemName as __ITEMNAME__,
            responsiblePeople as __RESONSIBLEPEOPLE__,
            departmentPeople as __DEPARTMENTPEOPLE__,
            (select bankName from banklist where banklist.id=question.bankID limit 1) as __BANKNAME__,
            userID1 as __USERID1__,
            userID2 as __USERID2__,
            bankFlag as __BANKFLAG__,
            bankID,
            date_format(endTime,'%Y-%m-%d')  as __ENDTIME__,
            departmentID,
            srcFilePath,
            statusFlag,
            timeLimit,
            situation as __SITUATION__,
            reason as __REASON__
             from question where id='".$id."' and editFlag='1';
            ";        
    }
    else 
    {
        $sqlStr = "select id as __ID__,
            questionDetail as __QUESTIONDETAIL__,
            itemName as __ITEMNAME__, 
            responsiblePeople as __RESONSIBLEPEOPLE__, 
            departmentPeople as __DEPARTMENTPEOPLE__,
            (select bankName from banklist where banklist.id=question.bankID limit 1) as __BANKNAME__,
            userID1 as __USERID1__,
            userID2 as __USERID2__,
            bankFlag as __BANKFLAG__,
            date_format(endTime,'%Y-%m-%d')  as __ENDTIME__,
            bankID,
            departmentID,
            srcFilePath,
            statusFlag,
            timeLimit,
            situation as __SITUATION__,
            reason as __REASON__
             from question where id='".$id."' and editFlag='0';
            ";
    }
    $data = $GLOBAL["G_DB_OBJ"]->executeSqlMap( $sqlStr, 1 );
    if ( !Empty( $data ) )
    {
        if ( $GLOBAL["G_DB_OBJ"]->getFieldValue("select bankLevel from banklist where id='".$data["bankID"]."'") == "0" )            
            $data["__DEPARTMENTNAME__"] = $GLOBAL["G_DB_OBJ"]->getFieldValue("select (select MenuName from treemenu where treemenu.MenuId=department.menuID) from department where id='".$data["departmentID"]."'");
        else
            $data["__DEPARTMENTNAME__"] = $GLOBAL["G_DB_OBJ"]->getFieldValue("select (select MenuName from treemenu where treemenu.MenuId=departmentOther.menuID) from departmentOther where id='".$data["departmentID"]."' and bankID='".$data["bankID"]."';");
    }
    $GLOBAL['htmlDefine']['replaceArray'] = array_merge( $GLOBAL['htmlDefine']['replaceArray'], $data );
    
    $GLOBAL['htmlDefine']['replaceArray']['__SELECT__']=preg_replace('/__OPTION[0-9]+__/','',str_replace('__OPTION'.$data["timeLimit"].'__','selected',$selectStr));
    $GLOBAL['htmlDefine']['replaceArray']['__UID__'] = $GLOBAL['runData']['userData']['uid'];
    
    if ( $data["bankFlag"] == "0" )
    {
        $GLOBAL['htmlDefine']['replaceArray']['__BANK0STYLE__'] = "display:block";
        $GLOBAL['htmlDefine']['replaceArray']['__BANK1STYLE__'] = "display:none";
        $GLOBAL['htmlDefine']['replaceArray']['__CHECKUSER1__'] = $GLOBAL["G_DB_OBJ"]->getFieldValue( "select uid from user where user.id='".$data["__USERID1__"]."'",1);
        $GLOBAL['htmlDefine']['replaceArray']['__CHECKUSER2__'] = $GLOBAL["G_DB_OBJ"]->getFieldValue( "select uid from user where user.id='".$data["__USERID2__"]."'",1);
    }
    else
    {
        $GLOBAL['htmlDefine']['replaceArray']['__BANK0STYLE__'] = "display:none";
        $GLOBAL['htmlDefine']['replaceArray']['__BANK1STYLE__'] = "display:block";
        $sqlStr = "select userID,(select MenuName from treemenu where MenuId=department.menuID limit 1) as departmentName from department where menuID in ( select ownerMenuIDList from departmentOther where id='".$data["departmentID"]."');";
        $GLOBAL['htmlDefine']['replaceArray']['__CHECKUSER1__'] = $GLOBAL["G_DB_OBJ"]->getFieldValue( "select uid from user where user.id='".$data["__USERID2__"]."'",1);
        $GLOBAL['htmlDefine']['replaceArray']['__CHECKUSER2__'] = getComboxFromSql( "userIDtmp", $sqlStr,$data["__USERID2__"],"changeUserID2(this)" );
    }
    if ( $data["statusFlag"] == "0" )
    {
        $title1 = "整&nbsp;&nbsp;改&nbsp;&nbsp;情&nbsp;&nbsp;况";
        $title2 = "未&nbsp;整&nbsp;改&nbsp;原&nbsp;因";
        $GLOBAL['htmlDefine']['replaceArray']['__RADIO0CHECKED__'] = "checked";
        $GLOBAL['htmlDefine']['replaceArray']['__RADIO1CHECKED__'] = "";
        $GLOBAL['htmlDefine']['replaceArray']['__DISPLAY0__'] = "display:none";
        $GLOBAL['htmlDefine']['replaceArray']['__DISPLAY1__'] = "display:block";
        $GLOBAL['htmlDefine']['replaceArray']['__TITLE__'] = $title2;
        
    }
    else
    {
        $title1 = "整&nbsp;&nbsp;改&nbsp;&nbsp;情&nbsp;&nbsp;况";
        $title2 = "未&nbsp;整&nbsp;改&nbsp;原&nbsp;因";
        $GLOBAL['htmlDefine']['replaceArray']['__RADIO0CHECKED__'] = "";
        $GLOBAL['htmlDefine']['replaceArray']['__RADIO1CHECKED__'] = "checked";
        $GLOBAL['htmlDefine']['replaceArray']['__DISPLAY0__'] = "display:block";
        $GLOBAL['htmlDefine']['replaceArray']['__DISPLAY1__'] = "display:none";
        $GLOBAL['htmlDefine']['replaceArray']['__TITLE__'] = $title1;
        
    }
    if ( !Empty($data["srcFilePath"])  )
    {
        $GLOBAL['htmlDefine']['replaceArray']['__SRCFILEPATH__'] = $data["srcFilePath"];
        $GLOBAL['htmlDefine']['replaceArray']['__DOWNLOADSTYLE__']="block";
    }
    else 
    {
        $GLOBAL['htmlDefine']['replaceArray']['__DOWNLOADSTYLE__']="none";
        $GLOBAL['htmlDefine']['replaceArray']['__SRCFILEPATH__'] = '';
    }
    require_once(ABS_CUR_DIR_MENU_CONF . "../../../kernel/comm/loadModules.php");
    $moduleShowtmpl = loadModules("webPage", $errMsg); 
}
if ( $opt==="delFlag" )
{
    $id=$_REQUEST["id"];
    $departmentID=$_REQUEST["departmentID"];
    if ( checkAcl($departmentID) ===false )
    {
        echo getHistoryBackScript( '您无操作权限!' );
        exit;
    }
    $srcFilePath = $GLOBAL['G_DB_OBJ']->getfieldValue("select srcFilePath from question where id='".$id."'");
    $rootDir = str_replace("/ckfinder/userfiles/","",$appConf['GLOBAL']['uploadDir']);
    $destRootFilePath = $rootDir.$srcFilePath;
    if ( !unlink($oldRootFilePath) )
        echo "delete file failed!".$oldRootFilePath."<br>";
    
    $sqlStr = "delete from question where id='".$id."' and editFlag='0' limit 1;";
    if ( $GLOBAL['G_DB_OBJ']->executeSql($sqlStr) !== 1 )
    {
        echo getErrorTmpl('/question.php?opt=listFlag0',"删除失败，请联络管理员!");
        exit;
    }
    else 
    {
        echo getAlertFormLocationJSCode('/question.php?opt=listFlag0',"删除成功!","","");
        exit;
    }
}
if ( $opt === "editFlagSave")//增加子项后台
{
    $id = $_REQUEST["id"];
    $userID = $GLOBAL["runData"]["userData"]["id"];

    $itemName = str_replace( "'", "\"", $_POST["itemName"] );
    $endTime = $_POST["endTime"];
    $responsiblePeople = str_replace( "'", "\"", $_POST["responsiblePeople"] );
    $departmentPeople = str_replace( "'", "\"", $_POST["departmentPeople"] );
    $statusFlag = $_POST["statusFlag"];
    $reason = str_replace( "'", "\"", $_POST["editor33"]);
    $srcFilePath = $_POST["srcFilePath"];
    $questionDetail = str_replace( "'", "\"", $_POST["editor11"] );
    $situation  = str_replace( "'", "\"", $_POST["editor22"] );

    if ( Empty( $srcFilePath ) )
    {
        echo getHistoryBackScript( '台帐原始资料必须上传不能为空!' );
        exit;
    }
    if ( !isDatetime($endTime, "Y-m-d" ) )
    {
        echo getHistoryBackScript( '请输入有效的整改完成时间!' );
        exit;
    }
    $rootDir = str_replace("/ckfinder/userfiles/","",$appConf['GLOBAL']['uploadDir']);
    $destFilePath = str_replace("/tmp/","/result/",$srcFilePath);
    $srcRootFilePath = $rootDir.$srcFilePath;
    $destRootFilePath = str_replace("/tmp/","/result/",$srcRootFilePath);


    if ( !rename($srcRootFilePath, $destRootFilePath) )
        echo "move file failed!".$srcRootFilePath."<br>";

    $fileBody = "<p>".$fileBody."</p>";
    $sqlStr = "update question set 
        itemName='".$itemName."',endTime='".$endTime."',responsiblePeople='".$responsiblePeople."',departmentPeople='".$departmentPeople."',
            srcFilePath='".$destFilePath."',questionDetail='".$questionDetail."',situation='".$situation."',reason='".$reason."',statusFlag='".$statusFlag."' where id='".$id."'
        ";

    if ($GLOBAL['G_DB_OBJ']->executeSql($sqlStr) === 1 )
    {
        if  ( strpos($_SERVER["HTTP_REFERER"],"&subFlag=reject&" )  === false )
            echo getAlertFormLocationJSCode('/question.php?opt=listFlag0',"台帐修改成功,请到台帐草稿里送审","");
        else 
            echo getAlertFormLocationJSCode('/question.php?opt=listFlag3',"台帐修改成功,请到台帐草稿里送审","");
    }
    else 
    {
        echo getErrorTmpl("保存失败，请联络管理员!");
    }
    exit;
}
if ($opt === "addFlag") {

    $userID = $GLOBAL["runData"]["userData"]["id"];
    $uid = $GLOBAL["runData"]["userData"]["uid"];
    $bankName = "";
    $bankID="";
    $departmentName = "";
    $departmentID = "";
    $v1 = "";
    $leaderID="";
    $leaderName="";
    $department = $GLOBAL["G_DB_OBJ"]->executeSqlMap( "select id,bankID,(select MenuName from treemenu where MenuId=department.menuID limit 1) as departmentName from department where viewUserID = '".$userID."'",1);
    $userFlag=0;//0为中心支行录入
    if ( Empty( $department["departmentName"] ) )
    {  
        $department = $GLOBAL["G_DB_OBJ"]->executeSqlMap( "select id,bankID,(select MenuName from treemenu where MenuId=departmentOther.menuID limit 1) as departmentName from departmentOther where userID = '".$userID."'",1);
        if ( !Empty( $department["departmentName"]  ) )
        {
            $userFlag=1;//1为旗县支行录入
            $departmentName = $department["departmentName"];
            $bankName = $GLOBAL["G_DB_OBJ"]->getFieldValue( "select bankName from banklist where id='".$department["bankID"]."';");
            $v1 = $bankName."->".$departmentName;
        }
    }
    else 
    {
        $departmentName = $department["departmentName"];
        $bankName = $GLOBAL["G_DB_OBJ"]->getFieldValue( "select bankName from banklist where id='".$department["bankID"]."';");
        $v1 = $bankName."->".$departmentName;
    }
    $departmentID = $department["id"];
    $bankID=$department["bankID"];
    ////????????有问题
    $leader = $GLOBAL["G_DB_OBJ"]->executeSqlMap("SELECT userID,name from `leader` WHERE bankID='".$bankID."' and ( departmentIDList='".$departmentID."' or instr(departmentIDList,'".$departmentID.",') = 1 or right(departmentIDList,length('".$departmentID."')+1)=',".$departmentID."' or instr(departmentIDList,',".$departmentID.",') > 0 )",1);

    $who = whoami( $userID );
    if ( $who !== "旗县支行科长" && $who !== "巴市支行科员" )
    {
        echo getWinAlert("非台帐录入人员，不能新建台帐(旗县支行科长与巴市支行科员可以录入台帐)!");
    }
    else 
    {
        if ( Empty( $leader ) )
            echo getWinAlert("您所在的科室未分配分管领导，将无法新建台帐，请联络管理员");
    }
    $leaderID = $leader["userID"];
    if ( Empty( $v1 ) )
        $v1 = "非台帐录入人员，无责任科室";

    if ( $userFlag === 0 )
    {
        $GLOBAL['htmlDefine']['replaceArray']['__BANK0STYLE__'] = "display:block";
        $GLOBAL['htmlDefine']['replaceArray']['__BANK1STYLE__'] = "display:none";
        //中心支行为科长为审核员
        $GLOBAL['htmlDefine']['replaceArray']['__USERID1__'] = $GLOBAL["G_DB_OBJ"]->getFieldValue( "select userID from department where viewUserID = '".$userID."'",1);
        $GLOBAL['htmlDefine']['replaceArray']['__CHECKUSER1__'] = $GLOBAL["G_DB_OBJ"]->getFieldValue( "select (select uid from user where user.id=department.userID) from department where viewUserID = '".$userID."'",1);
        $GLOBAL['htmlDefine']['replaceArray']['__CHECKUSER2__'] = $leader["name"];
        $GLOBAL['htmlDefine']['replaceArray']['__USERID2__'] = $leaderID;
        $GLOBAL['htmlDefine']['replaceArray']['__BANKFLAG__'] = "0";
    }
    else
    {
        $GLOBAL['htmlDefine']['replaceArray']['__BANK0STYLE__'] = "display:none";
        $GLOBAL['htmlDefine']['replaceArray']['__BANK1STYLE__'] = "display:block";
        $sqlStr = "select userID,(select MenuName from treemenu where MenuId=department.menuID limit 1) as departmentName from department where menuID in ( select ownerMenuIDList from departmentOther where id='".$departmentID."');";
        $GLOBAL['htmlDefine']['replaceArray']['__USERID1__']  =$leaderID;
        $GLOBAL['htmlDefine']['replaceArray']['__CHECKUSER1__'] = $leader["name"];
        //"userid2为用户自己去选"
        $GLOBAL['htmlDefine']['replaceArray']['__CHECKUSER2__'] = getComboxFromSql_v2( "userIDtmp", $sqlStr,"","changeUserID2(this)" );
        $GLOBAL['htmlDefine']['replaceArray']['__USERID2__'] = "";
        $GLOBAL['htmlDefine']['replaceArray']['__BANKFLAG__'] = "1";
    }

    $GLOBAL['htmlDefine']['replaceArray']['__UID__'] = $uid;
    $GLOBAL['htmlDefine']['replaceArray']['__BANKID__'] = $bankID;
    $GLOBAL['htmlDefine']['replaceArray']['__SELECT__'] = preg_replace('/__OPTION[0-9]+__/','',$selectStr);
    $GLOBAL['htmlDefine']['replaceArray']['__DEPARTMENTID__'] = $departmentID;

    $GLOBAL['htmlDefine']['replaceArray']['__DEPARTMENTNAME__'] = $v1;
    $GLOBAL['htmlDefine']['replaceArray']['__DOWNLOADSTYLE__'] = "none";
    $GLOBAL['htmlDefine']['replaceArray']['__SRCFILEPATH__'] = '';

    
    require_once(ABS_CUR_DIR_MENU_CONF . "../../../kernel/comm/loadModules.php");
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
function whoami_v1( $userID=0 )
{
    global $GLOBAL;
    $ret = array();
    $ret["uid"] = $GLOBAL["G_DB_OBJ"]->getFieldValue("select uid from user where id='".$userID."' limit 1");
    //echo "userID:".$userID."<br>";
    $v1 = $GLOBAL["G_DB_OBJ"]->executeSqlMap( "select (select MenuName from treemenu where MenuId = departmentOther.menuID limit 1) as departmentName,(select bankName from banklist where id=departmentOther.bankID limit 1 ) as bankName from departmentOther where userID='".$userID."' limit 1;" ,1);
    if ( !Empty( $v1 ) )
    {
        $ret["bankName"]=$v1["bankName"];
        $ret["departmentName"]=$v1["departmentName"];
        $ret["name"] = "科长";

        return $ret["bankName"].">".$ret["departmentName"].">".$ret["name"].">".$ret["uid"];
    }
    $v1 = $GLOBAL["G_DB_OBJ"]->executeSqlMap( "select (select MenuName from treemenu where MenuId = departmentOther.menuID limit 1) as departmentName,(select bankName from banklist where id=departmentOther.bankID limit 1 ) as bankName from departmentOther where viewUserID='".$userID."' limit 1;" ,1);
    if ( !Empty( $v1 ) )
    {
        $ret["bankName"]=$GLOBAL["G_DB_OBJ"]->getFieldValue( "select bankName from banklist where id='".$v1["bankID"]."' limit 1;" );
        $ret["departmentName"]=$v1["departmentName"];
        $ret["name"] = "科员";
        return $ret["bankName"].">".$ret["departmentName"].">".$ret["name"].">".$ret["uid"];
    }
    $v1 = $GLOBAL["G_DB_OBJ"]->executeSqlMap( "select id,name,(select bankName from banklist where banklist.id=leader.bankID limit 1) as bankName,(select bankLevel from banklist where banklist.id=leader.bankID limit 1) as bankLevel from leader where userID='".$userID."';",1 );
    if ( !Empty( $v1 ) )
    {
        if ( $ret["bankLevel"] == "1" )
            $ret["name"] = "分管领导";
        else
            $ret["name"] = "分管领导";
        $ret["bankName"]=$v1["bankName"];
        $ret["departmentName"]="分管领导";
        $ret["name"]=$v1["name"];
        return $ret["bankName"].">".$ret["departmentName"].">".$ret["name"].">".$ret["uid"];
    }
    $v1 = $GLOBAL["G_DB_OBJ"]->executeSqlMap( "select (select MenuName from treemenu where MenuId = department.menuID limit 1) as departmentName,(select bankName from banklist where id=department.bankID limit 1 ) as bankName from department where userID='".$userID."' limit 1;" ,1);
    if ( !Empty( $v1 ) )
    {
        $ret["bankName"]=$v1["bankName"];
        $ret["departmentName"]=$v1["departmentName"];
        $ret["name"] = "科长";
        return $ret["bankName"].">".$ret["departmentName"].">".$ret["name"].">".$ret["uid"];
    }
    $v1 = $GLOBAL["G_DB_OBJ"]->executeSqlMap( "select (select MenuName from treemenu where MenuId = department.menuID limit 1) as departmentName,(select bankName from banklist where id=department.bankID limit 1 ) as bankName from department where viewUserID='".$userID."' limit 1;" ,1);
    if ( !Empty( $v1 ) )
    {
        $ret["bankName"]=$v1["bankName"];
        $ret["departmentName"]=$v1["departmentName"];
        $ret["name"] = "科员";
        return $ret["bankName"].">".$ret["departmentName"].">".$ret["name"].">".$ret["uid"];
    }
    $v1 = $GLOBAL["G_DB_OBJ"]->executeSqlMap( "select id,bankLevel,bankName from banklist where userID='".$userID."';", 1 );
    if ( !Empty( $v1  ) )
    {
        //echo  "select id,bankLevel,bankName from banklist where userID='".$userID."';";
        $ret["bankName"]=$v1["bankName"];
        $ret["departmentName"]="";
        $ret["name"] = "审计帐号";
        return $ret["bankName"].">".$ret["name"].">".$ret["uid"];
    }
    if ( $GLOBAL["G_DB_OBJ"]->getFieldValue( "select uid from user where id='".$userID."';" ) == "admin" )
    {
        $ret["bankName"]=$GLOBAL["G_DB_OBJ"]->getFieldValue( "select bankName from banklist where bankLevel='0' limit 1;" );
        $ret["departmentName"]="科技科";
        $ret["name"] = "超级管理员";
        return $ret["bankName"].">".$ret["departmentName"].">".$ret["name"].">".$ret["uid"];
    }
    $ret["bankName"]=$GLOBAL["G_DB_OBJ"]->getFieldValue( "select bankName from banklist where bankLevel='0' limit 1;" );
    $ret["departmentName"]="未知";
    $ret["name"] = "未知";
        return $ret["bankName"].">".$ret["departmentName"].">".$ret["name"].">".$ret["uid"];
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
