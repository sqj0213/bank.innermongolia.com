<?php

define( 'ABS_CUR_DIR_PROJECT_LOGIN', dirname(__FILE__).'/' );
require_once(ABS_CUR_DIR_PROJECT_LOGIN . '../inc/conf.php');
require_once( ABS_CUR_DIR_PROJECT_LOGIN.'../../../kernel/comm/uploadFile.php' );
require_once( ABS_CUR_DIR_PROJECT_LOGIN.'./readFileContent.php' );
$extensionList= array("doc","gd","pdf","docx","xls","wps","GW");

$info = pathinfo($_FILES['file']['name']);
$tmpExtensionName = $info['extension'];//substr($_FILES['file']['tmp_name'],strpos($_FILES['file']['tmp_name'],".")+1 );

$retArr['srcFileName']=$_FILES['file']['name'];

if ( !in_array($tmpExtensionName,$extensionList) )
{
    $retArr["retCode"]=0;
    $retArr["filePath"]="";
    $retArr["msg"]="只支持doc|docx|gd|pdf|xls文件类型的上传:".$tmpExtensionName;
    header('Content-type:text/json');
    echo json_encode($retArr);
    exit;
}
else
{
    $fu=new file_upload("file",$appConf['GLOBAL']['uploadDir']."/tmp/");
    $msg = $fu->upload();
    $retEnd = explode( ":",$msg );

    if ( $retEnd[0] === 'success' )
    {
        
        $retArr["retCode"]=1;
        $retArr["filePath"]="/ckfinder/userfiles/tmp/".$retEnd[1];
        if ( $tmpExtensionName == 'pdf' )
            $retArr["msg"]='
                   <div class="panel-heading" align="center">
                      <h2>预览pdf文件</h2>
                   </div>
                   <div class="panel-body">
                	  <a class="media" href="'.$retArr["filePath"].'"></a>  
                   </div>';
        elseif  ( $tmpExtensionName == 'gd'|| $tmpExtensionName == 'wps'|| $tmpExtensionName == 'GW')
        {
            
            $retArr["msg"] = $retArr['srcFileName'];
        }
        elseif  ( $tmpExtensionName == 'xls' )
        {
        
            $retArr["msg"] = $retArr['srcFileName'];
        }
        else
            $retArr["msg"]=buildHtml("/tmp/".$retEnd[1]);
        header('Content-type:text/json');
        echo json_encode($retArr);
    }
    else 
    {
         $retArr["retCode"]=0;
         $retArr["filePath"]="";
         $retArr["msg"]=$msg;
         header('Content-type:text/json');
         echo json_encode($retArr);
    }
}
?>