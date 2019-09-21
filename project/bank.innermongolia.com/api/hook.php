<?php
define( 'ABS_CUR_DIR_PROJECT_LOGIN', dirname(__FILE__).'/' );
require_once(ABS_CUR_DIR_PROJECT_LOGIN . '../inc/conf.php');
require_once( ABS_CUR_DIR_PROJECT_LOGIN.'../../../kernel/inc/checkSession.php' );
//print_r( $GLOBAL['G_DB_OBJ']->executeSql("delete from user where uid='user1'") );
//print_r( $GLOBAL['G_DB_OBJ']->executeSql("insert into user (uid,passwd,influenceID,lastLoginTime) value('user1','123456','-1','1970-01-01 00:00:01')") );
//$GLOBAL['G_DB_OBJ']->executeSql("delete from user where uid='user1'")
//$departmentID=$GLOBAL['G_DB_OBJ']->getFieldValue("select MenuId from treemenu where MenuName='财务科' limit 1");
/*
 *  编辑	复制 复制	删除 删除	615 	财务科 	0 	../blank.php?flag=1 	0 	0 	??:style=popUp:addFlag=1|??:style=mulSele:delFlag=... 	'' 	1 	2018-07-20 22:10:33 	目录
	编辑 编辑	复制 复制	删除 删除	616 	信息科 	0 	../blank.php?flag=1 	0 	0 	??:style=popUp:addFlag=1|??:style=mulSele:delFlag=... 	'' 	1 	2018-07-20 22:21:17 	目录
	编辑 编辑	复制 复制	删除 删除	619 	保卫科 	0 	../blank.php?flag=1
 */
/*
$sqlStr = "delete from treemenu where MenuName='财务科' or MenuName='信息科' or MenuName='保卫科';";
$GLOBAL['G_DB_OBJ']->executeSql( $sqlStr );
$sqlStr = "update treemenu set MenuLevel=MenuLevel-1;";
$GLOBAL['G_DB_OBJ']->executeSql( $sqlStr ); 
$sqlStr = "update treemenu set MenuPid=0 where MenuLevel=0;";
delete from treemenu where MenuName='财务科' or MenuName='信息科' or MenuName='保卫科';
update treemenu set MenuLevel=MenuLevel-1;
update treemenu set MenuPid=0 where MenuLevel=0;

*/
/*
$sqlStr1="insert into treemenu (MenuName,MenuLevel,MenuPid,MenuEndFlag) values('财务科',0,0,'0'),('信息科',0,0,'0'),('保卫科',0,.0,'0')";
$GLOBAL['G_DB_OBJ']->executeSql($sqlStr1);
$caiwuID=$GLOBAL['G_DB_OBJ']->getFieldValue("select MenuId from treemenu where MenuName='财务科' limit 1;");
$xingxiID=$GLOBAL['G_DB_OBJ']->getFieldValue("select MenuId from treemenu where MenuName='信息科' limit 1;");
$baoweiID=$GLOBAL['G_DB_OBJ']->getFieldValue("select MenuId from treemenu where MenuName='保卫科' limit 1;");
$sql="update department set menuID='".$caiwuID."' where menuID=615;update department set menuID='".$xingxiID."' where menuID=616;update department set menuID='".$baoweiID."' where menuID=619;";
echo $sql;
print_r( $GLOBAL['G_DB_OBJ']->executeMutiSqlTrans( $sql) );
$sqlStr = "update treemenu set MenuLevel=MenuLevel+1 where MenuName<>'财务科' and MenuName <>'信息科' and MenuName<>'保卫科';update treemenu set MenuPid='".$caiwuID."' where MenuPid=0 and MenuName<>'财务科' and MenuName <>'信息科' and MenuName<>'保卫科' and MenuName<>'退出系统';";
echo $sqlStr;
print_r( $GLOBAL['G_DB_OBJ']->executeMutiSqlTrans( $sqlStr) );
*/
/*
$GLOBAL['G_DB_OBJ']->executeSql("update user set influenceID='-1' where influenceID='0';");
$GLOBAL['G_DB_OBJ']->executeSql("update treemenu set SortValue='9999' where MenuName='退出系统' and MenuPId='0';");
$GLOBAL['G_DB_OBJ']->executeSql("alter table department add column sortValue integer default 1 after userID;");
*/
/*
$GLOBAL['G_DB_OBJ']->executeSql("alter table treemenu  alter column MenuLink set default '/kernel.php?module=mainFrame&app=blank';");
$GLOBAL['G_DB_OBJ']->executeSql("update treemenu set MenuLink='/kernel.php?module=mainFrame&app=blank' where MenuEndFlag='0' and MenuName<>'退出系统'");
$GLOBAL['G_DB_OBJ']->executeSql("update treemenu set MenuLink='/kernel.php?module=mainFrame&app=blank' where MenuPId='0' and MenuName<>'退出系统'");
*/
/*
$GLOBAL['G_DB_OBJ']->executeSql("ALTER TABLE `department` ADD `viewUserID` INT NOT NULL DEFAULT '0' AFTER `userID`;");
$GLOBAL['G_DB_OBJ']->executeSql("delete from user where uid='nsk1' or uid='jwjcs1'");
$GLOBAL['G_DB_OBJ']->executeSql("INSERT INTO `user` (`id`, `uid`, `passwd`, `userName`, `sex`, `cityID`, `hometown`, `birthday`, `address`, `qq`, `msn`, `mobile`, `homepage`, `company`, `job`, `note`, `influenceID`, `siteID`, `treeID`, `status`, `lastLoginTime`, `departmentID`, `regTime`) VALUES (NULL, 'nsk1', '123456', '', '0', '0', NULL, '1978-02-13', NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, '-1', '0', '0', '0', '2018-08-10 22:37:58', '0', '2017-12-28 14:54:11');");
$GLOBAL['G_DB_OBJ']->executeSql("INSERT INTO `user` (`id`, `uid`, `passwd`, `userName`, `sex`, `cityID`, `hometown`, `birthday`, `address`, `qq`, `msn`, `mobile`, `homepage`, `company`, `job`, `note`, `influenceID`, `siteID`, `treeID`, `status`, `lastLoginTime`, `departmentID`, `regTime`) VALUES (NULL, 'jwjcs1', '123456', '', '0', '0', NULL, '1978-02-13', NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, '-1', '0', '0', '0', '2018-08-10 22:37:58', '0', '2017-12-28 14:54:11');");


$GLOBAL['G_DB_OBJ']->executeSql("ALTER TABLE `fileList` ADD `publicFlag` ENUM('0','1') NOT NULL DEFAULT '0' AFTER `fileBody`;");
*/
//print_r($GLOBAL['G_DB_OBJ']->getMutiRowFieldValue('SELECT * from statictis_login_oneday,statictis_login_sevenday,statictis_login_monthday,statictis_login_yearday,statictis_read_oneday,statictis_read_sevenday,statictis_read_monthday,statictis_read_yearday'));