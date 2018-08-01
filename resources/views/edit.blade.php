@extends('layouts.app')

@section('title')
{{ __('edit.edit.title') }}
@stop

@section('content')

<div class="card">
    <div class="card-header">{{ __('edit.edit.label') }}</div>
    <div class="card-body">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
            @endforeach
        @endif
        
        <form action="/update/{{ $link->id }}" method="post">
            @csrf
            <div class="form-group">
                 <label for="title">{{ __('edit.title.label') }}</label>
                 <input type="text" class="form-control" name="title" placeholder="{{ __('edit.title.placeholder') }}" value="{{$link->title}}" >
            </div>
            <div class="form-group">
                 <label for="link">{{ __('edit.link.label') }}</label>
                 <input type="text" class="form-control" name="link" value="{{$link->link}}" placeholder="{{ __('edit.link.placeholder') }}">
            </div>
            <div class="form-group">
                 <label for="tags">{{ __('edit.tags.label') }}</label>
                 <input type="text" class="form-control" name="tags" value="@foreach($link->tags as $tag){{$tag->name.' '}}@endforeach()" placeholder="{{ __('edit.tags.placeholder') }}">
            </div>
            <button type="submit" class="btn btn-warning"><i class="fas fa-edit"></i> {{ __('edit.edit.label') }}</button>
            <a class="btn btn-primary" href="/home"><i class="fas fa-arrow-left"></i> {{ __('edit.back') }}</a>
        </form>
    </div>
</div>

@stop
