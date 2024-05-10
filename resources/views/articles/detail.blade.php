@extends('layouts.app')

@section('content')
    <div class="container w-100" >

        @if ($errors->any())
            <div class="alert alert-warning">
                @foreach ($errors->all() as $msg)
                    {{ $msg }}
                @endforeach
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info">
                {{ session('info') }}
            </div>
        @endif
        <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-secondary mb-3">
        <span class="glyphicon glyphicon-chevron-left"></span> Back
        </a>
        <div class="card mb-3">
            <div class="card-body flex">

                <h4 class="card-title">{{ $article->title }} </h4>

                <b>Category:</b>
                <span class="text-success">
                    {{ $article->category->name ?? 'Unknown' }},
                </span>
                
                <div class="modal fade" id="imagePopup" tabindex="-1" aria-labelledby="imagePopupLabel" aria-hidden="true">
                    <div class="modal-dialog  modal-dialog-centered">
                        <div class="modal-content position-relative overflow-hidden h-100 w-100">  <button type="button" class="btn-close position-absolute top-0 end-0 mt-3 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
                            <img src="{{ asset($article->photo) }}" id="popup-image" alt="" class="img-fluid h-100 w-100"> 
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4 mb-2 align-items-center">
                        <img class="mb-2 img-fluid aspect-ratio aspect-ratio-16x9" src="{{ asset($article->photo) }}" alt="{{ $article->title }}" data-bs-toggle="modal" data-bs-target="#imagePopup" data-src="{{ asset($article->photo) }}">
                        <br><span class="font-bold">{{ $article->prices }}&nbsp;ks</span>
                    </div> 

                    <div class="col-8 mb-3">
                        {{ $article->body }}
                    </div>
                </div>
                @auth
                    @can('delete-article', $article)
                        <a class="btn btn-sm btn-danger text-light btn-outline-danger" href="{{ url("/articles/delete/$article->id") }}">
                            Delete
                        </a>
                        <a style="background-color: #000000; color: #FAA4BB;" class="btn btn-sm " href="{{ url("/articles/edit/$article->id") }}">
                            Edit
                        </a>
                    @endcan
                @endauth
                
                <ul class="list-group mt-4">
                    <li style="background-color: #000000; color: #FAA4BB;" class="list-group-item active">
                        Reviews ({{ count($article->comments) }})
                    </li>
                    @foreach ($article->comments as $comment)
                        <li class="list-group-item">    
                            @can('delete-comment', $comment)
                                <a href="{{ url("/comments/delete/$comment->id") }}" class="btn btn-close float-end"></a>
                            @endcan

                            <b class="text-success">
                                {{ $comment->user->name }}
                            </b> -
                            {{ $comment->content }}
                        </li>
                    @endforeach
                </ul>

        @auth
            <form action="{{ url('/comments/add') }}" method="post">
                @csrf
                <input type="hidden" name="article_id" value="{{ $article->id }}">
                <textarea name="content" class="form-control my-2"></textarea>
                <button  style="background-color: #000000; color: #FAA4BB;" class="btn btn-secondary">Add Comment</button>
            </form>
        @endauth
    </div>
@endsection
