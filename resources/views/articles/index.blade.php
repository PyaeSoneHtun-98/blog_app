@extends('layouts.app')

@section('content')
    <div class="container-fluid px-3">
        @if (session('info'))
            <div class="alert alert-info">
                {{ session('info') }}
            </div>
        @endif

        <div class="row gx-4">
            <!-- Filter Section -->
            <div class="col-lg-2 mb-4 pt-4">
                <div class="card border-0 shadow-sm sticky-top" style="top: 80px">
                    <div class="card-header text-white" style="background-color: #F08CB0;">
                        <i class="fas fa-filter me-2"></i>Filter Products
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/') }}" method="GET">
                            <div class="mb-3">
                                <label class="form-label text-white">Minimum Price (Ks)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                    <input type="number" class="form-control" name="min_price" 
                                           value="{{ request('min_price') }}" placeholder="0">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-white">Maximum Price (Ks)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                    <input type="number" class="form-control" name="max_price" 
                                           value="{{ request('max_price') }}" placeholder="Any">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-1"></i> Search
                            </button>
                            @if(request('min_price') || request('max_price'))
                                <a href="{{ url('/') }}" class="btn btn-outline-secondary w-100 mt-2">
                                    <i class="fas fa-times me-1"></i> Clear Filter
                                </a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content Section -->
            <div class="col-lg-10 mt-4">

                @if($articles->isEmpty())
                    <div class="alert alert-info d-flex align-items-center">
                        <i class="fas fa-info-circle me-2 fa-lg"></i>
                        <div>
                            No products found
                            @if(request('min_price') || request('max_price'))
                                for the selected price range
                                ({{ request('min_price', '0') }} Ks - {{ request('max_price', 'Any') }} Ks)
                            @endif
                        </div>
                    </div>
                @endif

                <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-4">
                    @foreach ($articles as $article)
                    <div class="col">
                        <div class="card h-100 shadow-sm" style="max-width: 320px; margin: 0 auto;">
                            <div class="position-relative">
                                @if ($article->photos)
                                    <?php
                                        try {
                                            $photoUrls = json_decode($article->photos);
                                            $firstImageUrl = $photoUrls[0] ?? null;
                                        } catch (Exception $e) {
                                            $firstImageUrl = null;
                                        }
                                    ?>
                                    @if ($firstImageUrl)
                                        <img src="{{ asset('storage/' . $firstImageUrl) }}" 
                                             class="card-img-top" 
                                             style="height: 200px; object-fit: cover;"
                                             alt="{{ $article->title }}">
                                    @else
                                        <img src="{{ asset('placeholder.jpg') }}" 
                                             class="card-img-top" 
                                             style="height: 200px; object-fit: cover;"
                                             alt="No image available">
                                    @endif
                                @else
                                    <img src="{{ asset('placeholder.jpg') }}" 
                                         class="card-img-top" 
                                         style="height: 200px; object-fit: cover;"
                                         alt="No image available">
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column p-3">
                                <h6 class="card-title mb-2" style="font-size: 0.9rem; line-height: 1.3;">
                                    {{ $article->title }}
                                </h6>
                                
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-primary">
                                        <i class="fas fa-tag me-1"></i>
                                        {{ $article->price }} ks
                                    </span>
                                    <small class="text-muted d-none d-md-block">
                                        <i class="far fa-clock me-1"></i>
                                        {{ $article->created_at->diffForHumans() }}
                                    </small>
                                </div>

                                <div class="small text-muted mb-2">
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="fas fa-user me-1 fa-sm"></i>
                                        <span class="text-truncate" style="font-size: 0.8rem;">{{ $article->user->name }}</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="fas fa-tshirt me-1 fa-sm"></i>
                                        <span class="text-truncate" style="font-size: 0.8rem;">{{ $article->category->name ?? 'Unknown' }}</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-comments me-1 fa-sm"></i>
                                        <span style="font-size: 0.8rem;">{{ count($article->comments) }} Reviews</span>
                                    </div>
                                </div>

                                <a href="{{ url("/articles/detail/$article->id") }}" 
                                   class="btn btn-primary btn-sm mt-auto py-1">
                                   <i class="fas fa-eye me-1"></i>
                                   View Details
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $articles->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
