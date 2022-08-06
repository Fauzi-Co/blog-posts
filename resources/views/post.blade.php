@extends('layouts.main')

@section('container')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <h2 class="mb-0">{{ $post->title }}</h2>
      <p>
        <small>By. <a href="/posts?author={{ $post->author->username }}" class="text-decoration-none text-secondary">{{ $post->author->name }}</a>
        <a href="/posts?category={{ $post->category->slug }}">
          <span class="badge bg-warning">{{ $post->category->name }}</span>
        </a>
        </small>
      </p>

      <img src="https:source.unsplash.com/1200x400?{{ $post->category->name }}" alt="" class="img-fluid mb-3">
      
      {{-- Tanpa htmlspeacialChar --}}
      <article class="mb-3">
        {!! $post->body !!}
      </article>
    
      <a href="/posts">Back</a>
    </div>
  </div>
</div>
  
@endsection