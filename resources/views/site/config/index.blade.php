@extends('site.layout.app')

@section('content')
    <div class="main__content__filter d-flex justify-content-between">
        <div class="title-panel">
            <div class="fw-700 fs-20 title">Cấu hình kết nối</div>
            <div class="fs-12 sub-title">Kết nối 2 website với nhau để đồng bộ dữ liệu</div>
        </div>
        <div class="text-center p-2">
            <div class="btn btn-primary--custom btn-sm call_ajax_modal-js" data-href="{{route('config.create')}}">Thêm kết nối mới</div>
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
                name: 'Nguồn dữ liệu',
                formatter: (cell) => gridjs.html(`<a href="${cell}" class="text-left co-link">${cell}</a>`),
            }, {
                name: 'Đồng bộ đến',
                formatter: (cell) => gridjs.html(`<a href="${cell}" class="text-left co-link">${cell}</a>`),
            }, {
                name: 'Thành công',
                formatter: (cell) => gridjs.html(`<div class="text-right">${cell}</div>`),
                width: '150px'
            }, {
                name: 'Thất bại',
                formatter: (cell) => gridjs.html(`<div class="text-right">${cell}</div>`),
                width: '150px'
            },{
                name: 'Trạng thái',
                width: '200px',
                formatter: (cell) => gridjs.html(`<span class="status ${cell.type == 1 ? 'status--success' : 'status--error'}">${cell.msg}</span>`),
            }, {
                name: 'Lần đồng bộ cuối',
                width: '200px',
                formatter: (cell) => cell ? gridjs.html(`${new Date(cell).toLocaleString()}`) : gridjs.html(`<span">-</span>`),
            }, {
                name: 'Ngày tạo',
                width: '200px',
                formatter: (cell) => gridjs.html(`${new Date(cell).toLocaleString()}`)
            }, {
                name: 'Action',
                width: '120px',
                formatter: (action) => gridjs.html(`<div class="d-flex"><div class="icon-hover-scale call_ajax_modal-js mx-2" data-href="` + action.edit + `"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16"><path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/></svg></div><div class="icon-hover-scale call_ajax_remove-js" data-href="` + action.remove + `"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
  <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
</svg></div></div>`)
            }],
            pagination: {
                limit: 15,
                server: {
                    url: (prev, page, limit) => `${prev}?page=${page}`
                }
            },
            server: {
                url: "{{route('api.config.get_all')}}",
                then: res => res.data.data.map((config, index) => [index + 1, config.crawl_site.domain, config.sync_site.domain, config.log.count_post_sync_success, config.log.count_post_sync_error, config.status, config.run_last_time, config.created_at, {edit: "{{route('config.edit', '_id')}}".replace("_id", config._id), remove: "{{route('config.destroy', '_id')}}".replace("_id", config._id)}]),
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
