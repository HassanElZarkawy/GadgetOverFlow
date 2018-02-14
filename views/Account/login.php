<link rel="stylesheet" href="<?php echo $root ?>assets/css/login.css">
<?php if (Tokenizer::exists('login-error')) { ?>
  <div class="alert alert-success">
    <strong>Invalid Attempt: </strong> <?php echo Tokenizer::get('login-error'); Tokenizer::delete('login-error'); ?>
  </div>
  <br />
<?php } ?>
<form action="<?php echo $root; ?>account/loguser" method="post">
<input type="hidden" id="Token" name="Token" value="<?php echo Session::get('_token'); ?>">
  <div class="login-form">
    <h1>Login</h1>
    <br />
    <div class="form-group ">
        <input type="text" class="form-control full-width" placeholder="Username " id="Username" name="Username">
        <i class="fa fa-user"></i>
    </div>
    <div class="form-group log-status">
        <input type="password" class="form-control full-width" placeholder="Password" id="Passwod" name="Password">
        <i class="fa fa-lock"></i>
    </div>
    <a class="link" href="#">Lost your password?</a>
    <input type="submit" class="log-btn" value="Login">
  </div>
</form>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
