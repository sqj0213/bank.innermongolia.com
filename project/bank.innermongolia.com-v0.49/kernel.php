<?php
    //导入kernel的基础模块,重定义模板与控制器
    define( 'ABS_CUR_DIR_KERNEL', dirname( __FILE__ ).'/' );
    require_once(ABS_CUR_DIR_KERNEL . 'inc/conf.php');



    $module = $_REQUEST['module'];
    $appType = $_REQUEST['appType'];
    $app = $_REQUEST[ 'app' ];

    if ( Empty( $appType ) )
    {

        if ( Empty( $module ) )
        {
        	echo "modules request is invalid!";
        	exit;
        }
         require_once( ABS_CUR_DIR_KERNEL.'../../kernel/modules/'.$module.'/'.$app.'.php' );
    }
    else
    {
        require_once( ABS_CUR_DIR_KERNEL.'/'.$app.'.php' );
    }

?>