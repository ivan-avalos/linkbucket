@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body p-0">
        <div class="row">
            <div class="col-12 col-md-3 py-3" style="border-right:1px solid #ccc;">
                <ul class="nav flex-column settings-nav">
                    <li class="nav-item pl-3 active">
                        <a class="nav-link lead text-muted" href="/site/about">{{ __('site.sidebar.about') }}</a>
                    </li>
                    <li class="nav-item pl-3 ">
                        <a class="nav-link lead text-muted" href="/site/features">{{ __('site.sidebar.features') }}</a>
                    </li>
                    <!--<li class="nav-item pl-3 ">
                        <a class="nav-link lead text-muted" href="https://pixelfed.social/site/help">Help</a>
                    </li>
                    <li class="nav-item pl-3 ">
                        <a class="nav-link lead text-muted" href="https://pixelfed.social/site/language">Language</a>
                    </li>-->
                    <li class="nav-item">
                        <hr>
                    </li>
                    <li class="nav-item pl-3 ">
                        <a class="nav-link lead text-muted" href="/site/open-source">{{ __('site.sidebar.open-source') }}</a>
                    </li>
                    <li class="nav-item">
                        <hr>
                    </li>
                    <li class="nav-item pl-3 ">
                        <a class="nav-link lead text-muted" href="/site/terms">{{ __('site.sidebar.terms') }}</a>
                    </li>
                    <li class="nav-item pl-3 ">
                        <a class="nav-link lead text-muted" href="/site/privacy">{{ __('site.sidebar.privacy') }}</a>
                    </li>
                    <li class="nav-item pl-3 ">
                        <a class="nav-link lead text-muted" href="/site/api">{{ __('site.sidebar.platform') }}</a>
                    </li>
                    <!--<li class="nav-item pl-3 ">
                        <a class="nav-link lead text-muted" href="https://pixelfed.social/site/libraries">Libraries</a>
                    </li>-->
                </ul>
            </div>
            <div class="col-12 col-md-9 p-5">
                <div class="title">
                    <h3 class="font-weight-bold">@yield('stitle')</h3>
                </div>
                <hr>
                <section>
                    @yield('scontent')
                </section>
            </div>
        </div>
    </div>
</div>
@stop