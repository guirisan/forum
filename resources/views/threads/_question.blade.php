
{{-- Editing question --}}
<div class="panel panel-default" v-if="editing">
    <div class="panel-heading">
        <div class="level">

            <div class="form-group">
                <input type="text" class="form-control" v-model="form.title">
            </div>


        </div>
    </div>

    <div class="panel-body">
        <div class="form-group">
            <textarea rows="10" class="form-control" v-model="form.body"></textarea>
        </div>
    </div>

    <div class="panel-footer" >

        <div class="level">

            <button class="btn btn-xs level-item" @click="resetForm">Cancel</button>
            <button class="btn btn-xs btn-primary level-item" @click="update">Update</button>

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
                posted: <span v-text="title"></span>
            </span>


        </div>
    </div>

    <div class="panel-body" v-text="body">
    </div>

    <div class="panel-footer" v-if="authorize('owns',thread)">
        <button class="btn btn-xs" @click="editing = true">Edit</button>
    </div>
</div>
