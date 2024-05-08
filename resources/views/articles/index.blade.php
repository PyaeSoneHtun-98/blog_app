@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 600px">

        {{ $articles->links() }}

        @if (session('info'))
            <div class="alert alert-info">
                {{ session('info') }}
            </div>
        @endif

        <div class="modal fade" id="imagePopup" tabindex="-1" aria-labelledby="imagePopupLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="imagePopupLabel">Article Image</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <img src="" id="popup-image" alt="" class="img-fluid">
        </div>
      </div>
    </div>
  </div>

        @foreach ($articles as $article)
            <div class="card mb-3" >
                <div class="card-body">
                    <h4 class="card-title">{{ $article->title }} </h4>
                    <small class="text-muted">
                        <b class="text-success">
                            {{ $article->user->name }}
                        </b>,
                        <b>Category:</b>
                        <span class="text-success">
                            {{ $article->category->name ?? 'Unknown' }}
                        </span>

                        <b>Comments:</b>
                        <span class="text-success">
                            {{ count($article->comments) }}
                        </span>,

                        {{ $article->created_at->diffForHumans() }}</small>
                    <!-- <div class="mb-2">{{ $article->body }}</div> -->
                    <div class="mb-2">
                        <img class="img-fluid"  src="{{ asset($article->photo) }}" alt="{{ $article->title }}">
                    </div>
                    <a href="{{ url("/articles/detail/$article->id") }}">
                        View Detail
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
