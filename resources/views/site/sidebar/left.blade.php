<aside class="sidebar sidebar--left sidebar--left--min {{$sidebarLeft ?? ''}}">
    <div class="sidebar__logo">
        <img src="https://websitemisa.misacdn.net/sites/logo/misa-mtax.svg" alt="">
        <span class="fw-bold ml-2 brand_name">F99 Price</span>
    </div>
    <div class="sidebar__menu__lists d-flex flex-column justify-content-between flex-1">
        <div class="sidebar__menu__top">
            <div class="sidebar__menu__item {{setActive('site.home.dashboard')}}">
                <a href="{{route('site.home.dashboard', ['brand_id' => app('request')->input('brand_id')])}}"><div class="mi mi-24 mi-sidebar-dashboard"></div><span>Trang chủ</span></a>
            </div>
            <div class="sidebar__menu__item {{setActive('compare.index')}}">
                <a href="{{route('compare.index', ['brand_id' => app('request')->input('brand_id')])}}"><div class="mi mi-24 mi-sidebar-report"></div><span>Báo cáo</span></a>
            </div>
            <div class="sidebar__menu__item {{setActive('setting.index')}}">
                <a href="{{route('setting.index', ['brand_id' => app('request')->input('brand_id')])}}"><div class="mi mi-24 mi-sidebar-setting"></div><span>Thiết lập</span></a>
            </div>
        </div>

        <div class="sidebar__menu__bottom">
            <div class="sidebar__menu__item">
                <a href=""><div class="mi mi-24 mi-sidebar-setting"></div><span>Cài đặt</span></a>
            </div>
        </div>
    </div>
</aside>