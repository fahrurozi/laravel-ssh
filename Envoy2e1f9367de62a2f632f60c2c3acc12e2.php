

<?php $__container->servers(['web' => 'rozi@192.168.56.69':'123']); ?>

<?php $__container->startTask('deploy'); ?>
    less /etc/passwd
<?php $__container->endTask(); ?>
