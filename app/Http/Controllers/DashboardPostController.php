<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DashboardPostController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //automatis
    return view('dashboard.posts.index', [
      'posts' => Post::where('user_id', auth()->user()->id)->get(),
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('dashboard.posts.create', [
      "categories" => Category::all(),
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    // save img upload
    // dan mereturn path filenya
    // return $request->file('image')->store('post-images');

    // Validasi Data Post
    $validatedData = $request->validate([
      'title' => 'required|max:255',
      'slug' => 'required|unique:posts',
      'category_id' => 'required',
      // tipe file biar ga dikira string
      'image' => 'image|file|max:1024',
      'body' => 'required',
    ]);

    // jika ada file maka akan menyimpan dan memvalidasi data
    if ($request->file('image')) {
      $validatedData['image'] = $request->file('image')->store('post-images');
    }

    // menambahkan User ID;
    $validatedData['user_id'] = auth()->user()->id;

    // membuat slug dari body dengan limir huruf 200 buah, dengan fungsi Str::limit($string, $limit, '...');
    $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 200);

    // Insert ke db tabel post
    Post::create($validatedData);

    // redirect dengan mengirimkan data
    return redirect('/dashboard/posts')->with('success', 'New post has ben added');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Post  $post
   * @return \Illuminate\Http\Response
   */
  public function show(Post $post)
  {
    return view('dashboard.posts.show', [
      'post' => $post,
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Post  $post
   * @return \Illuminate\Http\Response
   */
  public function edit(Post $post)
  {
    // View Edit
    return view('dashboard.posts.edit', [
      "post" => $post,
      "categories" => Category::all(),
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Post  $post
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Post $post)
  {
    // Validate update data post

    $rules = [
      'title' => 'required|max:255',
      'category_id' => 'required',
      'image' => 'image|mimes:jpg,png,jpeg,gif,svg|file|max:1024',
      'body' => 'required',
    ];


    // jika slug beda maka akan di validasi
    if ($request->slug != $post->slug) {
      $rules['slug'] = "required|unique:posts";
    }

    $validatedData = $request->validate($rules);

    // jika ada file maka akan menyimpan dan memvalidasi data
    if ($request->file('image')) {
      // Hapus file yang dulu jika ada
      if ($post->image) {
        // Static method untuk menghapus file gambar
        Storage::delete($post->image);
      }
      $validatedData['image'] = $request->file('image')->store('post-images');
    }

    // menambahkan User ID;
    $validatedData['user_id'] = auth()->user()->id;

    // membuat slug dari body dengan limir huruf 200 buah, dengan fungsi Str::limit($string, $limit, '...');
    $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 200);

    // Insert ke db tabel post
    Post::where('id', $post->id)->update($validatedData);

    // redirect dengan mengirimkan data
    return redirect('/dashboard/posts')->with('success', 'Post has ben updated');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Post  $post
   * @return \Illuminate\Http\Response
   */
  public function destroy(Post $post)
  {
    if ($post->image) {
      // Static method untuk menghapus file gambar
      Storage::delete($post->image);
    }

    // Delete data from db
    Post::destroy($post->id);

    // redirect dengan mengirimkan data
    return redirect('/dashboard/posts')->with('success', 'Post has ben deleted');
  }

  public function checkSlug(Request $request)
  {
    $slug = SlugService::createSlug(Post::class, 'slug', $request->title);

    return response()->json([
      'slug' => $slug,
    ]);
  }
}
