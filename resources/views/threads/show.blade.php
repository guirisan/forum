@extends('layouts.app')

@section('header')
<link rel="stylesheet" href="/css/vendor/jquery.atwho.css">
@endsection

@section('content')
<thread-view :thread="{{ $thread }}" inline-template v-cloak>
    <div class="container">
        <div class="row">
            <div class="col-md-8 ">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="level">

                            <img
                                src="{{ $thread->owner->avatar_path }}"
                                alt="{{ $thread->owner->name }}"
                                width="25"
                                height="25"
                                class="mr-1">

                            <span class="flex">
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


                <replies
                    @added="repliesCount++"
                    @removed="repliesCount--">
                </replies>


            </div>
            <div class="col-md-4">

                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>
                            Thread published {{ $thread->created_at->diffForHumans() }} by
                            <a href="#">{{ $thread->owner->name}}</a>, and has
                            <span v-text="repliesCount"></span>
                            {{ str_plural('comment', $thread->replies_count) }}
                        </p>

                        <subscribe-button v-if="signedIn" :active="{{ json_encode($thread->isSubscribedTo) }}"></subscribe-button>

                        <button v-if="authorize('isAdmin')"
                            @click="toggleLock"
                            v-text="locked ? 'Unlock' : 'Lock'"
                            class="btn btn-default">Lock
                        </button>


                    </div>
                </div>

            </div>
        </div>


    </div>
</thread-view>
@endsection
