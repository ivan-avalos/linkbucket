@extends('site.site')

@section('stitle')
{{ __('site.sidebar.open-source') }}
@stop

@section('scontent')
<p class="lead">
    {!! __('site.content.open-source') !!}
</p>
@stop