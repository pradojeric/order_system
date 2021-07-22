tasklist /FI "IMAGENAME eq xampp-control.exe" | findstr /I "xampp-control.exe" && (
    taskkill /f /IM xampp-control.exe
) || (
    start C:\xampp\xampp-control.exe
)
cd C:\Users\ARQminingfarms\Desktop\livewire\order-sys
set link=%cd%
set ip=192.168.100.168
start cmd /k "cd %link% && php artisan websockets:serve"
start cmd /k "cd %link% && php artisan serve --host %ip%"
cd "C:\Users\ARQminingfarms\AppData\Local\Programs\Opera GX"
start launcher.exe %ip%:8000/waiter-order
exit