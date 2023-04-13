<div class="form-header">
    <h5 class="m-0"><i class="fal fa-plus-circle"></i> {{ isset($user) ? 'Chỉnh sửa tài khoản' : 'Thêm tài khoản mới' }}</h5>
</div>
<form id="form_add_page" action="{{isset($user) ? route('accounts.update', $user->_id) : route('accounts.store')}}" method="{{isset($user) ? "PUT" : "POST"}}" class="form_submit_ajax-js flex-1 overflow-auto mt-2">
    @csrf
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="">Username</i></label>
                    <input disabled name="username" class="form-control" placeholder="Nhập tài khoản" value="{{$user->username ?? ""}}">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="">Email</i></label>
                    <input disabled name="email" class="form-control" placeholder="Nhập email" value="{{$user->email ?? ""}}">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="">Trạng thái</label>
                    <select name="status" class="form-control">
                        <option @if ($user->status == 1) selected="selected" @endif value="1">Kích hoạt</option>
                        <option @if ($user->status == 0) selected="selected" @endif value="0">Tạm dừng</option>
                    </select>
                </div>
            </div>
            <hr class="w-100" />
            <div class="col-12">
                <div class="form-group">
                    <label for="">Mật khẩu mới</i></label>
                    <input type="number" name="new_password" type="password" class="form-control" placeholder="Nhập mật khẩu mới">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="">Nhập lại mật khẩu mới</i></label>
                    <input type="number" name="renew_password" type="password" class="form-control" placeholder="Nhập lại mật khẩu mới">
                </div>
            </div>
        </div>
    </div>
</form>
<div class="form-footer p-3">
    <div class="row">
        <div class="col-12">
            <button class="btn btn-primary--custom d-inline-block w-100 submit_form-js" data-form="#form_add_page"><i
                    class="fal fa-save"></i> {{ isset($user) ? 'Cập nhật' : 'Thêm mới' }}</button>
        </div>
    </div>
</div>
