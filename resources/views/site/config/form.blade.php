<div class="form-header">
    <h5 class="m-0"><i class="fal fa-plus-circle"></i> {{ isset($detail) ? 'Chỉnh sửa kết nối' : 'Thêm kết nối mới' }}</h5>
</div>
<form id="form_add_page" action="{{isset($detail) ? route('config.update', $detail->_id) : route('config.store')}}" method="{{isset($detail) ? "PUT" : "POST"}}" class="form_submit_ajax-js flex-1 overflow-auto mt-2">
    @csrf
    <div class="container-fluid">
        <div class="row">
            @if (!isset($detail))
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Nguồn dữ liệu</label>
                        <select name="crawl_site_id" class="form-control">
                            @foreach($crawl_sites as $site)
                                <option value="{{$site->_id}}">{{$site->domain}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Đồng bộ đến</label>
                        <select name="sync_site_id" class="form-control">
                            @foreach($sync_sites as $site)
                                <option value="{{$site->_id}}">{{$site->domain}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @else
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Trạng thái</label>
                        <select name="status" @if ($detail->status == 2) disabled @endif class="form-control">
                            <option @if ($detail->status == 1) selected="selected" @endif value="1">Hoạt động</option>
                            <option @if ($detail->status == 0) selected="selected" @endif value="0">Tạm dừng</option>
                        </select>
                        @if ($detail->status == 2) <span class="text text--danger fs-12">Đang tạm dừng do lỗi xác thực username, vui lòng kiểm tra lại</span> @endif
                    </div>
                </div>
            @endif
            <div class="col-12">
                <div class="form-group">
                    <label for="">Thời gian đồng bộ mỗi lần (phút) - <i>Mặc định {{config("app.sync_time_step")}} phút</i></label>
                    <input type="number" name="time_step" class="form-control" placeholder="Nhập thời gian" value="{{$detail->time_step ?? ""}}">
                </div>
            </div>
        </div>
    </div>
</form>
<div class="form-footer p-3">
    <div class="row">
        <div class="col-12">
            <button class="btn btn-primary--custom d-inline-block w-100 submit_form-js" data-form="#form_add_page"><i
                    class="fal fa-save"></i> {{ isset($detail) ? 'Cập nhật' : 'Thêm mới' }}</button>
        </div>
    </div>
</div>
