@include('layouts.admin.header')
    <body class="sb-nav-fixed">
        @include('layouts.admin.navbar')
        <div id="layoutSidenav">
            @include('layouts.admin.sidebar')
            <div id="layoutSidenav_content">
                @yield('content')
                {{-- @include('layouts.admin.body') --}}
                @include('layouts.admin.footer')
            </div>
        </div>
    </body>
</html>
