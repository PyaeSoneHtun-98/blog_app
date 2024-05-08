@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 600px">

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

        <div class="card mb-3">
            <div class="card-body">
                <h4 class="card-title">{{ $article->title }} </h4>

                <b>Category:</b>
                <span class="text-success">
                    {{ $article->category->name ?? 'Unknown' }}
                </span>

                <small class="text-muted">{{ $article->created_at->diffForHumans() }}</small>

                <div class="modal fade" id="imagePopup" tabindex="-1" aria-labelledby="imagePopupLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <img src="{{ asset($article->photo) }}" id="popup-image" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>


                <div class="mb-2">
          <img class="img-fluid" src="{{ asset($article->photo) }}" alt="{{ $article->title }}" data-bs-toggle="modal" data-bs-target="#imagePopup" data-src="{{ asset($article->photo) }}">
        </div> 
                <div class="mb-3">{{ $article->body }}</div>
                @auth
                    @can('delete-article', $article)
                        <a class="btn btn-sm btn-outline-danger" href="{{ url("/articles/delete/$article->id") }}">
                            Delete
                        </a>
                        <a class="btn btn-sm btn-outline-success" href="{{ url("/articles/edit/$article->id") }}">
                            Edit
                        </a>
                    @endcan
                @endauth
            </div>
        </div>

        <ul class="list-group mt-4">
            <li class="list-group-item active">
                Comments ({{ count($article->comments) }})
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
                <button class="btn btn-secondary">Add Comment</button>
            </form>
        @endauth
    </div>
@endsection
