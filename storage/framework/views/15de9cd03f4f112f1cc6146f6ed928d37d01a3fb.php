<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <?php echo $__env->make('threads._list', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <?php echo e($threads->links()); ?>

        </div>

        <div class="col-md-4">
            <div class="panel panel-default">

                <div class="panel-heading">
                    Search
                </div>

                <div class="panel-body">
                    <form method="GET" action="/threads/search">
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Search terms..." name="q">
                        </div>

                        <div class="form-group">
                            <button class="btn btn-default" type="submit">Search</button>
                        </div>

                    </form>
                </div>
            </div>

            <?php if(count($trending)): ?>
                <div class="panel panel-default">

                    <div class="panel-heading">
                        Trending threads
                    </div>

                    <div class="panel-body">
                        <ul class="list-group">
                        <?php $__currentLoopData = $trending; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $thread): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item">
                                <a href="<?php echo e(url($thread->path)); ?>">
                                    <?php echo e($thread->title); ?>

                                </a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>