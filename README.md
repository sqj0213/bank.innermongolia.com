安装过程：
1.安装nginx:版本>=1.8.1
修改nginx.conf配置文件，内容如下，注意日志路径并且注意日志文件所在路径的权限

	#user  nobody;
	worker_processes  1;
	
	error_log  /data/logs/error.log;
	
	#pid        logs/nginx.pid;
	
	
	events {
	    worker_connections  1024;
	}
	
	
	http {
	    include       mime.types;
	    default_type  application/octet-stream;
	
	    client_max_body_size 50m; 
	    #log_format  main  '$remote_addr - $remote_user [$time_local] "$request" '
	    #                  '$status $body_bytes_sent "$http_referer" '
	    #                  '"$http_user_agent" "$http_x_forwarded_for"';
	
	    access_log  /data/logs/error.log;
	    access_log  logs/access.log  main;
	
	    sendfile        on;
	    #tcp_nopush     on;
	
	    #keepalive_timeout  0;
	    keepalive_timeout  65;
	
	
	
	    server {
		default_type 'text/html';
	 	charset utf-8;
	        listen       80;
	        server_name  localhost;
	
	
	        location / {
	            root   /usr/local/webapp/web-admin/project/bank.innermongolia.com/static/;//注意此处的路径与权限
	            index  index.html index.htm;
	        }
	
	        error_page   500 502 503 504  /50x.html;
	        location = /50x.html {
	            root   html;
	        }
	
	        location ~ \.php$ {
	            root           /usr/local/webapp/web-admin/project/bank.innermongolia.com/;//注意此处的路径与权限
	            fastcgi_pass   127.0.0.1:9000;
	            fastcgi_index  login.php;
	            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
	            include        fastcgi_params;
	        }
	
	    }
	
	
	
	    include servers/*;
	}
2.安装php：版本>=5.6.30
配置文件内容如下：注意日志文件路径与权限
[global]
error_log = /var/log/php-fpm.log
[www]
user = nobody
group = nobody
listen = 127.0.0.1:9000
pm = dynamic
pm.max_children = 5
pm.start_servers = 2
pm.min_spare_servers = 1
pm.max_spare_servers = 3

3.安装mysql:版本>=5.7.11
	导入webadmin.sql文件到数据库
	修改mysql的root密码为:"1q2w3e"
	
4.安装源代码：
  copy bank.innermongolia.com 代码到web根目录,并修改目录名 bank.innermongolia.com 为web-admin
  
5.修改配置文件：
打开文件web-admin/project/bank.innermongolia.com/inc/conf.ini文件，改为可以被其它机器访问的ip地址
日志路径改为windows的日志路径如c:\web-admin\data\logs\bank.innermongolia.com.acc-php.log
[GLOBAL]
serverInfo.dbInfo.dbHost="127.0.0.1"
serverInfo.dbInfo.dbName=webadmin
serverInfo.dbInfo.dbUser=root
serverInfo.dbInfo.dbPwd=1q2w3e
serverInfo.dbInfo.dbPort=3306
serverInfo.dbInfo.dbCharset=utf8

serverInfo.logInfo.accLog=/data/logs/bank.innermongolia.com.acc-php.log
serverInfo.logInfo.appLog=/data/logs/bank.innermongolia.com.app-php.log
serverInfo.logInfo.errLog=/data/logs/bank.innermongolia.com.err-php.log
serverInfo.logInfo.notLog=/data/logs/bank.innermongolia.com.not-php.log

serverInfo.errorUrl = "http://127.0.0.1/login.php"
serverInfo.tmplPath="/usr/local/webapp/web-admin/project/bank.innermongolia.com/static/tmpl/"
uploadDir="/usr/local/webapp/web-admin/project/bank.innermongolia.com/static/ckfinder/userfiles/"
checkACL="on"

6.访问测试：
	浏览器打开：http://ip/即可
	帐号：user密码：123456
