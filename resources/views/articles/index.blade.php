@extends('layouts.app')

@section('content')
    <div class="container w-100">
        @if (session('info'))
            <div class="alert alert-info">
                {{ session('info') }}
            </div>
        @endif

        <div class="row g-3">
            @foreach ($articles as $article)
            <div class="col-6 col-md-3">
                    <div class="flex card mb-2"  >
                        <div class="card-body shadow-md rounded-3" style="background-color:#FFC7D4;">
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
                            <a href="{{ url('/articles/detail/' . $article->id) }}">
                                <div class="image-container mb-2" style="max-height: 345px">
                                    {{-- <div class="card-image mb-2"> --}}
                                    @if (isset($article->photos))
                                        <?php
                                            try {
                                                $photoUrls = json_decode($article->photos);
                                                $firstImageUrl = $photoUrls[0];
                                            } catch (Exception $e) {
                                                $firstImageUrl = asset('logo.jpg'); 
                                            }
                                        ?>
                                        <img  class="img-fluid rounded mb-3 aspect-ratio aspect-ratio-16*9" src="{{ $firstImageUrl }}" alt="{{ $article->title }}">
                                        @else
                                        <img class="img-fluid rounded mb-3 aspect-ratio aspect-ratio-16*9" src="{{ asset('placeholder.jpg') }}" alt="No image available">
                                    @endif
                                </div>
                            </a>
                            <a class="btn btn-sm rounded" style="background-color: #CF4930; color: #ffffff;" href="{{ url("/articles/detail/$article->id") }}">
                                Details
                            </a>
                            <span class="float-end font-weight-bold">{{ $article->price }} ks</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center pt-4">  {{ $articles->links() }}
        </div>
    </div>
@endsection
