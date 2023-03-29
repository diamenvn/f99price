<div class="form-header">
    <h5 class="m-0"><i class="fal fa-plus-circle"></i> {{ isset($detail) ? 'Chỉnh sửa' : 'Thêm mới' }}</h5>
</div>
<form id="form_add_page" action="{{route('crawl_pages.store')}}" method="POST" class="form_submit_ajax-js flex-1 overflow-auto mt-2">
    @csrf
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="">Domain trang cần lấy dữ liệu</label>
                    <input type="text" name="domain" class="form-control" placeholder="Domain" value="{{$detail->domain ?? ""}}">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">Thời gian lấy mỗi lần (phút)</label>
                    <input type="number" name="time_step_min" class="form-control" placeholder="Nhập thời gian" value="{{$detail->time_step_min ?? ""}}">
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
