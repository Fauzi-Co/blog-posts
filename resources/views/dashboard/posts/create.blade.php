@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Create New Post</h1>
  <hr>
</div>

<div class="col-lg-6 pb-5">
  {{-- mengarah ke store di DashboardPostController --}}
  <form action="/dashboard/posts" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
      <label for="title" class="form-label">Title</label>
      <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="title" required autofocus value="{{ old('title') }}">
      @error('title')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="slug" class="form-label">Slug</label>
      <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" id="slug" placeholder="slug" readonly required value="{{ old('slug') }}">
      @error('slug')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror
    </div>
    
    <div class="mb-3">
      <label for="category_id" class="form-label">Category</label>
      <select name="category_id" id="category_id" class="form-control">
        @foreach ($categories as $category)
        <option value="{{ $category->id }}" {{ ($category->id == old('category_id') ? "selected" : "") }}>{{ $category->name }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="image" class="form-label">Post Image</label>
      <img src="" class="img-preview img-fluid mb-3 col-sm-4" alt="">
      <input class="form-control @error('image') is-invalid @enderror" type="file" name="image" id="image" onchange="previewImg(this)">
      @error('image')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror
    </div>
    
    <div class="mb-3">
      <label for="body" class="form-label">Body</label>
      @error('body')
      <small class="text-danger">
        {{ $message }}
      </small>   
      @enderror
      <input id="body" type="hidden" name="body" value="{{ old('body') }}" required>
     <trix-editor input="body"></trix-editor>
    </div>

    <button type="submit" class="btn btn-primary btn-sm">Create Post</button>
    
  </form>
</div>

<script>
  const title = document.querySelector("#title");
  const slug = document.querySelector("#slug");

  title.addEventListener('change', () => {
    fetch('/dashboard/posts/checkSlug?title=' + title.value)
    .then(res => res.json())
    .then(res => {
      slug.value = res.slug
      });
  })

  document.addEventListener('trix-file-accept', (e) => {
    e.preventDefault();
  })


  let previewImg = (e) => {
    const imgPreview = document.querySelector('.mb-3 .img-preview')
    imgPreview.classList.add('d-block')

    let img = new FileReader()
    img.readAsDataURL(e.files[0])

    img.onload = function(imgSrc) {
      imgPreview.src = imgSrc.target.result
    }
  }
</script>

@endsection
