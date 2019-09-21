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
    $GLOBAL['modulesInfo']['userKey'] = array(
        'id'=>'__ID__',
        'bankName' => '__NAME__',
        '(case when( bankLevel=\'0\' ) then \'巴市支行\' else \'旗县支行\' end )' => '__TYPE__',
        'regTime' => '__REGTIME__'
    );


    $GLOBAL['modulesInfo']['tableName'] = 'banklist';//这个地方需要修改
    $GLOBAL['modulesInfo']['orderSubSql'] = ' order by regtime desc';
	//$GLOBAL['modulesInfo']['subSql'] = " MenuPid=0";
	//print_r( $GLOBAL );
    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
    $moduleShowtmpl = loadModules("webPage", $errMsg);
	//print_r( $GLOBAL );
	//require_once($moduleShowtmpl);
	
} else if ($opt === "addFlag") {
	//静态页面中需要注意，input框的name属性需要按照规则命名
    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
    if ( checkAcl(0) ===false )
    {
        echo getHistoryBackScript( '您无权增加支行!' );
        exit;
    }
     $moduleShowtmpl = loadModules("webPage", $errMsg);
	//require_once($moduleShowtmpl);
	
}else if ($opt === "addFlagSave") {
    //静态页面中需要注意，input框的name属性需要按照规则命名
    $name = $_POST["bankName_银行名称_textarea_1_20_1_1"];
    $bankLevel = $_POST["bankLevel_机构类型_integer_1_5_1_1"];
    $uid = $_POST["loginame_查看帐号_textboxen_3_16_1_1"];
    $passwd = $_POST["passwd_帐号密码_textboxen_3_16_1_1"];

    if ( $GLOBAL['G_DB_OBJ']->getFieldValue( "select bankName from banklist where bankName ='".$name."' limit 1" ) === $name )
    {
        echo getHistoryBackScript( '支行已经存在!' );
        exit;
    }
    if ( $GLOBAL['G_DB_OBJ']->getFieldValue( "select uid from user where uid ='".$uid."' limit 1" ) === $uid )
    {
        echo getHistoryBackScript( '登录帐号存在同名帐号，请重新填写!' );
        exit;
    }

    $sqlStr = "insert into user(uid,passwd,userName,influenceID) values('".$uid."','".$passwd."','".$userName."','-1');";
    $userID = "";
    if ( $GLOBAL["G_DB_OBJ"]->executeSql( $sqlStr ) === 1 )
    {
        $userID = $GLOBAL["G_DB_OBJ"]->getFieldValue( "select id from user where uid='".$uid."' limit 1;");
    }
    if ( !Empty( $userID ) )
    {
        $sqlStr = "insert into banklist(bankName,bankLevel,userID) values('".$name."','".$bankLevel."','".$userID."');";
        
        $GLOBAL['G_DB_OBJ']->executeMutiSqlTrans( $sqlStr );
       // exit;
        if ( !Empty( $GLOBAL['G_DB_OBJ']->getFieldValue( "select uid from user where uid='".$uid."' limit 1" ) ) )
        {
            echo getWebLocationScript( '/bankManage.php?&opt=listFlag', '支行填加成功,全行查看帐号填加成功!' );
            exit;
        }
        else 
        {
            $GLOBAL['G_DB_OBJ']->executeSql("delete from user where id='".$userID."';");
            echo getHistoryBackScript( '支行填加失败,请联系管理员1!' );
            exit;
        }
    }
   else
   {
           echo getHistoryBackScript( '科室填加失败,请联系管理员2(userid)null!' );
          exit;
    }

    //require_once($moduleShowtmpl);

}else if ($opt === "editFlag") {
	//静态页面中需要注意，input框的name属性需要按照规则命名
    if ( checkAcl(0) ===false )
    {
        echo getHistoryBackScript( '您无权修改支行!' );
        exit;
    }
    $id = $_REQUEST["id"];
    $info = $GLOBAL['G_DB_OBJ']->executeSql("select id,bankLevel,bankName,(select uid from user where id=banklist.userID limit 1) as loginame1,(select passwd from user where id=banklist.userID limit 1) as passwd1 from banklist where id = $id");
    
    if ($info != null) {
        if ($info["bankLevel"] == '0' )
        {
            $info["__BANKTYPE__"] = "巴市";
            $info["__STYLE__"] = "block";
            $GLOBAL['htmlDefine']['replaceArray']["__LOGINAME1__"]="nsk1";
            $GLOBAL['htmlDefine']['replaceArray']["__PASSWD1__"]=$GLOBAL["G_DB_OBJ"]->getFieldValue("select passwd from user where uid='nsk1' limit 1");
            $GLOBAL['htmlDefine']['replaceArray']["__LOGINAME2__"]="jwjcs1";
            $GLOBAL['htmlDefine']['replaceArray']["__PASSWD2__"]=$GLOBAL["G_DB_OBJ"]->getFieldValue("select passwd from user where uid='jwjcs1' limit 1");
            $GLOBAL['htmlDefine']['replaceArray']["__LOGINAME3__"]="user";
            $GLOBAL['htmlDefine']['replaceArray']["__PASSWD3__"]=$GLOBAL["G_DB_OBJ"]->getFieldValue("select passwd from user where uid='user' limit 1");
        }
        else
        {
            $info["__BANKTYPE__"] = "旗县";
            $info["__STYLE__"] = "none";
            $GLOBAL['htmlDefine']['replaceArray']["__LOGINAME1__"]=$info["loginame1"];
            $GLOBAL['htmlDefine']['replaceArray']["__PASSWD1__"]=$info["passwd1"];
        }
        $GLOBAL['htmlDefine']['replaceArray'] = array_merge($GLOBAL['htmlDefine']['replaceArray'], array(
            '__ID__' => $id,
            '__NAME__' => $info["bankName"],
            '__BANKLEVEL__'=>$info["bankLevel"],
            '__BANKTYPE__'=>$info["__BANKTYPE__"],
            '__STYLE__'=>$info["__STYLE__"]
        ));
    }

    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
    $moduleShowtmpl = loadModules("webPage", $errMsg);
	//require_once($moduleShowtmpl);
	
}else if ($opt === "editFlagSave") {
    //静态页面中需要注意，input框的name属性需要按照规则命名
    $id=$_GET["id"];
    $name = $_POST["bankName_银行名称_textarea_1_20_1_1"];
    $bankLevel = $_POST["bankLevel_机构类型_integer_1_5_1_1"];
    $loginame1 = $_POST["loginame1_查看帐号1_textboxen_3_16_1_1"];
    $passwd1 = $_POST["passwd1_帐号密码1_textboxen_3_16_1_1"];
    $loginame2 = $_POST["loginame2_查看帐号2_textboxen_3_16_1_1"];
    $passwd2 = $_POST["passwd2_帐号密码2_textboxen_3_16_1_1"];
    $loginame3 = $_POST["loginame3_查看帐号3_textboxen_3_16_1_1"];
    $passwd3 = $_POST["passwd3_帐号密码3_textboxen_3_16_1_1"];
    if ( Empty( $passwd1 ) or Empty( $loginame1 ) )
    {
        echo getHistoryBackScript( '查看帐号1与密码1不能为空!' );
        exit;
    }
    $bankType = 1;
    if ( $GLOBAL["G_DB_OBJ"]->getFieldValue("select bankLevel from banklist where id='".$id."' limit 1") == "0" )
    {
        $bankType=0;
        if ( Empty( $passwd2 ) or Empty( $loginame2 ) )
        {
            echo getHistoryBackScript( '查看帐号2与密码2不能为空!' );
            exit;
        }
        if ( Empty( $passwd3 ) or Empty( $loginame3 ) )
        {
            echo getHistoryBackScript( '查看帐号3与密码3不能为空!' );
            exit;
        }
        if ( $loginame1 === $loginame2 || $loginame1 === $loginame3 || $loginame2 === $loginame3 )
        {
            echo getHistoryBackScript( '三个登录帐号不可以有相同的帐号!' );
            exit;
        }
    }

    if ( !Empty($GLOBAL['G_DB_OBJ']->getFieldValue( "select bankName from banklist where id<>'".$id."' and bankName='".$name."'" )))
    {
        echo getHistoryBackScript( '同名支行已经存在，修改失败1!' );
        exit;
    }
    
    if ( $bankType === 0 )
    {
        
        $ret1 = $GLOBAL["G_DB_OBJ"]->executeSql("update user set passwd='".$passwd1."' where uid='".$loginame1."' limit 1;");
        $ret2 = $GLOBAL["G_DB_OBJ"]->executeSql("update user set passwd='".$passwd2."' where uid='".$loginame2."' limit 1;");
        $ret3 = $GLOBAL["G_DB_OBJ"]->executeSql("update user set passwd='".$passwd3."' where uid='".$loginame3."' limit 1;");

        if ( $ret1!==1||$ret2!==1||$ret3!==1 )
        {
            echo getHistoryBackScript( '三个登录帐号密码修改失败!' );
            exit;
        }
    
    }
    else
    {
        $sql = "update user set passwd='".$passwd1."' where uid='".$loginame1."' limit 1;";
        if ( $GLOBAL['G_DB_OBJ']->executeSql( $sql ) !== 1 )
        {
            echo getHistoryBackScript( '登录帐号修改失败，请联络管理员!' );
            exit;
        }
    }

    $sql = "update banklist set bankName='".$name."' where id='".$id."'";
    $ret1 = $GLOBAL['G_DB_OBJ']->executeSql( $sql );

    if ( $ret1 !== 1 )
    {
        echo getHistoryBackScript( '支行修改失败!' );
        exit;
    }
    else 
    {
        echo getWebLocationScript( '/bankManage.php?&opt=listFlag', '支行修改成功!' );
        exit;
    }

}else if ($opt === "delFlag") {
	//静态页面中需要注意，input框的name属性需要按照规则命名
    $id = $_REQUEST["id"];
    if ( checkAcl(0) ===false )
    {
        echo getHistoryBackScript( '您无权删除支行!' );
        exit;
    }
    if ( $GLOBAL['G_DB_OBJ']->getFieldValue("select bankLevel from banklist where id='".$id."';") === '0' )
    {
        
        echo getHistoryBackScript( '巴市中心支行无法删除!' );
        exit;
    }

    $bankLevel = $GLOBAL['G_DB_OBJ']->getFieldValue("select bankLevel from banklist where id='".$id."';");
    if ( $bankLevel == "0" )
    {
        $departmentID= $GLOBAL['G_DB_OBJ']->getFieldValue("select id from department where bankID='".$id."';");
        if ( !Empty( $departmentID ) )
        {
            echo getHistoryBackScript( '支行删除失败,已经增加了支行下属科室，请先删除支行科室，再删除支行!' );
            exit;
        }
    }
    else 
    {
        $departmentOtherID=$GLOBAL['G_DB_OBJ']->getFieldValue("select id from departmentOther where bankID='".$id."';");
        if ( !Empty( $departmentOtherID ) )
        {
            echo getHistoryBackScript( '支行删除失败,已经增加了支行下属科室，请先删除支行科室，再删除支行!' );
            exit;
        }
    }
    $leaderID= $GLOBAL['G_DB_OBJ']->getFieldValue("select id from leader where bankID='".$id."';");
    if ( !Empty( $leaderID ) )
    {
        echo getHistoryBackScript( '支行删除失败,已经增加了支行分管领导，请先删除分管领导，再删除支行!' );
        exit;
    }
    else 
    {
        $userID= $GLOBAL['G_DB_OBJ']->getFieldValue("select userID from banklist where id='".$id."' and bankLevel='1';");
        $sqlStr="delete from banklist where id='".$id."' and bankLevel<>'0';delete from user where id='".$userID."' limit 1;";
        $GLOBAL['G_DB_OBJ']->executeMutiSqlTrans( $sqlStr );
        
        if ( Empty( $GLOBAL["G_DB_OBJ"]->getFieldValue("select id from banklist where id='".$id."';") ) )
        {
            echo getWebLocationScript( '/bankManage.php?&opt=listFlag', '支行删除成功,查看帐号删除成功!' );
            exit;   
        }
        else 
        {
            
            echo getHistoryBackScript( '支行删除失败!' );
            exit;
        }
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