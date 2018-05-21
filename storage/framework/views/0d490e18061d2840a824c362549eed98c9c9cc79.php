

<div class="panel panel-default" v-if="editing">
    <div class="panel-heading">
        <div class="level">

            <div class="form-group">
                <input type="text" value="<?php echo e($thread->title); ?>" class="form-control">
            </div>


        </div>
    </div>

    <div class="panel-body">
        <div class="form-group">
            <textarea rows="10" class="form-control "><?php echo e($thread->body); ?></textarea>
        </div>
    </div>

    <div class="panel-footer" >

        <div class="level">

            <button class="btn btn-xs level-item" @click="editing = false">Done</button>
            <button class="btn btn-xs level-item" @click="editing = false">Cancel</button>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $thread)): ?>
                <form method="POST" action="<?php echo e($thread->path()); ?>" class="mr-a">
                    <?php echo e(csrf_field()); ?>

                    <?php echo e(method_field('DELETE')); ?>


                    <button type="submit" class="btn btn-link">Delete</button>
                </form>
            <?php endif; ?>
        </div>

    </div>
</div>




<div class="panel panel-default" v-else>
    <div class="panel-heading">
        <div class="level">

            <img
                src="<?php echo e($thread->owner->avatar_path); ?>"
                alt="<?php echo e($thread->owner->name); ?>"
                width="25"
                height="25"
                class="mr-1">

            <span class="flex">
                <a href="<?php echo e(route('profile', $thread->owner)); ?>"> <?php echo e($thread->owner->name); ?> </a>
                posted: <strong><?php echo e($thread->title); ?></strong>
            </span>


        </div>
    </div>

    <div class="panel-body">
        <?php echo e($thread->body); ?>

    </div>

    <div class="panel-footer" >
        <button class="btn btn-xs" @click="editing = true">Edit</button>
    </div>
</div>
