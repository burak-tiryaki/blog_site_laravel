@extends('front.layouts.layout')
@section('title','Anasayfa')
@section('content')
    
<div class="row gx-4 gx-lg-5 justify-content-center">

    <div class="col-md-9 order-2 order-md-1">
        <!-- Articles -->
        @include('front.partials.listArticles')
    </div>

    @include('front.partials.sidebar')

</div>
@endsection