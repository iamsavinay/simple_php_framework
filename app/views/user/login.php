<?php $this->setLayout('form_layout');?>
<?php $this->setSiteTitle('Sign In'); ?>
<?php $this->start('head'); ?>

<?php $this->end(); ?>

<?php $this->start('body'); ?>

<div class="form-body">
  <div class="form-container">
    <div class="form-title">Sign In</div>
    <form class="form login-form" action="" method="post">
      <div class="form-group">
        <div class="error-message"><?=$this->displayErrors?></div>
      </div>
      <div class="form-group">
        <label for="username">Username or Email:</label>
        <input type="text" name="username" placeholder="Email or Username">
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" name="password" placeholder="Password">
      </div>
      <div class="form-group">
        <input type="checkbox" name="remember_me" value="on" checked> Remember Me<br />
      </div>
      <div class="form-group">
        <input type="submit" class="btn-primary" name="Submit" value="Sign In">
        <a class="tplink" href="javascript:void(0)"> Sign In with Google</a>
        <a class="tplink" href="javascript:void(0)"> Sign In with Facebook</a>
        <a class="tplink" href="<?=PROOT.'user/register'?>">Sign Up</a>
      </div>
    </form>
  </div>
</div>

<?php $this->end(); ?>
