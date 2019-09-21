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
    $searchSql = getSearchSql();
    //echo "sql:".$searchSql."<br>";
    /*"(case 
        when editFlag='0' then '草稿'
        when check1='0' and check2='0' and check3='0' and editFlag='1' then '被驳回'
        when check1='1' and check2='0' and check3='0' and editFlag='1' then '待审核'
        when check1='1' and check2='1' and check3='0' and editFlag='1' then '待销号'
        when check1='1' and check2='1' and check3='1' and endFlag='1' then '已销号'
        end)"
        */
    //ssssxxxxx
    $key1 = str_replace("17514","'", isset( $_REQUEST["key1"] ) ? ( $_REQUEST["key1"]) : '' );
    $GLOBAL['modulesInfo']['userKey'] = array(
        '(select bankName from banklist where id=question.bankID limit 1)'=>'__BANKNAME__',
        '(case when bankFlag=\'0\' then (select (select MenuName from treemenu where treemenu.MenuId=department.menuID limit 1) from department where department.id=question.departmentID limit 1) when bankFlag=\'1\' then (select (select MenuName from treemenu where treemenu.MenuId=departmentOther.menuID limit 1) from departmentOther where departmentOther.id=question.departmentID limit 1) end)'=>'__DEPARTMENTNAME__',
        'itemName'=>'__ITEMNAME__',
        'replace(questionDetail,\''.$key1.'\',\'<font color="red">'.$key1.'</font>\')'=>'__QUESTIONDETAIL__',
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
    $GLOBAL['modulesInfo']['subSql'] = $searchSql;
    $GLOBAL['modulesInfo']['orderSubSql'] = ' order by id desc';
    //$GLOBAL['htmlDefine']['replaceArray']['__SEARCHLIST__'] = $searchSql;
    $searchSql=str_replace("'","17453",$searchSql);
    //echo "<br>".$searchSql=str_replace("'","",$searchSql)."<br>";
    //$GLOBAL[ 'modulesInfo' ][ 'buttomStr' ] = str_replace( '__SEARCHLIST__', "sql=".$searchSql, $GLOBAL['modulesInfo']['buttomStr'] );
    //echo "<br>".$GLOBAL[ 'modulesInfo' ][ 'buttomStr' ]."<br>";

    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");

    $moduleShowtmpl = loadModules("webPage", $errMsg);
    exit;
}

if ($opt === "detail") {
    $searchType=!Empty($_REQUEST['searchType'])?$_REQUEST['searchType']:'';
    $key1=!Empty($_REQUEST['key1'])?$_REQUEST['key1']:'';
    $key2=!Empty($_REQUEST['key2'])?$_REQUEST['key2']:'';
    $key3=!Empty($_REQUEST['key3'])?$_REQUEST['key3']:'';
    $fileID=$_REQUEST['fileID'];
    $id = $_REQUEST["id"];
    $info = $GLOBAL['G_DB_OBJ']->executeSql("select fileID as __FILEID__,menuID,publicFlag, srcFileName as __SRCFILENAME__, srcFilePath as __SRCFILEPATH__, fileBody as __FILEBODY__ from fileList where fileID = '".$fileID."';");
    $aclFlag=checkMenuOptAcl( $info['menuID'] );

    if ( $aclFlag === false && $info['publicFlag']== '1')
    {
        if ($_SESSION['userData']['uid'] !== 'user'
            && $_SESSION['userData']['uid'] !== 'nsk1'
            && $_SESSION['userData']['uid'] !== 'jwjcs1')
        {
            echo getWebLocationScript("/fileList.php?opt=listFlag","对不起，您无查看权限!");
            exit;
        }
    }
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
    //print_r($_SESSION);
    $tmpSql = "insert into optlog(title,text,userID,ip) values('阅读','阅读文件','".$_SESSION['userData']['id']."','".$_SESSION['userData']['ip']."');";
    $GLOBAL['G_DB_OBJ']->executeSql($tmpSql);
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
function checkMenuOptAcl( $menuID=0,$_sessionUserMenuID=0 )
{

    global $GLOBAL;
    if ( $GLOBAL['runData']['userData']["uid"] ===  "admin" )
        return True;
    $sessionUserMenuID=$_sessionUserMenuID;
    if ( $sessionUserMenuID === 0 )
        $sessionUserMenuID=$GLOBAL['G_DB_OBJ']->getFieldValue("select menuID from department where userID='".$GLOBAL['runData']['userData']["id"]."' or viewUserID='".$GLOBAL['runData']['userData']["id"]."';");
    $menuArr = $GLOBAL['G_DB_OBJ']->executeSqlMap("select MenuPId,MenuName from webadmin.treemenu where MenuId=".$menuID,1);
    if ( Empty( $menuArr ) )
    {
        return False;
    }
    if ( $menuArr['MenuPId'] !== "0" )
    {
        return checkMenuOptAcl( $menuArr['MenuPId'],$sessionUserMenuID );
    }
    else
    {
        return ($sessionUserMenuID===$menuID)?True:False;
    }
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
       $menuPath = "<li><a href=\"#\">".$menuArr['MenuName']."</a></li>".$menuPath; 
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
    //echo "select id,bankLevel from banklist where userID='".$userID."';";
    $ret = $GLOBAL["G_DB_OBJ"]->executeSqlMap( "select id,bankLevel from banklist where userID='".$userID."';", 1 );
    if ( !Empty( $ret  ) )
    {
        if ( $ret["bankLevel"] == "1" )
            return "旗县全局帐号";
    }
    $uid = $GLOBAL["G_DB_OBJ"]->getFieldValue( "select uid from user where id='".$userID."' limit 1;" );
    if ( $uid == "nsk1" || $uid == "jwjcs1" ||  $uid == "user1" )
        return "巴市支行全局帐号";
    if ( $GLOBAL["G_DB_OBJ"]->getFieldValue( "select uid from user where id='".$userID."';" ) == "admin" )
        return "超级管事员";
    return "未知帐号";
}
function getSearchSql()
{
    $selectGroupStr = '<optgroup label="__BANKNAME__">
    __OPTIONLISTSTR__
    </optgroup>';
    $selectOptionStr = '<option value="__BANKID__,__BANKLEVEL__,__DEPARTMENTID__">__DEPARTMENTNAME__</option>';
    global $GLOBAL;
    $userID = $GLOBAL["runData"]["userData"]["id"];
    $who = whoami( $userID );
    
    $bankIDList=array();
    $bankNameList=array();
    $bankLevelList = array();
    $departmentIDList=array();
    $departmentNameList=array();
    $whoSql="";
    if ( $who === "旗县支行科员" )
    {
        $bankID = $GLOBAL["G_DB_OBJ"]->getFieldValue( "select bankID from departmentOther where viewUserID='".$userID."' limit 1" );
        array_push( $bankIDList, $bankID );
        array_push( $bankLevelList, '1' );
        array_push( $bankNameList, $GLOBAL["G_DB_OBJ"]->getFieldValue( "select bankName from banklist where banklist.id='".$bankID."' limit 1;" ) );
        $v1 = $GLOBAL["G_DB_OBJ"]->getFieldValue( "select id from departmentOther where viewUserID='".$userID."' limit 1");
        $departmentIDList[ $bankID ] = array( $v1 );
        $departmentNameList[ $bankID ] = array( $GLOBAL["G_DB_OBJ"]->getFieldValue( "select (select MenuName from treemenu where MenuId=departmentOther.menuID limit 1 ) from departmentOther where viewUserID='".$userID."' limit 1" ) );
        $whoSql = " bankID='".$bankID."' and departmentID='".$v1."'";
    }
    elseif( $who === "旗县支行科长" )
    {
        $bankID = $GLOBAL["G_DB_OBJ"]->getFieldValue( "select bankID from departmentOther where userID='".$userID."' limit 1" );
        array_push( $bankIDList, $bankID );
        array_push( $bankLevelList, '1' );
        array_push( $bankNameList, $GLOBAL["G_DB_OBJ"]->getFieldValue( "select bankName from banklist where banklist.id='".$bankID."' limit 1;" ) );
        $v1 = $GLOBAL["G_DB_OBJ"]->getFieldValue( "select id from departmentOther where userID='".$userID."' limit 1" );
        $departmentIDList[ $bankID ] = array( $v1 );
        $departmentNameList[ $bankID ] = array( $GLOBAL["G_DB_OBJ"]->getFieldValue( "select (select MenuName from treemenu where MenuId=departmentOther.menuID limit 1 ) from departmentOther where userID='".$userID."' limit 1" ) );
        $whoSql = " bankID='".$bankID."' and departmentID='".$v1."'";
    }
    elseif( $who === "旗县支行领导" )
    {
        $bankID = $GLOBAL["G_DB_OBJ"]->getFieldValue("select bankID from leader where userID='".$userID."' limit 1");
        array_push( $bankIDList, $bankID );
        array_push( $bankLevelList, '1' );
        array_push( $bankNameList, $GLOBAL["G_DB_OBJ"]->getFieldValue( "select bankName from banklist where banklist.id='".$bankID."' limit 1;" ) );
        $vv = $GLOBAL["G_DB_OBJ"]->getFieldValue("select departmentIDList from leader where userID='".$userID."' limit 1");
    
        $v1 = implode( ",",  $vv );
        $v2 = array();
        $departmentIDList[ $bankID ] = $v1;
        while ( current( $v1 ) !== false )
        {
            array_push( $v2, $GLOBAL["G_DB_OBJ"]->getFieldValue("select (select MenuName form treemenu where MenuId=departmentOther.menuID limit 1) from departmentOther where id='".current( $v1 )."' limit 1;" ) );
            next( $v1 );
        }
        $departmentNameList[ $bankID ] = $v2;
        $whoSql = " bankID='".$bankID."' and departmentID in(".$v1.")";
    }
    
    elseif( $who === "巴市支行科员" )
    {
        $bankID = $GLOBAL["G_DB_OBJ"]->getFieldValue("select bankID from department where viewUserID='".$userID."' limit 1");
        array_push( $bankIDList, $bankID );
        array_push( $bankLevelList, '0' );
        array_push( $bankNameList, $GLOBAL["G_DB_OBJ"]->getFieldValue( "select bankName from banklist where banklist.id='".$bankID."' limit 1;" ) );
        $v1 = $GLOBAL["G_DB_OBJ"]->getFieldValue("select id from department where viewUserID='".$userID."' limit 1" );
        $departmentIDList[ $bankID ] = array( $v1 );
        $departmentNameList[ $bankID ] = array( $GLOBAL["G_DB_OBJ"]->getFieldValue( "select (select MenuName from treemenu where MenuId=department.menuID limit 1 ) from department where viewUserID='".$userID."' limit 1" ) );
        $whoSql = " bankID='".$bankID."' and departmentID ='".$v1."'";
    }
    elseif( $who === "巴市支行科长" )
    {
        $bankID =$GLOBAL["G_DB_OBJ"]->getFieldValue("select bankID from department where userID='".$userID."' limit 1");
        array_push( $bankIDList, $bankID );
        array_push( $bankLevelList, '0' );
        array_push( $bankNameList, $GLOBAL["G_DB_OBJ"]->getFieldValue( "select bankName from banklist where banklist.id='".$bankID."' limit 1;" ) );
        $vv = $GLOBAL["G_DB_OBJ"]->getFieldValue("select id from department where userID='".$userID."' limit 1" );
        $departmentIDList[ $bankID ] = array( $vv );
        $departmentNameList[ $bankID ] = array( $GLOBAL["G_DB_OBJ"]->getFieldValue( "select (select MenuName from treemenu where MenuId=department.menuID limit 1 ) from department where userID='".$userID."' limit 1" ) );
        $menuID = $GLOBAL["G_DB_OBJ"]->getFieldValue("select menuID from department where userID='".$userID."' limit 1");
        $v1 = $GLOBAL["G_DB_OBJ"]->executeSqlMap("select bankID,(select bankName from banklist where id=bankID limit 1) as bankName,'1' as bankLevel, id as departmentID,(select MenuName from treemenu where MenuId=departmentOther.menuID limit 1) as departmentName from departmentOther where (ownerMenuIDList='".$menuID."' or instr(ownerMenuIDList,'".$menuID.",') = 1 or right(ownerMenuIDList,length(',".$menuID."'))='".$menuID."' or instr(ownerMenuIDList,',".$menuID.",')>0 ) limit 1",1);
        //print_r( $v1 );
    
        if ( !Empty( $v1 ) )
        {
            array_push( $bankIDList, $v1["bankID"] );
            array_push( $bankLevelList, $v1["bankLevel"] );
            array_push( $bankNameList, $v1["bankName"] );
            $departmentIDList[ $v1["bankID"] ] = array( $v1["departmentID"] );
            $departmentNameList[ $v1["bankID"] ] = array( $v1["departmentName"] );
            $vv = $vv.",".$v1["departmentID"];
        }
        $whoSql = " bankID='".$bankID."' and departmentID in (".$vv.")";
        //print_r( $departmentIDList );
        //exit;
    }
    elseif( $who === "巴市支行领导" )
    {
        $bankID = $GLOBAL["G_DB_OBJ"]->getFieldValue("select bankID from leader where userID='".$userID."' limit 1");
        array_push( $bankIDList, $bankID );
        array_push( $bankLevelList, '0' );
        array_push( $bankNameList, $GLOBAL["G_DB_OBJ"]->getFieldValue( "select bankName from banklist where banklist.id='".$bankID."' limit 1;" ) );
        $vv =  $GLOBAL["G_DB_OBJ"]->getFieldValue("select departmentIDList from leader where userID='".$userID."' limit 1");
    
        if ( strpos( $vv, "," ) !== false )
            $v1 = explode( ",", $vv );
        else
            $v1 = array( $vv );
        $v2 = array();
        $departmentIDList[ $bankID ] = $v1;

        while ( current( $v1 ) !== false )
        {
            array_push( $v2, $GLOBAL["G_DB_OBJ"]->getFieldValue("select (select MenuName from treemenu where MenuId=department.menuID limit 1) from department where id='".current( $v1 )."' limit 1;" ) );
            next( $v1 );
        }
        $departmentNameList[ $bankID ] = $v2;
        $whoSql = " bankID='".$bankID."' and departmentID in (".$vv.")";

    }
    elseif( $who === "旗县全局帐号" )
    {
        $bankID = $GLOBAL["G_DB_OBJ"]->getFieldValue("select id from banklist where userID='".$userID."' limit 1");
        array_push( $bankIDList, $bankID );
        array_push( $bankLevelList, '1' );
        $whoSql = " bankID='".$bankID."'";
        array_push( $bankNameList, $GLOBAL["G_DB_OBJ"]->getFieldValue( "select bankName from banklist where banklist.id='".$bankID."' limit 1;" ) );
        $departmentIDList[ $bankID ] = $GLOBAL["G_DB_OBJ"]->getSqlMap("select id from departmentOther where bankID='".$bankID."' order by id asc;",1);
        $departmentNameList[ $bankID ] = $GLOBAL["G_DB_OBJ"]->getSqlMap("select (select MenuName from treemenu where MenuId=departmentOther.menuID limit 1) from departmentOther where bankID='".$bankID."' order by id asc;",1);
        $whoSql = " bankID='".$bankID."'";
    }
    elseif( $who === "巴市支行全局帐号" )
    {
        //echo "select id from banklist where userID='".$userID."' limit 1";
        $bankID = $GLOBAL["G_DB_OBJ"]->getFieldValue("select id from banklist where bankLevel='0' limit 1");
        array_push( $bankIDList, $bankID );
        array_push( $bankLevelList, '0' );
        array_push( $bankNameList, $GLOBAL["G_DB_OBJ"]->getFieldValue( "select bankName from banklist where banklist.id='".$bankID."' limit 1;" ) );
        $departmentIDList[ $bankID ] = $GLOBAL["G_DB_OBJ"]->getSqlMap("select id from department where bankID='".$bankID."' order by id asc;",1);
        $departmentNameList[ $bankID ] = $GLOBAL["G_DB_OBJ"]->getSqlMap("select (select MenuName from treemenu where MenuId=department.menuID limit 1) from department where bankID='".$bankID."' order by id asc;",1);
    
        $v1 = $GLOBAL["G_DB_OBJ"]->getSqlMap("select id from banklist where bankLevel='1'",1);
         
        while( current( $v1 ) !== false )
        {
            $bankID = current( $v1 );
            array_push( $bankIDList, $bankID );
            array_push( $bankLevelList, '1' );
            array_push( $bankNameList, $GLOBAL["G_DB_OBJ"]->getFieldValue( "select bankName from banklist where banklist.id='".$bankID."' limit 1;" ) );
            $departmentIDList[ $bankID ] = $GLOBAL["G_DB_OBJ"]->getSqlMap("select id from departmentOther where bankID='".$bankID."' order by id asc;",1);
            $departmentNameList[ $bankID ] = $GLOBAL["G_DB_OBJ"]->getSqlMap("select (select MenuName from treemenu where MenuId=departmentOther.menuID limit 1) from departmentOther where bankID='".$bankID."' order by id asc;",1);
            next( $v1 );
        }
        $whoSql = "";
    }
    //否则为超级管理员，所有台帐全可查看
    else
    {
        //echo "select id from banklist where userID='".$userID."' limit 1";
        $bankID = $GLOBAL["G_DB_OBJ"]->getFieldValue("select id from banklist where bankLevel='0' limit 1");
        array_push( $bankIDList, $bankID );
        array_push( $bankLevelList, '0' );
        array_push( $bankNameList, $GLOBAL["G_DB_OBJ"]->getFieldValue( "select bankName from banklist where banklist.id='".$bankID."' limit 1;" ) );
        $departmentIDList[ $bankID ] = $GLOBAL["G_DB_OBJ"]->getSqlMap("select id from department where bankID='".$bankID."' order by id asc;",1);
        $departmentNameList[ $bankID ] = $GLOBAL["G_DB_OBJ"]->getSqlMap("select (select MenuName from treemenu where MenuId=department.menuID limit 1) from department where bankID='".$bankID."' order by id asc;",1);
    
        $v1 = $GLOBAL["G_DB_OBJ"]->getSqlMap("select id from banklist where bankLevel='1'",1);
         
        while( current( $v1 ) !== false )
        {
            $bankID = current( $v1 );
            array_push( $bankIDList, $bankID );
            array_push( $bankLevelList, '1' );
            array_push( $bankNameList, $GLOBAL["G_DB_OBJ"]->getFieldValue( "select bankName from banklist where banklist.id='".$bankID."' limit 1;" ) );
            $departmentIDList[ $bankID ] = $GLOBAL["G_DB_OBJ"]->getSqlMap("select id from departmentOther where bankID='".$bankID."' order by id asc;",1);
            $departmentNameList[ $bankID ] = $GLOBAL["G_DB_OBJ"]->getSqlMap("select (select MenuName from treemenu where MenuId=departmentOther.menuID limit 1) from departmentOther where bankID='".$bankID."' order by id asc;",1);
            next( $v1 );
        }
        $whoSql = "";
    }
    
    $selectListGroupStr = "";
    $optionListStr = "";
    $i = 0;
    while ( current( $bankIDList ) !== false )
    {
        $bankID = current( $bankIDList );
        $bankLevel= $bankLevelList[ $i ];
        $v1 = str_replace( '__BANKNAME__', $bankNameList[ $i ], $selectGroupStr );
        $j=0;
        $v2 = "";
    
        while ( current( $departmentIDList[ $bankID ] ) !== false )
        {
            $departmentID = current( $departmentIDList[ $bankID ] );
            $departmentName = $departmentNameList[ $bankID ][ $j ];
            $v3 = str_replace( '__BANKID__', $bankID, $selectOptionStr );
            $v3 = str_replace( '__BANKLEVEL__', $bankLevel, $v3 );
            $v3 = str_replace( '__DEPARTMENTID__', $departmentID, $v3 );
            $v3 = str_replace( '__DEPARTMENTNAME__', $departmentName, $v3 );
            $v2 .= $v3;
            $j++;
            next( $departmentIDList[ $bankID ] );
        }
        $selectListGroupStr .= str_replace( '__OPTIONLISTSTR__', $v2, $v1 );
        $i++;
        next( $bankIDList );
    }
    $GLOBAL['htmlDefine']['replaceArray']['__GROUPSELECTSTR__'] = $selectListGroupStr;

    $timeout = isset( $_REQUEST[ "timeout" ] )?$_REQUEST[ "timeout" ]:'';
    $statusFlag = str_replace("17154","'",isset( $_REQUEST[ "statusFlag" ] )?$_REQUEST[ "statusFlag" ]:'' );
    //echo $statusFlag."<br>";
    $checkStatus = isset( $_REQUEST[ "checkStatus" ] )?$_REQUEST[ "checkStatus" ] :'';
    $departmentIDList =  explode( ";", isset($_REQUEST[ "bankDepartment" ])?$_REQUEST[ "bankDepartment" ]:'' );
    $GLOBAL['htmlDefine']['replaceArray']['__BANKDEPARTMENT__'] = $_REQUEST[ "bankDepartment" ];
    $GLOBAL['htmlDefine']['replaceArray']['__CHECKSTATUS__'] = $_REQUEST[ "checkStatus" ];
    $GLOBAL['htmlDefine']['replaceArray']['__STATUSFLAG__'] = str_replace("17154","'",isset( $_REQUEST[ "statusFlag" ] )?$_REQUEST[ "statusFlag" ]:'' );
    $GLOBAL['htmlDefine']['replaceArray']['__TIMEOUT__'] = $_REQUEST[ "timeout" ];
    
    $key1 = str_replace("17514", "'", isset( $_REQUEST["key1"] ) ? $_REQUEST["key1"] : '');
    !Empty( $key1 )?( $tmpSql = "questionDetail like '%".$key1."%'" ) : ( $tmpSql = '' );
    if ( !Empty( $tmpSql ) )
        !Empty( $searchSql ) ? ( $searchSql = $tmpSql." and ".$searchSql) : ( $searchSql = $tmpSql );
    $GLOBAL['htmlDefine']['replaceArray']['__KEY1__'] = $key1;
        
    $tmpStr = "bankDepartment=".$_REQUEST[ "bankDepartment" ]."&checkStatus=".$_REQUEST["checkStatus"]."&statusFlag=".$_REQUEST["statusFlag"]."&timeout=".$_REQUEST["timeout"]."&key1=".$key1;
    $tmpStr = str_replace("'","17154",$tmpStr);
    $GLOBAL[ 'modulesInfo' ][ 'buttomStr' ] = str_replace( '__SEARCHLIST__', $tmpStr, $GLOBAL['modulesInfo']['buttomStr'] );
    $bankListID0="";
    $departmentListID0="";
    $bankListID1="";
    $departmentList1="";
    while( current( $departmentIDList ) !== false )
    {
        $bankDepartmentID = current( $departmentIDList );
        $v1 = explode( ",",$bankDepartmentID );
    
        if ( $v1[1] == 0 )
        {
            Empty( $bankListID0 )?( $bankListID0 = $v1[0] ):( $bankListID0 = $v1[0].",".$bankListID0 );
            //echo $v1[0];
            Empty( $departmentListID0 )?( $departmentListID0 = $v1[2] ):( $departmentListID0 = $v1[2].",".$departmentListID0 );
        }
        else
        {
            Empty( $bankListID1 )?( $bankListID1 = $v1[0] ):( $bankListID1 = $v1[0].",".$bankListID1 );
            Empty( $departmentListID1 )?( $departmentListID1 = $v1[2] ):( $departmentListID1 = $v1[2].",".$departmentListID1 );
        }
        next( $departmentIDList );
    }
    $searchSql1 = "";
    $searchSql2 = "";
    if ( !Empty( $bankListID0 ) )
        $searchSql1 = " bankID in (".$bankListID0.") and departmentID in (".$departmentListID0.")";
    if ( !Empty( $bankListID1 ) )
        $searchSql2 = " bankID in (".$bankListID1.") and departmentID in (".$departmentListID1.")";
    $searchSql = "";
    /*
     * <option value="1">已销号</option>
     <optgroup label="未销号">
     <option value="2">已超过整改时限</option>
     <option value="3">剩余10天时限</option>
     <option value="4">剩余20天时限</option>
     <option value="5">剩余20天以上时限</option>
     */
    if ( !Empty( $endFlag ) )
    {
        $v1 = explode( ",", $endFlag );
        $sql1 = "";
        $sql2 = "";
        while( current( $v1 ) !== false )
        {
            $v2 = current( $v1 );

            //timeout的台帐
            if ( $v2 == "1" )
                !Empty( $sql2 ) ? ( $sql2 = " or endTime<now() " ) :( $sql2 = " endTime<now() " );
            elseif ( $v2 == "2" )
                !Empty( $sql2 ) ? ( $sql2 = " or datediff( endTime,now() ) <= 10 " ) :( $sql2 = " datediff( endTime,now() ) <= 10  " );
            elseif ( $v2 == "3" )
                !Empty( $sql2 ) ? ( $sql2 = " or datediff( endTime,now() ) <= 20 " ) :( $sql2 = " datediff( endTime,now() ) <= 20  " );
            elseif ( $v2 == "4" )
                !Empty( $sql2 ) ? ( $sql2 = " or datediff( endTime,now() ) > 20 " ) :( $sql2 = " datediff( endTime,now() ) > 20  " );

            next( $v1 );
        }
        if ( !Empty( $sql2 ) )
            !Empty( $searchSql ) ? ( $searchSql .= " or ( endFlag='0' and ".$sql2.")") : ( $searchSql = "  ( endFlag='0' and ".$sql2.")");
    }
    if ( !Empty( $statusFlag ) )
        !Empty( $searchSql ) ? ( $searchSql .= " and statusFlag in (".$statusFlag.") " ) : ( $searchSql .= " statusFlag in (".$statusFlag.") " );

    /*
     * <option value="1">草稿</option>
     <option value="2">待审核</option>
     <option value="3">待销号</option>
     <option value="4">已驳回</option>
          <option value="5">已销号</option>
     */
  
    if( !Empty( $checkStatus ) )
    {
        $v1 = explode( ",", $checkStatus );
        $sql1 = "";
        while ( current( $v1 ) !== false  )
        {
            $val = current( $v1 );
            if ( $val == "1")
                !Empty( $sql1 ) ? ( $sql1 .= " and editFlag='0' ") : ( $sql1 = " editFlag='0' ");
            elseif ( $val == "2" )
                !Empty( $sql1 ) ? ( $sql1 .= " or ( check1='1' and check2='0') ") : ( $sql1 = " (check1='1' and check2='0') ");
            elseif ( $val == "3" )
                !Empty( $sql1 ) ? ( $sql1 .= " or ( check1='1' and check2='1' and check3='0' ) ") : ( $sql1 = " ( check1='1' and check2='1' and check3='0' ) ");
            elseif ( $val == "4" )
                !Empty( $sql1 ) ? ( $sql1 .= " or ( rejectFlag='1' ) ") : ( $sql1 = " rejectFlag='1' ");
            elseif ( $val == "5" )
                !Empty( $sql1 ) ? ( $sql1 .= " or ( endFlag='1' ) ") : ( $sql1 = " endFlag='1' ");
            next( $v1 );
        }
        if ( !Empty( $sql1 ) )
            !Empty( $searchSql ) ? ( $searchSql .= " and (".$sql1.")" ) : ( $searchSql = " (".$sql1.")" );
    }

    $tmpSql = "";
    if ( !Empty( $searchSql1 ) )
        $tmpSql = $searchSql1;
    if ( !Empty( $searchSql2 ) )
        !Empty( $tmpSql ) ? ( $tmpSql = "((".$tmpSql.") or (".$searchSql2."))" ):( $tmpSql = "(".$searchSql2.")" );
    if ( !Empty( $tmpSql ) )
        !Empty( $searchSql ) ? ( $searchSql = $tmpSql." and (".$searchSql.")" ) : ( $searchSql=$tmpSql );

    if ( !Empty( $whoSql ) )
        !Empty( $searchSql ) ? ( $searchSql = "(".$whoSql.") and (".$searchSql.")") : ( $searchSql = $whoSql );

    return $searchSql;
}
?>	