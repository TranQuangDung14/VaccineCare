<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yoeunes\Toastr\Facades\Toastr;

class PatientsController extends Controller
{
    // bệnh nhân
    public function index(){
        $data['patient']= Patients::get();
        return view('Admin.pages.patient.patient',compact('data'));
    }
    public function create(){
        return view('Admin.pages.patient.add_edit_patient');
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $rules = array(
            'name' => 'required',
            'dob' => 'required',
            'phone' => 'required',
        );
        $messages = array(
            'name.required'     => '--Tên bệnh nhân không được để trống!--',
            'dob.required'      => '--Ngày tháng năm sinh không được để trống!--',
            'phone.required'    => '--Số điện thoại không được để trống!--',
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
            $data               = new Patients();
            $data->name         = $request->name;
            $data->dob          = $request->dob;
            $data->email        = $request->email;
            $data->phone        = $request->phone;
            $data->address      = $request->address;

            $data->save();
            DB::commit();

            Toastr::success('Thêm mới thành công', 'success');
            return redirect()->route('patient');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Thêm mới thất bại', 'error');
            return redirect()->back();
        }
    }

    public function edit($id){
        $editData = Patients::find($id);
        return view('Admin.pages.patient.add_edit_patient',compact('editData'));
    }


    public function update(Request $request, $id)
    {
        $input = $request->all();

        $rules = array(
            'name' => 'required',
            'dob' => 'required',
            'phone' => 'required',
        );
        $messages = array(
            'name.required'     => '--Tên bệnh nhân không được để trống!--',
            'dob.required'      => '--Ngày tháng năm sinh không được để trống!--',
            'phone.required'    => '--Số điện thoại không được để trống!--',
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
            $data               = Patients::find($id);;
            $data->name         = $request->name;
            $data->dob          = $request->dob;
            $data->email        = $request->email;
            $data->phone        = $request->phone;
            $data->address      = $request->address;

            $data->update();
            DB::commit();

            Toastr::success('Cập nhật thành công', 'success');
            return redirect()->route('patient');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Cập nhật thất bại', 'error');
            return redirect()->back();
        }
    }

    // cần nâng cấp thêm
    public function delete($id)
    {
        try {
            $data = Patients::find($id);
            $data->delete();

            Toastr::success('Xóa thành công!', 'success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Xóa không thành công kiểm tra lại!', 'error');
            return redirect()->back();
        }
    }
}
