<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Album;
use App\Photo;
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

    //Stores all the uploaded pictures in public folder and in db
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
                $name=$image->getClientOriginalName();
                $image->move(public_path().'/images/'. $folderName . '/', $name);
                $data[] = $coverPicName;  
                $data[] = $name;  
            }
        }

        $album= new Album();
        $album->title = json_encode($request->title);
        $album->save();

        $photo = new Photo();
        $photo->albumId = $album->id;
        $photo->filename=json_encode($data);
        $photo->save();
        
        
        $request->albumName = $folderName;
        return $this->read_one($request);
    }

    //Read an album and it's pictures from db
    //Returns the album edit view
    public function read_one(Request $request)
    {
        $albumName = $request->albumName;
        // Get the specified album from db
        $dbAlbum = DB::table('albums')
        ->where('title', 'LIKE', '"' . $albumName . '"')
        ->get();
        $dbAlbumId;
        foreach($dbAlbum as $d)
        {
            $dbAlbumId = $d->id;
        }

        //With the AlbumId get the photos of that album from db
        $dbPhotoNames = Photo::where('albumId', $dbAlbumId)->get();
        $dbAlbumPhotoNames = $dbPhotoNames[0]['filename'];
        $picNames = array();
        $data = trim($dbAlbumPhotoNames, '[');
        $data = trim($data, ']');
        $names = explode(',', $data);
        foreach($names as $n)
        {
            $nam = str_replace('"', "", $n);
            array_push($picNames, $nam);
        }
        $album = public_path('/images/'. $albumName);
        $coverPicFolder = '/images/'. $albumName . '/main/';
        $mainPic = array_values($picNames)[0];
        foreach (array_keys($picNames, $mainPic) as $key) {
            unset($picNames[$key]);
        }
        
        $path = '/images/' .  $albumName;
        return view('test', ['mainPic' => $mainPic,'album' => $picNames, 'path' => $path, 'title' => $albumName, 'coverPath' => $coverPicFolder]);
    }

    public function edit(Request $request)
    {
        error_log('edit');
        $folderName = $request->title;
        $coverPicName = $request->main;
        $albumPicsNames = $request->pics;

        //Get Album from db
        $dbAlbum = DB::table('albums')
        ->where('title', 'LIKE', '"' . $folderName . '"')
        ->get();
        $dbAlbumId;
        foreach($dbAlbum as $d)
        {
            $dbAlbumId = $d->id;
        }
        error_log('album retrieved');
        //Delete the original photos
        $delPhoto = new Photo();
        $delPhoto->albumId = $dbAlbumId;
        Photo::where('albumId', $delPhoto->albumId)->delete();
        error_log('deleted photos from db');

        //Create new photos in db with the album id
        $data[] = $coverPicName;
        foreach($albumPicsNames as $name)
        {
            $data[] = $name;
        }
         
        $photo = new Photo();
        $photo->albumId = $dbAlbumId;
        $photo->filename=json_encode($data);
        $photo->save();
        error_log('created new photos in db');
        //Reorder the specific folder
        $album = public_path('/images/'. $folderName);
        $coverPicFolder = public_path('/images/'. $folderName . '/main/');
        foreach($albumPicsNames as $name)
        {
            error_log('in foreach');
            if($coverPicName != null)
            {
                error_log('if-1');
                if(\file_exists($album . $coverPicName))
                {
                    error_log('if-2');
                    File::move($album . $coverPicName, $coverPicFolder . $coverPicName);
                    $coverPicName = null;
                }
                elseif(file_exists($coverPicFolder . $coverPicName))
                {
                    error_log('elseif');
                    $coverPicName = null;
                }
            }
            
            if(file_exists($coverPicFolder . $name))
            {
                error_log('if-albumpics');
                File::move($coverPicFolder . $name, $album . $name);
            }  
        }
        error_log('after foreach');


        return $this->list_albums();
    }

    public function delete_album(Request $request)
    {
        //Delete from public folder
        $albumName = $request->albumName;
        $album = public_path('/images/'. $albumName);
        File::deleteDirectory($album);

        //Delete from db
        $dbAlbum = DB::table('albums')
        ->where('title', 'LIKE', '"' . $albumName . '"')
        ->get();
        $dbAlbum->delete();
        return $this->list_albums();
    }

    public function delete_picture(Request $request)
    {
        //The variables
        $reqAlbumName = $request->albumName;
        $picName = $request->picName;
        $data = explode('/', $reqAlbumName);
        $albumName = $data[count($data)-1];
        //Delete from db
        // Get the specified album from db
        $dbAlbum = DB::table('albums')
        ->where('title', 'LIKE', '"' . $albumName . '"')
        ->get();
        $dbAlbumId;
        foreach($dbAlbum as $d)
        {
            $dbAlbumId = $d->id;
        }
        
        //With the AlbumId get the photos of that album from db
        $dbPhotoNames = Photo::where('albumId', $dbAlbumId)->get();
        $dbAlbumPhotoNames = $dbPhotoNames[0]['filename'];
        $picNames = array();
        $data = trim($dbAlbumPhotoNames, '[');
        $data = trim($data, ']');
        $names = explode(',', $data);
        foreach($names as $n)
        {
            $nam = str_replace('"', "", $n);
            array_push($picNames, $nam);
        }
        //Delete from pics array 
        foreach (array_keys($picNames, $picName) as $key) {
            unset($picNames[$key]);
        }
        $photo = new Photo();
        $photo->albumId = $dbAlbumId;
        Photo::where('albumId', $photo->albumId)->delete();

        $newPhoto = new Photo();
        $newPhoto->albumId = $dbAlbumId;
        $newPhoto->filename=json_encode($picNames);
        $newPhoto->save();

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
