@extends('site.layout.app')

@section('content')
    <div class="my-3">
        <div class="row">
            <div class="col">
                @include("site.dashboard.summary")
                <div class="row">
                    <div class="col-12">
                        <div class="title-primary">Lấy dữ liệu gần đây nhất</div>
                        <div id="chart"></div>
                    </div>
                    <div class="col-12">
                        <div class="title-primary">Đồng bộ gần đây nhất</div>
                        <div id="chart-2"></div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-3">
                <div class="col-12 mb-2">
                    <h4>5 trang có bài viết nhiều nhất</h4>
                    <div class="intro-x"><div class="d-flex align-items-center px-3 py-2 mb-3 box zoom-in"><div class="flex-none w-10 h-10 overflow-hidden rounded-full image-fit"><img alt="Midone Tailwind HTML Admin Template" src="http://enigma-react.left4code.com/assets/profile-13.d2befb57.jpg"></div><div class="ml-4 mr-auto"><div class="font-medium">Leonardo DiCaprio</div><div class="text-slate-500 text-xs mt-0.5">15 May 2021</div></div></div></div>
                    <div class="intro-x"><div class="d-flex align-items-center px-3 py-2 mb-3 box zoom-in"><div class="flex-none w-10 h-10 overflow-hidden rounded-full image-fit"><img alt="Midone Tailwind HTML Admin Template" src="http://enigma-react.left4code.com/assets/profile-13.d2befb57.jpg"></div><div class="ml-4 mr-auto"><div class="font-medium">Leonardo DiCaprio</div><div class="text-slate-500 text-xs mt-0.5">15 May 2021</div></div></div></div>
                    <div class="intro-x"><div class="d-flex align-items-center px-3 py-2 mb-3 box zoom-in"><div class="flex-none w-10 h-10 overflow-hidden rounded-full image-fit"><img alt="Midone Tailwind HTML Admin Template" src="http://enigma-react.left4code.com/assets/profile-13.d2befb57.jpg"></div><div class="ml-4 mr-auto"><div class="font-medium">Leonardo DiCaprio</div><div class="text-slate-500 text-xs mt-0.5">15 May 2021</div></div></div></div>
                    <div class="intro-x"><div class="d-flex align-items-center px-3 py-2 mb-3 box zoom-in"><div class="flex-none w-10 h-10 overflow-hidden rounded-full image-fit"><img alt="Midone Tailwind HTML Admin Template" src="http://enigma-react.left4code.com/assets/profile-13.d2befb57.jpg"></div><div class="ml-4 mr-auto"><div class="font-medium">Leonardo DiCaprio</div><div class="text-slate-500 text-xs mt-0.5">15 May 2021</div></div></div></div>
                    <div class="intro-x"><div class="d-flex align-items-center px-3 py-2 mb-3 box zoom-in"><div class="flex-none w-10 h-10 overflow-hidden rounded-full image-fit"><img alt="Midone Tailwind HTML Admin Template" src="http://enigma-react.left4code.com/assets/profile-13.d2befb57.jpg"></div><div class="ml-4 mr-auto"><div class="font-medium">Leonardo DiCaprio</div><div class="text-slate-500 text-xs mt-0.5">15 May 2021</div></div></div></div>
                    <div class="intro-x"><div class="d-flex align-items-center px-3 py-2 mb-3 box zoom-in"><div class="flex-none w-10 h-10 overflow-hidden rounded-full image-fit"><img alt="Midone Tailwind HTML Admin Template" src="http://enigma-react.left4code.com/assets/profile-13.d2befb57.jpg"></div><div class="ml-4 mr-auto"><div class="font-medium">Leonardo DiCaprio</div><div class="text-slate-500 text-xs mt-0.5">15 May 2021</div></div></div></div>
                    <div class="intro-x"><div class="d-flex align-items-center px-3 py-2 mb-3 box zoom-in"><div class="flex-none w-10 h-10 overflow-hidden rounded-full image-fit"><img alt="Midone Tailwind HTML Admin Template" src="http://enigma-react.left4code.com/assets/profile-13.d2befb57.jpg"></div><div class="ml-4 mr-auto"><div class="font-medium">Leonardo DiCaprio</div><div class="text-slate-500 text-xs mt-0.5">15 May 2021</div></div></div></div>
                </div>
            </div> --}}
        </div>
    </div>
@endsection


@section('custom_js')
    <script>
        var data = [];
        var label = [];
        @if (isset($charts) && count($charts) > 0)
            @foreach ($charts as $chart)
                data.push('{{ $chart['count'] ?? 0 }}');
                label.push('{{ $chart['domain'] }}');
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


        var data = [];
        var label = [];
        @if (isset($recentSync) && count($recentSync) > 0)
            @foreach ($recentSync as $chart)
                data.push('{{ $chart['config']['log']['count_post_sync_success'] ?? 0 }}');
                label.push('{{ $chart['domain'] }}');
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

        var chart = new ApexCharts(document.querySelector("#chart-2"), options);
        chart.render();
    </script>
@endsection
