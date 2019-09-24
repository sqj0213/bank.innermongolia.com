<?php
define( 'ABS_CUR_DIR_PROJECT_LOGIN', dirname(__FILE__).'/' );
require_once(ABS_CUR_DIR_PROJECT_LOGIN . '../inc/conf.php');
require_once( ABS_CUR_DIR_PROJECT_LOGIN.'../../../kernel/inc/checkSession.php' );
print_r( $GLOBAL['G_DB_OBJ']->executeSql("delete from user where uid='user1'") );
print_r( $GLOBAL['G_DB_OBJ']->executeSql("insert into user (uid,passwd,influenceID,lastLoginTime) value('user1','123456','-1','1970-01-01 00:00:01')") );