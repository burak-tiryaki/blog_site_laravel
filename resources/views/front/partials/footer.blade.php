@php

    $socials = ['github','linkedin','instagram','twitter'];

    $socialUrl = [];
    foreach ($socials as $key) {
        $socialUrl[$key] = empty(config('app.custom_site_'.$key.'_url')) 
                            ? '': config('app.custom_site_'.$key.'_url');
    }
@endphp

<!-- Footer-->
<footer class="border-top">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <ul class="list-inline text-center">

                    @foreach ($socials as $social)
                        <li class="list-inline-item">
                            <a href="{{ isset($socialUrl[$social]) ? $socialUrl[$social] :''}}" target="_blank">
                                <span class="fa-stack fa-lg">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fab fa-{{$social}} fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                    @endforeach

                </ul>
                <div class="small text-center text-muted fst-italic">Copyright &copy; {{ $config->siteTitle}} {{date("Y")}}</div>
            </div>
        </div>
    </div>
</footer>