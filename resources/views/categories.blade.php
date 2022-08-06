@extends('layouts.main')

@section('container')
<h1 class="mb-4">Halaman Posts</h1>

<div class="container">
  <div class="row">
    @foreach ($categories as $category)
    <div class="col-md-4 mb-3">
      <a href="/posts?category={{ $category->slug }}">
        <div class="card bg-dark text-white border-0">
          <img class="card-img" src="https:source.unsplash.com/600x300?{{ $category->name }}" alt="Card image">
          <div class="card-img-overlay d-flex align-items-center justify-content-center p-0">
            <h5 class="card-title flex-fill text-center p-3" style="background-color: rgba(0, 0, 0, .3)">{{ $category->name }}</h5>
          </div>
        </div>
      </a>
    </div>
    @endforeach
  </div>
</div>

@endsection

