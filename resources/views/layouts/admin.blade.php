@include('layouts.partials.header')

    <style>
        header {
            position: static;
        }
    </style>

<body>

    <header id="colored" class="sticky" static>
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <div id="logo">
                        <a href="/"><img src="img/logo.png" width="160" height="34" alt="City tours" data-retina="true" class="logo_normal"></a>
                        <a href="/"><img src="img/logo_sticky.png" width="160" height="34" alt="City tours" data-retina="true" class="logo_sticky"></a>
                    </div>
                </div>
                <nav class="col-md-9 col-sm-9 col-xs-9">
                    <a class="cmn-toggle-switch cmn-toggle-switch__htx open_close" href="javascript:void(0);"><span>Menu mobile</span></a>
                    <div class="main-menu">
                        <div id="header_menu">
                            <img src="/img/logo_sticky.png" width="160" height="34" alt="City tours" data-retina="true">
                        </div>
                        <a href="#" class="open_close" id="close_in"><i class="icon_set_1_icon-77"></i></a>
                        <ul>
                            <li><a href="/">Home</a></li>
                            @if (Auth::check())<li><a href="/admin/users">Users</a></li>
                            <li><a href="{{ route('admin.pages.index') }}">Pages</a></li>
                            <li><a href="/admin/blogs">Blogs</a></li>
                            <li><a href="/admin/auth/logout">Log Out</a></li>
                            @endif
                        </ul>
                    </div><!-- End main-menu -->
                </nav>
            </div>
        </div><!-- container -->
    </header>

    <div id="position">
        <div class="container">
            <ul>
                <li><a href="/admin">Home</a></li>
                @yield('breadcrumbs')
            </ul>
        </div>
    </div>

    <div class="container margin_60">
        @if (Session::has('flash_notification.message'))
            <div class="alert alert-{{ Session::get('flash_notification.level') }}">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                {{ Session::get('flash_notification.message') }}
            </div>
        @endif

        @yield('content')
    </div>

@include('layouts.partials.footer')