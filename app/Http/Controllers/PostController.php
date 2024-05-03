<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth; //This is an Authentication class file, responsible for authentication
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{   
    const LOCAL_STORAGE_FOLDER = 'public/images/'; //This is the location what we want to save our image
    private $post;

    public function __construct(Post $post){
        $this->post = $post;
    }

    public function index(){
        $all_posts = $this->post->latest()->get();
        return view('posts.index')->with('all_posts', $all_posts); //Open the homepage
    }

    # Open the create.blade.php
    public function create(){
        return view('posts.create');
    }

    # Insert/Store data to the Posts Table
    public function store(Request $request){
        # 1. Validate the data
        $request->validate([
            'title' => 'required|min:1|max:50',
            'body' => 'required|max:1000',
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:1048'
        ]);
        # Note:    MIME - Multipurpose Internet  Mail Extensions

        # 2. Save the data into the Db
        $this->post->user_id = Auth::user()->id; //Auth::user()->id ---- this is current logged-in user
        $this->post->title = $request->title; // title of the post from the form
        $this->post->body  = $request->body;  //content of the post
        $this->post->image  = $this->saveImage($request); //handle the image separately
        $this->post->save(); //insert the data into the database

        # 3. Back to the homepage
        return redirect()->route('index');
    }

    public function saveImage($request){
        # rename the the image into current time to avoid overwriting
        $image_name = time() . "." . $request->image->extension();
        //$image_name = 1245878636.jpeg

        // save the image into storage/app/public/images
        $request->image->storeAs(self::LOCAL_STORAGE_FOLDER, $image_name);

        return $image_name;
    }

    public function show($id){
        $post = $this->post->findOrFail($id);
        return view('posts.show')->with('post', $post);
    }

    public function edit($id){
        $post = $this->post->findOrFail($id);

        # Note: In the URL bar: If the id of the logged-user is not equal to the id of the 
        # user who is owner of the post, then we will redirect them to the previous page
        if ($post->user->id != Auth::user()->id) {
            return redirect()->back();
        }

        return view('posts.edit')->with('post', $post);
    }

    public function update(Request $request, $id){
        # 1. Validate the data first
        $request->validate([
            'title' => 'required|min:1|max:50',
            'body' => 'required|min:1|max:1000',
            'image' => 'mimes:jpeg,jpg,png,gif|max:1048'
        ]);

        $post = $this->post->findOrFail($id);
        $post->title = $request->title;
        $post->body  = $request->body;

        # If there is a new image...
        if ($request->image) {
            #1. Delete the previous emage that's already in the local storage
            $this->deleteImage($post->image);

            #2. Move the new image into the local storage
            $post->image = $this->saveImage($request);
            //$post->image = '1235864555.jpeg'
        }

        $post->save(); //inserting the new updated details into the Db
        return redirect()->route('post.show', $id);
    }

    public function deleteImage($image_name){
        $image_path = self::LOCAL_STORAGE_FOLDER . $image_name;
        //$image_path = "/public/images/163785425.jpeg"

        if (Storage::disk('local')->exists($image_path)) {
            Storage::disk('local')->delete($image_path);
        }
    }

    public function destroy($id){
        $post = $this->post->findOrFail($id);
        $this->deleteImage($post->image);
        $post->delete();

        return redirect()->back();
    }
}
