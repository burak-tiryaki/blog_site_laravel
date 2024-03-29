<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light" id="mainNav">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="{{url('/')}}">
            {{-- @if (empty($config->siteLogo))
                {{$config->siteTitle}}
            @else
                <img src="{{asset($config->siteLogo)}}" width="100" alt="" srcset="">
            @endif --}}
            {{$config->siteTitle}}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto py-4 py-lg-0">
                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{url('/')}}">Home</a></li>

                @foreach ($pages as $page)
                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{route('page',$page->page_slug)}}">{{$page->page_title}}</a></li>
                @endforeach

                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{route('contact')}}">Contact</a></li>
            </ul>
            @if (!Auth::check())
                <a href="{{route('admin.login')}}" class="btn btn-outline-light rounded p-2 ms-1">Login</a>

            @else
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4 border rounded">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user fa-fw me-1"></i>
                        <span class="text-light">{{Auth::user()->user_name}}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{route('admin.articles.myArticles')}}">My articles</a></li>
                        <li><a class="dropdown-item" href="{{route('admin.articles.create')}}">Create Article</a></li>
                        <li><hr class="dropdown-divider" /></li> 
                        <li><a class="dropdown-item" href="{{route('logout')}}">Logout</a></li>
                    </ul>
                </li>
            </ul>
            @endif
        </div>
    </div>
</nav>
<!-- Page Header-->
<header class="masthead" style="background-image: url('@yield('bg', asset('/front/assets/img/home-bg.jpg'))')">
    <div class="container position-relative px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <div class="site-heading">
                    <h1>
                        @yield('site_heading',$config->siteTitle)
                    </h1>
                    <span class="subheading">A Blog Theme by Start Bootstrap</span>
                </div>
            </div>
        </div>
    </div>
</header>