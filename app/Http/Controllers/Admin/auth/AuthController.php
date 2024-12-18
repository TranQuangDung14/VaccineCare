<?php

namespace App\Http\Controllers\Admin\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yoeunes\Toastr\Facades\Toastr;

class AuthController extends Controller
{
    public function Showlogin()
    {
        if (auth()->check()) {
            // if (auth()->user()->role === 1) {
            return redirect()->back();
            // }
        }
        return view('Admin.pages.auth.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            Toastr::error('Thông tin tài khoản mật khẩu không chính xác!', 'error');
            return redirect()->route('ShowLogin');
        } 

        Auth::login($user);
        $user->name;
        Toastr::success('Xin chào: '.$user->name, 'Đăng nhập thành công!');
        return redirect()->route('dashboard');
    }


    public function Showregister()
    {
        if (auth()->check()) {
            return redirect()->back();
        }
        return view('Admin.pages.auth.register');
    }
    public function register(Request $request)
    {
        try {
            $input = $request->all();
            $rules = array(
                'name' => 'required|string',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|min:5',
                're_pass' => 'required|same:password',
            );
            $messages = array(
                'name.required'     => '--Tên người dùng không được để trống!--',
                'email.required'    => '--Email không được để trống!--',
                'email.string'      => '--Email phải là chuỗi!--',
                'email.email'       => '--Email không hợp lệ!--',
                'email.max'         => '--Email không được vượt quá 255 ký tự!--',
                'email.unique'      => '--Email đã tồn tại trong hệ thống!--',
                'password.required' => '--Mật khẩu không được để trống!--',
                'password.min'      => '--Mật khẩu phải có ít nhất 5 ký tự!--',
                're_pass.required'  => '--Vui lòng nhập lại mật khẩu!--',
                're_pass.same'      => '--Mật khẩu nhập lại không khớp!--',
            );
            $validator = Validator::make($input, $rules, $messages);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();

                foreach ($errors as $error) {
                    Toastr::error($error, 'Lỗi');
                }
            
                return redirect()->back()
                ->withErrors($validator)
                ->withInput();
            }
            // dd('dd');
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                // 'role' => '1',
            ]);

        } catch (\Exception $e) {
            dd($e);
        }
        return redirect()->route('ShowLogin');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('ShowLogin');
    }
}
