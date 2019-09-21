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
        '(select MenuName from treemenu where MenuId=department.menuID limit 1)' => '__NAME__',
        'sortValue'=>'__SORTVALUE__',
        '(select uid from user where user.id=department.userID)'=>'__UID__',
        '(select uid from user where user.id=department.viewUserID)'=>'__VIEWUID__',
        'regTime' => '__REGTIME__'
    );
    $statictisData = $GLOBAL['G_DB_OBJ']->getMutiRowFieldValue('SELECT * from statictis_login_oneday,statictis_login_sevenday,statictis_login_monthday,statictis_login_yearday,statictis_read_oneday,statictis_read_sevenday,statictis_read_monthday,statictis_read_yearday');
    $GLOBAL['htmlDefine']['replaceArray']['__LOGINONEDAY__']=$statictisData[0];
    $GLOBAL['htmlDefine']['replaceArray']['__LOGINSEVENDAY__']=$statictisData[1];
    $GLOBAL['htmlDefine']['replaceArray']['__LOGINMONTHDAY__']=$statictisData[2];
    $GLOBAL['htmlDefine']['replaceArray']['__LOGINYEARDAY__']=$statictisData[3];
    
    $GLOBAL['htmlDefine']['replaceArray']['__READONEDAY__']=$statictisData[4];
    $GLOBAL['htmlDefine']['replaceArray']['__READSEVENDAY__']=$statictisData[5];
    $GLOBAL['htmlDefine']['replaceArray']['__READMONTHDAY__']=$statictisData[6];
    $GLOBAL['htmlDefine']['replaceArray']['__READYEARDAY__']=$statictisData[7];
    
    $GLOBAL['modulesInfo']['tableName'] = 'department';//这个地方需要修改
    $GLOBAL['modulesInfo']['orderSubSql'] = ' order by sortValue,id asc';
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
        echo getHistoryBackScript( '您无权增加科室!' );
        exit;
    }
     $moduleShowtmpl = loadModules("webPage", $errMsg);
	//require_once($moduleShowtmpl);
	
}else if ($opt === "addFlagSave") {
    //静态页面中需要注意，input框的name属性需要按照规则命名
    $name = $_POST["name_部门名称_textarea_1_20_1_1"];
    $sortValue = $_POST["sortValue_显示顺序号_integer_1_5_1_1"];
    $uid = $_POST["uid_管理帐号用户名_textareaen_1_20_1_1"];
    $pwd = $_POST["passwd_管理帐号密码_textareaen_1_20_1_1"];
    $viewUID = $_POST["uid_浏览帐号用户名_textareaen_1_20_1_1"];
    $viewPWD = $_POST["passwd_浏览帐号密码_textareaen_1_20_1_1"];
    $note = $_POST["note_部门职责_textarea_1_9012_1_1"];
    $userName = $name."管理员";

    if ( $GLOBAL['G_DB_OBJ']->getFieldValue( "select uid from user where uid ='".$uid."' limit 1" ) === $uid )
    {
        echo getHistoryBackScript( '管理帐号用户名重复，请重新填写管理帐号用户名!' );
        exit;
    }
    if ( $GLOBAL['G_DB_OBJ']->getFieldValue( "select uid from user where uid ='".$viewUID."' limit 1" ) === $uid )
    {
        echo getHistoryBackScript( '浏览帐号用户名重复，请重新填写浏览帐号用户名!' );
        exit;
    }
    
    if ( $GLOBAL['G_DB_OBJ']->getFieldValue( "select MenuName from treemenu where MenuName ='".$name."' limit 1" ) === $name )
    {
        echo getHistoryBackScript( '科室已经存在!' );
        exit;
    }
    $sql = "insert into user( uid, passwd,userName,influenceID) values('".$viewUID."','".$viewPWD."','".$viewUID."','0');insert into user( uid, passwd,userName,influenceID) values('".$uid."','".$pwd."','".$userName."','-1');insert into treemenu(MenuName,MenuPId,MenuEndFlag,SortValue) values('".$name."','0','0','".$sortValue."');";
    $GLOBAL['G_DB_OBJ']->executeMutiSqlTrans( $sql );

    $userID = $GLOBAL['G_DB_OBJ']->getFieldValue( "select id from user where uid ='".$uid."' limit 1" );
    $viewUserID = $GLOBAL['G_DB_OBJ']->getFieldValue( "select id from user where uid ='".$viewUID."' limit 1" );
    
    $menuID = $GLOBAL['G_DB_OBJ']->getFieldValue( "select MenuId from treemenu where MenuName ='".$name."' limit 1" );
    if ( !Empty( $userID)&&!Empty($menuID) )
    {
        $sql = "insert into department(menuID,userID,viewUserID,note,sortValue) values('".$menuID."','".$userID."','".$viewUserID."','".$note."','".$sortValue."')";

       // exit;
        if ( $GLOBAL['G_DB_OBJ']->executeSql( $sql ) === 1  )
        {
            echo getWebLocationScript( '/departmentManage.php?&opt=listFlag', '科室填加成功!' );
            exit;
        }
        else 
        {
            echo getHistoryBackScript( '科室填加失败,请联系管理员1!' );
            exit;
        }
    }
    else
    {
            echo getHistoryBackScript( '科室填加失败,请联系管理员2(userid,menuid)null!' );
            exit;
     }

    //require_once($moduleShowtmpl);

}else if ($opt === "editFlag") {
	//静态页面中需要注意，input框的name属性需要按照规则命名
    if ( checkAcl(0) ===false )
    {
        echo getHistoryBackScript( '您无权修改科室!' );
        exit;
    }
    $id = $_REQUEST["id"];
    $info = $GLOBAL['G_DB_OBJ']->executeSql("select id,sortValue, (select MenuName from treemenu where MenuId=department.menuID limit 1 ) as name,(select uid from user where id=department.userID limit 1) as uid,(select uid from user where id=department.viewUserID limit 1) as viewUID,(select passwd from user where id=department.userID limit 1) as passwd,(select passwd from user where id=department.viewUserID limit 1) as viewPasswd,note from department where id = $id");

    if ($info != null) {
        $GLOBAL['htmlDefine']['replaceArray'] = array_merge($GLOBAL['htmlDefine']['replaceArray'], array(
            '__ID__' => $id,
            '__NAME__' => $info["name"],
            '__SORTVALUE__'=>$info["sortValue"],
            '__UID__' =>$info["uid"],
            '__VIEWUID__' =>$info["viewUID"],
            '__PASSWORD__' =>$info["passwd"],
            '__VIEWPASSWORD__' =>$info["viewPasswd"],
            '__NOTE__'=>$info["note"]
        ));
    }

    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
    $moduleShowtmpl = loadModules("webPage", $errMsg);
	//require_once($moduleShowtmpl);
	
}else if ($opt === "editFlagSave") {
    //静态页面中需要注意，input框的name属性需要按照规则命名
    $id=$_GET["id"];
    $name = $_POST["name_部门名称_textarea_1_20_1_1"];
    $sortValue = $_POST["sortValue_显示顺序号_integer_1_5_1_1"];
    $uid = $_POST["uid_管理帐号用户名_textareaen_1_20_1_1"];
    $pwd = $_POST["passwd_管理帐号密码_textareaen_1_20_1_1"];
    $viewUID = $_POST["uid_浏览帐号用户名_textareaen_1_20_1_1"];
    $viewPWD = $_POST["passwd_浏览帐号密码_textareaen_1_20_1_1"];
    
    
    $note = $_POST["note_部门职责_textarea_1_9012_1_1"];
    $userName = $name."管理员";
    $menuID= $GLOBAL['G_DB_OBJ']->getFieldValue( "select menuID from department where id='".$id."';" );
    if ( !Empty($GLOBAL['G_DB_OBJ']->getFieldValue( "select MenuName from treemenu where MenuId<>'".$menuID."' and MenuName='".$name."'" )))
    {
        echo getHistoryBackScript( '同名科室已经存在，修改失败1!' );
        exit;
            
    }
    $sql = "update department set note='".$note."',sortValue='".$sortValue."' where id='".$id."'";
    $ret1 = $GLOBAL['G_DB_OBJ']->executeSql( $sql );
    $sql = "update treemenu set MenuName='".$name."',SortValue='".$sortValue."' where MenuId='".$menuID."';";
    $ret2 = $GLOBAL['G_DB_OBJ']->executeSql( $sql );
    if ( $ret1 !== 1 )
    {
        echo getHistoryBackScript( '科室职责修改失败!' );
        exit;
    }
    if ( $ret2 !== 1 )
    {
        echo getHistoryBackScript( '科室名称修改失败!' );
        exit;
    }    
    $userID = $GLOBAL['G_DB_OBJ']->getFieldValue( "select userID from department where id ='".$id."' limit 1" );
    if ( !Empty( $userID) )
    {
        $sql = "select uid from user where id<>'".$userID."' and uid='".$userID."'";
        if ( !Empty( $GLOBAL['G_DB_OBJ']->getFieldValue($sql) ) )
        {
            echo getWebLocationScript( '/departmentManage.php?&opt=listFlag', '科室修改成功,管理帐号修改失败,有同名的帐号存在!' );
            exit;
        }
        else 
        {
            $sql = "update user set uid='".$uid."', passwd='".$pwd."' where id='".$userID."' limit 1;";
            if ( $GLOBAL['G_DB_OBJ']->executeSql( $sql ) === 1 )
            {
                $viewUserID = $GLOBAL['G_DB_OBJ']->getFieldValue( "select viewUserID from department where id ='".$id."' limit 1" );
                if ( !Empty( $viewUserID) )
                {
                    $sql = "select uid from user where id<>'".$viewUserID."' and uid='".$viewUID."'";
                    if ( !Empty( $GLOBAL['G_DB_OBJ']->getFieldValue($sql) ) )
                    {
                        echo getWebLocationScript( '/departmentManage.php?&opt=listFlag', '科室修改成功,管理帐号修改成功，浏览帐号修改失败,有同名的帐号存在!' );
                        exit;
                    }
                    else
                    {
                        $sql = "update user set uid='".$viewUID."', passwd='".$viewPWD."' where id='".$viewUserID."' limit 1;";
                        if ( $GLOBAL['G_DB_OBJ']->executeSql( $sql ) === 1 )
                        {
                            echo getWebLocationScript( '/departmentManage.php?&opt=listFlag', '科室修改成功,管理帐号修改成功，浏览帐号修改成功!' );
                            exit;
                        }
                        else
                        {
                            echo getWebLocationScript( '/departmentManage.php?&opt=listFlag', '科室修改成功,管理帐号修改成功，浏览帐号修改失败1!' );
                            exit;
                        }
                    }
                
                }
                elseif ( $viewUserID == 0 )
                {
                    $sql = "select uid from user where id<>'".$viewUserID."' and uid='".$viewUID."';";

                    if ( !Empty( $GLOBAL['G_DB_OBJ']->getFieldValue($sql) ) )
                    {
                        echo getWebLocationScript( '/departmentManage.php?&opt=listFlag', '科室修改成功,管理帐号修改失败,浏览帐号有同名的帐号存在!' );
                        exit;
                    }
                    else
                    {
                        $sql = "insert into user( uid, passwd,userName,influenceID) values('".$viewUID."','".$viewPWD."','".$viewUID."','0');";
                        if ( $GLOBAL['G_DB_OBJ']->executeSql( $sql ) === 1 )
                        {
                            $viewUserID= $GLOBAL['G_DB_OBJ']->getFieldValue( "select id from user where uid ='".$viewUID."' limit 1" );
                            $sql="update department set viewUserID='".$viewUserID."' where id='".$id."';";
                            if ( $GLOBAL['G_DB_OBJ']->executeSql( $sql ) === 1 )
                            {
                                echo getWebLocationScript( '/departmentManage.php?&opt=listFlag', '科室修改成功,管理帐号修改成功，浏览帐号修改成功!' );
                                exit;
                            }
                            else
                            {
                                echo getWebLocationScript( '/departmentManage.php?&opt=listFlag', '科室修改成功,管理帐号修改成功,浏览帐号修改失败!' );
                                exit;
                            }
                        }
                        else
                        {
                            echo getWebLocationScript( '/departmentManage.php?&opt=listFlag', '科室修改成功,管理帐号修改成功，浏览帐号填加失败11!' );
                            exit;
                
                        }
                    }
                }
                
                
               echo "viewuserid=".$viewUserID."<br>";
               echo "viewuserid=".($viewUserID===0)."<br>";
               exit;
                
                
                
                echo getWebLocationScript( '/departmentManage.php?&opt=listFlag', '科室修改成功,管理帐号修改成功!' );
            }
            else 
            {
                echo getWebLocationScript( '/departmentManage.php?&opt=listFlag', '科室修改成功,管理帐号修改失败1!' );
                exit;
            }
        }

    }


}else if ($opt === "delFlag") {
	//静态页面中需要注意，input框的name属性需要按照规则命名
    $id = $_REQUEST["id"];
    if ( checkAcl(0) ===false )
    {
        echo getHistoryBackScript( '您无权删除科室!' );
        exit;
    }
    if ( !Empty($GLOBAL['G_DB_OBJ']->getFieldValue("select id from responsibility where departmentID = '".$id."'") ))
    {
        echo getHistoryBackScript( '科室删除失败,已经增加了科室岗位职责，请先删除该科室的岗位职责后，再删除部门!' );
        exit;
    }
    if ( !Empty($GLOBAL['G_DB_OBJ']->getFieldValue("select fileID from fileListOther where departmentID = '".$id."'") ))
    {
        echo getHistoryBackScript( '科室删除失败,已经增加了部门流程图或者填加了问题整改，请先删除这两项文件，再删除科室!' );
        exit;
    }
    $menuID= $GLOBAL['G_DB_OBJ']->getFieldValue("select menuID from department where id='".$id."';");
    if ( !Empty($GLOBAL['G_DB_OBJ']->getFieldValue("select MenuName from treemenu where MenuPId = '".$menuID."' limit 1;") ))
    {
        echo getHistoryBackScript( '科室删除失败,已经增加了制度文件或子目录，请先删除子目录与文件，再删除科室!' );
        exit;
    }
    $userID = $GLOBAL['G_DB_OBJ']->getFieldValue("select userID from department where id = '".$id."'");
    $viewUserID = $GLOBAL['G_DB_OBJ']->getFieldValue("select viewUserID from department where id = '".$id."'");
    if ( !Empty( $userID ) )
    {
        $sql="delete from user where id='".$userID."' or id='".$viewUserID."';delete from department where id='".$id."';delete from treemenu where MenuId='".$menuID."'";
        $GLOBAL['G_DB_OBJ']->executeMutiSqlTrans( $sql );
        echo getWebLocationScript( '/departmentManage.php?&opt=listFlag', '科室删除成功!' );
        
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