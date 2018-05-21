<?php $__env->startSection('header'); ?>
<link rel="stylesheet" href="/css/vendor/jquery.atwho.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<thread-view :thread="<?php echo e($thread); ?>" inline-template v-cloak>
    <div class="container">
        <div class="row">
            <div class="col-md-8 ">

                <?php echo $__env->make('threads._question', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

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

                        <button v-if="authorize('isAdmin')"
                            @click="toggleLock"
                            v-text="locked ? 'Unlock' : 'Lock'"
                            class="btn btn-default">Lock
                        </button>


                    </div>
                </div>

            </div>
        </div>


    </div>
</thread-view>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>