@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit link</div>
                <div class="card-body">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
                @endforeach
            @endif
		    <form action="/update/{{ $link->id }}" method="post">
			<div class="form-group">
			     <label for="title">Title</label>
			     <input type="text" class="form-control"
			name="title" placeholder="Example Website" value="{{$link->title}}" />
			</div>
			<div class="form-group">
			     <label for="link">Link</label>
			     <input type="text" class="form-control"
			     name="link" value="{{$link->link}}"
			placeholder="https://example.com">
			</div>
			<div class="form-group">
			     <label for="tags">Tags </label>
			     <input type="text" class="form-control"
			name="tags" value="{{$link->tags}}" placeholder="Enter space separated tags">
			</div>
			<button type="submit" class="btn btn-warning"><i class="fas fa-edit"></i> Edit
			link</button>
			<a class="btn btn-primary" href="/home"><i class="fas fa-arrow-left"></i> Back</a>
			@csrf
		    </form>
                </div>
            </div>
	    <br>
        </div>
    </div>
</div>
@stop
