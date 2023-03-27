<div class="form-header">
    <h5 class="m-0"><i class="fal fa-plus-circle"></i> {{ isset($products) ? 'Quản lý sản phẩm' : 'Thêm mới' }}</h5>
</div>
<form id="form" action="" method="POST" class="flex-1 overflow-auto">
    @csrf
    <table class="table">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Sản phẩm</th>
                <th scope="col">Thao tác</th>
            </tr>
        </thead>
        <tbody class="tbody">
            @if (isset($products) && count($products) > 0)
                @foreach ($products as $key => $product)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td><input class="form-control" name="product[]" type="text"
                                value="{{ $product->product_name }}"></td>
                        <td>
                            <div class="btn btn-danger btn-click-remove-product-js">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-trash" viewBox="0 0 16 16">
                                    <path
                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z">
                                    </path>
                                    <path fill-rule="evenodd"
                                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z">
                                    </path>
                                </svg>
                            </div>
                            <div class="btn btn-secondary drag-handler">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-arrows-expand" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M1 8a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 8zM7.646.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 1.707V5.5a.5.5 0 0 1-1 0V1.707L6.354 2.854a.5.5 0 1 1-.708-.708l2-2zM8 10a.5.5 0 0 1 .5.5v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L7.5 14.293V10.5A.5.5 0 0 1 8 10z" />
                                </svg>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3">Không có sản phẩm nào</td>
                </tr>
            @endif
        </tbody>
    </table>
    <div class="px-3">
        <div class="btn btn-info btn-sm btn-add-product-js" data-form-target="#form">Thêm sản phẩm</div>
    </div>
</form>
<div class="form-footer p-3">
    <div class="row">
        <div class="col-12">
            <button class="btn btn-info d-inline-block w-100 submit_form-js" data-form="#form"><i
                    class="fal fa-save"></i> {{ isset($products) ? 'CẬP NHẬT' : 'TẠO MỚI' }}</button>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        Sortable.create(
            $('.tbody')[0], {
                animation: 150,
                scroll: true,
                handle: '.drag-handler'
            }
        );
    });
</script>
