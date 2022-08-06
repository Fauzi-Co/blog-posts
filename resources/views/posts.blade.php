@extends('layouts.main')

@section('container')
<h1 class="mb-4 text-center">{{ $title }}</h1>

<div class="row justify-content-center">
  <div class="col-6 mb-3">
    <form action="/posts">
      @if (request('category'))
         <input type="hidden" name="category" value="{{ request('category') }}"> 
      @endif
      @if (request('author'))
         <input type="hidden" name="author" value="{{ request('author') }}"> 
      @endif
      <div class="input-group mb-3">
        <button class="btn btn-outline-info" type="submit">Search</button>
        <input type="text" class="form-control" placeholder="Search..." aria-label="Example text with button addon" name="search" value="{{ request('search') }}">
      </div>
      
    </form>
  </div>
</div>


@if ($posts->count())
  <div class="card border-0 shadow mb-4"> 

    @if ($posts[0]->image)
      <div style="max-height: 350px; overflow:hidden" class="mt-3 mb-3">
        <img src="{{ asset('storage/'.$posts[0]->image) }}" alt="" style="width:100%">
      </div>
    @else
    <img src="https:source.unsplash.com/1200x400?{{ $posts[0]->category->name }}" class="card-img-top" alt="...">
    @endif

    
    <div class="card-body">
      <h3 class="card-title">
        <a href="/posts/{{ $posts[0]->slug }}" class="text-decoration-none text-dark">
          {{ $posts[0]->title }}
        </a>
      </h3>
      <p class="mb-0">
        <small>
          By. 
          <a href="/posts?author={{ $posts[0]->author->username }}" class="text-decoration-none text-secondary">
            {{ $posts[0]->author->name }}
          </a>
          
        <span class="text-muted">
           {{ $posts[0]->created_at->diffForHumans() }}
        </span>
        </small>
      </p>
      <p>
        <a href="/posts?category={{ $posts[0]->category->slug }}">
          <span class="badge bg-warning">
            {{ $posts[0]->category->name }}
          </span>
        </a>
      </p>
      <p class="card-text">{{ $posts[0]->excerpt }}</p>

      <a href="/posts/{{ $posts[0]->slug }}" class="text-decoration-none">Read more</a>
    </div>
  </div>

{{-- skip method, untuk melewati satu item di awal --}}
<div class="row">
  @foreach ($posts->skip(1) as $post)
  <div class="col-md-4 mb-3">
    <div class="card mb-4 overflow-hidden"> 
      <div class="position-absolute px-2 py-1" style="background-color: rgba(0, 0, 0, 0.3)">
        <small>
          <a href="/posts?category={{ $posts[0]->category->slug }}" class="text-decoration-none text-white">
            {{ $post->category->name }}
          </a>
        </small>
      </div>

      @if ($post->image)
        <img src="{{ asset('storage/'.$post->image) }}" alt="" style="width:100%">
      @else
      <img src="https:source.unsplash.com/600x400?{{ $post->category->name }}" class="card-img-top" alt="...">
      @endif

      
      <div class="card-body">
        <h3 class="card-title">
          <a href="/posts/{{ $post->slug }}" class="text-decoration-none text-dark">
            {{ $post->title }}
          </a>
        </h3>
        <p>
          <small>
            By. 
            <a href="/posts?author={{ $post->author->username }}" class="text-decoration-none text-secondary">
              {{ $post->author->name }}
            </a>, 
            <span class="text-muted">
             {{ $post->created_at->diffForHumans() }}
            </span>
          </small>
        </p>
        <p class="card-text">{{ $post->excerpt }}</p>
  
        <a href="/posts/{{ $post->slug }}" class="text-decoration-none">Read more</a>
      </div>
    </div>
  </div>
  @endforeach
</div>

@else
<p class="text-center fs-4">No Posts Found.</p>
@endif

<div class="d-flex justify-content-end">
  {{ $posts->links() }}
</div>

@endsection

