<?php $questions = $viewModel->get('questions'); $stats = $viewModel->get('stats'); $user = $viewModel->get('user'); $recent = $viewModel->get('recent') ?>
  <div class="row">
    <div class="col-md-9">  
      <h1 style="color: #ff7361 !important"><?php echo 'Questions asked by ' . $user->DisplayName . ' (' . count($questions) . '/' . $user->TotalQuestions . ')' ?></h1>
      <div class="tabs-warp question-tab">
        <div class="tab-inner-warp">
          <div class="tab-inner">
            <?php foreach ($questions as $item) { ?>
              <article class="question question-type-normal">
                <h2><a href="<?php echo $root; ?>question/<?php echo $item->qId; ?>"><?php echo $item->Title; ?></a></h2>
                <a class="question-report" href="#">Report</a>
                <div class="question-type-main"><i class="icon-question-sign"></i><a href="<?php echo $root; ?>question/<?php echo $item->Id; ?>" style="color: white;">Question</a></div>
                <div class="question-author">
                  <a href="#" data-gravatar-hash="<?php echo $item->UserImage; ?>" original-title="<?php echo $item->DisplayName; ?>" class="question-author-img tooltip-n">
                    <span></span>
                  </a>
                </div>
                <div class="question-inner">
                  <div class="clearfix"></div>
                  <p class="question-desc">
                    <?php echo substr(strip_tags($item->Body), 0, 200) . '...' ?>
                  </p>
                  <div class="question-details">
                    <span class="question-answered question-answered-done"><i class="icon-ok"></i>solved</span>
                    <span class="question-favorite"><i class="icon-star"></i><?php echo $item->UpVotes; ?></span>
                  </div>
                  <span class="question-date"><i class="icon-time"></i><?php echo Utility::time2str($item->CreationDate); ?></span>
                  <span class="question-comment"><a href="<?php echo $root; ?>question/<?php echo $item->Id; ?>"><i class="icon-comment"></i><?php echo $item->AnswerCount; ?></a></span>
                  <span class="question-view"><i class="icon-user"></i><?php echo $item->ViewCount; ?></span>
                  <span style="margin-left: 20px;" class="question-comment"><a href="<?php echo $root . 'tags/all/' . $item->Id; ?>"><i class="icon-tag"></i><?php echo $item->Name; ?></a></span>
                  <div class="clearfix"></div>
                </div>
              </article>
              <?php } ?>
          </div>
        </div>
      </div>
      <script>
        $(window).load(function() {
            $('a[data-gravatar-hash]').prepend(function(index){
                var hash = $(this).attr('data-gravatar-hash')
                return '<img width="100" height="100" alt="" src="' + hash + '">'
            });
        });
      </script>
    </div>
    <aside class="col-md-3 sidebar">
      <div class="widget widget_stats">
        <h3 class="widget_title">Stats</h3>
        <div class="ul_list ul_list-icon-ok">
          <ul>
            <li><i class="icon-question-sign"></i>Questions (<span><?php echo number_format($stats->totalQuestions); ?></span>)</li>
            <li><i class="icon-comment"></i>Answers (<span><?php echo number_format($stats->totalAnswers); ?></span>)</li>
          </ul>
        </div>
      </div>

      <?php if (!User::Instance()->isLogged()) { ?>
        <div class="widget widget_login">
            <h3 class="widget_title">Login</h3>
            <div class="form-style form-style-2">
            <form>
                <div class="form-inputs clearfix">
                <p class="login-text">
                    <input type="text" value="Username" onfocus="if (this.value == 'Username') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Username';}">
                    <i class="icon-user"></i>
                </p>
                <p class="login-password">
                    <input type="password" value="Password" onfocus="if (this.value == 'Password') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Password';}">
                    <i class="icon-lock"></i>
                    <a href="#">Forget</a>
                </p>
                </div>
                <p class="form-submit login-submit">
                <input type="submit" value="Log in" class="button color small login-submit submit">
                </p>
                <div class="rememberme">
                <label>
                    <input type="checkbox" checked="checked"> Remember Me</label>
                </div>
            </form>
            <ul class="login-links login-links-r">
                <li><a href="#">Register</a></li>
            </ul>
            <div class="clearfix"></div>
            </div>
        </div>
      <?php } ?>

      <div class="widget widget_tag_cloud">
        <h3 class="widget_title">Tags</h3>
        <?php $tags = $viewModel->get('tags'); ?>
        <?php foreach ($tags as $tag) { ?>
          <a href="#"><?php echo $tag->Name; ?></a>
        <?php } ?>
      </div>

      <div class="widget">
        <h3 class="widget_title">Recent Questions</h3>
        <ul class="related-posts">
          <?php foreach ($recent as $item) { ?>
            <li class="related-item">
              <h3><a href="#"><?php echo $item->Title; ?></a></h3>
              <p><?php echo substr($item->Body, 0, 100) . '...'; ?></p>
              <div class="clear"></div><span><?php echo Utility::time2str($item->CreationDate); ?></span>
            </li>
          <?php } ?>
        </ul>
      </div>

    </aside>
  </div>