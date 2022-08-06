<?php

namespace App\Models;

class Post
{
    private static $blog_posts = [
        [
            "title" => "Judul 1",
            "slug" => "judul1",
            "author" => "Jefri Nic",
            "body" => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nobis iusto a ab quae facilis, qui repellendus nemo. Nulla ipsa exercitationem fuga? Inventore omnis quisquam voluptate quis dolorum ut ab debitis."
        ],
        [
            "title" => "Judul 2",
            "slug" => "judul2",
            "author" => "Indir Nic",
            "body" => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nobis iusto a ab quae facilis, qui repellendus nemo. Nulla ipsa exercitationem fuga? Inventore omnis quisquam voluptate quis dolorum ut ab debitis."
        ],
        [
            "title" => "Judul 3",
            "slug" => "judul3",
            "author" => "Halim Nic",
            "body" => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nobis iusto a ab quae facilis, qui repellendus nemo. Nulla ipsa exercitationem fuga? Inventore omnis quisquam voluptate quis dolorum ut ab debitis."
        ]
    ];

    public static function all()
    {
        // dibungkus dalam collect supaya bisa dipakai firstWHere, Find, dll
        return collect(self::$blog_posts);
    }

    public static function find($slug)
    {
        $posts = static::all();
        // $post = [];

        // foreach ($posts as $p) {
        //     if ($p["slug"] == $slug) {
        //         $post = $p;
        //     }
        // }

        // return $post;
        return $posts->firstWhere('slug', $slug);
    }
}
