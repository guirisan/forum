@extends ('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-md-offset-2">
                <div class="page-header">

                    <avatar-form :user="{{ $profileUser }}"></avatar-form>

                </div>

                @forelse ($activities as $date => $activity)
                    {{-- {{ dd($activities) }} --}}
                    <h3 class="page-header">{{ $date }}</h3>
                    @foreach ($activity as $record)
                        @if (view()->exists("profiles.activities.{$record->type}"))
                            @include("profiles.activities.{$record->type}", ['activity' => $record])
                        @endif
                    @endforeach
                @empty
                    <p>The user has no activity</p>
                @endforelse

                {{-- {{ $threads->links() }} --}}

            </div>
        </div>


    </div>


@endsection
