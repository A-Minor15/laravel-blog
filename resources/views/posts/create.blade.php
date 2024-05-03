@extends('layouts.app')

@section('title', 'Create Post')

@section('content')
    <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data" autocomplete="off">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label text-secondary">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{old('title')}}" placeholder="Enter title here.." autofocus>
            @error('title')
                <p class="text-danger small">{{$message}}</p>
            @enderror
            
        </div>
        <div class="mb-3">
            <label for="body" class="form-label text-secondary">Body</label>
            <textarea name="body" id="body" rows="5" class="form-control" placeholder="Start writing...">{{ old('body') }}</textarea>
            @error('body')
                <p class="text-danger small">{{$message}}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="image" class="form-label text-secondary">Image</label>
            <input type="file" name="image" id="image" class="form-control" value="{{old('image')}}" aria-describedby="image-info">
            <div class="form-text" id="image-info">
                Acceptable formats are: jpeg, jpg, gif only.<br>
                Maximum file size: 1048Kb.
            </div>
            @error('image')
                <p class="text-danger small">{{$message}}</p>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary px-5">Post</button>
    </form>
@endsection