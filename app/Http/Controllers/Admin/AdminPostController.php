<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendAnnouncementMailJob;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class AdminPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->get();
        return view('admin.post.index')->with(['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $request->validate([
            'post' => ['required'],
            'plain_post' => ['required'],
        ]);

        $post = Post::create([
            'body' => $request->post,
            'plain_body' => $request->plain_post,
        ]);


        // Send the newly post annoucements to every users email
        $users = User::all();

        foreach ($users as $user ) {
            SendAnnouncementMailJob::dispatch(['to'=>$user->email, 'body'=>$post->body]);
        }
        
        return redirect()->route('admin.posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {        
        return view('admin.post.edit')->with(['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Post $post, Request $request)
    {        
        $request->validate([
            'post' => ['required'],
            'plain_post' => ['required'],
        ]);
        
        $post->body = $request->post;
        $post->plain_body = $request->plain_post;

        if ($post->save()) {
            $request->session()->flash('message', 'Post Updated Successfully!');
            $request->session()->flash('alert-class', 'alert-success');
        } else {
            $request->session()->flash('message', 'Post Updated Unsuccessfully!');
            $request->session()->flash('alert-class', 'alert-warning');
        }
        
        return redirect()->route('admin.posts.index');        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, Request $request)
    {        
        if ($post->delete()) {
            $request->session()->flash('message', 'Student Data Deleted Successfully!');
            $request->session()->flash('alert-class', 'alert-success');
        } else {
            $request->session()->flash('message', 'Student Data Deleted Unuccessfully!');
            $request->session()->flash('alert-class', 'alert-warning');
        }
        return redirect()->route('admin.posts.index');
    }
}