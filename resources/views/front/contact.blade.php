@extends('front.layouts.layout')

@section('site_heading','Contact Us')
@section('bg', 'front/assets/img/contact-bg.jpg')
@section('content')

<!-- Main Content-->
<main class="mb-4">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            
            <div class="col-md-8">

                @if(session('status'))
                    <div class="alert alert-success">{{session('status')}}</div>
                @endif

                <p>Want to get in touch? Fill out the form below to send me a message and I will get back to you as soon as possible!</p>
                <div class="my-5">
                    
                    <form action="{{route('contact.post')}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input class="form-control" id="name" name="name" value="{{ old('name') }}" type="text" placeholder="Enter your name..."  />
                            @error('name') <div class="text-small text-danger">{{$message}}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input class="form-control" id="email" name="email" value="{{ old('email') }}" type="email" placeholder="Enter your email..." />
                            @error('email') <div class="text-small text-danger">{{$message}}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <select class="form-select" name="subject" id="subject">
                                <option value="notSelected" >Choose Your Topic Here</option>
                                <option {{ old('subject')=='info' ?'selected' :''}} value="info">Info</option>
                                <option {{ old('subject')=='support' ?'selected' :''}} value="support">Support</option>
                                <option {{ old('subject')=='advice' ?'selected' :''}} value="advice">Advice</option>
                            </select>
                            @error('subject') <div class="text-small text-danger">{{$message}}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" placeholder="Enter your message here..." style="height: 12rem" >{{ old('message') }}</textarea>
                            @error('message') <div class="text-small text-danger">{{$message}}</div> @enderror
                        </div>
                        <br />
                        <button class="btn btn-primary text-uppercase" id="submitButton" type="submit">Send</button>
                    </form>
                </div>
            </div>
            <div class="col-md-4 border">
                deneme1
            </div>
        </div>
    </div>
</main>
@endsection