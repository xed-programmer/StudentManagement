<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(10);

        return view('announcement')->with(['posts' => $posts]);
    }
}