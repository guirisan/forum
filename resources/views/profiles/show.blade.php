@extends ('layouts.app')

@section('content')
    
    <div class="container">
        <div class="row">
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-md-offset-2">
                <div class="page-header">
                    <h1>
                        {{ $profileUser->name }}
                        <small>since {{ $profileUser->created_at->diffForHumans() }}</small>
                    </h1>
                </div>

                @foreach ($threads as $thread)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="level">
                                <span class="flex">
                                    {{-- <a href="{{ $thread->path }}"> --}}
                                    {{-- {{ dd($thread)}} --}}
                                    <a href="#">
                                        {{ $thread->title }}    
                                    </a>
                                    {{-- </a>  --}}
                                </span>
                                <span>
                                    posted 
                                    {{ $thread->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>

                        <div class="panel-body">
                            {{ $thread->body }}
                        </div>
                    </div>
                @endforeach

                {{ $threads->links() }}

            </div>
        </div>


    </div>


@endsection
