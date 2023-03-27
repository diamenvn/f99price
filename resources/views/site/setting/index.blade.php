@extends('site.layout.app')

@section('content')
    <div class="main__content__body flex-1 overflow-auto container-fluid">
        <div class="main__content__body h-100">
            <div class="row h-100">
                <div class="col-12">
                    <div class="main__content__filter mt-1 mb-2">
                        <div class="fw-700 fs-20 title">Cấu hình lấy dữ liệu {{ $brand->brand_name ?? '' }}</div>
                        <div class="btn btn-danger btn-sm call_ajax_remove-js" data-href="{{route('setting.destroy', $brand->_id)}}"><i class="far fa-trash"></i> Xoá trang này</div>
                    </div>
                    <form id="form" class="form_submit_ajax-js" action="{{$action}}" method="{{$method}}">
                        <div id="table-js"></div>
                    </form>
                    <div class="btn btn-info btn-sm btn-add-content-js">Thêm link cần lấy</div>
                </div>
            </div>
        </div>
    </div>

    <div class="main__content__footer d-flex justify-content-end">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 d-flex justify-content-center p-2">
                    <div class="btn btn-info btn-sm submit_form-js" data-form="#form">Lưu dữ liệu</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_js')
    <script>
        var data = [];
        @if (isset($brand->items) && count($brand->items) > 0)
            @foreach ($brand->items as $key => $item)
                data.push({
                    stt: {{$key + 1}},
                    link: gridjs.html(`<input class="form-control" name="link[]" value="{{$item->url ?? ''}}" />`),
                    list: gridjs.html(`<input class="form-control" name="element_lists[]" value="{{$item->setting->element_lists ?? ''}}" />`),
                    name: gridjs.html(`<input class="form-control" name="element_name[]" value="{{$item->setting->element_name ?? ''}}" />`),
                    image: gridjs.html(`<input class="form-control" name="element_thumbnail[]" value="{{$item->setting->element_thumbnail ?? ''}}" />`),
                    price: gridjs.html(`<input class="form-control" name="element_price[]" value="{{$item->setting->element_price ?? ''}}" />`),
                    unit: gridjs.html(`<input class="form-control" name="element_unit[]" value="{{$item->setting->element_unit ?? ''}}" />`),
                    url: gridjs.html(`<input class="form-control" name="element_url[]" value="{{$item->setting->element_url ?? ''}}" />`),
                    pagination: gridjs.html(`<input class="form-control" name="element_pagination[]" value="{{$item->setting->element_pagination ?? ''}}" />`),
                    end_pagination: gridjs.html(`<input class="form-control" name="end_pagination[]" value="{{$item->setting->end_pagination ?? ''}}" />`),
                    formatPrice: gridjs.html(`<input class="form-control" name="format_price[]" value="{{$item->setting->format_price ?? ''}}" />`),
                    action: gridjs.html(`<div data-id="{{$item->_id}}" class="btn btn-danger mx-2 btn-sm btn-remove-item-js">Xoá</div>`),
                    _id: `{{$item->_id}}`
                });
            @endforeach
        @endif
        

        grid = new gridjs.Grid({
            columns: [
                {id: 'stt', name: '#'},
                {id: 'link', name: 'Link lấy dữ liệu'},
                {id: 'list', name: 'Danh sách'},
                {id: 'name', name: 'Tên sản phẩm'},
                {id: 'image', name: 'Hình ảnh'},
                {id: 'price', name: 'Giá sản phẩm'},
                {id: 'unit', name: 'Đơn vị tính'},
                {id: 'url', name: 'URL'},
                {id: 'pagination', name: 'Link phân trang'},
                {id: 'end_pagination', name: 'Từ khoá kết thúc phân trang'},
                {id: 'formatPrice', name: 'Định dạng giá tiền'},
                {id: 'action', name: 'Action'},
                {id: '_id', hidden: true}
            ],
            fixedHeader: true,
            autoWidth: true,
            data: data
            
        }).render(document.getElementById("table-js"));
    </script>
    <script>
        $(function() {
            $('.btn-add-content-js').click(function() {
                let r = Math.random().toString(36).substring(7);

                append = {
                    stt: '#',
                    link: gridjs.html(`<input class="form-control" name="link[]" value="" />`),
                    list: gridjs.html(`<input class="form-control" name="element_lists[]" value="" />`),
                    name: gridjs.html(`<input class="form-control" name="element_name[]" value="" />`),
                    image: gridjs.html(`<input class="form-control" name="element_thumbnail[]" value="" />`),
                    price: gridjs.html(`<input class="form-control" name="element_price[]" value="" />`),
                    unit: gridjs.html(`<input class="form-control" name="element_unit[]" value="" />`),
                    url: gridjs.html(`<input class="form-control" name="element_url[]" value="" />`),
                    pagination: gridjs.html(`<input class="form-control" name="element_pagination[]" value="" />`),
                    end_pagination: gridjs.html(`<input class="form-control" name="end_pagination[]" value="" />`),
                    formatPrice: gridjs.html(`<input class="form-control" name="format_price[]" value="" />`),
                    action: gridjs.html(`<div data-id="` + r + `" class="btn btn-danger mx-2 btn-sm btn-remove-item-js">Xoá</div>`),
                    _id: r
                };
                
                data.push(append);
                grid.updateConfig({
                    data: data
                }).forceRender();
            });

            $(document).on('click', '.btn-remove-item-js', function() {
                id = $(this).attr('data-id');

                data = data.filter(function(item){ return item._id != id });
                grid.updateConfig({
                    data: data
                }).forceRender();
            });
        })
    </script>
@endsection
