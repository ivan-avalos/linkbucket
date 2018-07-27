@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @empty($no_add)
            <!-- STARTS ADD-LINK  -->
            <div class="card" style="margin-bottom:10px;">
                <div class="card-header">Add link</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                        @endforeach
                    @endif

                    <form action="/add" method="post">
                        <!--<div class="form-group">
            			     <label for="title">Title</label>
            			     <input type="text" class="form-control"
            			      name="title" placeholder="Example Website" />
            			</div>-->
                        <div class="form-group">
                            <label for="link">Link</label>
                            <input type="text" class="form-control" name="link" placeholder="https://example.com">
                        </div>
                        <div class="form-group">
                            <label for="tags">Tags </label>
                            <input type="text" class="form-control" name="tags" id="tags"
                                    placeholder="Enter space separated tags">
                        </div>
                        <button type="submit" class="btn btn-primary">
			<i class="fas fa-plus"></i> Add link</button> @csrf
                    </form>
                </div>
            </div>
            <!-- ENDS ADD-LINK  -->
            
            <!-- STARTS SEARCH -->
            <div class="card" style="margin-bottom:10px;">
                <div class="card-header">Search</div>
                <div class="card-body">
                    @if ($errors->search->any())
                        @foreach ($errors->search->all() as $error)
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                        @endforeach
                    @endif
                    <form action="/search" method="get">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="search" placeholder="Enter search query">
                            <div class="input-group-append">
        			            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
    			            </div>
                        </div>
			            @csrf
                    </form>
                </div>
            </div>
            @endempty
            <!-- ENDS SEARCH -->
            <br>
        </div>
        <div class="col-md-8">
            @isset($back)
                <p><a href="/home" class="btn btn-lg btn-primary"><i class="fas fa-arrow-left"></i> Back</a></p>
            @endisset
            <h1>
                @empty($title) Links @else {{$title}} @endempty
            </h1>
            @foreach ($links as $link)
            <div class="card" style="margin-bottom:10px;">
                <div class="card-body">
                    <h5 class="card-title">{{ $link->title }}</h5>
                    <p class="card-text">
                        <font color="#555555"><i>{{
			$link->link }}</i></font>
                    </p>
                    <p>@foreach ($link->tags as $tag)
                        <a href="/tags/{{$tag->name}}" class="badge badge-light">{{$tag->name}}</a> @endforeach
                    </p>
                    <a href="{{ $link->link }}" class="btn btn-primary"><i class="fas fa-reply"></i> Go</a>
                    <a href="/edit/{{$link->id}}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
                    <a href="/remove/{{$link->id}}" class="btn
			btn-danger"><i class="fas fa-trash"></i> Delete</a>
                </div>
            </div>  
            @endforeach
            <br> @empty($no_pagination)
            <ul class="pagination d-flex justify-content-center">
                {{ $links->links() }}
            </ul>
            @endempty
        </div>
    </div>
    <script type="text/javascript" >
        $('.new-tag-input').LovelyTag({hasHashTag: false});
    </script>
@endsection