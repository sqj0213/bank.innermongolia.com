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
 /*
*/
    $htmlData = getHTtmlData();
    $GLOBAL['htmlDefine']['replaceArray']['__TAB__'] = $htmlData["tabHtml"];
    $GLOBAL['htmlDefine']['replaceArray']['__TABLE__'] = $htmlData["tableHtml"];
    $statictisData = $GLOBAL['G_DB_OBJ']->getMutiRowFieldValue('SELECT * from statictis_login_oneday,statictis_login_sevenday,statictis_login_monthday,statictis_login_yearday,statictis_read_oneday,statictis_read_sevenday,statictis_read_monthday,statictis_read_yearday');
    $GLOBAL['htmlDefine']['replaceArray']['__LOGINONEDAY__']=$statictisData[0];
    $GLOBAL['htmlDefine']['replaceArray']['__LOGINSEVENDAY__']=$statictisData[1];
    $GLOBAL['htmlDefine']['replaceArray']['__LOGINMONTHDAY__']=$statictisData[2];
    $GLOBAL['htmlDefine']['replaceArray']['__LOGINYEARDAY__']=$statictisData[3];
    
    $GLOBAL['htmlDefine']['replaceArray']['__READONEDAY__']=$statictisData[4];
    $GLOBAL['htmlDefine']['replaceArray']['__READSEVENDAY__']=$statictisData[5];
    $GLOBAL['htmlDefine']['replaceArray']['__READMONTHDAY__']=$statictisData[6];
    $GLOBAL['htmlDefine']['replaceArray']['__READYEARDAY__']=$statictisData[7];

    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
    $moduleShowtmpl = loadModules("webPage", $errMsg);

} else if ($opt === "addFlag") {
	//静态页面中需要注意，input框的name属性需要按照规则命名
    $GLOBAL['htmlDefine']['replaceArray']['__BANKLIST__']=getComboxFromSql('bankID','select id,bankName from banklist order by id desc',"1");
    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
    if ( checkAcl(0) ===false )
    {
        echo getHistoryBackScript( '您无权增加科室!' );
        exit;
    }
     $moduleShowtmpl = loadModules("webPage", $errMsg);
	//require_once($moduleShowtmpl);
	
} else if ($opt === "addOtherFlag") {
    //静态页面中需要注意，input框的name属性需要按照规则命名
    $GLOBAL['htmlDefine']['replaceArray']['__BANKLIST__']=getComboxFromSql_v1('bankID','select id,bankName from banklist where id<>\'1\' order by id desc',"","onchange='changeBank(this)'");
    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
    $vv = $GLOBAL["G_DB_OBJ"]->getSqlMap( "select bankID, GROUP_CONCAT(ownerMenuIDList) as a from `departmentOther` group by bankID", 0 );
    
    $vv1 = array();
    while( current( $vv ) !== false )
    {
        $v = current( $vv );
        $vv1[ $v[ 0 ] ] = explode( ",", $v[1] );
        next( $vv );
    }
    //print_r( $vv1 );
    $vv2 = $GLOBAL["G_DB_OBJ"]->executeSqlMap( "select menuID as id,(select MenuName from treemenu where MenuId=department.menuID limit 1) as name from department", 0 );
    //print_r( $vv2 );
    //exit;__BANKDEPARTMENTIDLIST__
    $GLOBAL['htmlDefine']['replaceArray']['__BANKDEPARTMENTIDLIST__'] = json_encode( $vv1 );
    $GLOBAL['htmlDefine']['replaceArray']['__DEPARTMENTIDLIST__'] = json_encode( $vv2 );
    $GLOBAL['htmlDefine']['replaceArray']['__DEPARTMENTLIST__']=getCheckBoxBySql('departmentIDList[]','select menuID as id,(select MenuName from treemenu where MenuId=department.menuID limit 1) as name from department', '', array(), array() );
    
    if ( checkAcl(0) ===false )
    {
        echo getHistoryBackScript( '您无权增加科室!' );
        exit;
    }
    $moduleShowtmpl = loadModules("webPage", $errMsg);
    //require_once($moduleShowtmpl);

}
else if ($opt === "addFlagSave") {
    //静态页面中需要注意，input框的name属性需要按照规则命名
    $otherFlag=0;
    if ( Empty( $_POST["bankID"] ) )
    {
        echo getHistoryBackScript("科室所属银行必须填写!");
        exit;
    }
    if ( substr($_SERVER['HTTP_REFERER'],-12) === "addOtherFlag" )
    {

        if ( Empty( $_POST["departmentIDList"] ) )
        {
            echo getHistoryBackScript("上级科室必须填写!");
            exit;
        }
        $ownerIDMenuIDList = implode( $_POST["departmentIDList"],"," );
        $otherFlag=1;
    }
    $bankID=$_POST["bankID"];
    $name = $_POST["name_科室名称_textarea_1_20_1_1"];
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
    if ( $otherFlag === 1 )
    {

        if ( $GLOBAL['G_DB_OBJ']->getFieldValue(  "select MenuName from treemenu where MenuName ='".$name."' and bankID<>'".$bankID."' and bankID<>'0' and MenuPid='0' limit 1"  ) === $name )
        {
            echo getHistoryBackScript( '科室已经存在!' );
            exit;
        } 
    }
    else
    {
        //echo "l=".__LINE__."<br>";
        if ( $GLOBAL['G_DB_OBJ']->getFieldValue( "select MenuName from treemenu where MenuName ='".$name."' and MenuPid=0 and bankID='0' limit 1" ) === $name )
        {
            echo getHistoryBackScript( '科室已经存在!' );
            exit;
        }
    }
    if ( $otherFlag === 1 )
        $sql = "insert into user( uid, passwd,userName,influenceID) values('".$viewUID."','".$viewPWD."','".$viewUID."','0');insert into user( uid, passwd,userName,influenceID) values('".$uid."','".$pwd."','".$userName."','-1');insert into treemenu(MenuName,MenuPId,MenuEndFlag,SortValue,bankID) values('".$name."','0','0','".$sortValue."','".$bankID."');";
    else
        $sql = "insert into user( uid, passwd,userName,influenceID) values('".$viewUID."','".$viewPWD."','".$viewUID."','0');insert into user( uid, passwd,userName,influenceID) values('".$uid."','".$pwd."','".$userName."','-1');insert into treemenu(MenuName,MenuPId,MenuEndFlag,SortValue) values('".$name."','0','0','".$sortValue."');";
    $GLOBAL['G_DB_OBJ']->executeMutiSqlTrans( $sql );

    $userID = $GLOBAL['G_DB_OBJ']->getFieldValue( "select id from user where uid ='".$uid."' limit 1" );
    $viewUserID = $GLOBAL['G_DB_OBJ']->getFieldValue( "select id from user where uid ='".$viewUID."' limit 1" );
    if ( $otherFlag === 1 )
        $menuID = $GLOBAL['G_DB_OBJ']->getFieldValue( "select MenuId from treemenu where MenuName ='".$name."' and MenuPId=0 and bankID='".$bankID."' limit 1" );
    else
        $menuID = $GLOBAL['G_DB_OBJ']->getFieldValue( "select MenuId from treemenu where MenuName ='".$name."' and MenuPId=0 and bankID='0' limit 1" );
    if ( !Empty( $userID ) )
    {
        if ( $otherFlag === 1 )
            $sql = "insert into departmentOther(bankID,menuID,ownerMenuIDList,userID,viewUserID,note,sortValue) values('".$bankID."','".$menuID."','".$ownerIDMenuIDList."','".$userID."','".$viewUserID."','".$note."','".$sortValue."')";
        else 
            $sql = "insert into department(bankID,menuID,userID,viewUserID,note,sortValue) values('".$bankID."','".$menuID."','".$userID."','".$viewUserID."','".$note."','".$sortValue."')";
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
    $editType=$_GET["editType"];
    if ( $editType === "other")
    {
        $GLOBAL["htmlDefine"]["tmplPath"] = str_replace( "departmentManage_editFlag.tmpl","departmentManage_editOtherFlag.tmpl", $GLOBAL["htmlDefine"]["tmplPath"] );
        $vv = $GLOBAL["G_DB_OBJ"]->getFieldValue("select group_concat(ownerMenuIDList separator ',') as a from `departmentOther` where id<>'".$id."';" );
        $info = $GLOBAL['G_DB_OBJ']->executeSql("select id,sortValue, bankID,(select MenuName from treemenu where MenuId=departmentOther.menuID limit 1 ) as name,ownerMenuIDList,(select uid from user where id=departmentOther.userID limit 1) as uid,(select uid from user where id=departmentOther.viewUserID limit 1) as viewUID,(select passwd from user where id=departmentOther.userID limit 1) as passwd,(select passwd from user where id=departmentOther.viewUserID limit 1) as viewPasswd,note from departmentOther where id = $id");
        if ( Empty( $info["ownerMenuIDList"] ) )
            $GLOBAL['htmlDefine']['replaceArray']['__DEPARTMENTLIST__']=getCheckBoxBySql('departmentIDList[]','select menuID as id,(select MenuName from treemenu where MenuId=department.menuID limit 1) as name from department', "", array(), explode( ",", $vv ) );
        else
            $GLOBAL['htmlDefine']['replaceArray']['__DEPARTMENTLIST__']=getCheckBoxBySql('departmentIDList[]','select menuID as id,(select MenuName from treemenu where MenuId=department.menuID limit 1) as name from department', "", explode( ",", $info[ "ownerMenuIDList" ] ), explode( ",", $vv ) );

    }
    else 
    {
        $info = $GLOBAL['G_DB_OBJ']->executeSql("select id,sortValue, bankID,(select MenuName from treemenu where MenuId=department.menuID limit 1 ) as name,(select uid from user where id=department.userID limit 1) as uid,(select uid from user where id=department.viewUserID limit 1) as viewUID,(select passwd from user where id=department.userID limit 1) as passwd,(select passwd from user where id=department.viewUserID limit 1) as viewPasswd,note from department where id = $id");
    }
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
    $GLOBAL['htmlDefine']['replaceArray']['__BANKNAME__']=$GLOBAL["G_DB_OBJ"]->getFieldValue("select bankName from banklist where id ='".$info["bankID"]."' order by id desc");
    
    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
    $moduleShowtmpl = loadModules("webPage", $errMsg);
	//require_once($moduleShowtmpl);
	
}else if ($opt === "editFlagSave") {
    //静态页面中需要注意，input框的name属性需要按照规则命名
    $editType=$_GET["editType"];
    if ( $editType === "other" )
    {
        if ( Empty( $_POST["departmentIDList"] ) )
        {
            echo getHistoryBackScript("上级科室必须填写!");
            exit;
        }
        $ownerMenuIDList = implode( $_POST["departmentIDList"],"," );
    }
    
    
    $id=$_GET["id"];
    $name = $_POST["name_科室名称_textarea_1_20_1_1"];
    $sortValue = $_POST["sortValue_显示顺序号_integer_1_5_1_1"];
    $uid = $_POST["uid_管理帐号用户名_textareaen_1_20_1_1"];
    $pwd = $_POST["passwd_管理帐号密码_textareaen_1_20_1_1"];
    $viewUID = $_POST["uid_浏览帐号用户名_textareaen_1_20_1_1"];
    $viewPWD = $_POST["passwd_浏览帐号密码_textareaen_1_20_1_1"];
    

    $note = $_POST["note_部门职责_textarea_1_9012_1_1"];
    $userName = $name."管理员";
    if ( $editType === "other" )
    {
        $bankID = $GLOBAL['G_DB_OBJ']->getFieldValue("select bankID from departmentOther where id='".$id."'");
        $menuID= $GLOBAL['G_DB_OBJ']->getFieldValue( "select menuID from departmentOther where id='".$id."';" );

        if ( !Empty( $GLOBAL['G_DB_OBJ']->getFieldValue( "select MenuName from treemenu where MenuId<>'".$menuID."' and bankID='".$bankID."' AND MenuName='".$name."' AND MenuPId='0'" ) ) )
        {
            echo getHistoryBackScript( '同名科室已经存在，修改失败1!' );
            exit;
        }
        $sql = "update departmentOther set ownerMenuIDList='".$ownerMenuIDList."',note='".$note."',sortValue='".$sortValue."' where id='".$id."'";
        $ret1 = $GLOBAL['G_DB_OBJ']->executeSql( $sql );
    }
    else
    {    
        $menuID= $GLOBAL['G_DB_OBJ']->getFieldValue( "select menuID from department where id='".$id."';" );
        $bankID = $GLOBAL['G_DB_OBJ']->getFieldValue("select bankID from departmentOther where id='".$id."'");
        if ( !Empty($GLOBAL['G_DB_OBJ']->getFieldValue( "select MenuName from treemenu where MenuId<>'".$menuID."' and bankID='0' and MenuName='".$name."' and MenuPId='0'" )))
        {
            echo getHistoryBackScript( '同名科室已经存在，修改失败1!' );
            exit;
        }
        $sql = "update department set note='".$note."',sortValue='".$sortValue."' where id='".$id."'";
        $ret1 = $GLOBAL['G_DB_OBJ']->executeSql( $sql );

    }
    $sql = "update treemenu set MenuName='".$name."',SortValue='".$sortValue."' where MenuId='".$menuID."';";
    $ret2 = $GLOBAL['G_DB_OBJ']->executeSql( $sql );
    if ( $ret2 !== 1 )
    {
        echo getHistoryBackScript( '科室名称修改失败!' );
        exit;
    }
    
    if ( $ret1 !== 1 )
    {
        echo getHistoryBackScript( '科室职责修改失败!' );
        exit;
    }

    if ( $editType === "other" )
        $userID = $GLOBAL['G_DB_OBJ']->getFieldValue( "select userID from departmentOther where id ='".$id."' limit 1" );
    else
        $userID = $GLOBAL['G_DB_OBJ']->getFieldValue( "select userID from department where id ='".$id."' limit 1" );


    if ( !Empty( $userID) )
    {
        $sql = "select uid from user where id<>'".$userID."' and uid='".$uid."'";
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
                if ( $editType === "other" )
                    $viewUserID = $GLOBAL['G_DB_OBJ']->getFieldValue( "select viewUserID from departmentOther where id ='".$id."' limit 1" );
                else
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
                    echo $sql."<br>";
                    exit;
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
                            if ( $editType === "other" )
                                $sql="update departmentOther set viewUserID='".$viewUserID."' where id='".$id."';";
                            else
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
                echo getWebLocationScript( '/departmentManage.php?&opt=listFlag', '科室修改成功,管理帐号修改成功!' );
                exit;
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


    $delType=$_GET["delType"];
    
    if ( $delType == "other")
    {
        $bankID = $GLOBAL['G_DB_OBJ']->getFieldValue("select bankID from departmentOther where id='".$id."' limit 1;" ); 
        if ( !Empty($GLOBAL['G_DB_OBJ']->getFieldValue("select id from question where departmentID = '".$id."' and bankID='".$bankID."' limit 1;") ))
        {
            echo getHistoryBackScript( '科室删除失败,已经增加了台帐，请先删除该科室的相关台帐后，再删除科室!' );
            exit;
        }
        if ( !Empty($GLOBAL['G_DB_OBJ']->getFieldValue("select id from responsibility where departmentID = '".$id."' and bankID='0';") ))
        {
            echo getHistoryBackScript( '科室删除失败,已经增加了科室岗位职责，请先删除该科室的岗位职责后，再删除科室!' );
            exit;
        }
        if ( !Empty($GLOBAL['G_DB_OBJ']->getFieldValue("select fileID from fileListOther where departmentID = '".$id."' and bankID='0'") ))
        {
            echo getHistoryBackScript( '科室删除失败,已经增加该科室流程图，请先删除该类流程图，再删除科室!' );
            exit;
        }
        
        $menuID= $GLOBAL['G_DB_OBJ']->getFieldValue("select menuID from departmentOther where id='".$id."';");
        if ( !Empty($GLOBAL['G_DB_OBJ']->getFieldValue("select MenuName from treemenu where MenuPId = '".$menuID."' limit 1;") ))
        {
            echo getHistoryBackScript( '科室删除失败,已经增加了制度文件或子目录,请先删除子目录与文件,再删除科室!' );
            exit;
        }
        $userID = $GLOBAL['G_DB_OBJ']->getFieldValue("select userID from departmentOther where id = '".$id."'");
        $viewUserID = $GLOBAL['G_DB_OBJ']->getFieldValue("select viewUserID from departmentOther where id = '".$id."'");
        if ( !Empty( $userID ) )
        {
            $sql="delete from user where id='".$userID."' or id='".$viewUserID."';delete from departmentOther where id='".$id."';delete from treemenu where MenuId='".$menuID."'";
            $GLOBAL['G_DB_OBJ']->executeMutiSqlTrans( $sql );
            echo getWebLocationScript( '/departmentManage.php?&opt=listFlag', '科室删除成功!' );
            exit;
        }  
        
    }
    else 
    {
        if ( !Empty( $GLOBAL['G_DB_OBJ']->getFieldValue( "select (select id from departmentOther where department.menuID in (departmentOther.ownerMenuIDList) limit 1) from department where id = '".$id."' limit 1;" ) ) )
        {
            echo getHistoryBackScript( '科室删除失败,已经增加了下级分管科室,请先解除下级分管科室后,再删除科室!' );
            exit;
        }       
        $bankID = $GLOBAL['G_DB_OBJ']->getFieldValue("select bankID from department where id='".$id."' limit 1;" );
        if ( !Empty($GLOBAL['G_DB_OBJ']->getFieldValue("select id from question where departmentID = '".$id."' and bankID='".$bankID."' limit 1;") ))
        {
            echo getHistoryBackScript( '科室删除失败,已经增加了台帐,请先删除该科室的相关台帐后,再删除科室!' );
            exit;
        }
   
        if ( !Empty($GLOBAL['G_DB_OBJ']->getFieldValue("select id from responsibility where departmentID = '".$id."' and bankID='1';") ))
        {
            echo getHistoryBackScript( '科室删除失败,已经增加了科室岗位职责,请先删除该科室的岗位职责后,再删除科室!' );
            exit;
        }
        
        if ( !Empty($GLOBAL['G_DB_OBJ']->getFieldValue("select fileID from fileListOther where departmentID = '".$id."' and bankID='1';") ))
        {
            echo getHistoryBackScript( '科室删除失败,已经增加了部门流程图，请先删除该类流程图，再删除科室!' );
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


function getHTtmlData()
{
    global $GLOBAL;
    $tabHtmlStr = '<li class="item-__NUM____FLAG__"><i></i><div class="text"><h3>__NAME__</h3><p>旗县银行科室列表</p></div></li>';
    $tableHtmlStr = '<li class="item-__NUM__" style="position: relative; width: 1920px; left: 0px; top: 0px; display: list-item;">
                    <div>
					<table class="tablelist-new">
						<thead>
						<tr>
						<th>所属银行</th>
					    <th>部门名称</th>
					    <th>显示顺序号</th>
					    <th>管理帐号</th>
					    <th>浏览帐号</th>
                        __OWNERMENU__
					    <th>填加时间</th>
					    <th>操作</th>
					    </tr>
					    </thead>
					    <tbody>
                            __TRLIST__
					    </tbody>
					</table>
		    		</div>
		    	</li>';
    $trHtmlStr = '<tr>
			    <td>__BANKNAME__</td>
			    <td>__NAME__</td>
			    <td>__SORTVALUE__</td>
			    <td>__UID__</td>
			    <td>__VIEWUID__</td>
                __OWNERNAME__
			    <td>__REGTIME__</td>
			    <td><a href="/departmentManage.php?opt=editFlag&id=__ID__&editType=__EDITTYPE__" class="tablelink">修改</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="tablelink" onclick="javascript: if (confirm(\'请确认是否删除?\') ) location.href=\'/departmentManage.php?opt=delFlag&id=__ID__&delType=__DELTYPE__\';"> 删除</a></td>
			    </tr>';
    
    $i = 1;
    $tabHtml = "";
    $tableHtml = "";
    $dataList = $GLOBAL["G_DB_OBJ"]->executeSqlMap("select id,bankName,bankLevel from banklist where bankLevel='0' order by id asc limit 1;", 0);
    
    if ( current( $dataList ) !== false )
    {
        $rowData = current( $dataList );
        $tmpTabHtmlStr = "";
        $tmpTabHtmlStr = str_replace('__NUM__', $i, $tabHtmlStr );
        $tmpTabHtmlStr = str_replace('__NAME__', $rowData["bankName"], $tmpTabHtmlStr );
        if ( $rowData['bankLevel'] == '0' )
            $tmpTabHtmlStr = str_replace('__FLAG__', " on", $tmpTabHtmlStr );
            else
                $tmpTabHtmlStr = str_replace('__FLAG__', "", $tmpTabHtmlStr );
                $tabHtml .= $tmpTabHtmlStr;
    
                $dataTableList = $GLOBAL["G_DB_OBJ"]->executeSqlMap("select id as __ID__,(select bankName from banklist where banklist.id=department.bankID limit 1) as __BANKNAME__,
            (select MenuName from treemenu where MenuId=department.menuID limit 1) as __NAME__,sortValue as __SORTVALUE__,(select uid from user where user.id=department.userID) as __UID__,
            (select uid from user where user.id=department.viewUserID) as __VIEWUID__,regTime as __REGTIME__ from department order by sortValue,id asc",0);
                $trHtml = "";
    
                while ( current( $dataTableList ) !== false )
                {
                    $dataRow = current( $dataTableList );
                    if ( $rowData['bankLevel'] === '0' )
                    {
                        $tmpHtmlStr = str_replace( '__OWNERNAME__', '', $trHtmlStr );
                        $tmpHtmlStr = str_replace( '__EDITTYPE__', '', $tmpHtmlStr );
                        $tmpHtmlStr = str_replace( '__DELTYPE__', '', $tmpHtmlStr );
                    }
                    else
                    {
                        $tmpHtmlStr = str_replace( '__OWNERNAME__', '<td></td>', $trHtmlStr );
                        $tmpHtmlStr = str_replace( '__EDITTYPE__', 'other', $tmpHtmlStr );
                        $tmpHtmlStr = str_replace( '__DELTYPE__', 'other', $tmpHtmlStr );
                    }
                        while ( current( $dataRow ) !== false )
                        {
                            $tmpHtmlStr = str_replace( key( $dataRow ), current( $dataRow ), $tmpHtmlStr );
                            next( $dataRow );
                        }
                        $trHtml .= $tmpHtmlStr;
                        next( $dataTableList );
                }
    
    
                if ( $rowData['bankLevel'] == '0' )
                    $tmpTableHtml = str_replace( "__OWNERMENU__", '', $tableHtmlStr );
                    else
                        $tmpTableHtml = str_replace( "__OWNERMENU__", '<th>上级科室</th>', $tableHtmlStr );
                         
                        $tmpTableHtml = str_replace( "__NUM__", $i, $tmpTableHtml );
                        $tableHtml .= str_replace('__TRLIST__', $trHtml, $tmpTableHtml );
    
                        $i++;
    }
    
    $dataList = $GLOBAL["G_DB_OBJ"]->executeSqlMap("select id,bankName,bankLevel from banklist where bankLevel='1' order by id asc",0);
    while ( current( $dataList ) !== false )
    {
        $rowData= current( $dataList );
        $tmpTabHtmlStr = "";
        $tmpTabHtmlStr = str_replace('__NUM__', $i, $tabHtmlStr );
        $tmpTabHtmlStr = str_replace('__NAME__', $rowData["bankName"], $tmpTabHtmlStr );
        if ( $rowData['bankLevel'] === '0' )
            $tmpTabHtmlStr = str_replace('__FLAG__', "on", $tmpTabHtmlStr );
        else
            $tmpTabHtmlStr = str_replace('__FLAG__', "", $tmpTabHtmlStr );
    
        $dataTableList = $GLOBAL["G_DB_OBJ"]->executeSqlMap("select id as __ID__,(select bankName from banklist where banklist.id=departmentOther.bankID limit 1) as __BANKNAME__,
            (select MenuName from treemenu where MenuId=departmentOther.menuID limit 1) as __NAME__,ownerMenuIDList, sortValue as __SORTVALUE__,(select uid from user where user.id=departmentOther.userID) as __UID__,
            (select uid from user where user.id=departmentOther.viewUserID) as __VIEWUID__,regTime as __REGTIME__ from departmentOther where bankID='".$rowData["id"]."' order by sortValue,id asc",0);
        $trHtml = "";
        while ( current( $dataTableList ) !== false )
        {
            $dataRow = current( $dataTableList );
            if ( $rowData['bankLevel'] === '0' )
            {
                $tmpHtmlStr = str_replace( '__OWNERNAME__', '', $trHtmlStr );
                $tmpHtmlStr = str_replace( '__EDITTYPE__', '', $tmpHtmlStr );
                $tmpHtmlStr = str_replace( '__DELTYPE__', '', $tmpHtmlStr );
            }
            else
            {
                //echo 'select MenuName from treemenu where MenuId in('.$dataRow["ownerMenuIDList"].');';
                //print_r( $GLOBAL["G_DB_OBJ"]->executeSqlMap('select MenuName from treemenu where MenuId in('.$dataRow["ownerMenuIDList"].');'),0 );
                if ( !Empty( $dataRow["ownerMenuIDList"] ) )
                    $departmentList = implode(",",$GLOBAL["G_DB_OBJ"]->getSqlMap('select MenuName from treemenu where MenuId in('.$dataRow["ownerMenuIDList"].');',1));
                else 
                    $departmentList="";
                //print_r( $departmentList );
                $tmpHtmlStr = str_replace( '__OWNERNAME__', '<td>'.$departmentList.'</td>', $trHtmlStr );
                $tmpHtmlStr = str_replace( '__EDITTYPE__', 'other', $tmpHtmlStr );
                $tmpHtmlStr = str_replace( '__DELTYPE__', 'other', $tmpHtmlStr );
            }
            while ( current( $dataRow ) !== false )
            {
                $tmpHtmlStr = str_replace( key( $dataRow ), current( $dataRow ), $tmpHtmlStr );
                next( $dataRow );
            }
            $trHtml .= $tmpHtmlStr;
            next( $dataTableList );
        }
        $tabHtml .= $tmpTabHtmlStr;
        if ( $rowData['bankLevel'] == '0' )
            $tmpTableHtml = str_replace( "__OWNERMENU__", '', $tableHtmlStr );
        else
            $tmpTableHtml = str_replace( "__OWNERMENU__", '<th>上级科室</th>', $tableHtmlStr );
                 
        $tmpTableHtml = str_replace( "__NUM__", $i, $tmpTableHtml );
        $tableHtml .= str_replace('__TRLIST__', $trHtml, $tmpTableHtml );
        $i++;
        next( $dataList );
    }
    
    $retData['tabHtml'] = $tabHtml;
    $retData['tableHtml'] =$tableHtml;
    return $retData;
}


?>	