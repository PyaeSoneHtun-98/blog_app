@extends('layouts.app')

@section('content')
    <div class="container w-100">
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

        <div class="row">
            @foreach ($articles as $article)
            <div class="col-6 col-md-3">
                    <div class="flex card mb-3 shadow-md rounded-3">
                        <div class="card-body">
                            <h4 class="card-title">{{ $article->title }} </h4>
                            <small class="text-muted">
                                <b class="text-success">
                                    {{ $article->user->name }}
                                </b>,
                                <br>
                                <b>Category:</b>
                                <span class="text-success">
                                    {{ $article->category->name ?? 'Unknown' }}
                                </span>
                                <br>
                                <b>Reviews:</b>
                                <span class="text-success">
                                    {{ count($article->comments) }}
                                </span>,

                                {{ $article->created_at->diffForHumans() }}</small>
                            <!-- <div class="mb-2">{{ $article->body }}</div> -->
                            <div class="image-container mb-2" >
                                <img  class="img-fluid rounded mb-3 aspect-ratio aspect-ratio-16*9"  src="{{ asset($article->photo) }}" alt="{{ $article->title }}">
                            </div>
                            <a class="btn btn-sm rounded" style="background-color: #FAA4BB; color: #000000;" href="{{ url("/articles/detail/$article->id") }}">
                                Details
                            </a>
                            <span class="float-end font-bold">{{ $article->prices }} ks</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center">  {{ $articles->links() }}
        </div>
    </div>
@endsection
