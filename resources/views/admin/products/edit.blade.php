@extends('layouts.admin')

@section('admin-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Edit Product</h4>
</div>

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" 
                       class="form-control @error('title') is-invalid @enderror" 
                       id="title" 
                       name="title" 
                       value="{{ old('title', $product->title) }}" 
                       required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select class="form-select @error('category_id') is-invalid @enderror" 
                        id="category_id" 
                        name="category_id" 
                        required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" 
                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price (ks)</label>
                <input type="number" 
                       class="form-control @error('price') is-invalid @enderror" 
                       id="price" 
                       name="price" 
                       value="{{ old('price', $product->price) }}" 
                       required>
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="body" class="form-label">Description</label>
                <textarea class="form-control @error('body') is-invalid @enderror" 
                          id="body" 
                          name="body" 
                          rows="4" 
                          required>{{ old('body', $product->body) }}</textarea>
                @error('body')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Available Sizes</label>
                <div class="row g-3">
                    @foreach($sizes as $size)
                    <div class="col-auto">
                        <div class="form-check">
                            <input type="checkbox" 
                                   class="form-check-input" 
                                   name="sizes[]" 
                                   value="{{ $size->id }}" 
                                   id="size{{ $size->id }}"
                                   {{ in_array($size->id, old('sizes', $product->sizes->pluck('id')->toArray())) ? 'checked' : '' }}>
                            <label class="form-check-label" for="size{{ $size->id }}">
                                {{ $size->name }}
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
                @error('sizes')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="photos" class="form-label">Product Photos</label>
                <input type="file" 
                       class="form-control @error('photos') is-invalid @enderror" 
                       id="photos" 
                       name="photos[]" 
                       multiple 
                       accept="image/*">
                @error('photos')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">You can select multiple images. Supported formats: JPG, PNG, GIF</small>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Product</button>
            </div>
        </form>
    </div>
</div>
@endsection 