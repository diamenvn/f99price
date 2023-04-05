<div class="form-header">
    <h5 class="m-0"><i class="fal fa-plus-circle"></i> {{ isset($detail) ? 'Chỉnh sửa ' . $detail->domain : 'Thêm mới' }}</h5>
</div>
<form id="form_add_page" action="{{isset($detail) ? route('crawl_pages.update', $detail->_id) : route('crawl_pages.store')}}" method="{{isset($detail) ? "PUT" : "POST"}}" class="form_submit_ajax-js flex-1 overflow-auto mt-2">
    @csrf
    <div class="container-fluid">
        <div class="row">
            @if (!isset($detail))
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Domain trang cần lấy dữ liệu</label>
                        <input type="text" name="domain" class="form-control" placeholder="Bao gồm cả https hoặc http" value="{{$detail->domain ?? ""}}">
                    </div>
                </div>
            @endif
            <div class="col-12">
                <div class="form-group">
                    <label for="">Thời gian lấy mỗi lần (phút) - <i>Mặc định {{config("app.time_step")}} phút</i></label>
                    <input type="number" name="time_step" class="form-control" placeholder="Nhập thời gian" value="{{$detail->time_step ?? ""}}">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="">Giới hạn / ngày - <i>Mặc định {{number_format(config("app.limit_per_day"))}}</i></label>
                    <input type="number" name="limit_per_day" class="form-control" placeholder="Nhập số lượng" value="{{$detail->limit_per_day ?? ""}}">
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
