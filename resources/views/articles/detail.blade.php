@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Product Images Column -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body p-2">
                    @if($article->photos)
                        <?php
                            try {
                                $photoUrls = json_decode($article->photos);
                                $firstImageUrl = $photoUrls[0] ?? null;
                            } catch (Exception $e) {
                                $firstImageUrl = null;
                                $photoUrls = [];
                            }
                        ?>
                        @if($firstImageUrl)
                            <div class="image-container bg-secondary rounded">
                                <img src="{{ asset('storage/' . $firstImageUrl) }}" 
                                     class="main-image" 
                                     alt="{{ $article->title }}">
                            </div>
                            
                            <!-- Thumbnail Images -->
                            @if(count($photoUrls) > 1)
                                <div class="thumbnail-container mt-2">
                                    @foreach($photoUrls as $photo)
                                        <img src="{{ asset('storage/' . $photo) }}" 
                                             class="thumbnail-image" 
                                             onclick="changeMainImage('{{ asset('storage/' . $photo) }}')"
                                             alt="Product thumbnail">
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <div class="image-container bg-secondary rounded">
                                <img src="{{ asset('placeholder.jpg') }}" 
                                     class="main-image" 
                                     alt="No image available">
                            </div>
                        @endif
                    @else
                        <div class="image-container bg-secondary rounded">
                            <img src="{{ asset('placeholder.jpg') }}" 
                                 class="main-image" 
                                 alt="No image available">
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Details Column -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="card-title mb-3">{{ $article->title }}</h2>
                    
                    <div class="price-section mb-4 text-light">
                        <span class="badge bg-primary fs-5">
                            <i class="fas fa-tag me-2"></i>
                            {{ $article->price }} ks
                        </span>
                    </div>

                    <div class="product-meta mb-4">
                        <div class="d-flex align-items-center mb-2 text-muted">
                            <i class="fas fa-user me-2"></i>
                            <span>Posted by {{ $article->user ? $article->user->name : 'Unknown' }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-2 text-muted">
                            <i class="fas fa-tshirt me-2"></i>
                            <span>Category: {{ $article->category ? $article->category->name : 'Unknown' }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-2 text-muted">
                            <i class="far fa-clock me-2"></i>
                            <span>{{ $article->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    <div class="description-section mb-4">
                        <h5 class="mb-3 text-light">
                            <i class="fas fa-info-circle me-2"></i>
                            Description
                        </h5>
                        <p class="text-muted">{{ $article->body }}</p>
                    </div>

                    @if($article->sizes->isNotEmpty())
                        <div class="mb-3">
                            <strong class="text-light">Available Sizes:</strong>
                            <div class="d-flex gap-2 mt-2">
                                @foreach($article->sizes as $size)
                                    <span class="badge bg-primary text-light">{{ $size->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @auth
                        @if(auth()->user()->id == $article->user_id || auth()->user()->hasRole(['admin', 'editor']))
                            <div class="action-buttons d-flex gap-2">
                                @can('edit articles')
                                    <a href="{{ url("/articles/edit/$article->id") }}" 
                                       class="btn btn-primary">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>
                                @endcan
                                
                                @can('delete articles')
                                    <form action="{{ url("/articles/delete/$article->id") }}" 
                                          method="post" 
                                          class="d-inline">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-danger" 
                                                onclick="return confirm('Are you sure to delete?')">
                                            <i class="fas fa-trash me-1"></i> Delete
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Comments Section -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-4 text-light">
                        <i class="fas fa-comments me-2"></i>
                        Reviews ({{ count($article->comments) }})
                    </h5>

                    @auth
                        <form action="{{ url('/comments/add') }}" method="post" class="mb-4">
                            @csrf
                            <input type="hidden" name="article_id" value="{{ $article->id }}">
                            <div class="mb-3">
                                <textarea name="content" 
                                         class="form-control" 
                                         placeholder="Write your review..." 
                                         rows="3"></textarea>
                            </div>
                            <button class="btn btn-primary">
                                <i class="fas fa-paper-plane me-1"></i> 
                                Add Review
                            </button>
                        </form>
                    @endauth

                    @foreach($article->comments as $comment)
                        <div class="comment-item mb-3 p-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-circle text-primary me-2"></i>
                                    <span class="text-light">{{ $comment->user->name }}</span>
                                </div>
                                <small class="text-muted">
                                    <i class="far fa-clock me-1"></i>
                                    {{ $comment->created_at->diffForHumans() }}
                                </small>
                            </div>
                            <p class="mb-2 text-light">{{ $comment->content }}</p>
                            @auth
                                @can('delete-comment', $comment)
                                    <div class="text-end">
                                        <a href="{{ url("/comments/delete/$comment->id") }}" 
                                           class="btn btn-icon text-danger"
                                           onclick="return confirm('Are you sure to delete this comment?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                @endcan
                            @endauth
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.main-image {
    width: 100%;
    aspect-ratio: 1 / 1;  /* Make it square */
    object-fit: contain;  /* Show full image without cropping */
    background-color: var(--bg-secondary);  /* Background for non-square images */
    border-radius: 8px;
}

.thumbnail-container {
    overflow-x: auto;
    padding: 10px 0;
    display: flex;
    gap: 10px;
}

.thumbnail-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
    border: 2px solid transparent;
    flex-shrink: 0;  /* Prevent thumbnails from shrinking */
}

.thumbnail-image:hover {
    transform: scale(1.05);
    border-color: var(--primary);
}

.comment-item {
    border: 1px solid var(--border-color);
    border-radius: 8px;
    background-color: var(--card-bg);
}

.comment-item p {
    color: var(--text-light) !important;
    opacity: 0.9;
}

.comment-item .text-muted {
    color: var(--text-muted) !important;
    opacity: 0.8;
}

.btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
}

.btn-danger:hover {
    background-color: #bb2d3b;
    border-color: #b02a37;
}

.text-danger {
    color: #ff4d4d !important;
}

.text-danger:hover {
    color: #ff3333 !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .main-image {
        max-height: 400px;  /* Limit height on mobile */
    }
    
    .thumbnail-image {
        width: 60px;
        height: 60px;
    }
}

.card-title, h5.text-light {
    color: var(--text-light) !important;
}

.text-muted {
    color: var(--text-muted) !important;
    opacity: 0.9;
}

p.text-muted {
    color: var(--text-light) !important;
    opacity: 0.8;
}

/* Update form placeholder color */
.form-control::placeholder {
    color: var(--text-muted);
    opacity: 0.7;
}

.btn-icon {
    padding: 0;
    background: none;
    border: none;
    line-height: 1;
    transition: transform 0.2s;
}

.btn-icon:hover {
    transform: scale(1.1);
}
</style>

<script>
function changeMainImage(src) {
    document.querySelector('.main-image').src = src;
}
</script>
@endsection

{{-- <img src="http://localhost:8000/[&quot;storage\/articles\/1715574429_61IduqXygwL._AC_UY350_.jpg&quot;,&quot;storage\/articles\/1715574429_A_popular_model_of_ELLIOT_FRANZ\u00c9N.jpg&quot;,&quot;storage\/articles\/1715574429_s9-case-unselect-gallery-1-202403_FMT_WHH.jpg&quot;]" id="popup-image" alt="" class="img-fluid h-100 w-100"> --}}