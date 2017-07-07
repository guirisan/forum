@component('profiles.activities.activity')
    @slot('heading')    
        {{ $profileUser->name }} replies to 
        <a href='{{ $activity->subject->thread->path() }}'>
            {{ $activity->subject->thread->title }}
        </a>
        <span>
            posted 
            {{ $activity->subject->created_at->diffForHumans() }}
        </span>
    
    @endslot
    
    @slot('body')    
        {{ $activity->subject->body }}
    @endslot
@endcomponent

