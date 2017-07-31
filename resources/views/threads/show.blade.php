@extends('layouts.app')

@section('content')
<thread-view :initial-replies-count={{ $thread->replies_count }} inline-template>
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


                <replies :data="{{ $thread->replies }}" 
                    @added="repliesCount++"
                    @removed="repliesCount--">
                    </replies>

                {{-- {{ $replies->links() }} --}}



            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        Thread published {{ $thread->created_at->diffForHumans() }} by 
                        <a href="#">{{ $thread->owner->name}}</a>, and has 
                        <span v-text="repliesCount"></span> 
                        {{ str_plural('comment', $thread->replies_count) }}
                    </div>
                </div>

            </div>
        </div>


    </div>
</thread-view>
@endsection
