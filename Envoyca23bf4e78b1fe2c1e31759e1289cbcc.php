

<?php $__container->servers(['web' => 'rozi@192.168.56.69' => ['password' => '123']]); ?>

<?php /* envoy password */ ?>



<?php $__container->startTask('deploy'); ?>
    less /etc/passwd
<?php $__container->endTask(); ?>
