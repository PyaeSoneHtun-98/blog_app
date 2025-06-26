@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('info'))
        <div class="alert alert-info">
            {{ session('info') }}
        </div>
    @endif

    @auth
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title text-light mb-3">
                    <i class="fas fa-plus-circle me-2"></i>
                    Add New Category
                </h5>
                <form method="post" action="{{ url('/categories/add') }}">
                    @csrf
                    <div class="row g-3 align-items-center">
                        <div class="col-md-6">
                            <input type="text" name="name" 
                                   class="form-control" 
                                   placeholder="Enter category name">
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Add
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endauth

    <div class="card">
        <div class="card-body">
            <h5 class="card-title text-light mb-4">
                <i class="fas fa-folder-open me-2"></i>
                Categories
            </h5>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Created At</th>
                            @auth
                                <th>Actions</th>
                            @endauth
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td class="text-muted">#{{ $category->id }}</td>
                                <td>
                                    <i class="fas fa-tag me-2 text-primary"></i>
                                    <span class="category-name">{{ $category->name }}</span>
                                </td>
                                <td>
                                    <i class="far fa-clock me-2 text-muted"></i>
                                    <span class="time-text">{{ $category->created_at->diffForHumans() }}</span>
                                </td>
                                @auth
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ url("/categories/edit/$category->id") }}" 
                                               class="btn btn-icon text-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ url("/categories/delete/$category->id") }}" 
                                               class="btn btn-icon text-danger"
                                               onclick="return confirm('Are you sure to delete?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                @endauth
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
/* Update these styles */
.table {
    margin-bottom: 0;
    color: var(--text-light);  /* Default table text color */
}

.table thead {
    background-color: var(--bg-secondary);
}

.table thead th {
    color: var(--primary);  /* Changed header color to pink */
    font-weight: 600;
    border-bottom: 2px solid var(--border-color);
    padding: 1rem;
}

.table tbody tr {
    transition: all 0.2s;
    border-color: var(--border-color);
}

.table tbody tr:hover {
    background-color: var(--hover-color);
}

.table td {
    color: var(--text-light);
    border-color: var(--border-color);
    vertical-align: middle;
    padding: 1rem;
}

/* Category name styling */
.category-name {
    color: var(--primary) !important;  /* Changed to pink to match theme */
    font-weight: 500;
}

/* Optional: Add hover effect */
tr:hover .category-name {
    color: var(--accent) !important;
}

/* Time text styling */
.time-text {
    color: var(--text-muted);
}

/* Alert styling */
.alert-info {
    background-color: var(--card-bg);
    border-color: var(--primary);
    color: var(--text-light);
}

/* Form styling */
.form-control {
    background-color: var(--bg-secondary);
    border-color: var(--border-color);
    color: var(--text-light);
}

.form-control:focus {
    background-color: var(--bg-secondary);
    border-color: var(--primary);
    color: var(--text-light);
    box-shadow: 0 0 0 0.25rem rgba(240, 140, 176, 0.15);
}

.form-control::placeholder {
    color: var(--text-muted);
    opacity: 0.7;
}

.btn-icon {
    padding: 0.3rem;
    background: none;
    border: none;
    line-height: 1;
    transition: transform 0.2s;
}

.btn-icon:hover {
    transform: scale(1.1);
}

.text-primary {
    color: var(--primary) !important;
}

.text-primary:hover {
    color: var(--accent) !important;
}

.text-danger {
    color: #ff4d4d !important;
}

.text-danger:hover {
    color: #ff3333 !important;
}
</style>
@endsection 