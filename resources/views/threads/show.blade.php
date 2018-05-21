@extends('layouts.app')

@section('header')
<link rel="stylesheet" href="/css/vendor/jquery.atwho.css">
@endsection

@section('content')
<thread-view :thread="{{ $thread }}" inline-template v-cloak>
    <div class="container">
        <div class="row">
            <div class="col-md-8" v-cloak>

                @include('threads._question')

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
