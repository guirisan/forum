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

                @foreach ($activities as $date => $activity)
                    {{-- {{ dd($activities) }} --}}
                    <h3 class="page-header">{{ $date }}</h3>
                    @foreach ($activity as $record)
                        @include("profiles.activities.{$record->type}", ['activity' => $record])
                    @endforeach

                @endforeach

                {{-- {{ $threads->links() }} --}}

            </div>
        </div>


    </div>


@endsection
