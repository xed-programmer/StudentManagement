<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $paginate_num = 10;
        $posts = Post::latest()->paginate($paginate_num);
        return view('announcement')->with(['posts' => $posts, 'paginate_num' => $paginate_num]);
    }
}