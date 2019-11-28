<?php $this->setLayout('admin_layout');?>
<?php $this->setSiteTitle('Delete User');?>

<?php $this->start('head'); ?>

<meta content="some/meta" />
<script src="<?=PROOT?>js/jquery.js"></script>

<?php $this->end(); ?>

<?php $this->start('body'); ?>

<h1 class="page-title">Permanently Delete News</h1>

<div class="global-content">
    <div class="main-content">
        <div class="tool-cont">
            DELETE NEWS
        </div>
        <div class="content">
            <!-- error modal -->
            <div class="error-modal">
                <div>
                    <img src="<?=IROOT.'public/failed.gif'?>" alt="">
                </div>
            </div>

            <!-- success modal -->
            <div class="success-modal">
                <div>
                    <img src="<?=IROOT.'public/success.gif'?>" alt="">
                </div>
            </div>


            <form action="" id="deluser" class="form" method="post">
                <div class="form-caption">Confirm Delete</div>
                <div class="form-group">
                    <label for="username">ID: </label>
                    <div class="message">
                        Please type the ID : <b> <?=$this->resultdata->id?></b> below to confirm Delete.
                    </div>
                    <input type="text" name="id" id="id" value="">
                    <div class="help"> Important </div>
                </div>

                <div class="form-group">
                    <input type="submit" id="submitBtn" class="btn btn-red float-right" value="Confirm Delete">
                </div>
            </form>
        </div>
    </div>


    <div class="related-content">
        <div class="card1">

        </div>
    </div>
</div>

<?php $this->end(); ?>