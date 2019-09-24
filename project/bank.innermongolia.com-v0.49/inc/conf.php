<?php
define( 'ABS_CUR_PROJECT_PATH', dirname( __FILE__ ).'/' );
$appConf = parse_ini_file( ABS_CUR_PROJECT_PATH.'conf.ini', true );
function checkAcl($departmentID=0)
{
    global $GLOBAL;

    $uid=$_SESSION['userData']['uid'];
    if ( $uid === "admin" )
        return true;
    else
    {
        $id = $_SESSION['userData']['id'];
        $storeDepartmentiD=$GLOBAL['G_DB_OBJ']->getFieldValue("select id from department where userID='".$id."';");
        if ( $storeDepartmentiD === $departmentID )
            return true;
         else
            return false;
    }
}

//$appConf = parse_ini_file( ABS_CUR_PROJECT_PATH.'conf.ini');
?>