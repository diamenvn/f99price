@extends('site.layout.app')

@section('content')
    <div class="main__content__filter d-flex justify-content-between">
        <div class="title-panel">
            <div class="fw-700 fs-20 title">Danh sách website đồng bộ dữ liệu</div>
            <div class="fs-12 sub-title">Tìm thấy {{ isset($rows) ? $rows->total() : 0 }} trang</div>
        </div>
        <div class="text-center p-2">
            <div class="btn btn-primary--custom btn-sm call_ajax_modal-js" data-href="{{route('sync_pages.create')}}">Thêm mới</div>
        </div>
    </div>
    <div class="my-3">
        <div class="view-mode-item view-mode-list row">
            <div class="col-12">
                <div class="table-page" id="table-index-js"></div>
            </div>
        </div>
    </div>
@endsection


@section('custom_js')
    <script>
        new gridjs.Grid({
            columns: [{
                name: 'STT',
                width: '90px',
                formatter: (cell) => gridjs.html(`<div class="text-left">${cell}</div>`)
            }, {
                name: 'Domain',
                formatter: (cell) => gridjs.html(`<a href="${cell}" class="text-left co-link">${cell}</a>`),
            }, {
                name: 'Đã đồng bộ',
                width: '300px',
                formatter: (cell) => gridjs.html(`<div class="text-left">${cell} bài viết</div>`)
            }, {
                name: 'Ngày tạo',
                width: '200px',
                formatter: (cell) => gridjs.html(`${new Date(cell).toLocaleString()}`)
            }, {
                name: 'Trạng thái',
                width: '180px',
                formatter: (cell) => cell == 1 ? gridjs.html(`<div class="w-100">Running</div>`) : gridjs.html(`<div class="w-100">Stopped</div>`)
            }, {
                name: 'Action',
                width: '180px',
                formatter: (action) => gridjs.html(`<div class="icon-hover-scale call_ajax_modal-js" data-href="` + action.edit + `"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16"><path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/></svg></div>`)
            }],
            // data: data,
            pagination: {
                limit: 15,
                server: {
                    url: (prev, page, limit) => `${prev}?page=${page}`
                }
            },
            server: {
                url: "{{route('api.sync_page.get_all')}}",
                then: res => res.data.data.map((post, index) => [index + 1, post.domain, post.count, post.created_at, post.status, {edit: "{{route('sync_pages.edit', '_id')}}".replace("_id", post._id)}]),
                handle: (res) => {
                    if (res.status === 404 || res.status === 500) return {data: []};
                    if (res.ok) return res.json();
                    
                    throw Error('oh no :(');
                },
                total: res => res.data.total
            },
            fixedHeader: true,
            autoWidth: true,
            maxHeight: 'calc(100vh - 220px)',
            width: '100%'
        }).render(document.getElementById("table-index-js"));


        $(function() {
            $('.view-mode div').click(function() {
                target = $(this).attr('data-target');
                $('.view-mode-item').hide();
                $('.view-mode div').removeClass('active');
                $(this).addClass('active');
                $(target).show();
            });
        });
    </script>
@endsection
