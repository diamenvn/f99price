@extends('site.layout.app')

@section('content')
    <div class="main__content__filter">
        <div class="fw-700 fs-20 title">Tổng số lượng sản phẩm theo ngày</div>
    </div>
    <div class="row my-3">
        <div class="col-12">
            <div id="chart"></div>
        </div>
    </div>
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

@section('custom_js')
    <script>
        var data = [];
        var label = [];
        @if (isset($charts) && count($charts) > 0)
            @foreach ($charts as $chart)
                data.push('{{ $chart['data'] }}');
                label.push('{{ $chart['date'] }}');
            @endforeach
        @endif
        var options = {
            series: [{
                name: 'Tổng sản phẩm trên website',
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
            },
            yaxis: [{
                title: {
                    text: 'Tổng sản phẩm trên website',
                },

            }, {
                opposite: true,
                title: {
                    text: 'Social Media'
                }
            }]
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
    <script>
        data = [];
        @foreach ($rows ?? [] as $key => $row)
            data.push([
                '{{$key + 1}}',
                '{{$row->name}}',
                '{{is_numeric($row->price) ? number_format($row->price) : ''}}đ',
                gridjs.html('<img style="width: 60px" src="{{$row->thumbnail_url}}">')
            ]);
        @endforeach

        new gridjs.Grid({
            columns: ['STT', 'Tên sản phẩm', 'Giá sản phẩm', 'Hình ảnh'],
            data: data,
            search: {
                selector: (cell, rowIndex, cellIndex) => cellIndex === 0 ? cell.firstName : cell
            },
            fixedHeader: true,
            autoWidth: true,
            height: '740px'
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
