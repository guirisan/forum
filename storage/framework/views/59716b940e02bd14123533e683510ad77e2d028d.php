<?php $__env->startComponent('mail::message'); ?>
# One last step

Just need to confirm your adress.

<?php $__env->startComponent('mail::button', ['url' => url('/register/confirm?token=' . $user->confirmation_token)]); ?>
Confirm Email
<?php echo $__env->renderComponent(); ?>

Thanks,<br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
