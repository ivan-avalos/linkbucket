@extends('site.site')

@section('title')
{{ __('site.sidebar.about') }}
@stop

@section('stitle')
{{ __('site.sidebar.about') }}
@stop

@section('scontent')
<p class="lead">
    {{ __('site.content.about') }}
</p>
@stop