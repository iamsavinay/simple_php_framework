<?php $this->setLayout('default_layout');?>
<?php $this->setSiteTitle('Error!');?>

<?php $this->start('head'); ?>
<meta name="error" content="not-found" />
<?php $this->end(); ?>

<?php $this->start('body'); ?>

<a href="" class="blue" id="goback"> &lt; Go Back </a>
<h1> Error! Requested page not found.</h1>
<a class="red" href="<?=PROOT?>home"> Go back to Home</a>
<script>
    document.querySelector("#goback").href = document.referrer;
</script>

<?php $this->end(); ?>


