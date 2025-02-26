<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SendCalendarMail;
use App\Models\Notifications;
use App\Models\Patients;
use App\Models\SchedulesDetail;
use App\Models\VaccinationSchedules;
use App\Models\Vaccines;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Yoeunes\Toastr\Facades\Toastr;

class VaccinationSchedulesController extends Controller
{
    //lịch tiêm
    public function index()
    {
        $data['patient'] = Patients::get();
        return view('Admin.pages.vaccination_schedule.vaccination_schedule', compact('data'));
    }

    // thông tin lịch trình tiêm
    public function showService($id)
    {
        // $today = Carbon::today();
        // $scheduleDetails = SchedulesDetail::where('scheduled_date', '<', $today)
        //     ->where('status',0)
        //     ->get();
        //     dd($scheduleDetails);
        $data['patient'] = Patients::find($id);
        $data['schedule'] =  VaccinationSchedules::with('details.notification', 'vaccines')->where('patient_id', $id)->get();
        // dd($data['schedule']);
        return view('Admin.pages.vaccination_schedule.detail_schedule', compact('data'));
    }

    public function updatedetailSchedule($id)
    {
        $data['schedulesdetail'] = SchedulesDetail::find($id);
        return view('Admin.pages.vaccination_schedule.update_Schedule', compact('data'));
    }

    public function create($patient_id)
    {
        $data['patient'] = Patients::where('id', $patient_id)->first();
        $data['vaccines'] = Vaccines::get();
        return view('Admin.pages.vaccination_schedule.add_edit_vaccination_schedule', compact('data', 'patient_id'));
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $rules = array(
            'vaccine_id' => 'required',
            'scheduled_date' => 'required',

        );
        $messages = array(
            'vaccine_id.required' => '--Vaccine không được để trống!--',
            'scheduled_date.required' => '--Ngày dự kiến không được để trống!--',
        );
        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            Toastr::error('Kiểm tra lại', 'error');
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        DB::beginTransaction();
        try {
            $vaccines = Vaccines::where('id', $request->vaccine_id)->first();

            $schedule               = new VaccinationSchedules();
            $schedule->patient_id   = $request->patient_id;
            $schedule->vaccine_id   = $request->vaccine_id;
            $schedule->notes        = $request->notes ?? null;
            $schedule->save();

            $scheduled_date = Carbon::parse($request->scheduled_date);

            for ($i = 0; $i < $vaccines->doses_required; $i++) {
                $data                            = new SchedulesDetail();
                $data->vaccination_schedules_id  = $schedule->id;
                $data->dose_number               = $i + 1;
                if ($i === 0) {
                    $data->scheduled_date = $scheduled_date;
                    $data->notes = $request->notes ?? null;
                } else {
                    $data->scheduled_date = $scheduled_date->copy()->addDays($vaccines->dose_intervals * $i);
                }

                $data->status                    = 0;
                // $data->administered_date  = $request->administered_date; // sẽ cập nhật theo trạng thái
                // $data->notes                     = $request->notes ?? null;

                $data->save();

                // Tạo thông báo trước ngày tiêm
                if ($i > 0) {
                    $reminder_days = [15, 7, 1]; // Trước 15 ngày, 7 ngày, 1 ngày
                    foreach ($reminder_days as $days_before) {
                        $notification_date = $data->scheduled_date->copy()->subDays($days_before);

                        $notification = new Notifications();
                        $notification->schedule_id = $schedule->id;
                        $notification->schedules_detail_id = $data->id;
                        $notification->notification_type = 0; // Sử dụng cho mail
                        $notification->status = 'pending';
                        $notification->sent_at = $notification_date; // thời điểm gửi thông báo
                        $notification->save();
                    }
                }
            }

            DB::commit();

            Toastr::success('Thêm mới thành công', 'success');
            return redirect()->back();
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            Toastr::error('Thêm mới thất bại', 'error');
            return redirect()->back();
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            // dd($request->all());
            $data = SchedulesDetail::find($id);
            // dd($data);
            // if($data->dose_number + 1 &&  )
            $check_next_dose = SchedulesDetail::where('dose_number', '>', $data->dose_number)
                ->where('vaccination_schedules_id', $data->vaccination_schedules_id)
                ->where('status', 1)
                ->exists();

            if ($check_next_dose) {
                Toastr::error('Mũi này đã được tiêm rồi không được phép cập nhật lại', 'Lỗi');
                return redirect()->back();
            }
            if ($data->dose_number > 1) // kiểm tra thông tin mũi trước
            {
                $check_vaccination = $data->dose_number - 1;
                $check = SchedulesDetail::where('dose_number', $check_vaccination)->where('vaccination_schedules_id', $data->vaccination_schedules_id)->first();
                if ($check->status == 0 || $check->status == 2) {
                    Toastr::error('Mũi ' . $check->dose_number . ' chưa được tiêm hoặc bị lỡ', 'Kiểm tra lại!');
                    return redirect()->back();
                }
            }
            // if($data->status == 1 ){
            //     Toastr::warning('Mũi này đã được tiêm rồi nên không được cập nhật lại trạng thái', 'warning');
            // }
            $data->status = $request->status;
            $data->notes  = $request->notes ?? null;
            $data->update();
            Toastr::success('Cập nhật trạng thái thành công', 'success');
            return redirect()->back();
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            Toastr::error('Cập nhật trạng thái thất bại', 'error');
            return redirect()->back();
        }
    }

    // xóa lịch tiêm
    public function delete_schedule($id)
    {
        Toastr::warning('chức năng này tạm thời chưa được dùng', 'warning');
        return redirect()->back();
        DB::beginTransaction();
        try {
            $schedule = VaccinationSchedules::find($id);
            if (!$schedule) {
                Toastr::error('Không tìm thấy lịch tiêm!', 'error');
                return redirect()->back();
            }
            $schedule_detail = SchedulesDetail::where('vaccination_schedules_id', $id)->delete();
            $schedule->delete();
            DB::commit();
            Toastr::success('Xóa thành công!', 'success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Xóa không thành công kiểm tra lại!', 'error');
            return redirect()->back();
        }
    }
}
