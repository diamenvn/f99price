<aside class="sidebar sidebar--right sidebar--right-js {{$sidebarRight ?? ''}}">
    <div class="sidebar__container d-flex flex-column h-100">
        <div class="sidebar__title p-2 px-3">Danh sách trang web lấy dữ liệu</div>
        <div class="p-2 px-3 header__item__search mb-0">
            <input type="text" placeholder="Tìm kiếm..." class="inp__search w-100">
            <div class="inp__search__icon" style="top: 11px; right: 27px"></div>
        </div>
        <div class="sidebar__lists flex-1 overflow-auto">
            @if (isset($crawls) && count($crawls) > 0)
                @foreach ($crawls as $crawl)
                <a href="{{route($sidebarRightUrl ?? 'crawl_pages.index', ['_id' => $crawl->_id])}}" class="items sidebar__lists-items-js {{setActiveFilter(['_id' => $crawl->_id])}}" data-id="{{$crawl->_id}}">
                    <div class="item__prefix">
                        {{str_replace("https://", "", str_replace("http://", "", $crawl->domain))[0]}}
                    </div>
                    <div class="item__body">
                        <div class="title">{{$crawl->domain}}</div>
                        <div class="description">Lấy dữ liệu lần cuối vào lúc <span class="fw-bold co-red">{{gmdate('H:i:s',strtotime($crawl->crawled_last_time ?? $crawl->created_at))}}</span> ngày <span class="fw-bold co-red">{{gmdate('d-m-Y',strtotime($crawl->updated_at))}}</span></div>
                    </div>
                </a>
                @endforeach
            @else
                <div class="p-3"><span class="fs-20">Không có dữ liệu</span></div>
            @endif
            <div class="w-100 text-center p-2">
                <div class="btn btn-info btn-sm call_ajax_modal-js" data-href="{{route('crawl_pages.create')}}"><i class="fal fa-plus-circle mr-2"></i>Thêm trang lấy dữ liệu</div>
            </div>
        </div>
    </div>
</aside>