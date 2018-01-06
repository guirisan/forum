<?php $__env->startSection('header'); ?>
    <script src='https://www.google.com/recaptcha/api.js'></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Create a new thread
                </div>

                <div class="panel-body">
                <form action="/threads" method="POST" role="form">

                    <?php echo e(csrf_field()); ?>


                    <div class="form-group">
                        <label for="channel_id">Channel:</label>
                        <select name="channel_id" id="inputChannel_id" class="form-control" required>
                            <option value="">Select one...</option>
                            <?php $__currentLoopData = $channels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $channel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($channel->id); ?>" <?php echo e(old('channel_id') == $channel->id ? 'selected' : ''); ?>>
                                    <?php echo e($channel->slug); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" name="title" id="inputTitle" class="form-control" value="<?php echo e(old('title')); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="body">Body:</label>
                        <textarea name="body" id="inputBody" class="form-control" rows="10" required><?php echo e(old('body')); ?></textarea>
                    </div>

                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="6LcXtTwUAAAAAIqTxEO4DqEp2KhoeepRngsw7r7d"></div>
                    </div>

                    <div class="form-group">
                        <?php if(count($errors)): ?>
                            <ul class="alert alert-danger">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <?php echo e($error); ?>

                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Publish thread</button>
                    </div>

                </form>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>