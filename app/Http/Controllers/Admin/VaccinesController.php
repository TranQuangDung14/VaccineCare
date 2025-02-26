<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Diseases;
use App\Models\Vaccines;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yoeunes\Toastr\Facades\Toastr;

class VaccinesController extends Controller
{
    //vaccine
    public function index(){
        $data['vaccine'] = Vaccines::get();
        return view('Admin.pages.vaccine.vaccine',compact('data'));
    }

    public function create(){
        $data['diseases'] = Diseases::get();
        return view('Admin.pages.vaccine.add_edit_vaccine',compact('data'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $input = $request->all();

        $rules = array(
            'name' => 'required',
            'doses_required' => 'required',
            'dose_intervals' => 'required',
            'diseases_id' => 'required',
        );
        $messages = array(
            'name.required' => '--Tên vaccine không được để trống!--',
            'doses_required.required' => '--Số mũi cần tiêm không được để trống!--',
            'dose_intervals.required' => '--Chu kì thời gian tiêm không được để trống!--',
            'diseases_id.required' => '--Phòng bệnh chưa được chọn!--',
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
            $data                   = new Vaccines();
            $data->name             = $request->name;
            $data->doses_required   = $request->doses_required;
            $data->dose_intervals   = $request->dose_intervals;
            $data->diseases_id      = $request->diseases_id;
            $data->description      = $request->description ?? null;

            $data->save();
            DB::commit();

            Toastr::success('Thêm mới thành công', 'success');
            return redirect()->route('vaccine');
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            Toastr::error('Thêm mới thất bại', 'error');
            return redirect()->back();
        }
    }

    public function edit($id){
        $data['diseases'] = Diseases::get();
        $data['vaccine'] = Vaccines::find($id);
        return view('Admin.pages.vaccine.add_edit_vaccine',compact('data'));
    }


    public function update(Request $request, $id)
    {
        $input = $request->all();

        $rules = array(
            'name' => 'required',
            'doses_required' => 'required',
            'dose_intervals' => 'required',
            'diseases_id' => 'required',
        );
        $messages = array(
            'name.required' => '--Tên vaccine không được để trống!--',
            'doses_required.required' => '--Số mũi cần tiêm không được để trống!--',
            'dose_intervals.required' => '--Chu kì thời gian tiêm không được để trống!--',
            'diseases_id.required' => '--Phòng bệnh chưa được chọn!--',
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
            $data                   = Vaccines::find($id);
            $data->name             = $request->name;
            $data->doses_required   = $request->doses_required;
            $data->dose_intervals   = $request->dose_intervals;
            $data->diseases_id      = $request->diseases_id;
            $data->description      = $request->description ?? null;

            $data->update();
            DB::commit();

            Toastr::success('Cập nhật thành công', 'success');
            return redirect()->route('vaccine');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Cập nhật thất bại', 'error');
            return redirect()->back();
        }
    }

    // cần nâng cấp thêm khi có data
    public function delete($id)
    {
        Toastr::warning('Chức năng này tạm thời chưa được dùng', 'warning');
        return redirect()->back();
        try {
            $data = Vaccines::find($id);
            $data->delete();

            Toastr::success('Xóa thành công!', 'success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Xóa không thành công kiểm tra lại!', 'error');
            return redirect()->back();
        }
    }
}
