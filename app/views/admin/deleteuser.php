<?php $this->setLayout('admin_layout');?>
<?php $this->setSiteTitle('Delete User');?>

<?php $this->start('head'); ?>

<meta content="some/meta" />
<script src="<?=PROOT?>js/jquery.js"></script>

<?php $this->end(); ?>

<?php $this->start('body'); ?>

<h1 class="page-title">User Details</h1>

<div class="global-content">
    <div class="main-content">
        <div class="tool-cont">
            DELETE USER
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
                <input type="hidden" name="id" id="id" value="<?=$this->userdata->id?>">
                <div class="form-group">
                    <label for="username">Username: </label>
                    <div class="message">
                        Please type the Username: <b> <?=$this->userdata->username?></b> below to confirm Delete.
                    </div>
                    <input type="text" name="username" id="username" value="">
                    <div class="help">Required. Max 150 characters (Unique) </div>
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