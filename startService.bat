@echo off
REM Windows 下无效
REM set PHP_FCGI_CHILDREN=5

REM 每个进程处理的最大请求数，或设置为 Windows 环境变量
set PHP_FCGI_MAX_REQUESTS=1000
 
echo Starting mysql...
net start mysql

REM Windows 下无效
REM set PHP_FCGI_CHILDREN=5

REM 每个进程处理的最大请求数，或设置为 Windows 环境变量
set PHP_FCGI_MAX_REQUESTS=500

echo Starting PHP FastCGI...
d:\wnmp\RunHiddenConsole d:\wnmp\php-5.6.33-nts-Win32-VC11-x86\php-cgi.exe -b 127.0.0.1:9000 -c d:\wnmp\php-5.6.33-nts-Win32-VC11-x86\php.ini
 
echo Starting nginx...
d:\wnmp\RunHiddenConsole d:\wnmp\nginx-1.13.8\nginx.exe -p d:\wnmp\nginx-1.13.8