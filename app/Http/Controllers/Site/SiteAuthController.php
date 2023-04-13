<?php

namespace App\Http\Controllers\Site;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Services\CustomerService;

class SiteAuthController extends Controller
{
    public function __construct(CustomerService $customerService)
    {
        
        $this->customerService = $customerService;
    }

    public function login()
    {
        if (Auth::check()){
            return redirect()->route('site.home');
        }else{
            return view('site.auth.login');
        }
    }

    public function postLogin(LoginRequest $request)
    {
     
        $login = [
            'username' => $request->username,
            'password' => $request->password
        ];
        
        if(Auth::attempt($login)){
            if (Auth::user()->status == 2) {
                Auth::logout();
                $res['msg'] = 'Tài khoản của bạn chưa được kích hoạt!';
                return view('site.auth.login')->with('error', $res['msg']);
            }

            return redirect()->route('site.home.dashboard');
        }else{
            $res['success'] = 0;
            $res['msg'] = 'Tài khoản hoặc mật khẩu không chính xác';
            return view('site.auth.login')->with('error', $res['msg']);
        }
    }

    public function register()
    {
        if (Auth::check()){
            return redirect()->route('site.home');
        }else{
            return view('site.auth.register');
        }
    }

    public function postRegister(LoginRequest $request)
    {
        $username = $request->username;
        $data = [
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'is_active' => 1,
            'status' => 2,
        ];

        $user = $this->customerService->firstByUsername($username);

        if (isset($user)) {
            return view('site.auth.register')->with('error', "Tài khoản này đã tồn tại");
        }
        $create = $this->customerService->create($data);
        if ($create) {
            return view('site.auth.register')->with('success', "Tạo thành công, vui lòng chờ admin duyệt tài khoản");
        }

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
