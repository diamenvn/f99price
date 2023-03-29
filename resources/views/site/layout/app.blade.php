<!DOCTYPE html>
<html lang="en">

<head>
    @include('site.layout.head')
    @include('site.layout.css')
</head>

<body>
    <div class="wrapper wrapper--layout">
        @include('site.sidebar.left')
        @include('site.sidebar.right')
        <main class="site-main blur d-flex flex-column overflow-hidden">
            <header class="header header--layout d-flex justify-content-between">
                <div class="header__left d-flex align-items-center">
                    <div class="header__item">
                        @if(isset($detail))
                        <div class="header__current__db">
                            Dữ liệu {{$detail->domain}}
                        </div>
                        @endif
                    </div>
                </div>
                <div class="header__right d-flex">
                    <div class="header__item">
                        <div class="header__profie d-flex align-items-center">
                            <div class="header__item__avatar">
                                <img class="br-50" src="{{asset('assets/images/getavatar.png')}}" alt="">
                            </div>
                            <div class="header__item__name">User</div>
                        </div>
                    </div>
                </div>
            </header>
            <section class="main-content flex-1 overflow-auto d-flex flex-column container-fluid">
                @yield('content')
            </section>
        </main>
    </div>
</body>

</html>
@include('site.layout.modal')
@include('site.layout.js')
@yield('custom_js')
