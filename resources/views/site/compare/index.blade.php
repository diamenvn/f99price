@extends('site.layout.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-11">
            <div class="main__content__filter">
                <div class="title-panel">
                    <div class="fw-700 fs-20 title">Bảng so sánh giá cả</div>
                    <div class="fs-12 sub-title">Tìm thấy {{count($brands)}} nhãn hàng</div>
                </div>
                <div class="filter-panel d-flex">
                    <button class="btn btn-sm btn-info call_ajax_modal-js" data-href="{{$create}}">Quản lý sản phẩm</button>
                </div>
            </div>
            <div class="row my-3 overflow-hidden">
                <div class="col-12">
                    <div id="table-compare-js"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="popup cm-history-price cm-history-price-js position-fixed" style="display: none">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 p-2">
                    <h5 class="product_name-js"></h5>
                    <a id="link-js" target="_blank" href="#"></a>
                    <div class="form-group p-3">
                        <label for="filter-view">Thời gian</label>
                        <select name="" id="filter-view" class="form-control">
                            <option selected value="7">1 Tuần</option>
                            <option value="30">1 Tháng</option>
                        </select>
                    </div>
                    <div id="chart"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_js')
    <script>
        var columns = [{id: 'product_name', name: 'Tên sản phẩm'}];
        var name = "";
        @foreach ($brands as $brand)
            columns.push({id: '{{$brand->_id}}', name: gridjs.html('<img style="min-width: 32px;max-width: 32px;object-fit: contain;min-height: 32px;max-height: 32px; border-radius: 50%; border: 1px dashed #ddd; padding: 3px" src="{{$brand->brand_logo_url}}"> {{$brand->brand_name}}')});
        @endforeach


        $(function() {
            var popupHistory = $('.cm-history-price-js');
            $(document).on('change', '#filter-view', function(event) {
                getDetail(name, $(this).val());
            });

            $(document).on('click', '.product-item-js', function(event) {
                windowWidth = window.innerWidth;
                windowHeight = window.innerHeight;

                popupHistory.css({'top': event.clientY, 'left': event.clientX});
                if (windowWidth - event.clientX < popupHistory.width()) {
                    popupHistory.css({'left': event.clientX - popupHistory.width()});
                }
                if (windowHeight - event.clientY < popupHistory.height()) {
                    popupHistory.css({'top': event.clientY - popupHistory.height()});
                }
                name = $(this).attr('data-result-name');

                popupHistory.show();
                getDetail(name, $('#filter-view').val());
            });

            $(document).mouseup(function(e){
                if(!popupHistory.is(e.target) && popupHistory.has(e.target).length === 0){
                    popupHistory.hide();
                }   
            });
            
            $('.main-content, .gridjs-wrapper').scroll(function() {
                popupHistory.hide();
            });

        });

        var options = {
            series: [{
                name: 'Giá sản phẩm',
                type: 'column'
            }],
            chart: {
                height: 300,
                type: 'bar',
            },
            stroke: {
                width: [0, 4]
            },
            plotOptions: {
                bar: {
                    borderRadius: 5,
                    dataLabels: {
                    position: 'top', // top, center, bottom
                    },
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function (val) {
                    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(val)
                },
                offsetY: 0,
                style: {
                    fontSize: '12px',
                    colors: ["#fff"]
                }
            },
            yaxis: [{
                title: {
                    text: 'Giá tiền',
                },

            }]
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();


        function getDetail(name, days = 7) {
            Notiflix.Block.Dots('.cm-history-price-js');
            objectUrl = $('.url-to-product-js');
            lib.request.get('{{ route("api.compare.detail")}}' + "?name=" + encodeURIComponent(name) + "&day=" + days, function(res) {
                data = res.data.charts.map(function(array) {
                    objectUrl.attr('href', array.url);
                    return {
                        x: array.creation_time,
                        y: array.price
                    };
                });

                chart.updateSeries([{
                    data: data
                }]);

                $('#link-js').attr('href', res.data.detail.url);
                $('#link-js').text(res.data.detail.url);
                $('.product_name-js').text(res.data.detail.name);
                Notiflix.Block.Remove('.cm-history-price-js', 400);
            });
        }
    </script>
    <script>
        new gridjs.Grid({
            columns: columns,
            fixedHeader: true,
            autoWidth: true,
            height: '740px',
            server: {
                url: '{{$apiRequest}}',
                then: function(data) {
                    return data.data.map(function(array) {
                        result = [];
                        for(i in array) {
                            if (Array.isArray(array[i])) {
                                array[i].forEach(function(value) {
                                    if (!!!result[i]) result[i] = [];
                                    result[i].push(gridjs.html(`<a href="javascript:void()" data-result-name="` + value.name + `" class="compare-split product-item-js fs-14 row"><div class="col-9 p-0 text-one-line">` + value.name + ` - </div><div class="co-red p-0 overflow-hidden fw-600 col-3">` + value.price + `đ</div><br></a>`));
                                });
                            }else{
                                if (!!!result[i]) result[i] = [];
                                result[i].push(gridjs.html('<b>' + array[i] + '</b>'));
                            } 
                        }
                        return {...result};
                    });
                },
            },
        }).render(document.getElementById("table-compare-js"));
        
        @if (\Session::has('success'))
            Notiflix.Notify.Success('{{\Session::get("success")}}');
        @endif
        @if (\Session::has('error'))
            Notiflix.Notify.Failure('{{\Session::get("error")}}');
        @endif
    </script>
@endsection


