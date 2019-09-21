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
    
    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
    $moduleShowtmpl = loadModules("webPage", $errMsg);
	
} else if ($opt === "addFlag") {
	//静态页面中需要注意，input框的name属性需要按照规则命名
    $GLOBAL['htmlDefine']['replaceArray']['__BANKLIST__']=getComboxFromSql_v2('bankID','select id,bankName from banklist order by id asc',"0","changeDepartment(this.form)");

    $listData = getListData();
    $GLOBAL['htmlDefine']['replaceArray']['__BANKIDLIST__'] = $listData[0];
    $GLOBAL['htmlDefine']['replaceArray']['__DEPARTMENTIDLIST__'] = $listData[1];
    $GLOBAL['htmlDefine']['replaceArray']['__DEPARTMENTNAMELIST__'] = $listData[2];
    $GLOBAL['htmlDefine']['replaceArray']['__FILTERDEPARTMENTIDLIST__'] = $listData[3];
    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
    if ( checkAcl(0) ===false )
    {
        echo getHistoryBackScript( '您无权增加分管领导!' );
        exit;
    }
     $moduleShowtmpl = loadModules("webPage", $errMsg);
	//require_once($moduleShowtmpl);
	
}
else if ($opt === "addFlagSave") {
    //静态页面中需要注意，input框的name属性需要按照规则命名
    if ( Empty( $_POST["bankID"] ) )
    {
        echo getHistoryBackScript("所在银行必须填写!");
        exit;
    }

    if ( Empty( $_POST["departmentIDList"] ) )
    {
        echo getHistoryBackScript("分管科室必须填写!");
        exit;
    }

    $ownerIDMenuIDList = implode( $_POST["departmentIDList"],"," );


    $bankID=$_POST["bankID"];
    $name = $_POST["name_姓名_textarea_1_20_1_1"];
    $sortValue = $_POST["sortValue_显示顺序号_integer_1_5_1_1"];
    $uid = $_POST["uid_分管领导帐号用户名_textareaen_1_20_1_1"];
    $pwd = $_POST["passwd_分管领导帐号密码_textareaen_1_20_1_1"];

    
    $userName = $name;

    if ( $GLOBAL['G_DB_OBJ']->getFieldValue( "select uid from user where uid ='".$uid."' limit 1" ) === $uid )
    {
        echo getHistoryBackScript( '分管领导帐号用户名已经存在，请重新填写分管领导帐号用户名!' );
        exit;
    }
    
    if ( !Empty( $GLOBAL['G_DB_OBJ']->getFieldValue( "select id from leader where name ='".$name."' limit 1" ) ) )
    {
        echo getHistoryBackScript( '分管领导用户已经存在!' );
        exit;
    }

    $sql = "insert into user( uid, passwd,userName,influenceID) values('".$uid."','".$pwd."','".$userName."','-1');";
    $GLOBAL['G_DB_OBJ']->executeMutiSqlTrans( $sql );

    $userID = $GLOBAL['G_DB_OBJ']->getFieldValue( "select id from user where uid ='".$uid."' limit 1" );

    if ( !Empty( $userID ) )
    {
        $sql = "insert into leader(bankID,name,departmentIDList,userID,sortValue) values('".$bankID."','".$name."','".$ownerIDMenuIDList."','".$userID."','".$sortValue."')";

        if ( $GLOBAL['G_DB_OBJ']->executeSql( $sql ) === 1  )
        {
            echo getWebLocationScript( '/leaderManage.php?&opt=listFlag', '分管领导填加成功!' );
            exit;
        }
        else 
        {
            echo getHistoryBackScript( '分管领导填加失败,请联系管理员1!' );
            exit;
        }
    }
    else
    {
        echo getHistoryBackScript( '分管领导填加失败,请联系管理员2(userid,menuid)null!' );
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

    $info = $GLOBAL['G_DB_OBJ']->executeSql("select id,sortValue, bankID,name,(select uid from user where id=leader.userID limit 1) as uid,(select passwd from user where id=leader.userID limit 1) as passwd,departmentIDList from leader where id ='".$id."' limit 1" );
    
    if ( $info != null ) {
        $GLOBAL['htmlDefine']['replaceArray'] = array_merge($GLOBAL['htmlDefine']['replaceArray'], array(
            '__ID__' => $id,
            '__NAME__' => $info["name"],
            '__SORTVALUE__'=>$info["sortValue"],
            '__UID__' =>$info["uid"],
            '__PASSWORD__' =>$info["passwd"]
        ));
    }

    
    $vv = $GLOBAL["G_DB_OBJ"]->getFieldValue("select group_concat(departmentIDList SEPARATOR ',') as a FROM `leader` WHERE bankID='".$info["bankID"]."' and id<>'".$id."' group by bankID" );
    //$vv = array();
    //print_r( $vv );
    if ( $GLOBAL["G_DB_OBJ"]->getFieldValue("select bankLevel from banklist where id='".$info["bankID"]."'") == 0 )
    {
        $GLOBAL['htmlDefine']['replaceArray']['__DEPARTMENTLIST__']=getCheckBoxBySql('departmentIDList[]','select id,(select MenuName from treemenu where MenuId=department.menuID limit 1) as name from department where bankID='.$info["bankID"],"",explode( ",", $info["departmentIDList"] ), explode( ",", $vv ) );
    }
    else
    {
        $GLOBAL['htmlDefine']['replaceArray']['__DEPARTMENTLIST__']=getCheckBoxBySql('departmentIDList[]','select id,(select MenuName from treemenu where MenuId=departmentOther.menuID limit 1) as name from departmentOther where bankID='.$info["bankID"],"",explode( ",", $info["departmentIDList"] ), explode( ",", $vv ) );
    }
        
    $GLOBAL['htmlDefine']['replaceArray']['__BANKNAME__']=$GLOBAL["G_DB_OBJ"]->getFieldValue("select bankName from banklist where id ='".$info["bankID"]."' order by id desc");
    
    require_once(ABS_CUR_LOGIN_DIR . "../../../kernel/comm/loadModules.php");
    $moduleShowtmpl = loadModules("webPage", $errMsg);
	//require_once($moduleShowtmpl);
	
}else if ($opt === "editFlagSave") {
    //静态页面中需要注意，input框的name属性需要按照规则命名

    if ( Empty( $_POST["departmentIDList"] ) )
    {
        echo getHistoryBackScript("分管科室必须填写!");
        exit;
    }
    $ownerMenuIDList = implode( $_POST["departmentIDList"],"," );
    
    $id=$_GET["id"];
    $bankID=$_POST["bankID"];
    $name = $_POST["name_姓名_textarea_1_20_1_1"];
    $sortValue = $_POST["sortValue_显示顺序号_integer_1_5_1_1"];
    $uid = $_POST["uid_分管领导帐号用户名_textareaen_1_20_1_1"];
    $pwd = $_POST["passwd_分管领导帐号密码_textareaen_1_20_1_1"];
    
    $userName = $name;
 
    if ( !Empty($GLOBAL['G_DB_OBJ']->getFieldValue( "select name from leader where id<>'".$id."' and name='".$name."'" )))
    {
        echo getHistoryBackScript( '分管领导重名，修改失败1!' );
        exit;
    }
    $sql = "update leader set name='".$name."',departmentIDList='".$ownerMenuIDList."',sortValue='".$sortValue."' where id='".$id."'";
    $ret1 = $GLOBAL['G_DB_OBJ']->executeSql( $sql );
    
    if ( $ret1 !== 1 )
    {
        echo getHistoryBackScript( '分管领导修改失败!' );
        exit;
    }

    $userID = $GLOBAL['G_DB_OBJ']->getFieldValue( "select userID from leader where id ='".$id."' limit 1" );

    if ( !Empty( $userID) )
    {
        $sql = "select uid from user where id<>'".$userID."' and uid='".$uid."'";
        if ( !Empty( $GLOBAL['G_DB_OBJ']->getFieldValue($sql) ) )
        {
            echo getWebLocationScript( '/leaderManage.php?&opt=listFlag', '分管领导修改成功,管理帐号修改失败,有同名的帐号存在!' );
            exit;
        }
        else 
        {
            $sql = "update user set uid='".$uid."', passwd='".$pwd."' where id='".$userID."' limit 1;";
            if ( $GLOBAL['G_DB_OBJ']->executeSql( $sql ) === 1 )
            {
                echo getWebLocationScript( '/leaderManage.php?&opt=listFlag', '分管领导修改成功,管理帐号修改成功!' );
                exit;
            }
            else 
            {
                echo getWebLocationScript( '/leaderManage.php?&opt=listFlag', '分管领导修改成功,管理帐号修改失败1!' );
                exit;
            }
        }

    }

}else if ($opt === "delFlag") {
	//静态页面中需要注意，input框的name属性需要按照规则命名
    $id = $_REQUEST["id"];
    if ( checkAcl(0) ===false )
    {
        echo getHistoryBackScript( '您无权删除分管领导!' );
        exit;
    }
    $leaderUserID = $GLOBAL['G_DB_OBJ']->getFieldValue("select userID from leader where id='".$id."' limit 1;" );
    if ( !Empty( $GLOBAL['G_DB_OBJ']->getFieldValue("select id from question where userID1='".$leaderUserID."' or userID2='".$leaderUserID."' limit 1" ) ) )
    {
        echo getHistoryBackScript( '当前分管领导存在未审核的台账，不能删除，请以分管领导帐号登录系统，到台帐管理->我的台账模块审核台帐完成后，再删除分管领导帐号!' );
        exit;
    }
    $userID = $GLOBAL['G_DB_OBJ']->getFieldValue("select userID from leader where id = '".$id."' limit 1");
    if ( !Empty( $userID ) )
    {
        $sql="delete from user where id='".$userID."';delete from leader where id='".$id."'";
        $GLOBAL['G_DB_OBJ']->executeMutiSqlTrans( $sql );
        echo getWebLocationScript( '/leaderManage.php?&opt=listFlag', '分管领导删除成功!' );
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


function getListData()
{
    global $GLOBAL;
    $bankList=$GLOBAL["G_DB_OBJ"]->executeSqlMap("select id from banklist where bankLevel='1' order by id asc",0);
    $bankIDListStr = "";
    $departmentIDListStr="";
    $filterDepartmentIDListStr="";
    $departmentNameListStr="";
    //SELECT GROUP_CONCAT(departmentIDList SEPARATOR ',') FROM `leader` WHERE bankID=16 group by bankID
    while ( current( $bankList ) !== false )
    {
        $v1 = current( $bankList );
        $bankIDListStr .= $v1["id"].",";
        $departmentIDList = $GLOBAL["G_DB_OBJ"]->executeSqlMap("select id,(select MenuName from treemenu where treemenu.MenuId=departmentOther.menuID) as departmentName from departmentOther where bankID='".$v1["id"]."' order by id asc",0);
        $v2 = "";
        $v3 = "";
        while ( current( $departmentIDList ) !== false )
        {
            $vv2=current( $departmentIDList );
            $v2 .= $vv2[ "id" ].",";
            $v3 .= "'".$vv2[ "departmentName" ]."',";
            next( $departmentIDList );
        }
        if ( !Empty( $v2 ) )
        {
            $v2 = substr( $v2, 0, -1 );
            $v3 = substr( $v3, 0, -1 );
        }
        $v2 = "[".$v2."]";
        $v3 = "[".$v3."]";
        $departmentIDListStr .= $v2.",";
        $departmentNameListStr .= $v3.",";
        //echo "SELECT GROUP_CONCAT(departmentIDList SEPARATOR ',') FROM `leader` WHERE bankID='".$v1["id"]."' group by bankID"."<br>";
        $vv = $GLOBAL["G_DB_OBJ"]->getFieldValue("SELECT GROUP_CONCAT(departmentIDList SEPARATOR ',') as a FROM `leader` WHERE bankID='".$v1["id"]."' group by bankID");
        
        if ( !Empty( $vv ) )
            !Empty( $filterDepartmentIDListStr ) ? ( $filterDepartmentIDListStr .= ",[".$vv."]" ) : ( $filterDepartmentIDListStr = "[".$vv."]" ); 
        else 
            !Empty( $filterDepartmentIDListStr ) ? ( $filterDepartmentIDListStr .= ",[]" ) : ( $filterDepartmentIDListStr = "[]" );
        next( $bankList );
    }
    if ( !Empty( $departmentIDListStr ) )
    {
        $departmentIDListStr = substr( $departmentIDListStr, 0, -1 );
        $departmentNameListStr = substr( $departmentNameListStr, 0, -1 );
    }
    //echo $filterDepartmentIDListStr."<br>";
    if ( !Empty( $bankIDListStr ) )
        $bankIDListStr = substr( $bankIDListStr, 0, -1 );
    $v3=$GLOBAL["G_DB_OBJ"]->getFieldValue( "select id from banklist where bankLevel='0' order by id asc" );
    if ( !Empty( $v3 ) )
    {
        if ( !Empty( $bankIDListStr ) )
            $bankIDListStr =$v3.",".$bankIDListStr;
        else
            $bankIDListStr =$v3;
        $departmentIDList = $GLOBAL["G_DB_OBJ"]->executeSqlMap("select id,(select MenuName from treemenu where MenuId=department.menuID limit 1) as departmentName from department where bankID='".$v3."' order by id asc",0);
        $v2="";
        $v3="";
        while ( current( $departmentIDList ) !== false )
        {
            $vv2 = current( $departmentIDList );
            $v2 .= $vv2["id"].",";
            $v3 .= "'".$vv2["departmentName"]."',";
            next( $departmentIDList );
        }
        if ( !Empty( $v2 ) )
        {
            $v2 = substr( $v2, 0, -1 );
            $v3 = substr( $v3, 0, -1 );
        }
        $v2 = "[".$v2."]";
        $v3 = "[".$v3."]";
        if ( !Empty( $departmentIDListStr ) )
        {
            $departmentIDListStr = $v2.",".$departmentIDListStr;
            $departmentNameListStr = $v3.",".$departmentNameListStr;
        }
        else
        {
            $departmentIDListStr = $v2;
            $departmentNameListStr = $v3;
        }
        $vv = $GLOBAL["G_DB_OBJ"]->getFieldVaue("SELECT GROUP_CONCAT(departmentIDList SEPARATOR ',') FROM `leader` WHERE bankID='".$v3."' group by bankID");
        if ( !Empty( $vv ) )
            !Empty( $filterDepartmentIDListStr ) ? ( $filterDepartmentIDListStr = "[".$vv."],".$filterDepartmentIDListStr ) : ( $filterDepartmentIDListStr = "[".$vv."]" );
        else 
            !Empty( $filterDepartmentIDListStr ) ? ( $filterDepartmentIDListStr = "[],".$filterDepartmentIDListStr ) : ( $filterDepartmentIDListStr = "[]" );
            
    }
    $bankIDListStr = "[".$bankIDListStr."]";
    $departmentIDListStr = "[".$departmentIDListStr."]";
    $departmentNameListStr = "[".$departmentNameListStr."]";
    $filterDepartmentIDListStr = "[".$filterDepartmentIDListStr."]";
    $tmp[0]=$bankIDListStr;
    $tmp[1]=$departmentIDListStr;
    $tmp[2]=$departmentNameListStr;
    $tmp[3]=$filterDepartmentIDListStr;
    return $tmp;
}

function getHTtmlData()
{
    global $GLOBAL;
    $tabHtmlStr = '<li class="item-__NUM____FLAG__"><i></i><div class="text"><h3>__NAME__</h3><p>银行分管领导列表</p></div></li>';
    $tableHtmlStr = '<li class="item-__NUM__" style="position: relative; width: 1920px; left: 0px; top: 0px; display: list-item;">
                    <div>
                    <table class="tablelist-new">
                    <thead>
						<tr>
					    <th>姓名</th>
        				<th>所在银行</th>
                        <th>分管科室</th>
					    <th>登录帐号</th>
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
			    <td>__NAME__</td>
			    <td>__BANKNAME__</td>
                <td>__DEPARTMENTNAMELIST__</td>
			    <td>__UID__</td>
			    <td>__REGTIME__</td>
			    <td><a href="/leaderManage.php?opt=editFlag&id=__ID__&editType=__EDITTYPE__" class="tablelink">修改</a><a href="/leaderManage.php?opt=delFlag&id=__ID__&delType=__DELTYPE__" class="tablelink"> 删除</a></td>
			    </tr>';
    
    $i = 1;
    $tabHtml = "";
    $tableHtml = "";
    $dataList = $GLOBAL["G_DB_OBJ"]->executeSqlMap("select id,bankName,bankLevel from banklist order by id asc;", 0);
    
    while ( current( $dataList ) !== false )
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

        $dataTableList = $GLOBAL["G_DB_OBJ"]->executeSqlMap("select name as __NAME__, id as __ID__,(select bankName from banklist where banklist.id=leader.bankID limit 1) as __BANKNAME__,
            (select uid from user where user.id=leader.userID) as __UID__,bankID,departmentIDList,regTime as __REGTIME__ from leader where bankID='".$rowData["id"]."' order by id asc",0);
        $trHtml = "";

        while ( current( $dataTableList ) !== false )
        {
            $dataRow = current( $dataTableList );
            $tmpHtmlStr=$trHtmlStr;
            $departmentNameList="";
            if ( $GLOBAL["G_DB_OBJ"]->getFieldValue("select bankLevel from banklist where id='".$dataRow["bankID"]."'") === "0" )
            {
                $v1 = $GLOBAL["G_DB_OBJ"]->executeSqlMap("select (select MenuName from treemenu where MenuId=department.menuID limit 1) as name from department where id in (".$dataRow["departmentIDList"].")");
                while ( current( $v1 ) !== false )
                {
                    $vv1 = current( $v1 );
                    $departmentNameList .= $vv1["name"].",";
                    next( $v1 );
                }

            }
            else 
            {
                $v1 = $GLOBAL["G_DB_OBJ"]->executeSqlMap("select (select MenuName from treemenu where treemenu.MenuId=departmentOther.menuID) as name from departmentOther where id in (".$dataRow["departmentIDList"].")");
                while ( current( $v1 ) !== false )
                {
                    $vv1 = current( $v1 );
                    $departmentNameList .= $vv1["name"].",";
                    next( $v1 );
                }
            }
            if ( !Empty( $departmentNameList ) )
                $departmentNameList = substr( $departmentNameList, 0, -1 );
            $tmpHtmlStr = str_replace( '__DEPARTMENTNAMELIST__', $departmentNameList, $tmpHtmlStr );

            
            while ( current( $dataRow ) !== false )
            {
                $tmpHtmlStr = str_replace( key( $dataRow ), current( $dataRow ), $tmpHtmlStr );
                //echo "l=".__LINE__."<br>";
                next( $dataRow );
            }
            //echo "l=".__LINE__."<br>";
 
            $trHtml .= $tmpHtmlStr;
            next( $dataTableList );
        }
          
        $tmpTableHtml = str_replace( "__NUM__", $i, $tableHtmlStr );
        $tableHtml .= str_replace('__TRLIST__', $trHtml, $tmpTableHtml );

        $i++;
        next( $dataList );
    }
    
    $retData['tabHtml'] = $tabHtml;
    $retData['tableHtml'] =$tableHtml;
    return $retData;
}
?>	