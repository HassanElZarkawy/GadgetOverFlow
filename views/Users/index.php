<?php $users = $viewModel->get('users'); ?>

<link rel="stylesheet" href="<?php echo $root ?>assets/css/users.css">

<?php foreach ($users as $user) { ?>
  <div class="col-md-3">
    <div class="card">
      <div class="card-header">
        <a href="<?php echo $root . 'user/' . $user->UserId; ?>">
          <div class="card-header__avatar">
            <img style="height: 100%; width:100%;" class="img img-responsive" src="<?php echo $user->UserImage; ?>" />
          </div>
        </a>
        <a class="card-header__follow" href="<?php echo $root . 'user/' . $user->UserId; ?>">Profile</a>
      </div>
      <!-- Content-->
      <div class="card-content">
        <div class="card-content__username"><a href="<?php echo $root . 'user/' . $user->UserId; ?>"><strong><?php echo $user->DisplayName; ?></strong></a></div>
      </div>
      <!-- Footer-->
      <div class="card-footer">
        <div class="card-footer__pens"> 
          <span><a href="<?php echo $root. '/user/questions/' . $user->UserId; ?>"><?php echo $user->TotalQuestions; ?></a></span>
          <div class="label"><a href="<?php echo $root. '/user/questions/' . $user->UserId; ?>">Questions</a></div>
        </div>
        <div class="card-footer__followers"> 
          <span><?php echo $user->TotalAnswers; ?></span>
          <div class="label">Answers</div>
        </div>
        <div class="card-footer__following"> 
          <span><?php echo $user->Points; ?></span>
          <div class="label">Points</div>
        </div>
      </div>
    </div>
    <br />
  </div>
<?php } ?>