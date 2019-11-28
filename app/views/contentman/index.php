<?php $this->setLayout('contentman_layout');?>
<?php $this->setSiteTitle('Home');?>

<?php $this->start('head'); ?>
<meta content="some/meta" />
<?php $this->end(); ?>

<?php $this->start('body'); ?>

<h1 class="page-title">Content Management</h1>

<div class="global-content">
    <div class="main-content">
        <a href="<?=PROOT?>contentman/news"> Manage News</a>
        <a href="<?=PROOT?>contentman/college"> Manage Colleges</a>
        <a href="<?=PROOT?>contentman/exam"> Manage Exams</a>
    </div>
    <div class="related-content">Related Content</div>
</div>

<?php $this->end(); ?>
