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
        return view('edit-post', ['post' => $post]);
    }

    function add_post(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'topic' => 'required|max:255',
            'description' => 'required|max:1000',
        ]);
        
        $post = new Post;
        $post->title = $request->title;
        $post->topic = $request->topic;
        $post->description = $request->description;
        $post->save();
    
        return redirect('/list-posts');
    }

    function update_data(Request $request)
    {
        $post = \App\Post::find($request->id);
        if ($request->title == null || $request->title == ""){
            $request->title = $post->title;
        }
        if ($request->topic == null || $request->topic == ""){
            $request->topic = $post->topic;
        }
        if ($request->description == null || $request->description == ""){
            $request->description = $post->description;
        }
        
        $post->update(['title' => $request->title, 'topic' => $request->topic,
        'description' => $request->description]);

        return view('home');
    }

    function delete_data(Request $request)
    {
        $post = \App\Post::find($request->id);
        $post->delete();
        return view('home');
    }
}
