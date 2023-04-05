<div class="form-header">
    <h5 class="m-0"><i class="fal fa-plus-circle"></i> {{ isset($detail) ? 'Chỉnh sửa ' . $detail->domain : 'Thêm mới' }}</h5>
</div>
<form id="form_add_page" action="{{isset($detail) ? route('sync_pages.update', $detail->_id) : route('sync_pages.store')}}" method="{{isset($detail) ? "PUT" : "POST"}}" class="form_submit_ajax-js flex-1 overflow-auto mt-2">
    @csrf
    <div class="container-fluid">
        <div class="row">
            @if (!isset($detail))
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Domain</label>
                        <input type="text" name="domain" class="form-control" placeholder="Bao gồm cả https hoặc http" value="{{$detail->domain ?? ""}}">
                    </div>
                </div>
            @endif
            <div class="col-6">
                <div class="form-group">
                    <label for="">Username wordpress</i></label>
                    <input type="text" name="username" class="form-control" placeholder="Username" value="{{$detail->time_step ?? ""}}">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">Application password</label>
                    <input type="text" name="password" class="form-control" placeholder="Application Password" value="{{$detail->limit_per_day ?? ""}}">
                </div>
            </div>
            @if (isset($detail))
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Trạng thái</label>
                        <select name="status" class="form-control">
                            <option @if ($detail->status == 1) selected="selected" @endif value="1">Hoạt động</option>
                            <option @if ($detail->status == 0) selected="selected" @endif value="0">Tạm dừng</option>
                        </select>
                    </div>
                </div>
            @endif
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
