
{{-- Editing question --}}
<div class="panel panel-default" v-if="editing">
    <div class="panel-heading">
        <div class="level">

            <div class="form-group">
                <input type="text" value="{{ $thread->title }}" class="form-control">
            </div>


        </div>
    </div>

    <div class="panel-body">
        <div class="form-group">
            <textarea rows="10" class="form-control ">{{ $thread->body }}</textarea>
        </div>
    </div>

    <div class="panel-footer" >

        <div class="level">

            <button class="btn btn-xs level-item" @click="editing = false">Done</button>
            <button class="btn btn-xs btn-primary level-item" @click="editing = false">Update</button>

            @can ('update', $thread)
                <form method="POST" action="{{ $thread->path() }}" class="mr-a">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                    <button type="submit" class="btn btn-link">Delete</button>
                </form>
            @endcan
        </div>

    </div>
</div>



{{-- Viewing question --}}
<div class="panel panel-default" v-else>
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


        </div>
    </div>

    <div class="panel-body">
        {{ $thread->body }}
    </div>

    <div class="panel-footer" >
        <button class="btn btn-xs" @click="editing = true">Edit</button>
    </div>
</div>
