<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use Storage;

class AlbumController extends Controller
{
    public function list_albums()
    {
        $dir = public_path('/images');
        $files = array_diff(scandir($dir), array('..', '.'));
        
        return view('galleries',['albums' => $files]);
    }

    //Stores all the uploaded pictures in public folder
    public function store(Request $request)
    {
        $this->validate($request, [
            'coverPic' => 'required',
            'filename' => 'required',
            'filename.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if($request->hasfile('filename'))
        {
            foreach($request->file('filename') as $image)
            {
                $folderName = $request->title;
                $coverPic = $request->coverPic;
                $coverPicName = $coverPic->getClientOriginalName();
                $coverPic->move(public_path().'/images/'. $folderName . '/main/', $coverPicName);
                if($image != null || $image != "")
                {
                    $name=$image->getClientOriginalName();
                    $image->move(public_path().'/images/'. $folderName . '/', $name);
                }  
            }
        }
        
        $request->albumName = $folderName;
        return $this->read_one($request);
    }

    //Add new pictures in edit album view
    //Modified store method
    public function add_pic_in_edit(Request $request)
    {
        $this->validate($request, [
            'filename' => 'required',
            'filename.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if($request->hasfile('filename'))
        {
            foreach($request->file('filename') as $image)
            {
                $folderName = $request->title;
                $name=$image->getClientOriginalName();
                $image->move(public_path().'/images/'. $folderName . '/', $name);
                $newPicNames[] = $name;  
            }
        }
        
        $request->albumName = $request->title;
        return $this->read_one($request);
    }

    //Returns the album edit view
    public function read_one(Request $request)
    {
        $albumName = $request->albumName;
        $album = public_path('/images/'. $albumName);
        $files = array_diff(scandir($album), array('..', '.'));
        $coverPicFolder = public_path('/images/'. $albumName . '/main/');
        $coverPicFile = array_diff(scandir($coverPicFolder), array('..', '.'));
        $allPic = array();
        $resArray = array_merge($allPic, $coverPicFile);
        foreach($files as $f)
        {
            $data = explode('.', $f);
            if(array_values($data)[0] != 'main')
            {
                array_push($resArray, $f);
                
            }
            elseif(array_values($data)[0] == 'main')
            {
                if (($key = array_search($f, $files)) !== false) {
                    unset($files[$key]);
                }
            }
        }
        
        $mainPic = array_values($resArray)[0];
        $path = '/images/' .  $albumName;
        $coverPath = '/images/'. $albumName . '/main/';
        return view('test', ['mainPic' => $mainPic,'album' => $files, 'path' => $path, 'title' => $albumName, 'coverPath' => $coverPath]);
    }

    public function edit(Request $request)
    {
        $folderName = $request->title;
        $coverPicName = $request->main;
        $albumPicsNames = $request->pics;

        //Reorder the specific folders
        $album = public_path('/images/'. $folderName);
        $coverPicFolder = public_path('/images/'. $folderName . '/main/');
        foreach($albumPicsNames as $name)
        {
            if($coverPicName != null)
            {
                if(file_exists($album . '/'. $coverPicName))
                {
                    File::move($album . '/'. $coverPicName, $coverPicFolder . $coverPicName);
                    $coverPicName = null;
                }
                elseif(file_exists($coverPicFolder . $coverPicName))
                {
                    $coverPicName = null;
                }
            }
            
            if(file_exists($coverPicFolder . $name))
            {
                File::move($coverPicFolder . $name, $album . '/'. $name);
            }  
        }

        return redirect('/galleries');
    }

    public function delete_album(Request $request)
    {
        //Delete from public folder
        $albumName = $request->albumName;
        $album = public_path('/images/'. $albumName);
        File::deleteDirectory($album);

        return $this->list_albums();
    }

    public function delete_picture(Request $request)
    {
        //The variables
        $reqAlbumName = $request->albumName;
        $picName = $request->picName;
        $data = explode('/', $reqAlbumName);
        $albumName = $data[count($data)-1];

        //Delete from public folder
        $album = public_path('/images/'. $albumName);
        if(\file_exists($album . '/' . $picName))
        {
            unlink($album . '/' . $picName);
        }
        else
        {
            unlink($album . '/main/' . $picName);
        }
        
        $reqPicName = explode('/', $request->albumName);
        $request->albumName = $reqPicName[count($reqPicName)-1];
        $request->alb = $request->albumName;

        
        return $this->read_one($request);
    }
}
