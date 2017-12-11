<?php $__env->startComponent('profiles.activities.activity'); ?>
    <?php $__env->slot('heading'); ?>    
        <?php echo e($profileUser->name); ?> replies to 
        <a href='<?php echo e($activity->subject->thread->path()); ?>'>
            <?php echo e($activity->subject->thread->title); ?>

        </a>
        <span>
            posted 
            <?php echo e($activity->subject->created_at->diffForHumans()); ?>

        </span>
    
    <?php $__env->endSlot(); ?>
    
    <?php $__env->slot('body'); ?>    
        <?php echo e($activity->subject->body); ?>

    <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

