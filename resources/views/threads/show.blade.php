@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 ">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="#">
                        {{ $thread->owner->name}} 
                    </a>
                    posted:
                    <strong>
                        {{ $thread->title }}    
                    </strong>
                </div>

                <div class="panel-body">
                    {{ $thread->body }}
                </div>
            </div>
            
            @foreach ($thread->replies as $reply)
                @include('threads.reply')
            @endforeach

            @if (auth()->check())
            <form method="POST" action="{{ $thread->path() . '/replies' }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <textarea name="body" id="body" class="form-control" rows="5" required="required" placeholder="Comment something..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Comment</button>
            </form>
            @else
                <p class="text-center">
                    Please <a href="{{ route('login') }}">sign in</a> to participate
                </p>
            @endif
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    Thread published {{ $thread->created_at->diffForHumans() }} by 
                    <a href="#">{{ $thread->owner->name}}</a>, and has {{$thread->replies->count() }} replies.
                </div>
            </div>

        </div>
    </div>


</div>
@endsection
