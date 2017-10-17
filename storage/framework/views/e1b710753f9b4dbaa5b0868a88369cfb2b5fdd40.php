<?php $__empty_1 = true; $__currentLoopData = $threads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $thread): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="panel panel-default">
        <div class="panel-heading level">
            <div class="flex">

                <h4 >
                    <a href="<?php echo e($thread->path()); ?>">
                        <?php if(auth()->check() && $thread->hasUpdatesFor(auth()->user())): ?>
                            <strong>
                                <?php echo e($thread->title); ?>

                            </strong>
                        <?php else: ?>
                            <?php echo e($thread->title); ?>


                        <?php endif; ?>
                    </a>
                </h4>

                <h5>
                    Posted by <a href="<?php echo e(route('profile', $thread->owner)); ?>"><?php echo e($thread->owner->name); ?></a>
                </h5>
            </div>

            <a href="<?php echo e($thread->path()); ?>">
                <strong><?php echo e($thread->replies_count); ?> <?php echo e(str_plural('reply',$thread->replies_count)); ?> </strong>
            </a>
        </div>
        <div class="panel-body">
                <div class="body"> <?php echo e(nl2br($thread->body)); ?> </div>

                <hr>
        </div>

        <div class="panel-footer">
            <?php echo e($thread->visits()->count()); ?> visites
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <p>There are no results</p>
<?php endif; ?>
