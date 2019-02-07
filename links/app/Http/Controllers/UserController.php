<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{

    public function store(Request $request)
    {
        $this->validate($request, [
            'filename' => 'required',
            'filename.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        
        if($request->hasfile('filename'))
        {
            foreach($request->file('filename') as $image)
            {
            $name=$image->getClientOriginalName();
            $image->move(public_path().'/images/', $name);  
            $data[] = $name;  
            }
        }
    }
}