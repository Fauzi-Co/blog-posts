<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
  use HasFactory, Sluggable;

  // Table yang bisa diinsert
  // supaya bisa di insert pakau Class::create([])
  // protected $fillable = ['title', 'excerpt', 'body'];

  // kebalikan, ini yang ngga boleh di isis
  protected $guarded = ['id'];
  // solusi dari n + 1 query problem
  protected $with = ['category', 'author'];

  // Nama nya disamakan dengan yang akan dihubungkan
  // ini mau terhubung ke Category model dengan relasi belongsTo 
  public function scopeFilter($query, array $filters)
  {
    $query->when($filters['search'] ?? false, function ($query, $search) {
      return $query
        ->where('title', 'like', '%' . $search . '%')
        ->orWhere('body', 'like', '%' . $search . '%');
    });

    $query->when($filters['category'] ?? false, function ($query, $category) {
      return $query
        ->whereHas('category', function ($query) use ($category) {
          $query->where('slug', $category);
        });
    });

    $query->when($filters['author'] ?? false, fn ($query, $author) => $query->whereHas('author', fn ($query) => $query->where('username', $author)));
  }

  public function Category()
  {
    // Relasi One to One Post Ke Category
    return $this->belongsTo(Category::class);
  }

  public function author()
  {
    // terhubung ke User Model / Tabel User colum user_id
    return $this->belongsTo(User::class, 'user_id');
  }

  public function getRouteKeyName()
  {
    return 'slug';
  }

  public function sluggable(): array
  {
    return [
      'slug' => [
        'source' => 'title'
      ]
    ];
  }
}
