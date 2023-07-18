<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banner;
use App\Blog;

class BlogController extends Controller
{
    function index()
    {
        $posts = Blog::all();
        return view('client.post.list', compact('posts'));
    }
}
