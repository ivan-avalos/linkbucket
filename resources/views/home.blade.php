@extends('layouts.app')

@section('content')

@empty($no_add)
    <!-- STARTS ADD-LINK  -->
    <div class="card" style="margin-bottom:10px;">
        <div class="card-header">{{ __('home.link.add') }}</div>
    
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
                @csrf
                <div class="form-group">
                    <label for="link">{{ __('home.link.link.label') }}</label>
                    <input type="text" class="form-control" name="link" placeholder="{{ __('home.link.link.placeholder') }}">
                </div>
                <div class="form-group">
                    <label for="tags">{{ __('home.link.tags.label') }}</label>
                    <input type="text" class="form-control" name="tags" id="tags" placeholder="{{ __('home.link.tags.placeholder') }}">
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus"></i> {{ __('home.link.add') }}
                </button>
            </form>
        </div>
    </div>
    <!-- ENDS ADD-LINK  -->
    
    <!-- STARTS SEARCH -->
    <div class="card" style="margin-bottom:30px;">
        <div class="card-header">{{ __('home.search.label') }}</div>
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
                    <input type="text" class="form-control" name="search" placeholder="{{ __('home.search.placeholder') }}">
                    <div class="input-group-append">
    		            <button type="submit" class="btn btn-primary">
    		                <i class="fas fa-search"></i> {{ __('home.search.label') }}
    		            </button>
    	            </div>
                </div>
                @csrf
            </form>
        </div>
    </div>
    <!-- ENDS SEARCH -->
@endempty

<!-- Back button -->
@isset($back)
    <p><a href="/home" class="btn btn-lg btn-primary"><i class="fas fa-arrow-left"></i> {{ __('home.back') }}</a></p>
@endisset

<!-- Title -->
<h1>@empty($title) {{ __('home.title.links') }} @else {{$title}} @endempty</h1>

<!-- Links -->
<div style="margin-bottom: 30px;">
    @foreach ($links as $link)
        <div class="card" style="margin-bottom:10px;">
            <div class="card-body">
                <!-- Title -->
                <h5 class="card-title">{{ $link->title }}</h5>
                <!-- Link -->
                <p class="card-text">
                    <i style="color: #555555">{{ $link->link }}</i>
                </p>
                <!-- Tags -->
                <p class="card-text">
                    @foreach ($link->tags as $tag)
                        <a href="/tags/{{$tag->name}}" class="badge badge-light">{{$tag->name}}</a>
                    @endforeach
                </p>
                <!-- Go -->
                <a href="{{ $link->link }}" class="btn btn-primary">
                    <i class="fas fa-reply"></i> {{ __('home.link.go') }}
                </a>
                <!-- Edit -->
                <a href="/edit/{{$link->id}}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> {{ __('home.link.edit') }}
                </a>
                    
                <!-- Delete button -->
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete{{$link->id}}">
                    <i class="fas fa-trash"></i> {{ __('home.link.delete.delete') }}
                </button>
                <!-- Delete modal -->
                <div class="modal fade" id="delete{{$link->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <!-- Modal header -->
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteLabel">{{ __('home.link.delete.modal.header') }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                {{ __('home.link.delete.modal.body') }}
                            </div>
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">
                                    <i class="fas fa-ban"></i> {{ __('home.link.delete.modal.footer.cancel') }}</button>
                                <a class="btn btn-danger" href="/remove/{{$link->id}}">
                                    <i class="fas fa-trash"></i> {{ __('home.link.delete.modal.footer.delete') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Pagination -->
<ul class="pagination d-flex justify-content-center">
    {{ $links->links() }}
</ul>

<script type="text/javascript" >
    $('#delete').modal();
</script>
@stop