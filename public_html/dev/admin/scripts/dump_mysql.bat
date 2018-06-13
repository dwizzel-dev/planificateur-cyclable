@echo "...START DUMP"
SET DTIME=%Time%
SET DDATE=%Date%
SET YYYY=%DDATE:~6,4%
SET MTH=%DDATE:~3,2%
SET DD=%DDATE:~0,2%
SET HH=%DTIME:~0,2%
SET MM=%DTIME:~3,2%
SET SS=%DTIME:~6,2%
SET MYSQLPATH="C:\Program Files\MySQL\MySQL Server 5.5\bin"
SET FILEEXPORT="C:\inetpub\wwwroot\inspq\funio\temp\dump\dump_%DD%%MTH%%YYYY%%HH%%MM%%SS%.sql"
%MYSQLPATH%\mysqldump -uroot -pleschiens666 inspq > %FILEEXPORT%
@echo "END DUMP..."