<?php $this->setLayout('global_layout');?>
<?php $this->setSiteTitle('College Talash | Exams');?>

<?php $this->start('head'); ?>

<!-- <link rel="stylesheet" href="<?=PROOT.'css/news1.css'?>"> -->

<?php $this->end(); ?>


<?php $this->start('body'); ?>

<div class="ws-cnt">
    <div class="bg_img"><img src="/img/geometric.jpg" alt=""></div>
    <div class="ws-content">
    <h3>Search Exams, Important Dates, Results</h3>
    <form id="ws-form" action="<?=PROOT?>search" method="get">
        <input type="hidden" name="f" value="news">
        <input type="text" name="q" id="ws-input">
        <button id="ws-submit">Search</button>
    </form>
    </div>
    <script>
        document.querySelector('#ws-submit').addEventListener('click', function(event){
            event.preventDefault();
        if(document.querySelector('#ws-input').value != ''){
            console.log(document.querySelector('#ws-input').value);
            document.querySelector('#ws-form').submit();
        }
        });
    </script>
</div>



<?php $this->end(); ?>
