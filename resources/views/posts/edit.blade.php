@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
    <form action="{{ route('post.update', $post->id) }}" method="post" enctype="multipart/form-data" autocomplete="off">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <label for="title" class="form-label text-secondary">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{old('title', $post->title)}}" placeholder="Enter title here.." autofocus>
            @error('title')
                <p class="text-danger small">{{$message}}</p>
            @enderror
            
        </div>
        <div class="mb-3">
            <label for="body" class="form-label text-secondary">Body</label>
            <textarea name="body" id="body" rows="5" class="form-control" placeholder="Start writing...">{{ old('body', $post->body) }}</textarea>
            @error('body')
                <p class="text-danger small">{{$message}}</p>
            @enderror
        </div>
        <div class="row mb-3">
            <div class="col-6">
                <label for="image" class="form-label text-secondary">Image</label>
                <img src="{{ asset('/storage/images/' . $post->image) }}" alt="{{ $post->image }}" class="w-100 img-thumbnail">
                <input type="file" name="image" id="image" class="form-control mt-1" value="{{old('image')}}" aria-describedby="image-info">
                <div class="form-text" id="image-info">
                    Acceptable formats are: jpeg, jpg, gif only.<br>
                    Maximum file size: 1048Kb.
                </div>
                @error('image')
                    <p class="text-danger small">{{$message}}</p>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-warning px-5">Save</button>
    </form>
@endsection