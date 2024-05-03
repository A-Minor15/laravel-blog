@extends('layouts.app')

@section('title', 'Home')

@section('content')
    @forelse ($all_posts as $post)
        <div class="mt-2 border border-2 rounded p-4">
            <a href="{{ route('post.show', $post->id) }}">
                <h2 class="h4">{{ $post->title }}</h2>
            </a>
            <h3 class="h6 text-muted">{{$post->user->name}}</h3>
            <p class="fw-light mb-3">{{ $post->body }}</p>
            <p class="text-danger small">Posted on {{$post->created_at->diffForHumans()}}</p>

            {{-- Action Buttons --}}

            @if (Auth::user()->id === $post->user->id)
                <div class="mt-2 text-end">
                    {{-- Edit --}}
                    <a href="{{ route('post.edit', $post->id) }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-pen"></i> Edit</a>

                    {{-- Delete --}}
                    <form action="{{ route('post.destroy', $post->id) }}" method="post" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i> Delete</button>
                    </form>
                </div>
            @endif

        </div>
    @empty
        <div style="margin-top: 100px">
            <h2 class="text-muted text-center">No Post Yet</h2>
            <p class="text-center">
                <a href="{{ route('post.create') }}" class="text-decoration-none">Create a new post</a>
            </p>
        </div>
    @endforelse
@endsection