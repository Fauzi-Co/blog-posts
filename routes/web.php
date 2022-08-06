<?php

use App\Http\Controllers\DashboardPostController;
use App\Http\Controllers\AdminCategoryController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return view('home', [
    "active" => "home",
    "title" => "Home"
  ]);
});

Route::get('/about', function () {
  return view('about', [
    "title" => "About",
    "active" => 'about',
    "name" => "Fauzi",
    "email" => "eexxeezy@gamil.com",
    "image" => "foto.jpg"
  ]);
});

// Mengarahkan ke Post Controller dengan method index
Route::get('/posts', [PostController::class, 'index']);

// where slug 
Route::get('posts/{post:slug}', [PostController::class, 'detail']);

Route::get('/categories', function () {
  // dd(Category::all());
  return view('categories', [
    'title' => "Categories",
    'active' => 'categories',
    'categories' => Category::all()
  ]);
});

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');

Route::post('/login', [LoginController::class, 'authenticate']);

Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/dashboard', function () {
  return view('dashboard.index', [
    'title' => 'Dashboard',
    'active' => "Dashboard"
  ]);
})->middleware('auth');

Route::get('/dashboard/posts/checkSlug', [DashboardPostController::class, 'checkSlug'])->middleware('auth');

// Dashboard untuk blogger
Route::resource('/dashboard/posts', DashboardPostController::class)->middleware('auth');

// Dashboard untuk admin mengubah category
Route::resource('/dashboard/categories/', AdminCategoryController::class)->except('show');
