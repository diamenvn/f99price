<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ApiAccountController extends Controller
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

    public function getAll()
    {
        $rows = $this->customerService->search([]);
        $this->response['success'] = true;
        $this->response['msg'] = "Success";
        $this->response['data'] = $rows;
        return response()->json($this->response);
    }

}
