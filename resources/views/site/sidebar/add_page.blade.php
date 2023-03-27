<div class="form-header">
    <h5 class="m-0"><i class="fal fa-plus-circle"></i> Thêm mới</h5>
</div>
<form id="form_add_page" action="{{route('site.sidebar.storeAddPage')}}" method="POST" class="form_submit_ajax-js flex-1 overflow-auto mt-2">
    @csrf
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="">Link trang web</label>
                    <input type="text" name="brand_url" class="form-control">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">Tên trang web</label>
                    <input type="text" name="brand_name" class="form-control">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="">URL Hình ảnh đại diện</label>
                    <input type="text" name="brand_logo_url" class="form-control">
                </div>
            </div>
        </div>
    </div>
</form>
<div class="form-footer p-3">
    <div class="row">
        <div class="col-12">
            <button class="btn btn-info d-inline-block w-100 submit_form-js" data-form="#form_add_page"><i
                    class="fal fa-save"></i> {{ isset($products) ? 'CẬP NHẬT' : 'TẠO MỚI' }}</button>
        </div>
    </div>
</div>
