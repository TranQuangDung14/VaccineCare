<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Diseases;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yoeunes\Toastr\Facades\Toastr;

class DiseasesController extends Controller
{
    // thông tin bệnh
    
    public function index(){
        $data= Diseases::get();
        return view('Admin.pages.disease.disease',compact('data'));
    }

    public function create(){
        return view('Admin.pages.disease.add_edit_disease');
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $rules = array(
            'name' => 'required',
        );
        $messages = array(
            'name.required' => '--Tên loại bệnh không được để trống!--',
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
            $data               = new Diseases();
            $data->name         = $request->name;
            $data->description  = $request->description ?? null;

            $data->save();
            DB::commit();

            Toastr::success('Thêm mới thành công', 'success');
            return redirect()->route('disease');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Thêm mới thất bại', 'error');
            return redirect()->back();
        }
    }

    public function edit($id){
        $editData = Diseases::find($id);
        return view('Admin.pages.disease.add_edit_disease',compact('editData'));
    }


    public function update(Request $request, $id)
    {
        $input = $request->all();

        $rules = array(
            'name' => 'required',
        );
        $messages = array(
            'name.required' => '--Tên loại bệnh không được để trống!--',
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
            $data               = Diseases::find($id);;
            $data->name         = $request->name;
            $data->description  = $request->description ?? null;

            $data->update();
            DB::commit();

            Toastr::success('Cập nhật thành công', 'success');
            return redirect()->route('disease');
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
            $data = Diseases::find($id);
            $data->delete();

            Toastr::success('Xóa thành công!', 'success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Xóa không thành công kiểm tra lại!', 'error');
            return redirect()->back();
        }
    }
}
