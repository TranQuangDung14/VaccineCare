<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patients;
use App\Models\SchedulesDetail;
use App\Models\VaccinationSchedules;
use App\Models\Vaccines;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yoeunes\Toastr\Facades\Toastr;

class VaccinationSchedulesController extends Controller
{
    //lịch tiêm
    public function index(){
        $data['patient'] = Patients::get(); 
        return view('Admin.pages.vaccination_schedule.vaccination_schedule',compact('data'));
    }
    
    public function showService($id){
        $data['patient'] = Patients::find($id); 
        $data['schedule'] =  VaccinationSchedules::with('details','vaccines')->where('patient_id',$id)->get();
        return view('Admin.pages.vaccination_schedule.detail_schedule',compact('data'));
    }

    public function updatedetailSchedule($id){
        // dd('sss');
        $data['schedulesdetail'] = SchedulesDetail::find($id); 
        return view('Admin.pages.vaccination_schedule.update_Schedule',compact('data'));
    }

    public function create($patient_id){
        $data['patient'] = Patients::where('id',$patient_id)->first(); 
        $data['vaccines'] = Vaccines::get();
        return view('Admin.pages.vaccination_schedule.add_edit_vaccination_schedule',compact('data','patient_id'));
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
            $vaccines = Vaccines::where('id',$request->vaccine_id)->first();

            $schedule               = new VaccinationSchedules();
            $schedule->patient_id   = $request->patient_id;
            $schedule->vaccine_id   = $request->vaccine_id;
            $schedule->notes        = $request->notes ?? null;
            $schedule->save();

            $scheduled_date = Carbon::parse($request->scheduled_date);

            for ($i=0; $i < $vaccines->doses_required; $i++) { 
                $data                            = new SchedulesDetail();
                $data->vaccination_schedules_id  = $schedule->id;
                $data->dose_number               = $i+1;
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

    public function updateStatus(Request $request, $id){
        try {
            // dd($request->all());
            $data = SchedulesDetail::find($id);
            // dd($data);
            if($data->dose_number > 1) // kiểm tra thông tin mũi trước
            {
                $check_vaccination = $data->dose_number - 1;
                $check = SchedulesDetail::where('dose_number',$check_vaccination)->where('vaccination_schedules_id',$data->vaccination_schedules_id)->first();
                if($check->status == 0 || $check->status == 2){
                    Toastr::error('Mũi '.$check->dose_number. ' chưa được tiêm hoặc bị lỡ', 'Kiểm tra lại!');
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
        DB::beginTransaction();
        try {
            $schedule = VaccinationSchedules::find($id);
            if (!$schedule) {
                Toastr::error('Không tìm thấy lịch tiêm!', 'error');
                return redirect()->back();
            }    
            $schedule_detail = SchedulesDetail::where('vaccination_schedules_id',$id)->delete();
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
    
    // public function edit($id){
    //     $editData = Diseases::find($id);
    //     return view('Admin.pages.disease.add_disease',compact('editData'));
    // }


    // public function update(Request $request, $id)
    // {
    //     $input = $request->all();

    //     $rules = array(
    //         'name' => 'required',
    //     );
    //     $messages = array(
    //         'name.required' => '--Tên loại bệnh không được để trống!--',
    //     );
    //     $validator = Validator::make($input, $rules, $messages);

    //     if ($validator->fails()) {
    //         session()->flash('error', 'Kiểm tra lại!');
    //         return redirect()->back()
    //             ->withErrors($validator)
    //             ->withInput();
    //     }
    //     DB::beginTransaction();
    //     try {
    //         $data               = Diseases::find($id);;
    //         $data->name         = $request->name;
    //         $data->description  = $request->description ?? null;

    //         $data->update();
    //         DB::commit();

    //         Toastr::success('Cập nhật thành công', 'success');
    //         return redirect()->route('disease');
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         Toastr::error('Cập nhật thất bại', 'error');
    //         return redirect()->back();
    //     }
    // }

    // // cần nâng cấp thêm
    // public function delete($id)
    // {
    //     try {
    //         $data = Diseases::find($id);
    //         $data->delete();

    //         Toastr::success('Xóa thành công!', 'success');
    //         return redirect()->back();
    //     } catch (\Exception $e) {
    //         Toastr::error('Xóa không thành công kiểm tra lại!', 'error');
    //         return redirect()->back();
    //     }
    // }
}
