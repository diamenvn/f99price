@extends('site.layout.app')

@section('content')
    <div class="main__content__filter">
        <div class="title-panel">
            <div class="fw-700 fs-20 title">Danh sách sản phẩm</div>
            <div class="fs-12 sub-title">Tìm thấy {{ isset($rows) ? count($rows) : 0 }} sản phẩm</div>
        </div>
        <div class="filter-panel d-flex align-items-center view-mode">
            <span>Chế độ xem</span>
            <div class="mx-2 fs-20" data-target=".view-mode-gird"><i class="far fa-border-all"></i></div>
            <div class="mx-2 fs-20 active" data-target=".view-mode-list"><i class="far fa-bars"></i></div>
        </div>
    </div>
    <div class="my-3">
        <div class="view-mode-item view-mode-gird row" style="display: none">
            @if (isset($rows) && count($rows) > 0)
                @foreach ($rows as $row)
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-12">
                    <div class="box box--light">
                        <div class="box-header">
                            <img src="{{$row->thumbnail_url}}" alt="" class="w-100">
                        </div>
                        <div class="box-body">
                            <div class="name text-two-line">{{$row->name}}</div>
                        </div>
                        <div class="box-footer">
                            <div class="label label-increase">{{is_numeric($row->price) ? number_format($row->price) : '-'}}đ</div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
        <div class="view-mode-item view-mode-list row">
            <div class="col-12">
                <div id="table-index-js"></div>
            </div>
        </div>
    </div>
@endsection