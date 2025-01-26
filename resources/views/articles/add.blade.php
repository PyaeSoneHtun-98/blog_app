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
        <a href="{{ url()->previous() }}" class="btn btn-sm mb-3" style="background-color: #000000; color: #FAA4BB;">
            <span class="glyphicon glyphicon-chevron-left"></span> Back
            </a>
        <form method="post" enctype="multipart/form-data">
            @csrf
            <input type="text" class="form-control mb-2" name="title" placeholder="Title">
            <textarea name="body" class="form-control mb-2" placeholder="Body"></textarea>
            <textarea name="price" class="form-control mb-2" placeholder="Price"></textarea>
            <input type="file" name="photos[]" class="form-control mb-2" placeholder="Upload Photo" multiple>
            <select name="category_id" class="form-select mb-2">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach

           
            </select>
            <button class="btn btn-primary">Add Article</button>
        </form>
    </div>
@endsection
