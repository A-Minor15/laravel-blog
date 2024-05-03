<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    private $comment;

    public function __construct(Comment $comment) {
        $this->comment = $comment;
    }

    public function store($post_id, Request $request){
        $request->validate([
            'comment' => 'required|min:1|max:150'
        ]);

        $this->comment->user_id = Auth::user()->id; //owner of the comment
        $this->comment->post_id = $post_id;          //post being commented on
        $this->comment->body = $request->comment;   //the actual comment
        $this->comment->save();                     // Save the comment into Db

        return redirect()->back(); //go back to the same page
    }

    public function destroy($id) {
        $this->comment->destroy($id);
        return redirect()->back();
    }
}
