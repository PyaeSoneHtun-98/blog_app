@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 700px">

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

        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="deleteConfirmationModalLabel"> Delete Product <i class="fa-solid fa-trash"></i></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  Are you sure you want to delete this product? This action cannot be undone.
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancle</button>
                  <form action="{{ url("/articles/delete/$article->id") }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          
        <a href="{{ url('/') }}" class="btn btn-sm mb-3" style="background-color: #000000; color: #FAA4BB;">
        <span class="glyphicon glyphicon-chevron-left"></span> Back
        </a>
        <div class="card mb-3 sm:w-50">
            <div class="card-body flex">

                <h4 class="card-title">{{ $article->title }} </h4>

                <b>Category:</b>
                <span class="text-success">
                    {{ $article->category->name ?? 'Unknown' }},
                </span>
                
                <div class="modal fade" id="imagePopup" tabindex="-1" aria-labelledby="imagePopupLabel" aria-hidden="true">
                    <div class="modal-dialog  modal-dialog-centered">
                        <div class="modal-content position-relative overflow-hidden h-100 w-100">  <button type="button" class="btn-close position-absolute top-0 end-0 mt-3 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
                            <img id="popup-image" alt="" class="img-fluid h-100 w-100"> 
                        </div>
                    </div>
                </div>

                <div class="mb-2 align-items-center">
                        <div id="article-{{ $article->id }}-carousel" class="mb-2 carousel slide" data-bs-ride="carousel">  <ol class="carousel-indicators" style="display: none;">
                            @if(isset($article->photos))
                              <?php $photoUrls = json_decode($article->photos); ?>
                              @foreach ($photoUrls as $index => $photoUrl)
                                <li data-target="#article-{{ $article->id }}-carousel" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>  @endforeach
                            @endif
                          </ol>
                          <div class="carousel-inner">
                            @if(isset($article->photos))
                              @foreach ($photoUrls as $index => $photoUrl)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                  <img class="w-100 aspect-ratio aspect-ratio-16x9" src="{{ asset($photoUrl) }}" alt="{{ $article->title }}" data-bs-toggle="modal" data-bs-target="#imagePopup">
                                </div>
                              @endforeach
                            @else
                            @endif
                          </div>
                          <a class="carousel-control-prev" href="#article-{{ $article->id }}-carousel" role="button" data-bs-slide="prev">  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only"></span>
                          </a>
                          <a class="carousel-control-next" href="#article-{{ $article->id }}-carousel" role="button" data-bs-slide="next">  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only"></span>
                          </a>
                        </div>
                        <p class="h3 font-weight-bold">{{ $article->price }}&nbsp;ks</p>
                        <div class="col-8 mb-3">
                            {{ $article->body }}
                        </div>
                    </div>
                </div>

                </div>
                    @auth
                        @can('delete-article', $article)
                            <a href="#" class="btn btn-sm btn-danger text-light btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal">
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

                                <b class="text-warning">
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
                    <button  style="background-color: #000000; color: #FAA4BB;" class="btn btn-secondary">Add Review</button>
                </form>
            @endauth
            </div>

    </div>
    <script>
        document.getElementById('imagePopup').addEventListener('shown.bs.modal', function () {
          const imageUrl = document.querySelector('.carousel-item.active img').getAttribute('src');
          document.getElementById('popup-image').setAttribute('src', imageUrl);
      
          // Optional error handling
          document.getElementById('popup-image').onerror = function() {
            this.setAttribute('src', 'placeholder.gif'); // Set a placeholder image on error
            console.error('Failed to load image:', imageUrl);
          };
        });
      </script>
@endsection

{{-- <img src="http://localhost:8000/[&quot;storage\/articles\/1715574429_61IduqXygwL._AC_UY350_.jpg&quot;,&quot;storage\/articles\/1715574429_A_popular_model_of_ELLIOT_FRANZ\u00c9N.jpg&quot;,&quot;storage\/articles\/1715574429_s9-case-unselect-gallery-1-202403_FMT_WHH.jpg&quot;]" id="popup-image" alt="" class="img-fluid h-100 w-100"> --}}