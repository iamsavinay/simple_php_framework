<?php $this->setLayout('global_layout');?>
<?php $this->setSiteTitle('Dashboard');?>

<?php $this->start('head'); ?>
<meta content="some/meta" />
<?php $this->end(); ?>


<?php $this->start('body'); ?>

<h1 class="text-center"> This is your Dashboard. <?=$this->userinfo->username?> </h1>

<?php $this->end(); ?>
