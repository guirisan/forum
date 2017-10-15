<?php $__env->startComponent('profiles.activities.activity'); ?>
    <?php $__env->slot('heading'); ?>    
        <?php echo e($profileUser->name); ?> publish
        <a href='<?php echo e($activity->subject->path()); ?>'>
            <?php echo e($activity->subject->title); ?>    
        </a>
        posted 
        <?php echo e($activity->subject->created_at->diffForHumans()); ?>    
    <?php $__env->endSlot(); ?>

    <?php $__env->slot('body'); ?>    
        <?php echo e($activity->subject->body); ?>

    <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
