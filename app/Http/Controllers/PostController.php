<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class PostController extends Controller
{
  public function index()
  {
    $title = '';
    if (request('category')) {
      $category = Category::firstWhere('slug', request('category'));

      $title = ' in ' . $category->name;
    }

    if (request('author')) {
      $author = User::firstWhere('username', request('author'));

      $title = ' by ' . $author->name;
    }

    return view('posts', [
      "title" => "All Posts" . $title,
      "active" => "posts",
      // Dapat dari Model
      // "posts" => Post::all()
      // with eager loading, supaya tidak terjadi n + 1 query problem, solusi menggunakan with()
      "posts" => Post::latest()->filter(request(['search', 'category', 'author']))->paginate(4)->withQueryString(),
    ]);
  }

  public function detail(Post $post)
  {

    return view('post', [
      "title" => "Detail Post",
      "active" => "posts",

      // "post" => Post::find($post)
      // Langsung di ambil query dari model Post tanpa harus mengambil id dulu dari parameter,
      // Perhatikan Parameter harus sama
      "post" => $post
    ]);
  }
}
