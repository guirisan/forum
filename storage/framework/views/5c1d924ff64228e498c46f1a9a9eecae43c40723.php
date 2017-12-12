<?php $__env->startSection('header'); ?>
<link rel="stylesheet" href="/css/vendor/jquery.atwho.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<thread-view :data-replies-count="<?php echo e($thread->replies_count); ?>" :data-locked="<?php echo e($thread->locked); ?>" inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 ">
                <div class="panel panel-default">
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

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $thread)): ?>
                            <span>
                                <form method="POST" action="<?php echo e($thread->path()); ?>">
                                    <?php echo e(csrf_field()); ?>

                                    <?php echo e(method_field('DELETE')); ?>


                                    <button type="submit" class="btn btn-link">Delete</button>
                                </form>
                            </span>
                            <?php endif; ?>

                        </div>
                    </div>

                    <div class="panel-body">
                        <?php echo e($thread->body); ?>

                    </div>
                </div>


                <replies
                    @added="repliesCount++"
                    @removed="repliesCount--">
                </replies>


            </div>
            <div class="col-md-4">

                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>
                            Thread published <?php echo e($thread->created_at->diffForHumans()); ?> by
                            <a href="#"><?php echo e($thread->owner->name); ?></a>, and has
                            <span v-text="repliesCount"></span>
                            <?php echo e(str_plural('comment', $thread->replies_count)); ?>

                        </p>

                        <subscribe-button v-if="signedIn" :active="<?php echo e(json_encode($thread->isSubscribedTo)); ?>"></subscribe-button>

                        <button v-if="authorize('isAdmin') && !locked" @click="locked = true" class="btn btn-default">Lock</button>


                    </div>
                </div>

            </div>
        </div>


    </div>
</thread-view>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>