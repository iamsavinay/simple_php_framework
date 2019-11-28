<?php $this->setLayout('form_layout');?>
<?php $this->setSiteTitle('Sign Up'); ?>
<?php $this->start('head'); ?>

<?php $this->end(); ?>

<?php $this->start('body'); ?>

<div class="form-body">
  <div class="form-container">
    <div class="form-title">Sign Up</div>
    <form class="form login-form" action="" method="post">
      <div class="form-group">
        <div class="error-message"><?=$this->displayErrors?></div>
      </div>
      <div class="form-group">
        <label for="fname">First Name:</label>
        <input type="text" name="fname" value="<?=$this->post['fname']?>">
      </div>
      <div class="form-group">
        <label for="lname">Last Name:</label>
        <input type="text" name="lname" value="<?=$this->post['lname']?>">
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="text" name="email" value="<?=$this->post['email']?>">
      </div>
      <div class="username">
        <label for="username">Username:</label>
        <input type="text" name="username" value="<?=$this->post['username']?>">
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" name="password" value="<?=$this->post['password']?>">
      </div>
      <div class="form-group">
        <label for="confirm">Confirm Password:</label>
        <input type="password" name="confirm" value="<?=$this->post['confirm']?>">
      </div>
      <div class="form-group">
        <input type="submit" class="btn-primary" name="Submit" value="Sign Up">
      </div>
      <div class="form-group">
        <a class="tplink" href="<?=PROOT.'user/login'?>">Sign In</a>
      </div>
    </form>
  </div>
</div>

<?php $this->end(); ?>
