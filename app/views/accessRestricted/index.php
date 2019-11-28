<?php $this->setLayout('default_layout');?>
<?php $this->setSiteTitle('Restricted!');?>

<?php $this->start('head'); ?>
<meta name="error" content="not-found" />
<?php $this->end(); ?>

<?php $this->start('body'); ?>

<a href="" class="blue" id="goback"> &lt; Go Back </a>
<h1> Sorry! You are not allowed to visit this page.</h1>
<a class="red" href="<?=PROOT?>home"> Go back to Home</a>
<script>
    document.querySelector("#goback").href = document.referrer;
</script>


<?php $this->end(); ?>
