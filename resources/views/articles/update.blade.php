@extends('layouts.app');



@section('content')



    <div class="container" style="max-width: 600px">

        <!-- errors is global variable and all the error will be in this variable -->

        @if ($errors->any())
            <div class="alert alert-warning">

                @foreach ($errors->all() as $msg)
                    {{ $msg }}
                @endforeach

            </div>
        @endif

        <form action="{{ url('/articles/edit') }}" method="post" enctype="multipart/form-data">

            @csrf

            <input type="hidden" name = "id" value="{{ $article->id }}">

            <input name="title" type="text" class="form-control mb-2" value="{{ $article->title }}">
            <input type="file" name="photo" class="form-control mb-2" placeholder="Upload Photo">
            <textarea name="body" class="form-control mb-2">{{ $article->body }}</textarea>

            <select name="category_id" class="form-select mb-3">

                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $article->category->id == $category->id ? 'selected' : '' }}>

                        {{ $category->name }}

                    </option>
                @endforeach

            </select>

            <button class="btn btn-primary">Update Article</button>

        </form>

    </div>



@endsection
