<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>@yield('title',empty(config('app.custom_site_title')) ? 'Burak\'s Blog': config('app.custom_site_title'))</title>
        <link rel="icon" type="image/x-icon" href="{{empty(config('app.custom_site_favicon')) ? 'https://placehold.co/32': asset(config('app.custom_site_favicon'))}}" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{asset('front/')}}/css/styles.css" rel="stylesheet" />
    </head>
    <body>
        @include('front.partials.navbarHeader')

        <!-- Main Content-->
        <div class="container px-4 px-lg-5">
            @yield('content')
        </div>

        @include('front.partials.footer')

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{asset('front/')}}/js/scripts.js"></script>
    </body>
</html>
