@echo "...START CRONJOB"
SET SCRIPTPATH=C:\inetpub\wwwroot\inspq\site\admin\scripts
CALL %SCRIPTPATH%\dump_mysql.bat
@echo "END CRONJOB"
