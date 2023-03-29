<aside class="sidebar sidebar--right sidebar--right-js {{$sidebarRight ?? ''}}">
    <div class="sidebar__container d-flex flex-column h-100">
        <div class="sidebar__title text-one-line p-2 px-3">Danh sách trang</div>
        <div class="p-2 px-3 header__item__search mb-0">
            <input type="text" placeholder="Tìm kiếm nhãn hàng" class="inp__search w-100">
            <div class="inp__search__icon" style="top: 11px; right: 27px"></div>
        </div>
        <div class="sidebar__lists flex-1 overflow-auto">
            @if (isset($brands) && count($brands) > 0)
                @foreach ($brands as $brand)
                <a href="{{route($sidebarRightUrl ?? 'site.home.dashboard', ['brand_id' => $brand->_id])}}" class="items sidebar__lists-items-js {{setActiveFilter(['brand_id' => $brand->_id])}}" data-id="{{$brand->_id}}">
                    {{-- @if (isset($brand->brand_logo_url))
                    <div class="item__logo_preview">
                        <img src="{{$brand->brand_logo_url}}" alt="">
                    </div>
                    @else --}}
                    <div class="item__prefix">
                        {{$brand->brand_name[0]}}
                    </div>
                    {{-- @endif --}}
                    <div class="item__body">
                        <div class="title text-one-line">{{$brand->brand_name}}</div>
                        <div class="description text-two-line">Cập nhật lần cuối vào lúc <span class="fw-bold">{{gmdate('H:i:s',strtotime($brand->updated_at))}}</span> ngày <span class="fw-bold">{{gmdate('d-m-Y',strtotime($brand->updated_at))}}</span></div>
                    </div>
                </a>
                @endforeach
            @else
                <div class="p-3"><span class="fs-20">Không có dữ liệu</span></div>
            @endif
            <div class="w-100 text-center p-2">
                <div class="btn btn-success btn-sm call_ajax_modal-js" data-href="{{route('site.sidebar.add_page')}}">Thêm trang mới</div>
            </div>
        </div>
    </div>
</aside>