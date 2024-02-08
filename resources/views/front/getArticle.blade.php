@extends('front.layouts.layout')

@section('site_heading',$article->article_title)
@section('bg', $article->article_image)
@section('content')

<!-- Post Content-->
<article class="mb-4">
    <div class="row gx-4 gx-lg-5 justify-content-center">
        <div class="col-md-9">
            {!! $article->article_content !!}
            <p>
                Placeholder text by
                <a href="http://spaceipsum.com/">Space Ipsum</a>
                &middot; Images by
                <a href="https://www.flickr.com/photos/nasacommons/">NASA on The Commons</a>
            </p>
            <p class="text-muted">Reading Count: {{$article->article_hit}}</p>
        </div>
        
        @include('front.partials.sidebar')
        
    </div>
</article>

@endsection