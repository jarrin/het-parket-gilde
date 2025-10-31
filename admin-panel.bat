@echo on
REM Admin Panel Management Script for Het Parket Gilde

:menu
cls
echo ============================================
echo   Het Parket Gilde - Admin Panel Manager
echo ============================================
echo.
echo 1. Start Admin Panel
echo 2. Stop Admin Panel
echo 3. Restart Admin Panel
echo 4. View Logs
echo 5. Open Admin Panel in Browser
echo 6. Open Database Setup in Browser
echo 7. Rebuild Container
echo 8. Exit
echo.
set /p choice="Enter your choice (1-8): "

if "%choice%"=="1" goto start
if "%choice%"=="2" goto stop
if "%choice%"=="3" goto restart
if "%choice%"=="4" goto logs
if "%choice%"=="5" goto open_admin
if "%choice%"=="6" goto open_setup
if "%choice%"=="7" goto rebuild
if "%choice%"=="8" goto end
goto menu

:start
echo.
echo Starting admin panel...
docker-compose up -d
echo.
echo Admin panel is now running!
echo Access at: http://localhost:8080/admin/
echo.
pause
goto menu

:stop
echo.
echo Stopping admin panel...
docker-compose down
echo.
echo Admin panel stopped.
echo.
pause
goto menu

:restart
echo.
echo Restarting admin panel...
docker-compose restart
echo.
echo Admin panel restarted!
echo.
pause
goto menu

:logs
echo.
echo Showing logs (Press Ctrl+C to exit)...
echo.
docker-compose logs -f
pause
goto menu

:open_admin
echo.
echo Opening admin panel in browser...
start http://localhost:8080/admin/
goto menu

:open_setup
echo.
echo Opening database setup in browser...
start http://localhost:8080/admin/db_setup.php
goto menu

:rebuild
echo.
echo Rebuilding container (this may take a minute)...
docker-compose down
docker-compose build --no-cache
docker-compose up -d
echo.
echo Container rebuilt and started!
echo.
pause
goto menu

:end
echo.
echo Goodbye!
exit

