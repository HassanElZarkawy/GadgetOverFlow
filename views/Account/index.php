<link rel="stylesheet" href="<?php echo $root ?>assets/css/login.css">
<div class="login-form">
  <h1>Vini</h1>
  <div class="form-group ">
    <input type="text" class="form-control" placeholder="Username " id="UserName">
    <i class="fa fa-user"></i>
  </div>
  <div class="form-group log-status">
    <input type="password" class="form-control" placeholder="Password" id="Passwod">
    <i class="fa fa-lock"></i>
  </div>
  <span class="alert">Invalid Credentials</span>
  <a class="link" href="#">Lost your password?</a>
 <button type="button" class="log-btn" >Log in</button>
</div>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

<script  src="<?php echo $root ?>assets/js/login.js"></script>