@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add link</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

		    <form action="/add" method="post">
			<div class="form-group">
			     <label for="title">Title</label>
			     <input type="text" class="form-control"
			name="title" placeholder="Example Website" />
			</div>
			<div class="form-group">
			     <label for="link">Link</label>
			     <input type="text" class="form-control" name="link"
			placeholder="https://example.com">
			</div>
			<button type="submit" class="btn btn-primary">Add
			link</button>
			@csrf
		    </form>
                </div>
            </div>
	    <br>
        </div>
	<div class="col-md-8">
	<h1>Links</h1>
	@foreach ($links as $link)
            <div class="card" style="margin-bottom:10px;">
                <div class="card-body">
                    <h5 class="card-title">{{ $link->title }}</h5>
                    <p class="card-text"><font color="#555555"><i>{{ $link->link }}</i></font></p>
                    <a href="{{ $link->link }}" class="btn btn-primary">Go</a>
		    <a href="/edit/{{$link->id}}" class="btn btn-warning">Edit</a>
		    <a href="/remove/{{$link->id}}" class="btn
			btn-danger">Delete</a>
                </div>
            </div>
	@endforeach
	<br>
	<ul class="pagination">
            {{ $links->links() }}
	</ul>
    </div>
</div>
@endsection
