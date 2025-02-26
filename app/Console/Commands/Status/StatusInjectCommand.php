<?php

namespace App\Console\Commands\Status;

use App\Models\SchedulesDetail;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class StatusInjectCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'status:inject';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cập nhật trạng thái của từng mũi tiêm nếu quá hạn';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            Log::info('Bắt đầu cập nhật trạng thái!');
            $count = 0;
            $today = Carbon::today();
            $scheduleDetails = SchedulesDetail::where('scheduled_date', '<', $today)
                ->where('status', 0)
                ->get();
            foreach ($scheduleDetails as $scheduleDetail) {
                $scheduleDetail->status = 2;
                $scheduleDetail->save();
                $count++;
            }
            Log::info('câp nhật trạng thái thành công!');
            Log::info('Số lượng đã cập nhật: ' . $count);
            Log::info('Task Scheduler chạy lúc: ' . now());
            $this->info('Đã cập nhật trạng thái thành công!');
        } catch (\Exception $e) {
            //throw $th;
            Log::info('Lỗi :' . $e);
        }
    }
}
