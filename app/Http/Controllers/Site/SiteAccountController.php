<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class SiteAccountController extends Controller
{
    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
        $this->response['success'] = false;
        $this->response['msg'] = "Error";
        $this->response['data'] = [];
        $this->response['creation_time'] = time();
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    }

    public function index()
    {
        $data['rows'] = $this->customerService->search([]);
        $data['title'] = "Quản trị tài khoản";
        $data['sidebarRight'] = "d-none";
        return view('site.accounts.index', $data);
    }

    public function edit($userId)
    {
        $data['user'] = $this->customerService->first($userId);

        return view('site.accounts.form', $data);
    }

    public function update($userId, Request $request)
    {
        $request = $request->only(['status', 'new_password', 'renew_password']);
        $password = $request['new_password'];
        $rePassword = $request['renew_password'];

        $user = $this->customerService->first($userId);

        if (!isset($user)) {
            $this->response['msg'] = "Tài khoản này không tồn tại";
            return response()->json($this->response);
        }
        if (isset($password) && $password != $rePassword) {
            $this->response['msg'] = "Nhập lại mật khẩu không trùng";
            return response()->json($this->response);
        }
        
        if (isset($password) && strlen($password) < 6) {
            $this->response['msg'] = "Mật khẩu không được ngắn hơn 6 kí tự";
            return response()->json($this->response);
        }

        if (isset($password) && isset($rePassword)) {
            $update['password'] = Hash::make($password);
        }

        $update['status'] = $request['status'];
        if ($this->customerService->update($user, $update)) {
            $this->response['success'] = true;
            $this->response['msg'] = "Cập nhật thành công";
        }
        return response()->json($this->response);
    }

}
