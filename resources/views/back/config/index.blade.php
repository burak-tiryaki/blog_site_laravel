@extends('back.layouts.layout')
@section('title','Site Configs')
@section('content')

@php
    $siteTitle = empty(config('app.custom_site_title')) ? '': config('app.custom_site_title');

    $logoSrc = empty(config('app.custom_site_logo')) ? 'https://placehold.co/400': asset(config('app.custom_site_logo'));
    $logoOldValue = empty(config('app.custom_site_logo')) ? '': config('app.custom_site_logo');

    $faviconSrc = empty(config('app.custom_site_favicon')) ? 'https://placehold.co/400': asset(config('app.custom_site_favicon'));
    $faviconOldValue = empty(config('app.custom_site_favicon')) ? '': config('app.custom_site_favicon');

    //$isActive = empty(config('app.custom_site_active')) ? '': config('app.custom_site_active');

    $githubValue = empty(config('app.custom_site_github_url')) ? '': config('app.custom_site_github_url');
    $linkedinValue = empty(config('app.custom_site_linkedin_url')) ? '': config('app.custom_site_linkedin_url');
    $twitterValue = empty(config('app.custom_site_twitter_url')) ? '': config('app.custom_site_twitter_url');
    $instagramValue = empty(config('app.custom_site_instagram_url')) ? '': config('app.custom_site_instagram_url');
@endphp

@if(session('status'))
<div class="row">{{-- Alert --}}
    <div class="col-12 text-center">
        <div class="alert alert-success mt-4">
            {{ session('status') }}
        </div>
    </div>
</div>
@endif

<div class="card mb-4">
    <div class="card-header d-flex align-items-center">
        <span>
            <i class="fa-solid fa-gear"></i>
            Update Site Settings
        </span>
    </div>
    <div class="card-body">
        <form action="{{route('admin.config.configPost')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label class="form-label">Site Default Title</label>
                        <input type="text" class="form-control" name="title" value="{{ isset($siteTitle) ? $siteTitle :''}}">
                    </div>
                    <div class="mb-3" id="logo">
                        <label class="form-label">Logo</label>
                        <div class="row d-flex align-items-center">
                            <div class="col-sm-3">
                                <img src="{{isset($logoSrc) ? $logoSrc :''}}" class="w-100" alt="">
                                <input type="hidden" name="oldlogo" value="{{isset($logoOldValue) ? $logoOldValue :''}}">
                            </div>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="logo" accept="image/*">
                            </div>
                            @error('logo') <div class="text-small text-danger">{{$message}}</div> @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Favicon</label>
                        <div class="row d-flex align-items-center">
                            <div class="col-sm-3">
                                <img src="{{isset($faviconSrc) ? $faviconSrc :''}}" class="w-100" alt="">
                                <input type="hidden" name="oldfavicon" value="{{isset($faviconOldValue) ? $faviconOldValue :''}}">
                            </div>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="favicon" accept="image/x-icon" >
                                <span class="text-muted text-small">(Only accepted type .ico)</span>
                            </div>
                            @error('favicon') <div class="text-small text-danger">{{$message}}</div> @enderror
                        </div>
                    </div>
                    <div class="mb-3 ">
                        <label class="form-label">Site is Active?</label>
                        <select name="active" id="" class="form-select w-25">
                            <option {{ empty($config->isActive) ? ($config->isActive == "1" ? 'selected' :'') :''}} value="1">Active</option>
                            <option {{ empty($config->isActive) ? ($config->isActive == "0" ? 'selected' :'') :''}} value="0">Passive</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label class="form-label"><i class="fa-brands fa-github me-1 fa-lg"></i>GitHub</label>
                        <input type="text" class="form-control" name="github" value="{{isset($githubValue) ? $githubValue :''}}">
                    </div>
                    <div class="mb-3" id="linkedin">
                        <label class="form-label"><i class="fa-brands fa-linkedin me-1 fa-lg"></i>Linkedin</label>
                        <input type="text" class="form-control" name="linkedin" value="{{isset($linkedinValue) ? $linkedinValue :''}}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="fa-brands fa-twitter me-1 fa-lg"></i>Twitter (X)</label>
                        <input type="text" class="form-control" name="twitter" value="{{isset($twitterValue) ? $twitterValue :''}}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="fa-brands fa-instagram me-1 fa-lg"></i>Instagram</label>
                        <input type="text" class="form-control" name="instagram" value="{{isset($instagramValue) ? $instagramValue :''}}">
                    </div>
                </div>

                <div class="my-2 justify-content-center d-flex">
                    <button type="submit" class="btn btn-primary" style="width:25em">Update Config</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

