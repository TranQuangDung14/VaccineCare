<?php

namespace App\Console\Commands\Email;

use App\Mail\SendCalendarMail;
use App\Models\Notifications;
use App\Models\SchedulesDetail;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailNotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vaccine:send-reminder-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gửi email nhắc nhở lịch tiêm chủng trước 15-7-1 ngày';

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
            $test = 'dũng đẹp zai vcl';
            $today = Carbon::today();
            $days_before_list = [30, 7, 1];
            $emailCount = 0;
            foreach ($days_before_list as $days_before) {
                $target_date = $today->copy()->addDays($days_before);

                $schedules = SchedulesDetail::whereDate('scheduled_date', $target_date)
                    ->with('vaccinationschedules.patients')
                    ->get();

                foreach ($schedules as $schedule) {
                    $patient = $schedule->vaccinationschedules->patients;
                    Log::info('$schedule:' . $schedule);
                    Log::info('$patient:' . $patient);
                    Log::info('$patient->mail:' . $patient->email);
                    if ($patient && $patient->email) {
                        // Gửi email
                        Mail::to($patient->email)->send(new SendCalendarMail($test));

                        // Lưu thông báo vào database
                        Notifications::create([
                            'schedule_id' => $schedule->vaccination_schedules_id,
                            'schedules_detail_id' => $schedule->id,
                            'notification_type' => 0, // Mail
                            'status' => 'sent',
                            'sent_at' => now()
                        ]);
                        $emailCount++;
                    }
                }
            }
            Log::info('Đã gửi email nhắc nhở thành công! <vaccine:send-reminder-mail>');
            Log::info('Đã gửi tổng :' . $emailCount . ' email.');
            $this->info('Đã gửi email nhắc nhở thành công!');
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::info('Lỗi :' . $e);
        }
    }
}
