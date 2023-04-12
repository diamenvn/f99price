@extends('site.layout.app')

@section('content')
    @if (isset($detail))
        <div class="main__content__filter d-flex justify-content-between">
            <div class="title-panel">
                <div class="fw-700 fs-20 title"><a target="_blank" href="{{$detail->domain}}">{{$detail->domain}}</a></div>
                <div class="fs-12 sub-title">Tìm thấy {{ isset($posts) ? $posts->total() : 0 }} bài viết</div>
            </div>
            <div class="text-center p-2">
                <div class="btn btn-primary--custom btn-sm call_ajax_modal-js" data-href="{{route('crawl_pages.edit', $detail->_id)}}">Chỉnh sửa</div>
            </div>
        </div>
        <div class="mb-3 mt-2">
            @include('site.page.overview')
        </div>
        <div class="my-3">
            <div class="view-mode-item view-mode-list p-1 row">
                <div class="col-12">
                    <div class="title-primary">Thống kê theo giờ</div>
                    <div id="chart"></div>
                </div>
            </div>
            <div class="view-mode-item view-mode-list row">
                <div class="col-12">
                    <div class="title-primary">Danh sách bài viết đang chờ đồng bộ</div>
                    <div class="table-page" id="table-index-js"></div>
                </div>
            </div>
        </div>
    @else
        <div class="d-flex justify-content-center h-100 align-items-center">
            <h4 class="p-2 text-center">Chọn 1 trang bên cạnh để xem chi tiết</h4>
        </div>
    @endif
@endsection


@section('custom_js')
    <script>
        var data = [];
        var label = [];
        @if (isset($charts) && count($charts) > 0)
            @foreach ($charts as $chart)
                data.push('{{ $chart['data'] }}');
                label.push('{{ $chart['hour'] }}h');
            @endforeach
        @endif
        var options = {
            series: [{
                name: 'Số lượng bài viết',
                type: 'column',
                data: data
            }],
            chart: {
                height: 300,
                type: 'area',
            },
            stroke: {
                width: [0, 4]
            },
            dataLabels: {
                enabled: true,
                enabledOnSeries: [1]
            },
            labels: label,
            xaxis: {
                type: 'text'
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
    <script>

        new gridjs.Grid({
            columns: [{
                name: 'STT',
                width: '70px',
                formatter: (cell) => gridjs.html(`<div class="text-left">${cell}</div>`)
            }, {
                name: 'Link bài viết',
                formatter: (cell) => gridjs.html(`<a href="${cell}" class="text-left co-link">${cell}</a>`)
            }, {
                name: 'Nội dung',
                width: '400px',
                formatter: (cell) => gridjs.html(`<div class="text-two-line">${cell}</div>`)
            }, {
                name: 'Ngày đăng',
                width: '180px',
                formatter: (cell) => new Date(cell).toLocaleString()
            }],
            // data: data,
            pagination: {
                limit: 15,
                server: {
                    url: (prev, page, limit) => `${prev}&page=${page}`
                }
            },
            server: {
                url: "{{route('api.page.get_all', ['site_id' => $detail->_id ?? null])}}",
                then: res => res.data.data.map((post, index) => [index + 1, post.post_link, post.post_content, post.post_date]),
                handle: (res) => {
                    if (res.status === 404 || res.status === 500) return {data: []};
                    if (res.ok) return res.json();
                    
                    throw Error('oh no :(');
                },
                total: res => res.data.total
            },
            fixedHeader: true,
            autoWidth: true,
            resizable: true,
            height: '700px',
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
