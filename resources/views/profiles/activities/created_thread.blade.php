@component('profiles.activities.activity')
    @slot('heading')    
        {{ $profileUser->name }} publish
        <a href='{{ $activity->subject->path() }}'>
            {{ $activity->subject->title }}    
        </a>
        posted 
        {{ $activity->subject->created_at->diffForHumans() }}    
    @endslot

    @slot('body')    
        {{ $activity->subject->body }}
    @endslot
@endcomponent
