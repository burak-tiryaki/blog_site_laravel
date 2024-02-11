@extends('front.layouts.layout')
@section('title',$page->page_title)
@section('site_heading',$page->page_title)
@section('bg',url($page->page_image))
@section('content')
    
<div class="row gx-4 gx-lg-5 justify-content-center">

    <div class="col-md-10 col-lg-8 col-xl-7">
        {!! $page->page_content !!}
    </div>
    
</div>
@endsection