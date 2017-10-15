<?php $__env->startSection('content'); ?>

    <div class="container">
        <div class="row">
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-md-offset-2">
                <div class="page-header">
                    <h1>
                        <?php echo e($profileUser->name); ?>

                        <small>since <?php echo e($profileUser->created_at->diffForHumans()); ?></small>
                    </h1>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $profileUser)): ?>
                        <form method="POST" action="<?php echo e(route('avatar', $profileUser)); ?>" enctype="multipart/form-data">
                            <?php echo e(csrf_field()); ?>

                            <input name="avatar" type="file" class="form-input">
                            <button type="submit" class="btn btn-primary">Add avatar</button>
                        </form>
                    <?php endif; ?>


                    <img src="/storage/<?php echo e($profileUser->avatar()); ?>" alt="" width="200" height="200">
                </div>

                <?php $__empty_1 = true; $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    
                    <h3 class="page-header"><?php echo e($date); ?></h3>
                    <?php $__currentLoopData = $activity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(view()->exists("profiles.activities.{$record->type}")): ?>
                            <?php echo $__env->make("profiles.activities.{$record->type}", ['activity' => $record], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p>The user has no activity</p>
                <?php endif; ?>

                

            </div>
        </div>


    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>