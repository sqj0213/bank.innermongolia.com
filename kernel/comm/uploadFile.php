<?php
/*
program:赵金鹏
time:2012-04-11
todo:代码还有很多可以加的方法，由于时间关系没有加，以后有需要再更新。
*/
  class file_upload
  {
      var $g_filename; // File对象名称
      var $g_Directroy;  //上传至目录 
      var $g_MaxSize;    //最大上传大小  
      var $g_doUpFile;   //上传的文件名 
      var $g_sm_File;   //缩略图名称 
      var $g_Error;     //错误参数 
      //构造函数
      public function file_upload($file_name,$dir_upload='')
      {
           $this->g_filename=$file_name;
           $this->g_MaxSize=50097152; // (1024*2)*1024=2097152 就是 2M 
           $this->g_Error=0;
           if($dir_upload=="")
                $this->g_Directroy="upload";
           else
                $this->g_Directroy=$dir_upload;
      }
      //上传
      function upload()
      {
          if($this->Is_uploadDir() && $this->Is_FileMax())
          {
              $this->get_newname();
              $file_path=$this->g_Directroy.'/'.$this->g_doUpFile;
              if(!move_uploaded_file( $_FILES[$this->g_filename]['tmp_name'], $file_path))
                {
                    $this->g_Error=5;
                    return $this->get_error();
                } 
              else 
              {
                  $this->g_Error=0;
                  return $this->get_error(); 
              }
          }
          else
                return  $this->get_error(); 
      }
      //生成新名称
      function get_newname()
      {
            $tempName = $_FILES[$this->g_filename]['name']; 
            $extStr = explode('.', $tempName); 
            $count = count($extStr)-1; 
            $ext = $extStr[$count]; 
            $this->g_doUpFile=date('YmdHis').rand(0, 9).'.'.$ext;
      }
      //验证上传目录是否存在
      function Is_uploadDir()
      {
           if(!is_dir($this->g_Directroy))
            { 
                if(!mkdir($this->g_Directroy))
                    {
                        $this->g_Error=1;
                        return false;
                    }
                if(!chmod($this->g_Directroy,0755))
                    {
                        $this->g_Error=2;
                        return false;
                    }
            }
            return true;
      }
      //验证上传文件是否超出限制
      function Is_FileMax()
      {
          if($_FILES[$this->g_filename]['size']>$this->g_MaxSize)
            {
               $this->g_Error=3;
               return false;
           }
           return true;
      }
      //返回服务器文件名
      function get_filename()
      {
          return  $this->$g_doUpFile;
      }
      //自定义错误代码
      function get_error()
      {
          switch($this->g_Error)
          {
              case 0:
                $tip="success:".$this->g_doUpFile;break;
              case 1:
                $tip="文件上传目录不存在并且无法创建文件上传目录";break;  
              case 2:
                $tip="文件上传目录的权限无法设定为可读可写";break;
              case 3:
                $tip="上传的文件大小超过了规定大小";break;
              case 4:
                $tip="请选择上传的文件";break;
              case 5:
                $tip="复制文件失败，请重新上传";break;
              
          }
          return  $tip;  
      }
  }
?>