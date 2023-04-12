<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

}
