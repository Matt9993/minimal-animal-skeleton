<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    public function index() 
    { 
        $posts = \App\Post::all();
    }

    function list_all()
    {
        $posts = \App\Post::orderBy('created_at')->get();
        
        return view('list-posts', ['posts' => $posts]);
    }

    function read_one(Request $request)
    {
        $post = \App\Post::find($request->id);
        $title = $post->title;
        $content = $post->description; 
        return view('edit-post', ['postId' => $request->id,'title' => $title, 'content' => $content]);
    }

    function add_post(Request $request)
    {
        $post = new Post;
        $post->title = $request->title;
        $post->description = $request->content;
        $post->save();
    
        return redirect('/list-posts');
    }

    function update_data(Request $request)
    {
        $post = \App\Post::find($request->id);
        if ($request->title == null || $request->title == ""){
            $request->title = $post->title;
        }
        if ($request->content == null || $request->content == ""){
            $request->content = $post->content;
        }
        
        $post->update(['title' => $request->title, 'description' => $request->content]);

        return redirect('/list-posts');
    }

    function delete_data(Request $request)
    {
        $post = \App\Post::find($request->id);
        $post->delete();
        return view('home');
    }
}
