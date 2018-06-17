@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add link</div>
                <div class="card-body">
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
			<button type="submit" class="btn btn-warning">Edit
			link</button>
			<a class="btn btn-primary" href="/home">Back</a>
			@csrf
		    </form>
                </div>
            </div>
	    <br>
        </div>
    </div>
</div>
@stop
