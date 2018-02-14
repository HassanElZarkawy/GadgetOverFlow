<?php $questions = $viewModel->get('questions'); $stats = $viewModel->get('stats'); $top = $viewModel->get('top'); ?>
  <div class="row">
    <div class="col-md-9">
      <div class="tabs-warp question-tab">
        <div class="tab-inner-warp">
          <div class="tab-inner" id="list" name="list">
            <?php $isLogged = User::Instance()->isLogged(); ?>
            <?php foreach ($questions as $item) { ?>
              <article class="question question-type-normal" itemscope itemtype="http://schema.org/Article">
                <h2 itemprop="name"><a itemprop="url" href="<?php echo $root; ?>question/<?php echo $item->qId; ?>"><?php echo $item->Title; ?></a></h2>
                <?php if (!$isLogged) { ?>
                  <a data-remodal-target="login-reminder" class="question-report">Report</a>
                <?php } else { ?>
                  <a data-remodal-target="report-success" class="question-report">Report</a>
                <?php } ?>
                <div class="question-type-main"><i class="icon-question-sign"></i><a itemprop="url" href="<?php echo $root; ?>question/<?php echo $item->qId; ?>" style="color: white;">Question</a></div>
                <div class="question-author">
                  <a itemprop="url" href="<?php echo $root . 'user/' . $item->UserId ?>" data-gravatar-hash="<?php echo $item->UserImage; ?>" original-title="<?php echo $item->DisplayName; ?>" class="question-author-img tooltip-n">
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
                  <span itemprop="dateCreated" class="question-date"><i class="icon-time"></i><?php echo Utility::time2str($item->CreationDate); ?></span>
                  <span class="question-comment"><a href="<?php echo $root; ?>question/<?php echo $item->qId; ?>"><i class="icon-comment"></i><?php echo $item->AnswerCount; ?></a></span>
                  <span class="question-view"><i class="icon-user"></i><?php echo $item->ViewCount; ?></span>
                  <span style="margin-left: 20px;" class="question-comment"><a href="<?php echo $root . 'tags/all/' . $item->Id; ?>"><i class="icon-tag"></i><?php echo $item->Name; ?></a></span>
                  <div class="clearfix"></div>
                </div>
              </article>
              <?php } ?>
                <a id="loadMore" name="loadMore" class="load-questions"><i class="icon-refresh"></i>Load More Questions</a>
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
              <form method="post" action="<?php echo $root . 'account/loguser' ?>">
                <div class="form-inputs clearfix">
                  <p class="login-text">
                    <input id="Username" name="Username" type="text" value="Username" onfocus="if (this.value == 'Username') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Username';}">
                    <i class="icon-user"></i>
                  </p>
                  <p class="login-password">
                    <input id="Password" name="Password" type="password" value="Password" onfocus="if (this.value == 'Password') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Password';}">
                    <i class="icon-lock"></i>
                  </p>
                </div>
                <p class="form-submit login-submit">
                  <input type="submit" value="Log in" class="button color small login-submit submit">
                </p>
                <div class="rememberme">
                  <label><input type="checkbox" checked="checked"> Remember Me</label>
                </div>
              </form>
              <ul class="login-links login-links-r">
                <li><a href="<?php echo $root . 'account/register'; ?>">Register</a></li>
              </ul>
              <div class="clearfix"></div>
            </div>
        </div>
      <?php } ?>

      <div class="widget widget_highest_points">
        <h3 class="widget_title">Highest points</h3>
        <ul>
          <?php foreach ($top as $item) { ?>
							<li>
								<div class="author-img">
									<a href="<?php echo $root . 'user/' . $item->UserId; ?>"><img width="60" height="60" src="<?php echo $item->UserImage ?>" alt="<?php echo $item->DisplayName ?>"></a>
								</div> 
								<h6><a href="<?php echo $root . 'user/' . $item->UserId; ?>"><?php echo $item->DisplayName ?></a></h6>
								<span class="comment"><?php echo number_format($item->Points) . ' Points' ?></span>
							</li>
						<?php } ?>
        </ul>
      </div>

      <div class="widget widget_tag_cloud">
        <h3 class="widget_title">Tags</h3>
        <?php $tags = $viewModel->get('tags'); ?>
        <?php foreach ($tags as $tag) { ?>
          <a href="<?php echo $root . 'tags/all/' . $tag->Id; ?>"><?php echo $tag->Name; ?></a>
        <?php } ?>
      </div>

      <div class="widget">
        <h3 class="widget_title">Recent Questions</h3>
        <ul class="related-posts">
          <?php foreach (array_slice($questions, 0, 2) as $item) { ?>
            <li class="related-item">
              <h3><a href="<?php echo $root . 'question/' . $item->qId; ?>"><?php echo $item->Title; ?></a></h3>
              <p><?php echo strip_tags(substr($item->Body, 0, 100)) . '...'; ?></p>
              <div class="clear"></div><span><?php echo Utility::time2str($item->CreationDate); ?></span>
            </li>
          <?php } ?>
        </ul>
      </div>

    </aside>
  </div>


  <div class="remodal" data-remodal-id="login-reminder">
    <button data-remodal-action="close" class="remodal-close"></button>
    <h1>Login</h1>
    <p>
      Please login first before reporting a question.
    </p>
    <br>
    <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
    <button onclick="window.location='http://gadgetoverflow.ga/account/login'" class="remodal-confirm">OK</button>
  </div>

  <div class="remodal" data-remodal-id="report-success">
    <button data-remodal-action="close" class="remodal-close"></button>
    <h1>Success</h1>
    <p>
      Question has been reported to the admins.
    </p>
    <br>
    <button data-remodal-action="confirm" class="remodal-confirm">Ok</button>
  </div>

  <link rel="stylesheet" href="<?php echo $root ?>assets/css/modal.css">
  <link rel="stylesheet" href="<?php echo $root ?>assets/css/remodal.css">
  <script src="<?php echo $root ?>assets/js/modal.js"></script>

  <script>
    //tab-inner
    //loadMore
    var template = 
   ['<article class="question question-type-normal">',
    '<h2><a href="http://gadgetoverflow.ga/question/{{qId}}">{{Title}}</a></h2>',
    '<a class="question-report" href="#">Report</a>',
    '<div class="question-type-main"><i class="icon-question-sign"></i><a href="http://gadgetoverflow.ga/question/{{qId}}" style="color: white;">Question</a></div>',
    '<div class="question-author">',
    '<a href="#" data-gravatar-hash="{{UserImage}}" original-title="{{DisplayName}}" class="question-author-img tooltip-n"></a>',
    '<span></span>',
    '</a>',
    '</div>',
    '<div class="question-inner">',
    '<div class="clearfix"></div>',
    '<p class="question-desc">',
    '{{Body}}',
    '</p>',
    '<div class="question-details">',
    '<span class="question-answered question-answered-done"><i class="icon-ok"></i>solved</span>',
    '<span class="question-favorite"><i class="icon-star"></i>{{Votes}}</span>',
    '</div>',
    '<span class="question-date"><i class="icon-time"></i>{{CreationDate}}</span>',
    '<span class="question-comment"><a href="http://gadgetoverflow.ga/question/{{qId}}"><i class="icon-comment"></i>{{AnswerCount}}</a></span>',
    '<span class="question-view"><i class="icon-user"></i>{{ViewCount}}</span>',
    '<span style="margin-left: 20px;" class="question-comment"><a href="http://gadgetoverflow.ga/tags/all/{{Id}}"><i class="icon-tag"></i>{{TagName}}</a></span>',
    '<div class="clearfix"></div>',
    '</div>',
    '</article>',
   ].join('\n');
   var btn = '<a id="loadMore" name="loadMore" class="load-questions"><i class="icon-refresh"></i>Load More Questions</a>';
    var index = 2;
    $(document).on('click', '#loadMore', function(){
      $.ajax({
                url: '<?php echo $root . 'api/home/' ?>' + index,
                type: 'get',
                dataType:'json',
                success: function(response){
                  index++;
                  $('#loadMore').remove();
                  for (var i= 0; i < response.length; ++i)
                  {
                    var body = response[i].Body.replace(/<(?:.|\n)*?>/gm, '');
                    var tt = template.replace("{{qId}}", response[i].qId)
                                     .replace("{{UserImage}}", response[i].UserImage)
                                     .replace("{{DisplayName}}", response[i].DisplayName)
                                     .replace("{{Body}}", body.substr(0, 100))
                                     .replace("{{Votes}}", response[i].UpVotes)
                                     .replace("{{CreationDate}}", timeConverter(response[i].CreationDate))
                                     .replace("{{AnswerCount}}", response[i].AnswerCount)
                                     .replace("{{ViewCount}}", response[i].ViewCount)
                                     .replace("{{TagName}}", response[i].Name)
                                     .replace("{{Id}}", response[i].Id)
                                     .replace("{{Title}}", response[i].Title)
                    $('#list').append(tt);
                  }
                  $('#list').append(btn);
                  $('a[data-gravatar-hash]').prepend(function(index){
                      var hash = $(this).attr('data-gravatar-hash')
                      return '<img width="100" height="100" alt="" src="' + hash + '">'
                  });
                }
      })
    });

    function timeConverter(UNIX_timestamp){
      var a = new Date(UNIX_timestamp * 1000);
      var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
      var year = a.getFullYear();
      var month = months[a.getMonth()];
      var date = a.getDate();
      var hour = a.getHours();
      var min = a.getMinutes();
      var sec = a.getSeconds();
      var time = date + ' ' + month + ' ' + year;
      return time;
    }

  </script>