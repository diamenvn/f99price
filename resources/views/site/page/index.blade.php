@extends('site.layout.app')

@section('content')
    {{-- <div class="main__content__filter d-flex justify-content-between">
        <div class="title-panel">
            <div class="fw-700 fs-20 title"><a target="_blank" href="{{$detail->domain}}">{{$detail->domain}}</a></div>
            <div class="fs-12 sub-title">Tìm thấy {{ isset($posts) ? count($posts) : 0 }} bài viết</div>
        </div>
        <div class="text-center p-2">
            <div class="btn btn-primary--custom btn-sm call_ajax_modal-js" data-href="{{route('crawl_pages.edit', $detail->_id)}}">Chỉnh sửa</div>
        </div>
    </div> --}}
    <div class="mb-3 mt-2">
        @include('site.page.overview')
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
        <div class="view-mode-item view-mode-list p-1 row">
            <div class="col-12">
                <div class="title-primary">Thống kê theo giờ</div>
                <div id="chart"></div>
            </div>
        </div>
        <div class="view-mode-item view-mode-list row">
            <div class="col-12">
                <div class="title-primary">Danh sách bài viết</div>
                <div id="table-index-js"></div>
                {{-- @if (isset($posts))
                    {{ $posts->links() }}
                @endif --}}
            </div>
        </div>
    </div>
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
        data = [];
        @foreach ($posts ?? [] as $key => $row)
            data.push([
                '{{$key + 1}}',
                '{{$row->post_link}}',
                '{{$row->post_content}}',
                '{{gmdate("d-m-Y H:i:s",strtotime($row->updated_at))}}',
                gridjs.html('')
            ]);
        @endforeach

        new gridjs.Grid({
            columns: [{
                name: 'STT',
                width: '100px',
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
                width: '130px'
            }, {
                name: 'Hành động',
                width: '130px'
            }],
            data: data,
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
