<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function store($channelId, Thread $thread)
    {
        $this->validate(request(), ['body' => 'required']);

        $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id() 
        ]);

        return back()
            ->with('flash', 'Your reply has been received.');
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();
        
        return back()
            ->with('flash','Reply has been deleted');
    }
}
