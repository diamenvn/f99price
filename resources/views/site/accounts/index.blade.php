@extends('site.layout.app')

@section('content')
    <div class="main__content__filter d-flex justify-content-between">
        <div class="title-panel">
            <div class="fw-700 fs-20 title">Danh sách tài khoản</div>
            <div class="fs-12 sub-title">Tìm thấy {{ isset($rows) ? $rows->total() : 0 }} tài khoản</div>
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
                name: 'Tên tài khoản',
                formatter: (cell) => gridjs.html(`${cell}`)
            }, {
                name: 'Admin',
                formatter: (cell) => cell == 1 ? gridjs.html(`<?xml version="1.0"?><svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none"><path d="M4.91988 12.257C4.2856 12.257 3.65131 12.5199 3.19988 13.0342C2.79417 13.4913 2.59417 14.0799 2.63417 14.6913C2.67417 15.3027 2.94846 15.857 3.4056 16.2627L7.51417 19.8684C7.93131 20.2342 8.46846 20.4399 9.02274 20.4399C9.0856 20.4399 9.14846 20.4399 9.21131 20.4342C9.82846 20.3827 10.4056 20.0799 10.7942 19.5999L20.857 7.27986C21.657 6.30272 21.5085 4.85701 20.5313 4.05701C20.057 3.67415 19.4627 3.49129 18.857 3.55415C18.2513 3.61701 17.7027 3.90844 17.3142 4.38272L8.74846 14.8627L6.42274 12.8227C5.99417 12.4456 5.45131 12.257 4.91988 12.257Z" fill="url(#paint0_linear)"/><path d="M9.02279 20.0284C8.56565 20.0284 8.12565 19.8627 7.78279 19.5598L3.67422 15.9541C2.89708 15.2684 2.81708 14.0798 3.50279 13.3027C4.18851 12.5255 5.37708 12.4455 6.15422 13.1313L8.79994 15.4513L17.6285 4.63983C18.2856 3.83412 19.4685 3.71983 20.2742 4.37126C21.0799 5.0284 21.1942 6.21126 20.5428 7.01697L10.4742 19.337C10.1542 19.7313 9.67993 19.977 9.17708 20.0227C9.12565 20.0227 9.07422 20.0284 9.02279 20.0284Z" fill="url(#paint1_linear)"/><path opacity="0.75" d="M9.02279 20.0284C8.56565 20.0284 8.12565 19.8627 7.78279 19.5598L3.67422 15.9541C2.89708 15.2684 2.81708 14.0798 3.50279 13.3027C4.18851 12.5255 5.37708 12.4455 6.15422 13.1313L8.79994 15.4513L17.6285 4.63983C18.2856 3.83412 19.4685 3.71983 20.2742 4.37126C21.0799 5.0284 21.1942 6.21126 20.5428 7.01697L10.4742 19.337C10.1542 19.7313 9.67993 19.977 9.17708 20.0227C9.12565 20.0227 9.07422 20.0284 9.02279 20.0284Z" fill="url(#paint2_radial)"/><path opacity="0.5" d="M9.02279 20.0284C8.56565 20.0284 8.12565 19.8627 7.78279 19.5598L3.67422 15.9541C2.89708 15.2684 2.81708 14.0798 3.50279 13.3027C4.18851 12.5255 5.37708 12.4455 6.15422 13.1313L8.79994 15.4513L17.6285 4.63983C18.2856 3.83412 19.4685 3.71983 20.2742 4.37126C21.0799 5.0284 21.1942 6.21126 20.5428 7.01697L10.4742 19.337C10.1542 19.7313 9.67993 19.977 9.17708 20.0227C9.12565 20.0227 9.07422 20.0284 9.02279 20.0284Z" fill="url(#paint3_radial)"/><defs><linearGradient id="paint0_linear" x1="15.825" y1="-13.9667" x2="9.82533" y2="23.9171" gradientUnits="userSpaceOnUse"><stop stop-color="#00CC00"/><stop offset="0.1878" stop-color="#06C102"/><stop offset="0.5185" stop-color="#17A306"/><stop offset="0.9507" stop-color="#33740C"/><stop offset="1" stop-color="#366E0D"/></linearGradient><linearGradient id="paint1_linear" x1="15.2501" y1="0.625426" x2="7.43443" y2="23.6215" gradientUnits="userSpaceOnUse"><stop offset="0.2544" stop-color="#90D856"/><stop offset="0.736" stop-color="#00CC00"/><stop offset="0.7716" stop-color="#0BCD07"/><stop offset="0.8342" stop-color="#29CF18"/><stop offset="0.9166" stop-color="#59D335"/><stop offset="1" stop-color="#90D856"/></linearGradient><radialGradient id="paint2_radial" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(15.452 8.95803) rotate(116.129) scale(8.35776 4.28316)"><stop stop-color="#FBE07A" stop-opacity="0.75"/><stop offset="0.0803394" stop-color="#FBE387" stop-opacity="0.6897"/><stop offset="0.5173" stop-color="#FDF2C7" stop-opacity="0.362"/><stop offset="0.8357" stop-color="#FFFBF0" stop-opacity="0.1233"/><stop offset="1" stop-color="white" stop-opacity="0"/></radialGradient><radialGradient id="paint3_radial" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(11.6442 17.0245) rotate(155.316) scale(9.80163 4.14906)"><stop stop-color="#440063" stop-opacity="0.25"/><stop offset="1" stop-color="#420061" stop-opacity="0"/></radialGradient></defs></svg>`) : gridjs.html(``)
            }, {
                name: 'Ngày tạo',
                width: '200px',
                formatter: (cell) => gridjs.html(`${new Date(cell).toLocaleString()}`)
            }, {
                name: 'Trạng thái',
                width: '180px',
                formatter: (cell) => cell == 1 ? gridjs.html(`<div class="w-100 status status--success">Đang hoạt động</div>`) : (cell == 2 ? gridjs.html(`<div class="w-100 status status--error">Chưa kích hoạt</div>`) : gridjs.html(`<div class="w-100 status status--error">Tạm dừng</div>`))
            }, {
                name: 'Action',
                width: '180px',
                formatter: (action) => gridjs.html(`<div class="icon-hover-scale call_ajax_modal-js" data-href="` + action.edit + `"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16"><path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/></svg></div>`)
            }],
            pagination: {
                limit: 15,
                server: {
                    url: (prev, page, limit) => `${prev}?page=${page}`
                }
            },
            server: {
                url: "{{route('api.account.get_all')}}",
                then: res => res.data.data.map((user, index) => [index + 1, user.username, user.is_admin, user.created_at,user.status, {edit: "{{route('accounts.edit', '_id')}}".replace("_id", user._id)}]),
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
