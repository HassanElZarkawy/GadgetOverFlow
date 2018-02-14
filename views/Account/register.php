<link rel="stylesheet" href="<?php echo $root ?>assets/css/login.css">
<?php if (Tokenizer::exists('register-error')) { ?>
  <div class="alert alert-success">
    <strong>Invalid Attempt: </strong> <?php echo Tokenizer::get('register-error'); Tokenizer::delete('register-error'); ?>
  </div>
  <br />
<?php } ?>
<form action="<?php echo $root; ?>account/adduser" method="post">
<input type="hidden" id="Token" name="Token" value="<?php echo Session::get('_token'); ?>">
  <div class="login-form">
    <h1>Register</h1>
    <br />
    <div class="form-group ">
        <input type="text" class="form-control full-width" placeholder="Nickname " id="Nickname" name="Nickname">
        <i class="fa fa-user"></i>
    </div>
    <div class="form-group ">
        <input type="text" class="form-control full-width" placeholder="Email " id="Email" name="Email">
        <i class="fa fa-user"></i>
    </div>
    <div class="form-group log-status">
        <input type="password" class="form-control full-width" placeholder="Password" id="Passwod" name="Password">
        <i class="fa fa-lock"></i>
    </div>
    <div class="form-group log-status">
        <input type="password" class="form-control full-width" placeholder="Re-Password" id="RePasswod" name="RePassword">
        <i class="fa fa-lock"></i>
    </div>
    <a class="link" href="<?php echo $root . 'account/login'; ?>">already have account?</a>
    <input type="submit" class="log-btn" value="Register">
  </div>
</form>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
