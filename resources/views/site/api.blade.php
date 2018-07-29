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
                    <li class="nav-item pl-3 ">
                        <a class="nav-link lead text-muted" href="/site/open-source">Open Source</a>
                    </li>
                    <li class="nav-item pl-3 ">
                        <a class="nav-link lead text-muted" href="/site/api">Platform</a>
                    </li>
                </ul>
            </div>
            <div class="col-12 col-md-9 p-5">
                <div class="title">
                    <h3 class="font-weight-bold">Platform</h3>
                </div>
                <hr>
                <section>
                    <p class="lead"></p>
                </section>
            </div>
        </div>
    </div>
</div>
@stop