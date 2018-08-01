@extends('site.site')

@section('title')
{{ __('site.sidebar.open-source') }}
@stop

@section('stitle')
{{ __('site.sidebar.open-source') }}
@stop

@section('scontent')
<p class="lead">
    {!! __('site.content.open-source') !!}
</p>
@stop