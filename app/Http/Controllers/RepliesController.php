<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use App\Inspections\Spam;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }
    
    public function store($channelId, Thread $thread, Spam $spam)
    {
        $this->validateReply();

        $spam->detect(request('body'));


        $reply = $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        if (request()->expectsJson()) {
            return $reply->load('owner');
        }

        return back()
            ->with('flash', 'Your reply has been received.');
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $this->validateReply();
        
        // $reply->update(['body' => request('body')]);
        $reply->update(request(['body']));
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();
        if (request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }
        return back()
            ->with('flash', 'Reply has been deleted');
    }

    public function validateReply()
    {
        $this->validate(request(), ['body' => 'required']);
        resolve(Spam::class)->detect(request('body'));
    }
}
