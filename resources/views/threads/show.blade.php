@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 ">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="level">
                        <span class="flex">
                            {{-- <a href="/profiles/{{ $thread->owner->name }}"> --}}
                            <a href="{{ route('profile', $thread->owner) }}"> {{ $thread->owner->name}} </a>
                            posted: <strong>{{ $thread->title }}</strong>
                        </span>
                        @can ('update', $thread)
                        <span>
                            <form method="POST" action="{{ $thread->path() }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <button type="submit" class="btn btn-link">Delete</button>
                            </form>
                        </span>
                        @endcan
                        
                    </div>
                </div>

                <div class="panel-body">
                    {{ $thread->body }}
                </div>
            </div>

            @foreach ($replies as $reply)
                @include('threads.reply')
            @endforeach

            {{ $replies->links() }}

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
                    <a href="#">{{ $thread->owner->name}}</a>, and has {{$thread->replies_count }} 
                    {{ str_plural('comment', $thread->replies_count) }}
                </div>
            </div>

        </div>
    </div>


</div>
@endsection
