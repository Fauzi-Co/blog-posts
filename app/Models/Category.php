<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Join ke tabel post
    public function posts()
    {
        // One to Many
        // Relasi nya 
        // Satu kategori boleh banyak post
        return $this->hasMany(Post::class);
    }
}
