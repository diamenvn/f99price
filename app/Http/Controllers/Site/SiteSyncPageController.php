<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\SyncSiteService;
use App\Services\ApiService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SiteSyncPageController extends Controller
{
    public function __construct(
        SyncSiteService $syncSiteService,
        ApiService $apiService
    )
    {
        $this->syncSiteService = $syncSiteService;
        $this->apiService = $apiService;
        $this->response['success'] = false;
        $this->response['msg'] = "Error";
        $this->response['data'] = [];
        $this->response['creation_time'] = time();
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    }

    public function index()
    {
        $data['title'] = "Đẩy dữ liệu";
        $data['rows'] = $this->syncSiteService->search(['status' => 1], ['created_at' => 'DESC']);
        $data['sidebarRight'] = "d-none";

        return view('site.sync.index', $data);
    }

    public function create()
    {
        return view('site.sync.form');
    }

    public function store(Request $request)
    {
        $request = $request->only(['domain', 'username', 'password']);
        $domain = $request['domain'] ?? null;
        $username = $request['username'] ?? null;
        $password = $request['password'] ?? null;

        if (!$domain || !$username || !$password) {
            $this->response['msg'] = "Vui lòng điền đầy đủ dữ liệu";
            return response()->json($this->response);
        }

        $firstByDomain = $this->syncSiteService->firstByCondition(['domain' => $domain]);
        if (isset($firstByDomain)) {
            $this->response['msg'] = "Domain này đã tồn tại";
            return response()->json($this->response);
        }

        if (!$this->apiService->checkConnectWordpressByUserNameAndPassword($domain, $username, $password)) {
            $this->response['msg'] = "Username or application password không đúng";
            return response()->json($this->response);
        }

        $insert['domain'] = $domain;
        $insert['base64_authenticate'] = base64_encode( $username . ':' . $password );
        $insert['status'] = 1;

        if ($this->syncSiteService->create($insert)) {
            $this->response['success'] = true;
            $this->response['msg'] = "Tạo thành công";
        }

        return response()->json($this->response);
    }
    
    public function edit($siteId)
    {
        $data['detail'] = $this->syncSiteService->firstById($siteId);
        return view('site.sync.form', $data);
    }

    public function update(Request $request, $id)
    {
        $request = $request->only(['username', 'password', 'status']);
        $username = $request['username'] ?? null;
        $password = $request['password'] ?? null;

        $first = $this->syncSiteService->firstById($id);
        if (!isset($first)) {
            $this->response['msg'] = "Domain này không tồn tại";
            return response()->json($this->response);
        }

        if (isset($username) && isset($password)) {
            if (!$this->apiService->checkConnectWordpressByUserNameAndPassword($first->domain, $username, $password)) {
                $this->response['msg'] = "Username or application password không đúng";
                return response()->json($this->response);
            }
    
            $update['base64_authenticate'] = base64_encode( $username . ':' . $password );
        }


        $update['status'] = (int)($request['status'] ?? $first->status);

        
        if ($this->syncSiteService->update($first, $update)) {
            $this->response['success'] = true;
            $this->response['msg'] = "Cập nhật thành công";
        }

        return response()->json($this->response);
    }

}
