<?php

namespace Modules\Auth\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\Models\Admin;
use Modules\Core\App\Rules\IranMobile;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view("auth::login");
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'mobile' => ['required', 'digits:11'],
            'password' => ['required', 'min:3'],
        ]);
        $mobile = $request->mobile;
        $password = $request->password;
        

        $admin = Admin::where('mobile',$mobile)->first();
        if(Auth::attempt($credentials)){
        
            if (Hash::check($password,$admin->password)){
                session()->put('admin_id',$admin->id);
                session()->put('admin_title',$admin->name);
                return redirect()->route('admin.dashboard');
                } else {
                $status = 'danger';
                $message = 'اطلاعات وارد شده اشتباه است';
                return redirect()->back()->with(['status' => $status,'message' => $message]);
            }
        }else{
        $status = 'danger';
        $message = 'اطلاعات وارد شده اشتباه است';
        $data = [
            'status' => $status,
            'message' => $message
        ];
        return redirect()->back()->with($data);
        }
    }
    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
