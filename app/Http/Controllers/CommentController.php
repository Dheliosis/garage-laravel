<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\EnabledRequest;
use App\Models\Annoucement;
use App\Models\Comment;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class CommentController extends Controller
{
    public function store(CreateCommentRequest $request,  Annoucement $annoucement)
    {
        $user =$request->user();
        $comment = new Comment([
            'content' => $request->get('content'),
            'annoucement_id' => $annoucement->id,
            'enabled' => true
        ]);

        $user->comments()->save($comment);
        return back();
    }

    public function displayUpdate(Comment $comment)
    {
        return view ('annoucements.comments.update',['comment'=>$comment]);
    }

    public function update(CreateCommentRequest $request ,Comment $comment)
    {
//        dd($comment);
        $comment->update([
            'content' => $request->get('content'),
        ]);

        try {
            $annoucement = Annoucement::findOrFail($comment->annoucement_id);
            return redirect()->route("annoucement.show", $annoucement);
        }
        catch (Exception $e) {
            dd($e);
        }

    }

    public function delete(Comment $comment)
    {
        $comment->delete();
        return back();
    }

    public function updateEnabled(EnabledRequest $request, Comment $comment)
    {
        $comment->update([
            'enabled'=> $request->get('enabled')
        ]);
        return back();
    }
}
