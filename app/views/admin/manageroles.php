<?php $this->setLayout('admin_layout');?>
<?php $this->setSiteTitle('Manage Roles');?>

<?php $this->start('head'); ?>
<meta content="some/meta" />
<?php $this->end(); ?>

<?php $this->start('body'); ?>

<h1 class="page-title"> Administration </h1>

<div class="global-content">
    <div class="main-content">
        <a href="<?=PROOT?>/users">Manage Users</a>
        <a href="<?=PROOT?>/roles">Manage Roles</a>
    </div>
    <div class="related-content">Related Content</div>
</div>

<?php $this->end(); ?>
