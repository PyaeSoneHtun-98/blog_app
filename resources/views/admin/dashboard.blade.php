@extends('layouts.admin')

@section('admin-content')
<div class="tab-content">
    <!-- Dashboard Overview -->
    <div class="tab-pane fade show active" id="dashboard-overview">
        <h4 class="mb-4 text-dark">Dashboard Overview</h4>
        
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <a href="{{ route('admin.products.index') }}" class="text-decoration-none">
                    <div class="stat-card">
                        <div class="stat-card-content">
                            <i class="fas fa-tshirt stat-icon"></i>
                            <div>
                                <h3>{{ $stats['articles'] }}</h3>
                                <p>Total Products</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('admin.categories.index') }}" class="text-decoration-none">
                    <div class="stat-card">
                        <div class="stat-card-content">
                            <i class="fas fa-tags stat-icon"></i>
                            <div>
                                <h3>{{ $stats['categories'] }}</h3>
                                <p>Categories</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                    <div class="stat-card">
                        <div class="stat-card-content">
                            <i class="fas fa-users stat-icon"></i>
                            <div>
                                <h3>{{ $stats['users'] }}</h3>
                                <p>Users</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('admin.reviews.index') }}" class="text-decoration-none">
                    <div class="stat-card">
                        <div class="stat-card-content">
                            <i class="fas fa-comments stat-icon"></i>
                            <div>
                                <h3>{{ $stats['comments'] }}</h3>
                                <p>Reviews</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent Products Table -->
        <div class="bg-white rounded p-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-dark">Recent Products</h5>
                <a href="{{ url('/admin/products') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\Article::latest()->take(5)->get() as $article)
                            <tr>
                                <td>{{ $article->title }}</td>
                                <td>{{ $article->category->name ?? 'N/A' }}</td>
                                <td>{{ $article->price }} ks</td>
                                <td>{{ $article->created_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ url("/articles/detail/$article->id") }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $article->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $article->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Management -->
    <div class="tab-pane fade" id="products-management">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Products Management</h4>
            <a href="{{ url('/articles/add') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add New Product
            </a>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\Article::latest()->paginate(10) as $article)
                            <tr>
                                <td>{{ $article->title }}</td>
                                <td>{{ $article->category->name ?? 'N/A' }}</td>
                                <td>{{ $article->price }} ks</td>
                                <td>{{ $article->created_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ url("/articles/edit/$article->id") }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ url("/articles/delete/$article->id") }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Management -->
    <div class="tab-pane fade" id="categories-management">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Categories Management</h4>
            <a href="{{ url('/categories/add') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add Category
            </a>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Products Count</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\Category::all() as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->articles->count() }}</td>
                                <td>{{ $category->created_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ url("/categories/edit/$category->id") }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ url("/categories/delete/$category->id") }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Management -->
    <div class="tab-pane fade" id="users-management">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Users Management</h4>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\User::all() as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach($user->roles as $role)
                                        <span class="badge bg-primary">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                                <td>{{ $user->created_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if(auth()->id() != $user->id)
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Management -->
    <div class="tab-pane fade" id="reviews-management">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Reviews Management</h4>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>User</th>
                                <th>Review</th>
                                <th>Posted</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\Comment::latest()->get() as $comment)
                            <tr>
                                <td>{{ $comment->article->title }}</td>
                                <td>{{ $comment->user->name }}</td>
                                <td>{{ Str::limit($comment->content, 50) }}</td>
                                <td>{{ $comment->created_at->diffForHumans() }}</td>
                                <td>
                                    <form action="{{ url("/comments/delete/$comment->id") }}" method="GET" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 