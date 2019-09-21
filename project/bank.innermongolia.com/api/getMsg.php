<?php

define( 'ABS_CUR_DIR_PROJECT_LOGIN', dirname(__FILE__).'/' );
require_once(ABS_CUR_DIR_PROJECT_LOGIN . '../inc/conf.php');
require_once( ABS_CUR_DIR_PROJECT_LOGIN.'../../../kernel/inc/checkSession.php' );

global $GLOBAL;
$ret = array();
$userID = $GLOBAL["runData"]["userData"]["id"];

$ret["count"]=$GLOBAL["G_DB_OBJ"]->getFieldValue("select count(*) from question where ( userID='".$userID."' or userID1='".$userID."' or userID2='".$userID."' ) and datediff(endTime,now())<10 and endFlag='0'");
$ua = $_SERVER["HTTP_USER_AGENT"];
if ( preg_match( "/MSIE/", $ua ) )
    header( "Content-Type: text/html" );
    else if (preg_match( "/Firefox/", $ua ) )
        header( 'Content-type:text/json' );
        else
            header( 'Content-type:text/json' );
echo json_encode( $ret );
