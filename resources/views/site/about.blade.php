@extends('layouts.app')

@section('content')
<div class="card mt-5">
    <div class="card-body p-0">
        <div class="row">
            <div class="col-12 col-md-3 py-3" style="border-right:1px solid #ccc;">
                <ul class="nav flex-column settings-nav">
                    <li class="nav-item pl-3 active">
                        <a class="nav-link lead text-muted" href="/site/about">About</a>
                    </li>
                    <!--<li class="nav-item pl-3 ">
                        <a class="nav-link lead text-muted" href="https://pixelfed.social/site/features">Features</a>
                    </li>
                    <li class="nav-item pl-3 ">
                        <a class="nav-link lead text-muted" href="https://pixelfed.social/site/help">Help</a>
                    </li>
                    <li class="nav-item pl-3 ">
                        <a class="nav-link lead text-muted" href="https://pixelfed.social/site/language">Language</a>
                    </li>
                    <li class="nav-item">
                        <hr>
                    </li>
                    <li class="nav-item pl-3 ">
                        <a class="nav-link lead text-muted" href="https://pixelfed.social/site/fediverse">Fediverse</a>
                    </li>-->
                    <li class="nav-item pl-3 ">
                        <a class="nav-link lead text-muted" href="/site/open-source">Open Source</a>
                    </li>
                    <!--<li class="nav-item">
                        <hr>
                    </li>
                    <li class="nav-item pl-3 ">
                        <a class="nav-link lead text-muted" href="https://pixelfed.social/site/terms">Terms</a>
                    </li>
                    <li class="nav-item pl-3 ">
                        <a class="nav-link lead text-muted" href="https://pixelfed.social/site/privacy">Privacy</a>
                    </li>-->
                    <li class="nav-item pl-3 ">
                        <a class="nav-link lead text-muted" href="/site/api">Platform</a>
                    </li>
                    <!--<li class="nav-item pl-3 ">
                        <a class="nav-link lead text-muted" href="https://pixelfed.social/site/libraries">Libraries</a>
                    </li>-->
                </ul>
            </div>
            <div class="col-12 col-md-9 p-5">
                <div class="title">
                    <h3 class="font-weight-bold">About</h3>
                </div>
                <hr>
                <section>
                    <p class="lead">
                        Linkbucket is a bookmark manager where you can save
                        your bookmarks in the cloud and access to them from any device. It's useful to
                        backup important links and manage them easily.
                    </p>
                </section>
            </div>
        </div>
    </div>
</div>
@stop