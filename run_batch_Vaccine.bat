@echo off
cd /d F:\Q.Dung\Nhu\VaccineCare
php artisan schedule:run >> schedule_log.txt 2>&1
exit